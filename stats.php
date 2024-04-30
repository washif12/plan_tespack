<?php include_once('includes/header.php'); ?>
    <!-- DataTables -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">
    <!-- Sweet Alert -->
    <link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <!-- Dropzone css -->
    <link href="assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
    <style>
        #datatable_info,
        #datatable_paginate {
            display: none;
        }

        #datatable_length label {
            color: white;
        }

        .mbox {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin: 10px 55px 10px 25px;
            padding-left: 4px;
        }
    </style>
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
                            <a href="stats.php" class="waves-effect active">
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
                            <a href="map.php" class="waves-effect">
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
                    <h3 class="page-title">Dashboard Statistics </h3>
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
                                        <div class="custom-icon-table"><img src="assets/images/icons/sidebar/dashboard-white.png"></div>ENERGY STATISTICS
                                    </h2>
                                    <p class="text-muted m-b-30 font-14"></p>
                                    <div class="row">
                                        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12 m-b-10 ">
                                            <div class="row">
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <!-- Country Dropdown -->
                                                    <?php include_once('includes/dropdowns/country.php'); ?>
                                                    <!-- Country Dropdown -->
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <!-- Project Dropdown -->
                                                    <?php include_once('includes/dropdowns/project.php'); ?>
                                                    <!-- Project Dropdown -->
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <!-- PM Dropdown -->
                                                    <?php include_once('includes/dropdowns/pm.php'); ?>
                                                    <!-- PM Dropdown -->
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <!-- SSM Dropdown -->
                                                    <?php include_once('includes/dropdowns/ssm.php'); ?>
                                                    <!-- SSM Dropdown -->
                                                </div>
                                                <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                                    <label for="example-text-input-lg" class="col-form-label">From</label>
                                                </div>
                                                <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-4">
                                                    <input type="date" class="form-control" id="date-from" max="<?php echo date("Y-m-d"); ?>">
                                                </div>
                                                <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                                    <label for="example-text-input-lg" class="col-form-label">To</label>
                                                </div>
                                                <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-4">
                                                    <input type="date" class="form-control" id="date-to" max="<?php echo date("Y-m-d"); ?>">
                                                </div>
                                                <div class="form-group col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                    <button class="btn btn-plan" id="filterBtn">FILTER</button>
                                                </div>
                                                <div class="form-group col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                                    <button class="btn btn-plan" id="resetBtn">RESET</button>
                                                </div>
                                                <div class="form-group col-12">
                                                    <p class="text-center text-danger" id="errMsg"></p>
                                                    <p class="text-center text-success" id="msgSuccess"></p>
                                                </div>
                                            </div>
                                            <!--<div id="morris-line-example" class="morris-chart-height"></div>-->
                                            <div class="col-12 energyGraphContainer">
                                                <canvas id="lineChart" height="350"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12 m-b-10">
                                            <div class="row">
                                                <div class="col-12 text-center text-plan m-b-10">
                                                    <span class="badge font-20 text-plan" style="line-height: normal;background-color: #e2e2e2;border-radius: 0px;cursor: pointer;">Total SSM</span><span class="badge font-20 text-white" style="line-height: normal;border-radius: 0px;background-color: #ee008b;" id="smb_count"></span>
                                                </div>
                                                <div class="col-12 text-center text-plan m-b-10">
                                                    <span class="badge font-14 text-white" style="line-height: normal;border-radius: 0px;background-color: #ee008b;" id="smb_infos"></span>
                                                </div>
                                                <div class="col-12 text-center text-plan m-b-10">
                                                    <h3>Important Information</h3>
                                                </div>
                                                <div class="col-4">
                                                    <div class="bg-plan text-center" style="width: 100%;">
                                                        <p class="text-white m-b-20 p-t-10 font-14">
                                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Energy generated from solar"></i>&nbsp;
                                                            Solar Energy
                                                        </p>
                                                        <img src="assets/images/dash/sun-yellow.png" class="m-b-10 img-responsive" style="width: 50%;height: 50%;margin: auto;">
                                                    </div>
                                                    <div class="text-center" style="background-color: #f410a0;width: 100%;">
                                                        <p class="text-white font-20 p-b-10 p-t-10" id="info_solar"></p>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="bg-plan text-center" style="width: 100%;">
                                                        <p class="text-white m-b-20 p-t-10 font-14">
                                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Energy consumed from wall socket"></i>&nbsp;
                                                            Grid Energy
                                                        </p>
                                                        <img src="assets/images/pages/report/consumed.png" class="m-b-10 img-responsive" style="width: 50%;height: 50%;margin: auto;">
                                                    </div>
                                                    <div class="text-center" style="background-color: #f410a0;width: 100%;">
                                                        <p class="text-white font-20 p-b-10 p-t-10" id="info_grid"></p>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="bg-plan text-center" style="width: 100%;">
                                                        <p class="text-white m-b-20 p-t-10 font-14">
                                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Energy consumed from the battery"></i>&nbsp;
                                                            Battery Energy
                                                        </p>
                                                        <img src="assets/images/dash/energy-green.png" class="m-b-10 img-responsive" style="width: 50%;height: 50%;margin: auto;">
                                                    </div>
                                                    <div class="text-center" style="background-color: #f410a0;width: 100%;">
                                                        <p class="text-white font-20 p-b-10 p-t-10" id="info_battery"></p>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="bg-plan text-center" style="width: 100%;">
                                                        <p class="text-white m-b-20 p-t-10 font-14">
                                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Total Carbon emission reduced from the solar energy generated "></i>&nbsp;
                                                            CO2 Reduced
                                                        </p>
                                                        <img src="assets/images/dash/co2-reduce-white.png" class="m-b-10 img-responsive" style="width: 50%;height: 50%;margin: auto;">
                                                    </div>
                                                    <div class="text-center" style="background-color: #f410a0;width: 100%;">
                                                        <p class="text-white font-20 p-b-10 p-t-10" id="info_carbon"></p>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="bg-plan text-center" style="width: 100%;">
                                                        <p class="text-white m-b-20 p-t-10 font-14">
                                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Total number of SSMs in the field"></i>&nbsp;
                                                            Total SSM
                                                        </p>
                                                        <img src="assets/images/dash/smb-white.png" class="m-b-10 img-responsive" style="width: 50%;height: 50%;margin: auto;">
                                                    </div>
                                                    <div class="text-center" style="background-color: #f410a0;width: 100%;">
                                                        <p class="text-white font-20 p-b-10 p-t-10" id="total_ssm_imp"></p>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="bg-plan text-center" style="width: 100%;">
                                                        <p class="text-white m-b-20 p-t-10 font-14">
                                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Total hours of the Solar Media Bag usage"></i>&nbsp;
                                                            Hours Used
                                                        </p>
                                                        <img src="assets/images/dash/time-white.png" class="m-b-10 img-responsive" style="width: 50%;height: 50%;margin: auto;">
                                                    </div>
                                                    <div class="text-center" style="background-color: #f410a0;width: 100%;">
                                                        <p class="text-white font-20 p-b-10 p-t-10" id="total_rt"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 m-t-20">
                                            <div class="col-12 text-center text-plan m-b-20">
                                                <h3>FEATURED COUNTRIES</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 text-center p-r-0 p-l-0" style="border: 4px solid #005aa7;">
                                                    <h5 class="text-white bg-plan p-b-10 p-t-10 m-t-0">HIGHEST TEACHING HOURS</h5>
                                                    <table id="datatable" class="table table-borderless dt-responsive nowrap text-center teaching-hours-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead xstyle="display: none;">
                                                            <tr>
                                                                <th>SN</th>
                                                                <!-- <th></th> -->
                                                                <th>Country</th>
                                                                <th>Device Runtime</th>
                                                            </tr>
                                                        </thead>
                                                        <!--<tbody>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></td>
                                                                                <td>Country</td>
                                                                                <td>1200 Hours</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2</td>
                                                                                <td><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></td>
                                                                                <td>Country</td>
                                                                                <td>120Hours</td>
                                                                            </tr>
                                                                        </tbody>-->
                                                    </table>
                                                    <button id="btn-example-load-more" class="btn btn-sm btn-plan m-b-10" style="display:none">Load More</button>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 text-center p-r-0 p-l-0" style="border: 4px solid #005aa7;">
                                                    <h5 class="text-white bg-plan p-b-10 p-t-10 m-t-0">SOLAR ENERGY GENERATED</h5>
                                                    <table id="datatable" class="table table-borderless dt-responsive nowrap text-center solar" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead xstyle="display: none;">
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Country</th>
                                                                <!-- <th></th> -->
                                                                <th>Solar Energy(Watt)</th>
                                                            </tr>
                                                        </thead>
                                                        <!--<tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></td>
                                                                    <td>Country</td>
                                                                    <td>1200W</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></td>
                                                                    <td>Country</td>
                                                                    <td>120W</td>
                                                                </tr>
                                                            </tbody>-->
                                                    </table>
                                                    <button id="btn-example-load-more-solar" class="btn btn-sm btn-plan m-b-10" style="display:none">Load More</button>
                                                </div>
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
    <!-- Required datatable js -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/jszip.min.js"></script>
    <script src="assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <!-- Chart JS -->
    <script src="assets/plugins/moment/moment.js"></script>
    <script src="assets/plugins/chart.js/chart.min.js"></script>
    <script src="assets/pages/chartjs.init.js"></script>
    <!--Morris Chart
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="assets/pages/morris.init.js"></script>-->
    <script type="text/javascript" src="assets/js/loadMore.min.js"></script>
    <!-- Sweet-Alert  -->
    <script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <script src="assets/pages/sweet-alert.init.js"></script>
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>
    <script src="assets/js/pages/stats.js"></script>
    <script src="assets/js/notification.js"></script>

</body>

</html>