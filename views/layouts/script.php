<script src="../public/assets/template/js/jquery.min.js"></script>
<script src="../public/assets/template/js/popper.min.js"></script>
<script src="../public/assets/template/js/bootstrap.min.js"></script>
<script src="../public/assets/template/js/modernizr.min.js"></script>
<script src="../public/assets/template/js/waves.js"></script>
<script src="../public/assets/template/js/jquery.slimscroll.js"></script>
<script src="../public/assets/template/js/jquery.nicescroll.js"></script>
<script src="../public/assets/template/js/jquery.scrollTo.min.js"></script>

<!-- Required datatable js -->
<script src="../public/assets/template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/assets/template/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="../public/assets/template/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="../public/assets/template/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="../public/assets/template/plugins/datatables/jszip.min.js"></script>
<script src="../public/assets/template/plugins/datatables/pdfmake.min.js"></script>
<script src="../public/assets/template/plugins/datatables/vfs_fonts.js"></script>
<script src="../public/assets/template/plugins/datatables/buttons.html5.min.js"></script>
<script src="../public/assets/template/plugins/datatables/buttons.print.min.js"></script>
<script src="../public/assets/template/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="../public/assets/template/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="../public/assets/template/plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="../public/assets/template/pages/datatables.init.js"></script>

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
$("#datatable").DataTable();
$("#boxscroll").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true});
$("#boxscroll2").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true}); 

});
</script>

</body>
</html>