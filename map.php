<?php include_once('includes/header.php'); ?>
    <!-- DataTables -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/select.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

</head>


<body class="fixed-left">
    <div id="overlay-loader">
        <div class="cv-spinner">
            <img class="spinner-img" src="assets/images/tespack-logo.png">
            <p class="loading-text font-16" style="color:#ffcc05;font-weight:500;">Please Wait</p>
        </div>
    </div>
    <!-- Loader 
            <div id="preloader"><div id="status"><div class="spinner"></div></div></div>-->

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">

            <!-- LOGO -->
            <div class="topbar-left">
                <div class="">
                    <!--<a href="stats.php" class="logo text-center">Fonik</a>-->
                    <a href="stats.php" class="logo"><img src="assets/images/logo.png" height="80%" width="80%" alt="logo"></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">
                <div id="sidebar-menu">
                    <ul>

                        <!--<li class="menu-title">Main</li>-->

                        <li class="">
                            <a href="stats.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/dashboard-white.png"></div><span> Dashboard Statistics </span>
                            </a>
                        </li>

                        <?php if ($role == '1' || $role == '3' || $role == '2') : ?>
                            <li>
                                <a href="user.php" class="waves-effect">
                                    <div class="custom-icon"><img src="assets/images/icons/sidebar/admin-white.png"></div><span> Users </span>
                                </a>
                            </li>
                        <?php else :
                        endif; ?>

                        <li>
                            <a href="map.php" class="waves-effect active">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/map-white.png"></div><span> Map </span>
                            </a>
                        </li>

                        <li>
                            <a href="geoFencing.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/geofencing-white.png"></div><span> Geofencing </span>
                            </a>
                        </li>

                        <?php if ($role == '1' || $role == '3' || $role == '0') : ?>
                            <li>
                                <a href="countries.php" class="waves-effect">
                                    <div class="custom-icon"><img src="assets/images/icons/sidebar/countries-white.png"></div><span> Countries </span>
                                </a>
                            </li>
                        <?php else :
                        endif; ?>

                        <li>
                            <a href="smb.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/smb-white.png"></div><span> SSM </span>
                            </a>
                        </li>

                        <li>
                            <a href="teams.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/teams-white.png"></div><span> Teams </span>
                            </a>
                        </li>

                        <li>
                            <a href="projects.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/projects-white.png"></div><span> Projects </span>
                            </a>
                        </li>

                        <li>
                            <a href="trainings.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/training-white.png"></div><span> SSM Tutorials </span>
                            </a>
                        </li>

                        <li>
                            <a href="tickets.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/ticket-support-white.png"></div><span> Ticket Support </span>
                            </a>
                        </li>

                        <li>
                            <a href="report.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/reports-white.png"></div><span> Reports </span>
                            </a>
                        </li>

                        <li>
                            <a href="logs.php" class="waves-effect">
                                <div class="custom-icon"><img src="assets/images/icons/sidebar/logs-white.png"></div><span> Logs </span>
                            </a>
                        </li>

                        <?php if ($role == '0') : ?>
                            <li>
                                <a href="admin.php" class="waves-effect">
                                    <div class="custom-icon"><img src="assets/images/icons/sidebar/admin-white.png"></div><span> Tespack Admin </span>
                                </a>
                            </li>
                            <li>
                                <a href="ticketList.php" class="waves-effect">
                                    <div class="custom-icon"><img src="assets/images/icons/sidebar/ticket-support-white.png"></div><span> Ticket List </span>
                                </a>
                            </li>
                        <?php else :
                        endif; ?>

                    </ul>
                </div>
                <div class="clearfix"></div>
            </div> <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <!-- Top Bar Start -->
                <?php include_once('includes/topbar.php'); ?>
                <li class="hide-phone list-inline-item app-search">
                    <h3 class="page-title"> Maps </h3>
                </li>
                </ul>

                <div class="clearfix"></div>
                </nav>

            </div>
            <!-- Top Bar End -->

            <!-- ==================
                                PAGE CONTENT START
                                ================== -->

            <div class="page-content-wrapper">

                <div class="container-fluid">
                    <input type="hidden" value="<?php echo $user_id; ?>" id="data-id">
                    <input type="hidden" value="<?php echo $role; ?>" id="user-role">
                    <input type="hidden" value="<?php echo $country; ?>" id="user-country">
                    <input type="hidden" value="<?php echo $user_id; ?>" id="data-ud">
                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-30">
                                <div class="card-body">

                                    <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">
                                        <div class="custom-icon-table"><img src="assets/images/icons/sidebar/map-white.png"></div>Map
                                    </h2>
                                    <div class="row m-b-20">
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <!-- Country Dropdown -->
                                            <?php include_once('includes/dropdowns/country.php'); ?>
                                            <!-- Country Dropdown -->
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <!-- Project Dropdown -->
                                        <?php include_once('includes/dropdowns/project.php'); ?>
                                        <!-- Project Dropdown -->
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <!-- PM Dropdown -->
                                            <?php include_once('includes/dropdowns/pm.php'); ?>
                                            <!-- PM Dropdown -->
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                            <!-- SSM Dropdown -->
                                            <?php include_once('includes/dropdowns/ssm.php'); ?>
                                            <!-- SSM Dropdown -->
                                        </div>
                                        <div class="form-group col-xl-2 col-lg-2 col-md-4 col-sm-12 col-xs-12">
                                            <span class="badge font-20 text-plan" style="line-height: normal;background-color: #e2e2e2;border-radius: 0px;">Total SSM</span><span class="badge font-20 text-white" style="line-height: normal;border-radius: 0px;background-color: #ee008b;" id="smb_count"></span>
                                        </div>

                                        <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-12 col-xs-12 text-right">
                                            <button class="btn btn-plan" id="resetBtn">RESET</button>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <p class="text-center text-danger" id="errMsg"></p>
                                            <p class="text-center text-success" id="msgSuccess"></p>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-20">
                                            <div id="gmaps-markers" class="gmaps"></div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-20" style="margin: auto;">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-3" style="border: 1px solid gray;height: 50%;border-right: none;">
                                                            <h2 style="color: #6fcfaf;" id="sos_count"></h2>
                                                        </div>
                                                        <div class="col-9 sos-status" style="border: 1px solid gray;margin: auto;width: 100%;">
                                                            <img src="assets/images/map/sos.png" data-src='assets/images/map/sos.png' data-hover='assets/images/map/sos-hovered.png' class="img-fluid img-sos" style="margin: 30px;">
                                                            <h5 class="text-center text-muted"><b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Total number of SSMs that activated their SOS alert"></i>&nbsp;SOS</b></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-9 live-status" style="border: 1px solid gray;margin: auto;width: 100%;border-left: none;">
                                                            <img src="assets/images/map/live-new.png" data-src='assets/images/map/live-new.png' data-hover='assets/images/map/live-new-hovered.png' class="img-fluid img-live" style="margin: 30px;">
                                                            <h5 class="text-center text-muted"><b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Total number of SSMs that are live and in current use."></i>&nbsp;Live SSM</b></h5>
                                                        </div>
                                                        <div class="col-3" style="border: 1px solid gray;height: 50%;border-left: none;">
                                                            <h2 style="color: #6fcfaf;" id="ssm_count"></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="row">
                                                    <div class="col-6">
                                                        <div class="row" style="background-color:black;">
                                                            <div class="col-12" style="margin: auto;width: 100%;">
                                                                <img src="assets/images/map/tes_logo.png" class="img-fluid" style="margin: 20px;">
                                                            </div>
                                                            <div class="col-12" style="margin: auto;width: 100%;">
                                                                <img src="assets/images/map/serial.PNG"class="img-fluid" style="margin: 20px;margin-top:0px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-3" style="border: 1px solid gray;height: 50%;border-right: none;">
                                                            <h2 style="color: #6fcfaf;">34</h2>
                                                        </div>
                                                        <div class="col-9 report-status" style="border: 1px solid gray;margin: auto;width: 100%;">
                                                            <img src="assets/images/map/report-new.png" data-src='assets/images/map/report-new.png' data-hover='assets/images/map/report-new-hovered.png' class="img-fluid img-report" style="margin: 30px;">
                                                            <h5 class="text-center text-muted"><b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Total number of SSMs that requiere technical assistance"></i>&nbsp;ERROR</b></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-9 gf-status" style="border: 1px solid gray;margin: auto;width: 100%;border-left: none;">
                                                            <img src="assets/images/map/gf.png" data-src='assets/images/map/gf.png' data-hover='assets/images/map/gf-hovered.png' class="img-fluid img-gf" style="margin: 30px;">
                                                            <h5 class="text-center text-muted"><b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Total number of SSMs that are outside their authorised area "></i>&nbsp;GEO-LOCATION</b></h5>
                                                        </div>
                                                        <div class="col-3" style="border: 1px solid gray;height: 100%;border-left: none;">
                                                            <h2 style="color: #6fcfaf;">34</h2>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- Content  -->
        <footer class="footer">
            © <?php echo date('Y'); ?> Tespack - All rights reserved .
        </footer>

    </div> <!-- content Page-->
    </div> <!-- Wrapper-->

    <!-- Profile modal -->
    <?php include_once('includes/modal/profile.php'); ?>
    <!-- Profile modal -->
    <!-- Notification modal -->
    <?php include_once('includes/modal/notification.php'); ?>
    <!-- Notification modal -->
    <!-- Logout modal -->
    <?php include_once('includes/modal/logout.php'); ?>
    <!-- Logout modal -->
    <!-- SOS modal -->
    <div id="sosModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel">GEOFENCING</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <table id="datatable_gf" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SSM Reference</th>
                                            <th>User Responsible</th>
                                            <th>Project Assigned</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>SSM Reference</th>
                                            <th>User Responsible</th>
                                            <th>Project Assigned</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- Assigned SSM Section ends -->
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- SOS modal -->
    <!-- Live modal -->
    <div id="liveModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel">Live SSM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <table id="datatable_liveSSM" class="table table-borderless  text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>SSM Reference</th>
                                            <th>User Responsible</th>
                                            <th>Project Assigned</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>SN</th>
                                            <th>SSM Reference</th>
                                            <th>User Responsible</th>
                                            <th>Project Assigned</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- Assigned SSM Section ends -->
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- Live modal -->

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- google maps api -->
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDsfrDPuaM-HIXsGsFwmujW-CrE36KtmTE"></script>

    <!-- Gmaps file -->
    <script src="assets/plugins/gmaps/gmaps.min.js"></script>
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>

   <!-- Required datatable js -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- <script src="assets/pages/gmaps.js"></script> -->
    <script src="assets/js/pages/map.js"></script>
    <script src="assets/js/notification.js"></script>
</body>

</html>