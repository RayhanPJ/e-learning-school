<script src="../public/assets/template/js/jquery.min.js"></script>
<script src="../public/assets/template/js/popper.min.js"></script>
<script src="../public/assets/template/js/bootstrap.min.js"></script>
<script src="../public/assets/template/js/modernizr.min.js"></script>
<script src="../public/assets/template/js/waves.js"></script>
<script src="../public/assets/template/js/jquery.slimscroll.js"></script>
<script src="../public/assets/template/js/jquery.nicescroll.js"></script>
<script src="../public/assets/template/js/jquery.scrollTo.min.js"></script>

<script src="../public/assets/template/plugins/skycons/skycons.min.js"></script>
<script src="../public/assets/template/plugins/raphael/raphael-min.js"></script>
<script src="../public/assets/template/plugins/morris/morris.min.js"></script>

<script src="../public/assets/template/pages/dashborad.js"></script>

<!-- App js -->
<script src="../public/assets/template/js/app.js"></script>
<script>
    /* BEGIN SVG WEATHER ICON */
    if (typeof Skycons !== 'undefined'){
    var icons = new Skycons(
        {"color": "#fff"},
        {"resizeClear": true}
        ),
            list  = [
                "clear-day", "clear-night", "partly-cloudy-day",
                "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                "fog"
            ],
            i;

        for(i = list.length; i--; )
        icons.set(list[i], list[i]);
        icons.play();
    };

// scroll

$(document).ready(function() {

$("#boxscroll").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true});
$("#boxscroll2").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true}); 

});
</script>

</body>
</html>