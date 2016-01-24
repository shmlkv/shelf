var jq = document.createElement('script');
jq.src = "scripts/jquery.js";
document.querySelector('head').appendChild(jq);

jq.onload = onload;
var suggest_count = 0;
var input_initial_value = 'asd';
var suggest_selected = 0;

function onload(){
    $(function() {
        $('[data-popup-open]').on('click', function(e)  {
            var targeted_popup_class = jQuery(this).attr('data-popup-open');
            $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
            e.preventDefault();
        });

        $('[data-popup-close]').on('click', function(e)  {
            var targeted_popup_class = jQuery(this).attr('data-popup-close');
            $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
            e.preventDefault();
        });
    });

    $('.popup-message').delay(1000).fadeOut(); 
    
   //$('#desc').on('click', function(e)  {
   //    if ( $("#desc").has("#editor") ) {
   //        $('<button class="btn inline addbook" id="save" style="display:block !important" value="22">Save description</button></div>').insertAfter($("#desc"));
   //    }
   //});
    $('#save').on('click', function(e)  {
        $edit = $('#editor').html();
        //$ss =;
        $book = $('#save').attr('value');
        $.ajax({
            url: 'scripts/addbook.php',
            type: 'post',
            data: {data: $edit, action: 'edit_desc', bookid: $book},
            datatype: 'html',
            success: function(rsp){
                    window.location.reload();
                }
        });
    });
    $('#save').on('click', function(e)  {
        $edit = $('#editor').html();
        //$ss =;
        $book = $('#save').attr('value');
        $.ajax({
            url: 'scripts/addbook.php',
            type: 'post',
            data: {action: 'edit_desc', data: $edit, bookid: $book},
            datatype: 'html',
            success: function(rsp){
                    window.location.reload();
                }
        });
    });

    $('#fav').on('click', function(e)  {
        //$ss =;
        $book = $('#fav').attr('value');

        $.ajax({
            url: 'scripts/addbook.php',
            type: 'post',
            data: {want: true, book: $book},
            datatype: 'html',
            success: function(rsp){
                    window.location.reload();
                }
        });
    });

     $('.opinion').on('click', function(e)  {
        $book = $('#fav').attr('value');
        $uid = $('.comment').attr('value');

        if($(this).is("#like")){
            $opinion = true;
        }
        if($(this).is("#dislike")){
            $opinion = false;
        }
        $.ajax({
            url: 'scripts/addbook.php',
            type: 'post',
            data: {action: 'like', book: $book, uid: $uid, opinion:  $opinion},
            datatype: 'html',
            success: function(rsp){
                    window.location.reload();
                }
        });
    });


    //scripts/addbook.php?want=true&book=

    $("#search_box").keyup(function(I){
        // определяем какие действия нужно делать при нажатии на клавиатуру
        switch(I.keyCode) {
            // игнорируем нажатия на эти клавишы
            case 13:  // enter
            case 27:  // escape
            case 38:  // стрелка вверх
            case 40:  // стрелка вниз
            break;
 
            default:
                // производим поиск только при вводе более 2х символов
                if($(this).val().length>2){
 
                    input_initial_value = $(this).val();
                    // производим AJAX запрос к /ajax/ajax.php, передаем ему GET query, в который мы помещаем наш запрос
                    $.get("search.php", { "query":$(this).val() },function(data){
                        alert('asd');
                        //php скрипт возвращает нам строку, ее надо распарсить в массив.
                        // возвращаемые данные: ['test','test 1','test 2','test 3']
                        var list = eval("("+data+")");
                        suggest_count = list.length;
                        if(suggest_count > 0){
                            // перед показом слоя подсказки, его обнуляем
                            $("#search_advice_wrapper").html("").show();
                            for(var i in list){
                                if(list[i] != ''){
                                    // добавляем слою позиции
                                    $('#search_advice_wrapper').append('<div class="advice_variant">'+list[i]+'</div>');
                                }
                            }
                        }
                    }, 'html');
                }
            break;
        }
    });
 
    //считываем нажатие клавишь, уже после вывода подсказки
    $("#search_box").keydown(function(I){
        switch(I.keyCode) {
            // по нажатию клавишь прячем подсказку
            case 13: // enter
            case 27: // escape
                $('#search_advice_wrapper').hide();
                return false;
            break;
            // делаем переход по подсказке стрелочками клавиатуры
            case 38: // стрелка вверх
            case 40: // стрелка вниз
                I.preventDefault();
                if(suggest_count){
                    //делаем выделение пунктов в слое, переход по стрелочкам
                    key_activate( I.keyCode-39 );
                }
            break;
        }
    });
 
    // делаем обработку клика по подсказке
    $('.advice_variant').on('click',function(){
        // ставим текст в input поиска
        $('#search_box').val($(this).text());
        // прячем слой подсказки
        $('#search_advice_wrapper').fadeOut(350).html('');
    });
 
    // если кликаем в любом месте сайта, нужно спрятать подсказку
    $('html').click(function(){
        $('#search_advice_wrapper').hide();
    });
    // если кликаем на поле input и есть пункты подсказки, то показываем скрытый слой
    $('#search_box').click(function(event){
        //alert(suggest_count);
        if(suggest_count)
            $('#search_advice_wrapper').show();
        event.stopPropagation();
    });


}

function key_activate(n){
    $('#search_advice_wrapper div').eq(suggest_selected-1).removeClass('active');
 
    if(n == 1 && suggest_selected < suggest_count){
        suggest_selected++;
    }else if(n == -1 && suggest_selected > 0){
        suggest_selected--;
    }
 
    if( suggest_selected > 0){
        $('#search_advice_wrapper div').eq(suggest_selected-1).addClass('active');
        $("#search_box").val( $('#search_advice_wrapper div').eq(suggest_selected-1).text() );
    } else {
        $("#search_box").val( input_initial_value );
    }
}