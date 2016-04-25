$(document).ready(function(){

    /* FEED PAGE LIKE BUTTON */
    $(".liken").click(function(){
        $(this).css("background-image", "url('../images/heart-fill.svg')");
    });
    
    /* LAZY LOADING FEED PAGE */
    $(document).on('click','.show_more',function(){
        var ID = $(this).attr('id');
        $('.show_more').hide();
        $('.loding').show();
        $.ajax({
            type:'POST',
            url:'feed.php',
            data:'date='+ID,
            success:function(html){
                $('#show_more_main'+ID).remove();
                $('.wrap-photo').append(html);
            }
        }); 
    });
});

