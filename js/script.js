$(document).ready(function(){

    /* FEED PAGE LIKE BUTTON */
    $(".liken").click(function(){
        $(this).css("background-image", "url('../images/heart-fill.svg')");
    });
    
    /* LAZY LOADING FEED PAGE */
    $(window).scroll(function() {
        
        if($(window).scrollTop() + $(window).height() == $(document).height()) 
        {
            setTimeout(function(){
                
                var data = {
                    index: $(".show_more").attr('data-index')
                }

                $.post("../ajax/loadFeed.php", data, function(response) {
    
                    $('.show_more_main').remove();

                    var data = $.parseJSON(response);

                    for(var i = 0; i < data[1].length; i++)
                    {
                        var header_content = '<div class="profile-pic"></div><div class="profile-name">'+data[1][i][2]+'</div><div class="minutes-posted">'+data[1][i][3]+'</div>';
                        
                        var header = '<div class="header-photo">'+header_content+'</div>';
                    
                        var image = '<img src="'+data[1][i][0]+'" alt="Photo" width="100%" height="auto">';

                        var footer_content = '<div class="likes">test</div><div class="wrap-description"><div class="description-username">USERNAME</div><div class="description-text">'+data[1][i][1]+'</div></div><div class="line"></div>';
                        
                        var footer = '<div class="footer-photo">'+footer_content+'</div>';

                        var post = '<div class="wrap-photo">' + header + image + footer + '</div>';            
      
                        $('.container').append(post);
                    }

                    // if($(".show_more").attr('data-index') == null){
                    //     alert("Test");
                    // }else{
                    
                    var showmore = '<div class="show_more_main" id="show_more_main"><span data-index="'+data[0]+'" class="show_more" title="Load more posts">Show more</span><span class="loding" style="display: none;"><span class="loding_txt">Loading....</span></span></div>';
                    
                    $('.container').append(showmore);
                    
                // }       
                })
        
            }, 1000);
        }

    });
    
    /* REPORT PHOTO */
    $('.flag').click(function(){
        
        $(".container-report").css("display", "block");
        
        $('html, body').css({
            'overflow': 'hidden'
        });
        
    });
    
    $('.report-cancel').click(function(){
        
        $(".container-report").css("display", "none");
        
        $('html, body').css({
            'overflow': 'auto'
        });
        
    });
    
    var count;
    $(this).find('.report').click(function(){
        
        $(".container-report").css("display", "none");
            
        $('html, body').css({
            'overflow': 'auto'
        });
        
        if(count.attr('data-size') == 2) 
        {
            alert("test");
        } 
        else
        {
            count.attr('data-size', i + 1);
        }

    });

});