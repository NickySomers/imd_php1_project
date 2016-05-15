$(".input-search").keyup(function () {

    if ($(this).val() != "") 
    {
        var data = {
            input: $(this).val()
        };

        $.post("../ajax/searchLoad.php", data, function (response) 
        {
            $(".wrap-suggestions").css("display", "flex");
            $('.wrap-blur').addClass("blur-all");

            var data = $.parseJSON(response);
            
            if(data[0].length > 0)
            {
                $(".suggestions").append("<h2 class='search-title'>Users</h2>");
                var users = "";
;
                    for (var i = 0; i < data[0].length; i++) 
                    {
                        users += "<li>" + data[0][i] + "</li>";
                    }
                $(".suggestions").append("<ul class='grid'>"+users+"</ul>");
            }
            
            if(data[1].length > 0)
            {
                $(".suggestions").append("<h2 class='search-title'>Hashtags</h2>");
                var tags = "";
;
                    for (var i = 0; i < data[1].length; i++) 
                    {
                        tags += "<li>" + data[1][i] + "</li>";
                    }
                $(".suggestions").append("<ul>"+tags+"</ul>");
            }
            
            if(data[2].length > 0)
            {
                (".suggestions").append("<h2 class='search-title'>Locations</h2>");
                var locations = "";
;
                    for (var i = 0; i < data[2].length; i++) 
                    {
                        locations += "<li>" + data[2][i] + "</li>";
                    }
                $(".suggestions").append("<ul>"+locations+"</ul>");
            }
            
            if(data[0].length == 0 && data[1].length == 0 && data[2].length == 0)
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
    $(".search-overlay").fadeOut();
});