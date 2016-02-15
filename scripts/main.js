var jq = document.createElement('script');
jq.src = "scripts/jquery.min.js";
document.querySelector('head').appendChild(jq);

jq.onload = onload;
var suggest_count = 0;
var input_initial_value = 'asd';
var suggest_selected = 0;

function onload(){
    $(function() {

        var $prvw = $('#preview'),
            $gird = $('#gird'),
            $li   = $gird.find("li"),
            $img  = $prvw.find("img"),
            $block = $prvw.find("left-side"),
            $alt1 = $prvw.find("span.title"),
            $alt2 = $prvw.find("span.author"),
            $alt3 = $prvw.find("span.desc"),
            $btn1 = $prvw.find("a#1"),
            $btn2 = $prvw.find("a#2"),
            $btn3 = $prvw.find("a#3"),
            $full =  $("<li />", {"class":"full", html:$prvw});
        $li.on("click", function( evt ){
            var $el = $(this),
                d = $el.data(),
                $clone = $full.clone();
            $el.toggleClass("active").siblings().removeClass("active");
            $prvw.hide();
            $full.after($clone);
            $clone.find(">div").slideUp(function(){
                $clone.remove();
            });
            if(!$el.hasClass("active")) return;
            $img.attr("src", d.src);
            $btn1.text("Прочитало: " + d.readers);
            $btn2.text("Хотят прочитать: " + d.toread);
            $btn3.text("Средний рейтинг: " + d.rating);
            $alt1.text(d.title);
            $alt2.text(d.author);
            $alt3.text(d.desc);
            $li.filter(function(i, el){
                return el.getBoundingClientRect().top < evt.clientY;
            }).last().after($full);
            $prvw.slideDown();
        });
        $(window).on("resize", function(){
            $full.remove();
            $li.removeClass("active");
        });
        $('label').on("click", function( evt ){
            $full.remove();
            $li.removeClass("active");
        });

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
}
