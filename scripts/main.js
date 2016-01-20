var jq = document.createElement('script');
jq.src = "scripts/jquery.js";
document.querySelector('head').appendChild(jq);

jq.onload = onload;

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
}