$(".input-search").keyup(function () {

    if ($(this).val() != "") 
    {
        var data = {
            input: $(this).val()
        };

        $.post("searchLoad.php", data, function (response) 
        {
            $(".wrap-suggestions").css("display", "flex");
            $('.wrap-blur').addClass("blur-all");

            var data = $.parseJSON(response);
            
            if(data[0].length > 0)
            {
                $(".suggestions").append("<p>Users</p>");
                
                $(".suggestions").append("<ul>");
                    for (var i = 0; i < data[0].length; i++) 
                    {
                        $(".suggestions").append("<li>");
                        $(".suggestions").append(data[0][i]);
                        $(".suggestions").append("</li>");
                    }
                $(".suggestions").append("</ul>");
            }
            
            if(data[1].length > 0)
            {
                $(".suggestions").append("<p>Tags</p>");
                
                $(".suggestions").append("<ul>");
                    for (var i = 0; i < data[1].length; i++) 
                    {
                        $(".suggestions").append("<li>");
                        $(".suggestions").append(data[1][i]);
                        $(".suggestions").append("</li>");
                    }
                $(".suggestions").append("</ul>");
            }
            
            if(data[0].length == 0 && data[1].length == 0)
            {
                $(".suggestions").css("display", "none");
                $('.wrap-blur').removeClass("blur-all");
            }
            else
            {
                $(".suggestions").css("display", "block");
            }

        });

        $(".suggestions").empty();
        
    } 
    else 
    {    
        $(".wrap-suggestions").css("display", "none");
        $('.wrap-blur').removeClass("blur-all");
    }
    
});

$(".cancel").click(function(){
    $(".wrap-suggestions").css("display", "none");
    $(".input-search").val("");
});