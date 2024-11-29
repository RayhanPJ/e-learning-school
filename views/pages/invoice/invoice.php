<?php
$base_url = "/e-learning-school/public/assets/template";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Annex - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="<?= $base_url; ?>/images/favicon.ico">
        <!-- DataTables -->
        <link href="<?= $base_url; ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $base_url; ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="<?= $base_url; ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $base_url; ?>/plugins/morris/morris.css" rel="stylesheet">
        <link href="<?= $base_url; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?= $base_url; ?>/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?= $base_url; ?>/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="page-content container">
            <div class="page-header text-blue-d2">
                <h1 class="page-title text-secondary-d1">
                    Invoice
                    <small class="page-info">
                        <i class="fa fa-angle-double-right text-80"></i>
                        ID: #111-222
                    </small>
                </h1>

                <div class="page-tools">
                    <div class="action-buttons">
                        <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="Print">
                            <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                            Print
                        </a>
                        <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="PDF">
                            <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                            Export
                        </a>
                    </div>
                </div>
            </div>

            <div class="container px-0">
                <div class="row mt-4">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center text-150">
                                    <i class="fa fa-book fa-2x text-success-m2 mr-1"></i>
                                    <span class="text-default-d3">Bootdey.com</span>
                                </div>
                            </div>
                        </div>
                        <!-- .row -->

                        <hr class="row brc-default-l1 mx-n1 mb-4" />

                        <div class="row">
                            <div class="col-sm-6">
                                <div>
                                    <span class="text-sm text-grey-m2 align-middle">To:</span>
                                    <span class="text-600 text-110 text-blue align-middle">Alex Doe</span>
                                </div>
                                <div class="text-grey-m2">
                                    <div class="my-1">
                                        Street, City
                                    </div>
                                    <div class="my-1">
                                        State, Country
                                    </div>
                                    <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600">111-111-111</b></div>
                                </div>
                            </div>
                            <!-- /.col -->

                            <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                <hr class="d-sm-none" />
                                <div class="text-grey-m2">
                                    <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                        Invoice
                                    </div>

                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span> #111-222</div>

                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span> Oct 12, 2019</div>

                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Status:</span> <span class="badge badge-warning badge-pill px-25">Unpaid</span></div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>

                        <div class="mt-4">
                            <div class="row text-600 text-white bgc-default-tp1 py-25">
                                <div class="d-none d-sm-block col-1">#</div>
                                <div class="col-9 col-sm-5">Description</div>
                                <div class="d-none d-sm-block col-4 col-sm-2">Qty</div>
                                <div class="d-none d-sm-block col-sm-2">Unit Price</div>
                                <div class="col-2">Amount</div>
                            </div>

                            <div class="text-95 text-secondary-d3">
                                <div class="row mb-2 mb-sm-0 py-25">
                                    <div class="d-none d-sm-block col-1">1</div>
                                    <div class="col-9 col-sm-5">Domain registration</div>
                                    <div class="d-none d-sm-block col-2">2</div>
                                    <div class="d-none d-sm-block col-2 text-95">$10</div>
                                    <div class="col-2 text-secondary-d2">$20</div>
                                </div>

                                <div class="row mb-2 mb-sm-0 py-25 bgc-default-l4">
                                    <div class="d-none d-sm-block col-1">2</div>
                                    <div class="col-9 col-sm-5">Web hosting</div>
                                    <div class="d-none d-sm-block col-2">1</div>
                                    <div class="d-none d-sm-block col-2 text-95">$15</div>
                                    <div class="col-2 text-secondary-d2">$15</div>
                                </div>

                                <div class="row mb-2 mb-sm-0 py-25">
                                    <div class="d-none d-sm-block col-1">3</div>
                                    <div class="col-9 col-sm-5">Software development</div>
                                    <div class="d-none d-sm-block col-2">--</div>
                                    <div class="d-none d-sm-block col-2 text-95">$1,000</div>
                                    <div class="col-2 text-secondary-d2">$1,000</div>
                                </div>

                                <div class="row mb-2 mb-sm-0 py-25 bgc-default-l4">
                                    <div class="d-none d-sm-block col-1">4</div>
                                    <div class="col-9 col-sm-5">Consulting</div>
                                    <div class="d-none d-sm-block col-2">1 Year</div>
                                    <div class="d-none d-sm-block col-2 text-95">$500</div>
                                    <div class="col-2 text-secondary-d2">$500</div>
                                </div>
                            </div>

                            <div class="row border-b-2 brc-default-l2"></div>

                            <div class="row mt-3">
                                <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                    Extra note such as company or payment information...
                                </div>

                                <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                    <div class="row my-2">
                                        <div class="col-7 text-right">
                                            SubTotal
                                        </div>
                                        <div class="col-5">
                                            <span class="text-120 text-secondary-d1">$2,250</span>
                                        </div>
                                    </div>

                                    <div class="row my-2">
                                        <div class="col-7 text-right">
                                            Tax (10%)
                                        </div>
                                        <div class="col-5">
                                            <span class="text-110 text-secondary-d1">$225</span>
                                        </div>
                                    </div>

                                    <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                        <div class="col-7 text-right">
                                            Total Amount
                                        </div>
                                        <div class="col-5">
                                            <span class="text-150 text-success-d3 opacity-2">$2,475</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />

                            <div>
                                <span class="text-secondary-d1 text-105">Thank you for your business</span>
                                <a href="#" class="btn btn-info btn-bold px-4 float-right mt-3 mt-lg-0">Pay Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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