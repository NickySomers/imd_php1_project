$(document).ready(function(){

    /* FEED PAGE LIKE BUTTON */
    // $(".liken").click(function(){
    $('body').delegate('.liken', 'click', function() {
        var like = $(this);
        var data = {
            id: like.closest( ".wrap-photo" ).attr("data-index")
        }

        $.post("../ajax/likePost.php", data, function(response) {
            if(response == true){
                like.css("background-image", "url('../images/heart-fill.svg')");
                like.closest(".footer-photo").find(".likesCount").text(parseInt(like.closest(".footer-photo").find(".likesCount").text()) + 1);
            }else{
                like.css("background-image", "url('../images/heart.svg')");

                like.closest(".footer-photo").find(".likesCount").text(parseInt(like.closest(".footer-photo").find(".likesCount").text()) - 1);
            }      
        });
    });
    
    /* LAZY LOADING FEED PAGE */
    $(window).scroll(function() {
        
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            
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
                        var liked = "";
                        
                        if(data[1][i][5] == true)
                        {
                            liked = "liked";
                        }
                        else
                        {
                            liked = "";
                        }

                        var footer_content = '<div class="likes"><span class="likesCount">' + data[1][i][6] + '</span> likes</div><div class="wrap-description"><div class="description-username">'+data[1][i][2]+'</div><div class="description-text">'+data[1][i][1]+'</div></div><div class="line"></div><div class="wrap-liken"><div class="liken '+liked+'"></div><input type="text" name="comment" class="comment" placeholder="Add a comment..."><div class="flag"></div></div>';
                        var footer = '<div class="footer-photo">'+footer_content+'</div>';
                        var post = '<div class="wrap-photo" data-index="' + data[1][i][4] + '">' + header + image + footer + '</div>';            

                        $('.container').append(post);

                    }

                    var showmore = '<div class="show_more_main" id="show_more_main"><span data-index="'+data[0]+'" class="show_more" title="Load more posts">Show more</span><span class="loding" style="display: none;"><span class="loding_txt">Loading....</span></span></div>';
                    $('.container').append(showmore);

                })
        
            }, 1000);
        }
        
    });
    
    /* UPLOAD PAGE + FILTERS */
    $('.filter-1').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('.filter-1').addClass('active');
    });

    $('.filter-2').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('_1977');
        $('.filter-2').addClass('active');
    });

    $('.filter-3').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('earlybird');
        $('.filter-3').addClass('active');
    });

    $('.filter-4').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('hudson');
        $('.filter-4').addClass('active');
    });

    $('.filter-5').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('aden');
        $('.filter-5').addClass('active');
    });

    $('.filter-6').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('lofi');
        $('.filter-6').addClass('active');
    });

    $('.filter-7').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('mayfair');
        $('.filter-7').addClass('active');
    });

    $('.filter-8').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('nashville');
        $('.filter-8').addClass('active');
    });

    $('.filter-9').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('rise');
        $('.filter-9').addClass('active');
    });

    $('.filter-10').click(function () {
        $('#change-filter').removeClass();
        $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
        $('#change-filter').addClass('walden');
        $('.filter-10').addClass('active');
    });

    $("#publish").click(function () {
        var className = $('#change-filter').attr("class");
        $(".input-filter").attr('value', className);
        $("#publish-form").submit();
    });

    $("#anotherPhoto").click(function () {
        location.href="index.php";
    });

    $('#form-upload').submit(function () {
        var queryString = new FormData($('form')[0]);
        $.ajax({
            type: "POST",
            url: 'upload.php',
            data: queryString,
            contentType: false,
            processData: false,
            beforeSend: function () {},
            success: function () {}
        });
    });

    $("#file").change(function () {
        $("#form-upload").submit();
    });
    
    /* REPORT PHOTO */
    $('.flag').click(function() {
        
        $(".container-report").css("display", "block");
        
        $('html, body').css({
            'overflow': 'hidden'
        });
        
    });
    
    $('.report').click(function () {
        
        var dataReport = {
            postId: $(this).closest(".wrap-photo").attr("data-index")
        }
        
        $.ajax({
            type: "POST",
            url: '../ajax/insertReport.php',
            data: dataReport
        });
        
        $(".container-report").css("display", "none");
        
        $('html, body').css({
            'overflow': 'auto'
        });
        
    });
    
    $('.report-cancel').click(function() {
        
        $(".container-report").css("display", "none");
        
        $('html, body').css({
            'overflow': 'auto'
        });
        
    });
    
});


