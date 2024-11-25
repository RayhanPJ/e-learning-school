<?php
$base_url = "/e-learning-school/public/assets/template";
?>
<script src="<?= $base_url; ?>/js/jquery.min.js"></script>
<script src="<?= $base_url; ?>/js/popper.min.js"></script>
<script src="<?= $base_url; ?>/js/bootstrap.min.js"></script>
<script src="<?= $base_url; ?>/js/modernizr.min.js"></script>
<script src="<?= $base_url; ?>/js/waves.js"></script>
<script src="<?= $base_url; ?>/js/jquery.slimscroll.js"></script>
<script src="<?= $base_url; ?>/js/jquery.nicescroll.js"></script>
<script src="<?= $base_url; ?>/js/jquery.scrollTo.min.js"></script>

<!-- Required datatable js -->
<script src="<?= $base_url; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= $base_url; ?>/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/jszip.min.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/buttons.print.min.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= $base_url; ?>/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?= $base_url; ?>/plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="<?= $base_url; ?>/pages/datatables.init.js"></script>

<script src="<?= $base_url; ?>/plugins/skycons/skycons.min.js"></script>
<script src="<?= $base_url; ?>/plugins/raphael/raphael-min.js"></script>
<script src="<?= $base_url; ?>/plugins/morris/morris.min.js"></script>

<script src="<?= $base_url; ?>/pages/dashborad.js"></script>

<!-- App js -->
<script src="<?= $base_url; ?>/js/app.js"></script>
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