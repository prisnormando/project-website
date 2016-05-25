<div id="parser" style="display:none"></div>
<div class="bs-example">
    <h2 id="feedback"> Feedback</h2>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Carousel indicators -->

        <!-- Wrapper for carousel items -->
        <div class="carousel-inner"> </div>

        <!--<ol class="carousel-num"></ol>-->
        <div class="carousel-num"></div>

        <!--<div class="carousel-inner">    
            <div class="item active">
                <img src="./img/slide1.png" alt="First Slide">
            </div>
            <div class="item">
                <img src="./img/slide2.png" alt="Second Slide">
            </div>
            <div class="item">
                <img src="./img/slide3.png" alt="Third Slide">
            </div>
       </div>

        <ol class="carousel-num">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>--> 
        <!-- Carousel controls -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>

<script>
    var Twitter = {};

    Twitter.callback = function (jsonP) {
        console.log("json", jsonP);
        var parser = $("#parser"),
                container = $(".carousel-inner"),
                ol = $(".carousel-num"),
                tweets,
                i,
                createItem = function (item, index) {
                    
                    var url = "https://publish.twitter.com/oembed?url=" + encodeURIComponent($(item).attr("href")) 
                            + "&callback=?"
                            + "&hide_media=true";
                    
                    $.getJSON(url, function (data) {

                        var div = $('<div class="item' + ((index === 0) ? ' active' : '') + '"></div>'),
                                divInner = $('<div class="carousel-content"></div>');
                                //li = $('<li data-target="#myCarousel" data-slide-to="' + index + '"' + ((index === 0) ? ' class="active"' : '') + '></li>');
                                

                        div.append(divInner.html(data.html));
                        //ol.append(li);

                        container.append(div);
                    })
                };

        parser.html(jsonP.body);

        tweets = $('.timeline-Tweet-timestamp');

        for (i = 0; i < tweets.length; i++) {
            createItem(tweets[i], i);
        }
        
        var total_tweets = tweets.length;
        
        $('.carousel-num').html('<span class="slideNr">1</span>/' + total_tweets);
    }




    window.addEventListener("load", function () {
        var jp = document.createElement("script");
        jp.src = "https://cdn.syndication.twimg.com/widgets/timelines/733358003295035393?&lang=en&callback=Twitter.callback&suppress_response_codes=true&rnd=0.013";
        var hd = document.getElementsByTagName("head")[0];
        hd.appendChild(jp);

    });

    !function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id)) {
        js = d.createElement(s);
        js.id = id;
        js.src = p + "://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);
        }
     }(document, "script", "twitter-wjs");

    $(document).ready(function () {
        $('#myCarousel').carousel({
            interval: 5000
        });
        
        var current = 1;
        
        $('#myCarousel').on('slide.bs.carousel', function(e) {
            var num_items = $('.item').length;
            
            if(e.direction == "left")
                current = (current >= num_items)?(1):(current + 1);
            else if(e.direction == "right")
                current = (current <= 1)?(num_items):(current - 1);
           
           $('.slideNr').html(current);
        });
    });


</script>