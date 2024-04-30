<?php include_once('includes/header.php'); ?>
<!-- DataTables -->
<link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/datatables/select.min.css" rel="stylesheet" type="text/css" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<!-- Dropzone css -->
<link href="assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">

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
                            <a href="report.php" class="waves-effect active">
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
                    <h3 class="page-title"> Reports </h3>
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
                    <input type="hidden" value="<?php echo $fullName; ?>" id="data-name">
                    <input type="hidden" value="<?php echo $user_id; ?>" id="data-ud">

                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-30">
                                <div class="card-body">

                                    <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">
                                        <div class="custom-icon-table"><img src="assets/images/icons/sidebar/reports-white.png"></div>Reports
                                        <!-- <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#downloadModal" href="#" style="float: right;margin-right: 5%;">Download All</button> -->
                                    </h2>
                                    <p class="text-muted m-b-30 font-14"></p>
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
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <!-- SSM Dropdown -->
                                            <?php include_once('includes/dropdowns/ssm.php'); ?>
                                            <!-- SSM Dropdown -->
                                        </div>
                                        <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                            <label for="example-text-input-lg" class="col-form-label">From</label>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-4 text-left">
                                            <input type="date" class="form-control" id="date-from" max="<?php echo date("Y-m-d"); ?>">
                                        </div>
                                        <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                            <label for="example-text-input-lg" class="col-form-label">To</label>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-4 text-left">
                                            <input type="date" class="form-control" id="date-to" max="<?php echo date("Y-m-d"); ?>">
                                        </div>
                                        <div class="form-group col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-4 text-right">
                                            <button class="btn btn-plan" id="filterBtn">FILTER</button>
                                        </div>
                                        <div class="form-group col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-4 text-right">
                                            <button class="btn btn-plan" id="resetBtn">RESET</button>
                                        </div>
                                        <div class="form-group col-12">
                                            <p class="text-center text-danger" id="errMsg"></p>
                                            <p class="text-center text-success" id="msgSuccess"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body text-center" style="padding: 0;">
                                                    <h4 class="text-plan text-center m-b-30">Energy Report</h4>
                                                    <div class="row" id="energy-report-pdf">
                                                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row" id="energy-report-pdf">
                                                                <div class="col-4 text-right p-r-0" style="margin: auto;">
                                                                    <img class="" src="assets/images/pages/report/consumed.png" alt="Generic placeholder image" height="64">
                                                                </div>
                                                                <div class="col-8">
                                                                    <h6><b>Grid Energy</b></h6>
                                                                    <p class="font-12">Energy consumed from wall socket</p>
                                                                </div>
                                                                <div class="col-4 text-right p-r-0" style="margin: auto;">
                                                                    <img class="" src="assets/images/pages/report/generated.png" alt="Generic placeholder image" height="64">
                                                                </div>
                                                                <div class="col-8">
                                                                    <h6><b>Solar Energy</b></h6>
                                                                    <p class="font-12">Energy generated from solar</p>
                                                                </div>
                                                                <div class="col-4 text-right p-r-0" style="margin: auto;">
                                                                    <img class="" src="assets/images/dash/energy-green.png" alt="Generic placeholder image" height="64">
                                                                </div>
                                                                <div class="col-8">
                                                                    <h6><b>Battery Energy</b></h6>
                                                                    <p class="font-12">Energy consumed from the battery</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 energyGraphContainer">
                                                            <!--<div id="morris-line-example"></div>-->
                                                            <canvas id="lineChart" height="350"></canvas>
                                                        </div>
                                                        <div class="col-12 m-b-30">
                                                            <div class="m-b-10 m-t-10">
                                                                <div class="text-center" style="padding: 0;">
                                                                    <!--<img id="" src="" alt="hardware graph" style="display: none;">-->
                                                                    <table id="energyReportTable" class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;display: none;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Date</th>
                                                                                <th>From Solar</th>
                                                                                <th>From Grid</th>
                                                                                <th>From Battery</th>
                                                                                <th>User Total usages</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tfoot>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Date</th>
                                                                                <th>From Solar</th>
                                                                                <th>From Grid</th>
                                                                                <th>From Battery</th>
                                                                                <th>User Total usages</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button id="btn_energy" class="btn btn-plan m-b-10 btn_download">DownLoad Energy Info</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body text-center" style="padding: 0;">
                                                    <h4 class="text-plan text-center m-b-30">Carbon Emission Report</h4>
                                                    <div class="row" id="carbon-report-pdf">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 carbonGraphContainer">
                                                            <!--<div id="morris-line-carbon"></div>-->
                                                            <canvas id="morris-line-carbon" height="350"></canvas>
                                                        </div>
                                                        <div class="col-12 m-b-30">
                                                            <div class="m-b-10 m-t-10">
                                                                <div class="text-center" style="padding: 0;">
                                                                    <img id="carbon" src="" alt="carbon graph" style="display: none;">
                                                                    <table id="carbonEmissionPdf" class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;display: none;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Date</th>
                                                                                <th>CO<sub>2</sub> Emission</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tfoot>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Date</th>
                                                                                <th>CO<sub>2</sub> Emission</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button id="btn_carbon" class="btn btn-plan m-b-10 btn_download">DownLoad Carbon Emission Info</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body text-center" style="padding: 0;">
                                                    <h4 class="text-plan text-center m-b-30">Geofence Alert Report</h4>
                                                    <div class="row" id="carbon-report-pdf">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 carbonGraphContainer">
                                                            <canvas id="pie" height="350"></canvas>
                                                        </div>
                                                        <div class="col-12 m-b-10">
                                                            <div class="m-b-10 m-t-10">
                                                                <div class="text-center" style="padding: 0;">
                                                                    <img id="gfUrl" src="" alt="security graph" style="display: none;">
                                                                    <table id="securityPdf" class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;display: none;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Country</th>
                                                                                <th>Total Geofence Alerts</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tfoot>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Country</th>
                                                                                <th>Total Geofence Alerts</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button id="btn_security" class="btn btn-plan m-b-10 btn_download">Download Geofence Alert Info</button>
                                                    <!-- <button data-toggle="modal" data-target="#securityReportModal" class="btn btn-sm btn-plan m-b-10">Learn More</button> -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12"> -->
                                        <div class="col-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body text-center" style="padding: 0;">
                                                    <h4 class="text-plan text-center m-b-30">Battery Cycle Report</h4>
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 text-center" style="margin: auto;">
                                                            <h5>
                                                                <img src="assets/images/pages/report/faulty battery.png" style="max-width: 48px;"><br>Batteries to be Recycled
                                                            </h5>
                                                            <h1 style="width: 50%;margin: auto;background-color: #ffcc05;padding: 10px;border-radius: 5px;" class="battery_faulty"></h1>
                                                        </div>
                                                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12 batteryCycleContainer">
                                                            <canvas id="barBattery" height="350"></canvas>
                                                        </div>
                                                        <div class="col-12 m-b-10">
                                                            <div class="m-b-10 m-t-10">
                                                                <div class="text-center" style="padding: 0;">
                                                                    <img id="hardwareUrlBattery" src="" alt="hardware graph" style="display: none;">
                                                                    <table id="hardwareBatteryPdf" class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;display: none;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Battery ID</th>
                                                                                <th>Cycle</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tfoot>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Battery ID</th>
                                                                                <th>Cycle</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button id="btn_cycle" class="btn btn-plan m-b-10 btn_download">DownLoad Battery Cycle Info</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($role == '0'): ?>
                                        <div class="col-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body text-center" style="padding: 0;">
                                                    <h4 class="text-plan text-center m-b-30">Hardware Report</h4>
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 text-center" style="margin: auto;">
                                                            <h5>
                                                                <img src="assets/images/pages/report/faulty battery.png" style="max-width: 48px;"><br>Batteries to be Recycled
                                                            </h5>
                                                            <h1 style="width: 50%;margin: auto;background-color: #ffcc05;padding: 10px;border-radius: 5px;" class="battery_faulty"></h1>
                                                        </div>
                                                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                                            <canvas id="bar" height="350"></canvas>
                                                        </div>
                                                        <div class="col-12 m-b-10">
                                                            <div class="m-b-10 m-t-10">
                                                                <div class="text-center" style="padding: 0;">
                                                                    <img id="harwareUrl" src="" alt="hardware graph" style="display: none;">
                                                                    <table id="hardwarePdf" class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;display: none;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Total Batteries</th>
                                                                                <th>Cycle Range</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tfoot>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Total Batteries</th>
                                                                                <th>Cycle Range</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button id="btn_battery" class="btn btn-plan m-b-10 btn_download">DownLoad Total Battery Cycle Info</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <!-- <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body text-center" style="padding: 0;">
                                                    <h4 class="text-plan text-center m-b-30">Faulty SSMs Report</h4>
                                                    <table class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;">
                                                        <thead>
                                                            <tr>
                                                                <th>S2MS ID</th>
                                                                <th>Project</th>
                                                                <th>Country</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Project A</td>
                                                                <td>Country</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>Project B</td>
                                                                <td>Country</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button id="btn-example-load-more" data-toggle="modal" data-target="#smbReportModal" class="btn btn-sm btn-plan m-b-10">Load More</button>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-12 m-b-30">
                                            <div class="card m-b-30 p-b-10" style="border-radius:20px;">
                                                <div class="card-body text-center" style="padding: 0;">
                                                    <h4 class="text-plan text-center m-b-30">Replacement History</h4>
                                                    <h5 class="">Click the button below to download parts replacement informations.</h5>
                                                    <table id="part-replace" class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;display: none;">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Replacement</th>
                                                                <th>Quantity</th>
                                                                <th>Reference</th>
                                                                <th>Country</th>
                                                                <th>Project</th>
                                                                <th>Responsible</th>
                                                                <th>Email</th>
                                                                <th>Phone</th>
                                                            </tr>
                                                        </thead>

                                                        <tfoot>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Replacement</th>
                                                                <th>Quantity</th>
                                                                <th>Reference</th>
                                                                <th>Country</th>
                                                                <th>Project</th>
                                                                <th>Responsible</th>
                                                                <th>Email</th>
                                                                <th>Phone</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <button id="btn_parts" class="btn btn-plan m-b-10 btn_download">DownLoad Replacement Info</button>
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

        </div>
    </div> <!-- Content  -->
    <footer class="footer">
        © <?php echo date('Y'); ?> Tespack - All rights reserved .
    </footer>
    <img id="url" style="display: none;" />
    </div> <!-- content Page-->
    </div> <!-- Wrapper-->
    <!-- Profile modal -->
    <?php include_once('includes/modal/profile.php'); ?>
    <!-- Profile modal -->
    <!-- Download modal -->
    <?php include_once('includes/modal/report_download.php'); ?>
    <!-- Download modal -->
    <!-- Notification modal -->
    <?php include_once('includes/modal/notification.php'); ?>
    <!-- Notification modal -->
    <!-- Logout modal -->
    <?php include_once('includes/modal/logout.php'); ?>
    <!-- Logout modal -->
    <!-- Dowload modal -->
    <div id="downloadModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-download"></i>&nbsp; DownLoad All </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body before-dl">
                    <h6>Are you sure you want to download all the reports?</h6>
                </div>
                <div class="modal-footer before-dl">
                    <button type="button" class="btn btn-plan btn-download-all">Yes</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light">No</button>
                </div>
                <div class="modal-body after-dl">
                    <h6>Congrats! All the reports are downloded.</h6>
                </div>
                <div class="modal-footer after-dl text-center">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">OK</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- Download modal -->
    <!-- SMB Report modal -->
    <div id="smbReportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-exclamation-triangle"></i>&nbsp; Error Report </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body before-dl text-center">
                    <table id="faulty-smb" class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>S2MS ID</th>
                                <th>Project</th>
                                <th>Country</th>
                                <th>S2MS Error</th>
                                <th>Power Bank Error</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>Project A</td>
                                <td>Country</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2</td>
                                <td>Project B</td>
                                <td>Country</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- SMB Report modal -->
    <!-- Security Report modal -->
    <div id="securityReportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-exclamation-triangle"></i>&nbsp; Security Report </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body before-dl">
                    <table class="table table-bordered text-center m-b-20" style="width: 90%;margin: auto;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>S2MS ID</th>
                                <th>Project</th>
                                <th>Country</th>
                                <th>SOS Activated (Times)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>Project A</td>
                                <td>Country</td>
                                <td>23</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2</td>
                                <td>Project B</td>
                                <td>Country</td>
                                <td>12</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- Security Report modal -->

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
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>
    <!-- Download js -->
    <script src="assets/js/common/reportDownload.js"></script>
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

    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <!-- Chart JS -->
    <script src="assets/plugins/moment/moment.js"></script>
    <script src="assets/plugins/chart.js/chart.min.js"></script>
    <script src="assets/pages/chartjs.init.js"></script>
    <!--Morris Chart
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="assets/pages/morris-report.init.js"></script>-->
    <!-- Chart JS -->
    <script src="assets/plugins/pdfReport/html2canvas.min.js"></script>
    <script src="assets/plugins/pdfReport/jspdf.min.js"></script>
    <script src="assets/js/images.js"></script>
    <script src="assets/js/notification.js"></script>

    <script>
        $(document).ready(function() {
            /* Ajax Loader */
            $(document).ajaxSend(function() {
                $("#overlay-loader").fadeIn(300);
            });
            $(document).ajaxStop(function() {
                $("#overlay-loader").fadeOut(300);
            });
            $(".dt-buttons").css('display', 'none');
            /* Get Image for line, carbon graphs */
            var user_id = $("#data-id").val();
            loadNotification(user_id);
            let imgLine, imgCarbon = "";
            async function setLineImage() {
                imgLine,
                imgCarbon = "";
                const canvasLine = document.getElementById('lineChart')
                imgLine = canvasLine.toDataURL("img/png")


                const canvasCarbon = document.getElementById('morris-line-carbon')
                imgCarbon = canvasCarbon.toDataURL("img/png")

                //document.getElementById('carbon').src = imgCarbon;
                //console.log("cc", imgCarbon);
            }
            /* Datatable set functions */
            var energyDT = "";
            var carbonDT = "";
            var batteryDT = ""
            const setEnergyDataInTable = (data) => {
                energyDT = $('#energyReportTable').DataTable({
                    data: data,
                    columns: [{
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'y'
                        },
                        {
                            data: 'a'
                        },
                        {
                            data: 'b'
                        },
                        {
                            data: 'c'
                        },
                        {
                            data: 'd'
                        }

                    ],
                    searching: false,
                    paging: false,
                    sorting: false,
                    dom: 'Bt',
                    buttons: [{
                        extend: 'pdf',
                        text: 'DownLoad Energy Info',
                        title: function() {
                            return 'Energy Info';
                        },
                        className: 'btn-plan btn-energy',
                        footer: true,
                        customize: function(doc) {
                            doc.content[1].table.body[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content[1].table.body.slice(-1)[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 350,
                                image: imgLine
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: tespackPowered
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: planLogo
                            });
                        },
                        filename: function() {
                            return 'energy-info'
                        }
                    }],
                    drawCallback: function() {
                        //var hasRows = this.api().rows({ filter: 'applied' }).data().length > 0;
                        //$('.btn-group.btn-group-vertical')[0].style.display = 'none'
                        $(".dt-buttons").css('display', 'none');
                    }
                })
            }
            const setHardwareDataInTable = (data) => {

                $('#hardwarePdf').DataTable({
                    data: data,
                    columns: [{
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'total_batteries'
                        },
                        {
                            data: 'range'
                        }

                    ],
                    searching: false,
                    paging: false,
                    sorting: false,
                    dom: 'tB',
                    buttons: [{
                        extend: 'pdf',
                        text: 'DownLoad Total Battery Cycle Info',
                        title: function() {
                            return 'Total Battery Cycle Info';
                        },
                        className: 'btn-plan btn-battery',
                        footer: true,
                        customize: function(doc) {
                            doc.content[1].table.body[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content[1].table.body.slice(-1)[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 350,
                                image: hardwareUrl
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: tespackPowered
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: planLogo
                            });

                        },
                        filename: function() {
                            return 'total-battery-cycle-info'
                        }
                    }],
                    drawCallback: function() {
                        //var hasRows = this.api().rows({ filter: 'applied' }).data().length > 0;
                        //$('.btn-group.btn-group-vertical')[0].style.display = 'none'
                        $(".dt-buttons").css('display', 'none');
                    }
                })
            }

            const setBatteryDataInTable = (data) => {

                batteryDT = $('#hardwareBatteryPdf').DataTable({
                    data: data,
                    columns: [{
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'battery_id'
                        },
                        {
                            data: 'cycle',
                            // render: function(data, type, row, meta) {
                            //     if(data<=600) {
                            //         return '<span class="badge font-14" style="background-color:#2dc937;">'+data+'</span>';
                            //     } else if(data>600 && data<=1200) {
                            //         return '<span class="badge font-14" style="background-color:#e7b416;">'+data+'</span>';
                            //     } else {
                            //         return '<span class="badge font-14" style="background-color:#cc3232;">'+data+'</span>';
                            //     }
                            // }
                        }

                    ],
                    searching: false,
                    paging: false,
                    sorting: false,
                    dom: 'tB',
                    buttons: [{
                        extend: 'pdf',
                        text: 'DownLoad Battery Cycle Info',
                        title: function() {
                            return 'Battery Cycle Info';
                        },
                        className: 'btn-plan btn-cycle',
                        footer: true,
                        customize: function(doc) {
                            doc.content[1].table.body[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content[1].table.body.slice(-1)[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            //doc.content[1].margin = [ 100, 0, 100, 0 ];
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 350,
                                image: hardwareUrlBattery
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: tespackPowered
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: planLogo
                            });

                        },
                        filename: function() {
                            return 'battery-cycle-info'
                        }
                    }],
                    drawCallback: function() {
                        //var hasRows = this.api().rows({ filter: 'applied' }).data().length > 0;
                        //$('.btn-group.btn-group-vertical')[0].style.display = 'none'
                        $(".dt-buttons").css('display', 'none');
                    }
                })
            }

            const setSecurityDataInTable = (data) => {

                $('#securityPdf').DataTable({
                    data: data,
                    columns: [{
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'country'
                        },
                        {
                            data: 'count'
                        }

                    ],
                    searching: false,
                    paging: false,
                    sorting: false,
                    dom: 'tB',
                    buttons: [{
                        extend: 'pdf',
                        text: 'DownLoad Geofence Alert Info',
                        title: function() {
                            return 'Geofence Alert Info';
                        },
                        className: 'btn-plan btn-security',
                        footer: true,
                        customize: function(doc) {
                            doc.content[1].table.body[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content[1].table.body.slice(-1)[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 350,
                                image: gfUrl
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: tespackPowered
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: planLogo
                            });

                        },
                        filename: function() {
                            return 'geofence-alert-info'
                        }
                    }],
                    drawCallback: function() {
                        //var hasRows = this.api().rows({ filter: 'applied' }).data().length > 0;
                        //$('.btn-group.btn-group-vertical')[0].style.display = 'none'
                        $(".dt-buttons").css('display', 'none');
                    }
                })
            }

            const setCO2DataInTable = (data) => {

                carbonDT = $('#carbonEmissionPdf').DataTable({
                    data: data,

                    columns: [{
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'date'
                        },
                        {
                            data: 'total_foot_print'
                        }
                    ],
                    searching: false,
                    paging: false,
                    sorting: false,
                    dom: 'Bt',
                    buttons: [{
                        extend: 'pdf',
                        text: 'DownLoad Carbon Emission Info',
                        title: function() {
                            return 'Carbon Emission Info';
                        },
                        className: 'btn-plan btn-carbon',
                        footer: true,
                        customize: function(doc) {
                            doc.content[1].table.body[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content[1].table.body.slice(-1)[0].forEach(function(h) {
                                h.fillColor = '#005aa7';
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 350,
                                image: imgCarbon
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: tespackPowered
                            });
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 0],
                                alignment: 'center',
                                width: 150,
                                image: planLogo
                            });
                        },
                        filename: function() {
                            return 'carbon-emission-info'
                        }
                    }],
                    drawCallback: function() {
                        $(".dt-buttons").css('display', 'none');
                    }
                })
            }
            /* Reset Line graphs */
            const resetLineGraph = () => {
                $('#lineChart').remove();
                $('.energyGraphContainer').append('<canvas id="lineChart" height="350"></canvas>');
                $('#morris-line-carbon').remove();
                $('.carbonGraphContainer').append('<canvas id="morris-line-carbon" height="350"></canvas>');
            }
            /* Load Graph data initially */
            var energyChartData;
            var initialRole = $("#user-role").val();
            var initialCountry = $("#user-country").val();
            var initialPM = $('#pro_manager').val();
            // var arr = {'user_id': user_id, 'country': '', 'project': '', 'pro_manager': '', 'ssm': ''}
            // if(initialRole=='3') {
            //     arr = {'user_id': user_id, 'country': initialCountry, 'project': '', 'pro_manager': '', 'ssm': ''}
            // }
            // else if(initialRole=='2') {
            //     arr = {'user_id': user_id, 'country': '', 'project': '', 'pro_manager': $('#pro_manager').val(), 'ssm': ''}
            // }
            // else if(initialRole=='4') {
            //     arr = {'user_id': user_id, 'country': '', 'project': $('#project').val(), 'pro_manager': '', 'ssm': ''}
            // }
            // else {
            //     arr = {'user_id': user_id, 'country': '', 'project': '', 'pro_manager': '', 'ssm': ''}
            // }
            var arr = {
                'user_id': user_id,
                'country': '',
                'project': Number('0'),
                'pro_manager': Number('0'),
                'ssm': '',
                'from_date': '',
                'to_date': ''
            }
            if (initialRole == '3') {
                arr = {
                    'user_id': user_id,
                    'country': initialCountry,
                    'project': Number('0'),
                    'pro_manager': Number('0'),
                    'ssm': '',
                    'from_date': '',
                    'to_date': ''
                }
            } else if (initialRole == '2') {
                arr = {
                    'user_id': user_id,
                    'country': '',
                    'project': Number('0'),
                    'pro_manager': Number($('#pro_manager').val()),
                    'ssm': '',
                    'from_date': '',
                    'to_date': ''
                }
            } else if (initialRole == '4') {
                arr = {
                    'user_id': user_id,
                    'country': '',
                    'project': Number($('#project').val()),
                    'pro_manager': Number('0'),
                    'ssm': '',
                    'from_date': '',
                    'to_date': ''
                }
            } else {
                arr = {
                    'user_id': user_id,
                    'country': '',
                    'project': Number('0'),
                    'pro_manager': Number('0'),
                    'ssm': '',
                    'from_date': '',
                    'to_date': ''
                }
            }
            var chartData;
            var carbonChartData;

            var solarDataForGraph = [];
            var gridDataForGraph = [];
            var batteryDataForGraph = [];
            var datesForGraph = [];

            var dataForCarbonGraph = [];
            var datesForCarbonGraph = [];

            $.ajax({
                type: "POST",
                url: "assets/api/new_map_data.php",
                data: JSON.stringify(arr)
            }).done(function(result) {
                console.log(result);
                //$("#morris-line-example").empty();
                //$("#morris-line-carbon").empty();
                if (result.energy_data.length == 0) {
                    $("#errMsg").text('Sorry! No data found.').show().delay(10000).hide("slow");
                    energyChartData = $.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                    $.ChartJsLine.respChart($("#lineChart"), 'Line', energyChartData.lineCharts, energyChartData.lineOpt);
                    $.ChartJsCarbon.init(dataForCarbonGraph, datesForCarbonGraph);
                } else {
                    chartData = result.energy_data;
                    carbonChartData = result.carbon_emission;

                    setEnergyDataInTable(chartData);

                    setCO2DataInTable(result.carbon_emission);
                    jQuery.each(chartData, function(index, item) {
                        solarDataForGraph.push(item.a);
                        gridDataForGraph.push(item.b);
                        batteryDataForGraph.push(item.c);
                        //datesForGraph.push(item.y);
                        /* Converting to current timezone */
                        var dbDateTime = new Date(item.y);
                        var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                        var dbOffset = dbDateTime.getTimezoneOffset();
                        var thisTimeZoneMs = dbDateTimeMs - (dbOffset * 60 * 1000);
                        var thisTimeZone = new Date(thisTimeZoneMs);
                        datesForGraph.push(thisTimeZone);
                    });
                    jQuery.each(carbonChartData, function(index, item) {
                        dataForCarbonGraph.push(item.total_foot_print);
                        datesForCarbonGraph.push(item.date);
                    });
                    //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                    energyChartData = $.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                    $.ChartJsLine.respChart($("#lineChart"), 'Line', energyChartData.lineCharts, energyChartData.lineOpt);
                    $.ChartJsCarbon.init(dataForCarbonGraph, datesForCarbonGraph);
                    setTimeout(function() {
                        setLineImage();
                    }, 3000);
                }
            });
            /* Battery Chart Individual */
            var barDataBattery = [];
            var barLabelBattery = [];
            var hardwareUrlBattery = "";
            var dataForBatCycle = [];
            $.ajax({
                type: "POST",
                url: "assets/api/battery_cycle_data.php",
                data: JSON.stringify(arr)
            }).done(function(result) {
                console.log(result);
                //var data = jQuery.parseJSON(result);
                if (result.device.length > 0) {
                    jQuery.each(result.device, function(index, item) {
                        barDataBattery.push(item.cycle);
                        barLabelBattery.push(item.battery_id);
                        dataForBatCycle.push(item);
                        // if(item.ssm.length>0) {
                        //     jQuery.each(item.ssm, function(indexBat, itemBat) {
                                
                        //     });
                        // }
                    });
                    $.ChartJsBattery.init(barDataBattery, barLabelBattery);
                    setBatteryDataInTable(dataForBatCycle);
                    
                    setTimeout(function() {
                        //setLineImage();
                        const barChartImgBattery = document.getElementById('barBattery');
                        hardwareUrlBattery = barChartImgBattery.toDataURL("img/png");
                    }, 3000);
                }
                else {
                    $.ChartJsBattery.init(barDataBattery, barLabelBattery);
                }
                $('.battery_faulty').text(result.total_fault_battery);
            });
            /* Get SMB count */
            var userData = {
                role: <?php echo $role; ?>,
                country: '<?php echo $country; ?>'
            }
            var projectHtml = $('#project').get(0).innerHTML;
            var countryHtml = $('#country').get(0).innerHTML;
            var pmHtml = $('#pro_manager').get(0).innerHTML;
            var ssmHtml = $('#ssm_device').get(0).innerHTML;
            /* Filter button with date and SSM */
            $('#filterBtn').prop('disabled', true);
            $(document).on('change', 'input[type=date]', function() {
                if ($(this).val() == '') {
                    $('#filterBtn').prop('disabled', true);
                } else {
                    $('#filterBtn').prop('disabled', false);
                }
            });
            //$('#morris-line-example').css('display', 'hidden');
            $(document).on('click', '#filterBtn', function() {
                // var formData = JSON.stringify({
                //     user_id: user_id,
                //     ssm: $("#ssm_device").val(),
                //     from_date: $("#date-from").val(),
                //     to_date: $("#date-to").val(),
                //     project: $("#project").val(),
                //     country: $("#country").val(),
                //     pro_manager: $("#pro_manager").val()
                // });
                arr.from_date = $("#date-from").val();
                arr.to_date = $("#date-to").val();
                $.ajax({
                    type: "POST",
                    url: "assets/api/new_map_data.php",
                    data: JSON.stringify(arr)
                }).done(function(result) {
                    console.log(result);
                    resetLineGraph();
                    //$("#morris-line-example").empty();
                    //$("#morris-line-carbon").empty();
                    solarDataForGraph = [];
                    gridDataForGraph = [];
                    batteryDataForGraph = [];
                    datesForGraph = [];

                    dataForCarbonGraph = [];
                    datesForCarbonGraph = [];
                    if (result.energy_data.length == 0) {
                        $("#errMsg").text('Sorry! No data found.').show().delay(10000).hide("slow");
                        energyChartData = $.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        $.ChartJsLine.respChart($("#lineChart"), 'Line', energyChartData.lineCharts, energyChartData.lineOpt);
                        $.ChartJsCarbon.init(dataForCarbonGraph, datesForCarbonGraph);
                    } else {
                        chartData = result.energy_data;
                        carbonChartData = result.carbon_emission;
                        if(energyDT!='') {
                            energyDT.destroy();
                        }
                        setEnergyDataInTable(chartData);
                        if(carbonDT!='') {
                            carbonDT.destroy();
                        }
                        setCO2DataInTable(carbonChartData);
                        //$.MorrisCharts.init(chartData, carbonChartData);
                        jQuery.each(chartData, function(index, item) {
                            solarDataForGraph.push(item.a);
                            gridDataForGraph.push(item.b);
                            batteryDataForGraph.push(item.c);
                            //datesForGraph.push(item.y);
                            /* Converting to current timezone */
                            var dbDateTime = new Date(item.y);
                            var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                            var dbOffset = dbDateTime.getTimezoneOffset();
                            var thisTimeZoneMs = dbDateTimeMs - (dbOffset * 60 * 1000);
                            var thisTimeZone = new Date(thisTimeZoneMs);
                            datesForGraph.push(thisTimeZone);
                        });
                        jQuery.each(carbonChartData, function(index, item) {
                            dataForCarbonGraph.push(item.total_foot_print);
                            datesForCarbonGraph.push(item.date);
                        });
                        //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        energyChartData = $.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        $.ChartJsLine.respChart($("#lineChart"), 'Line', energyChartData.lineCharts, energyChartData.lineOpt);
                        $.ChartJsCarbon.init(dataForCarbonGraph, datesForCarbonGraph);
                        setTimeout(function() {
                            setLineImage();
                        }, 3000);
                    }
                });
                //$.MorrisCharts.init();
                /* Battery Chart Individual */
                $.ajax({
                type: "POST",
                url: "assets/api/battery_cycle_data.php",
                data: JSON.stringify(arr)
                }).done(function(result) {
                    //console.log(result.device);
                    $('#barBattery').remove();
                    $('.batteryCycleContainer').append('<canvas id="barBattery" height="350"></canvas>');
                    barDataBattery = [];
                    barLabelBattery = [];
                    hardwareUrlBattery = '';
                    dataForBatCycle = [];
                    if(batteryDT!='') {
                        batteryDT.destroy();
                    }
                    //var data = jQuery.parseJSON(result);
                    if (result.device.length > 0) {
                        jQuery.each(result.device, function(index, item) {
                            barDataBattery.push(item.cycle);
                            barLabelBattery.push(item.battery_id);
                            dataForBatCycle.push(item);
                        });
                        $.ChartJsBattery.init(barDataBattery, barLabelBattery);
                        setBatteryDataInTable(dataForBatCycle);
                        setTimeout(function() {
                            //setLineImage();
                            const barChartImgBattery = document.getElementById('barBattery')
                            hardwareUrlBattery = barChartImgBattery.toDataURL("img/png")
                        }, 3000);
                    }
                    else {
                        $.ChartJsBattery.init(barDataBattery, barLabelBattery);
                    }
                    $('.battery_faulty').text(result.total_fault_battery);
                });
            });
            /* Changing dropdowns on select */
            var selected_project;
            var selected_pm;
            var selected_ssm;
            //var arr = {'country':'','project':'','pro_manager':'','ssm':''}
            $(document).on('change', 'select', function() {
                arr = {
                    'user_id': user_id,
                    'country': '',
                    'project': '',
                    'pro_manager': '',
                    'ssm': ''
                };
                if ($(this).attr("id") == 'country') {
                    arr.country = $(this).val();
                    arr.project = Number('0');
                    arr.pro_manager = Number('0');
                } else if ($(this).attr("id") == 'project') {
                    arr.project = Number($(this).val());
                    selected_project = $(this).find("option:selected").text();
                    arr.pro_manager = Number('0');
                } else if ($(this).attr("id") == 'pro_manager') {
                    arr.pro_manager = Number($(this).val());
                    selected_pm = $(this).find("option:selected").text();
                    arr.project = Number('0');
                } else if ($(this).attr("id") == 'ssm_device') {
                    arr.ssm = $(this).val();
                    selected_ssm = $(this).find("option:selected").text();
                    arr.project = Number('0');
                    arr.pro_manager = Number('0');
                    if ($(this).val() != null) {
                        $('#filterBtn').prop('disabled', false);
                    } else {
                        $('#filterBtn').prop('disabled', true);
                    }
                }
                console.log(arr);
                var selectData = {
                    type: $(this).attr("id"),
                    value: $(this).val()
                };
                $.ajax({
                    type: "POST",
                    url: "assets/api/new_map_data.php",
                    data: JSON.stringify(arr),
                    success: function(result) {
                        //var data = jQuery.parseJSON(result);
                        console.log(result);
                        resetLineGraph();
                        //$("#morris-line-example").empty();
                        //$("#morris-line-carbon").empty();
                        solarDataForGraph = [];
                        gridDataForGraph = [];
                        batteryDataForGraph = [];
                        datesForGraph = [];

                        dataForCarbonGraph = [];
                        datesForCarbonGraph = [];
                        if (result.success == 1) {
                            if (result.energy_data.length == 0) {
                                $("#errMsg").text('Sorry! No data found for this SSM.').show().delay(10000).hide("slow");
                                energyChartData = $.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                                $.ChartJsLine.respChart($("#lineChart"), 'Line', energyChartData.lineCharts, energyChartData.lineOpt);
                                $.ChartJsCarbon.init(dataForCarbonGraph, datesForCarbonGraph);
                            } else {
                                chartData = result.energy_data;
                                carbonChartData = result.carbon_emission;
                                //$.MorrisCharts.init(chartData, carbonChartData);
                                if(energyDT!='') {
                                    energyDT.destroy();
                                }
                                setEnergyDataInTable(chartData);
                                if(carbonDT!='') {
                                    carbonDT.destroy();
                                }
                                setCO2DataInTable(carbonChartData);
                                jQuery.each(chartData, function(index, item) {
                                    solarDataForGraph.push(item.a);
                                    gridDataForGraph.push(item.b);
                                    batteryDataForGraph.push(item.c);
                                    //datesForGraph.push(item.y);
                                    /* Converting to current timezone */
                                    var dbDateTime = new Date(item.y);
                                    var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                                    var dbOffset = dbDateTime.getTimezoneOffset();
                                    var thisTimeZoneMs = dbDateTimeMs - (dbOffset * 60 * 1000);
                                    var thisTimeZone = new Date(thisTimeZoneMs);
                                    datesForGraph.push(thisTimeZone);
                                });
                                jQuery.each(carbonChartData, function(index, item) {
                                    dataForCarbonGraph.push(item.total_foot_print);
                                    datesForCarbonGraph.push(item.date);
                                });

                                //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                                energyChartData = $.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                                $.ChartJsLine.respChart($("#lineChart"), 'Line', energyChartData.lineCharts, energyChartData.lineOpt);
                                $.ChartJsCarbon.init(dataForCarbonGraph, datesForCarbonGraph);
                                setTimeout(function() {
                                    setLineImage();
                                }, 3000);
                            }
                            if (result.project.length > 0) {
                                $('#project').find('option').not(':first').remove();
                                jQuery.each(result.project, function(index, item) {
                                    $('#project').append($('<option/>', {
                                        value: item.id,
                                        text: item.name
                                    }));
                                });
                            } else if (result.project.length == 0) {
                                $('#project').find('option').not(':first').remove();
                                $('#project').append('<option disabled>No Data Found</option>');
                            }
                            if (result.project_manager.length > 0) {
                                $('#pro_manager').find('option').not(':first').remove();
                                jQuery.each(result.project_manager, function(index, item) {
                                    $('#pro_manager').append($('<option/>', {
                                        value: item.id,
                                        text: item.name
                                    }));
                                });
                            } else if (result.project_manager.length == 0) {
                                $('#pro_manager').find('option').not(':first').remove();
                                $('#pro_manager').append('<option disabled>No Data Found</option>');
                            }
                            if (result.device.length > 0) {
                                $('#ssm_device').find('option').not(':first').remove();
                                jQuery.each(result.device, function(index, item) {
                                    $('#ssm_device').append($('<option/>', {
                                        value: item.ssm_id,
                                        text: item.ref
                                    }));
                                });
                            } else if (result.device.length == 0) {
                                $('#ssm_device').find('option').not(':first').remove();
                                $('#ssm_device').append('<option disabled>No Data Found</option>');
                            }
                            $('#country').find('option').remove();
                            //$('#country').append('<option selected disabled>Country</option>');
                            jQuery.each(result.country, function(index, item) {
                                $('#country').append($('<option/>', {
                                    value: item.country,
                                    text: item.country,
                                }));
                            });
                        }
                    }
                });
                /* Battery Chart Individual */
                $.ajax({
                type: "POST",
                url: "assets/api/battery_cycle_data.php",
                data: JSON.stringify(arr)
                }).done(function(result) {
                    console.log(result.device);
                    $('#barBattery').remove();
                    $('.batteryCycleContainer').append('<canvas id="barBattery" height="350"></canvas>');
                    barDataBattery = [];
                    barLabelBattery = [];
                    hardwareUrlBattery = '';
                    dataForBatCycle = [];
                    if(batteryDT!='') {
                        batteryDT.destroy();
                    }
                    //var data = jQuery.parseJSON(result);
                    if (result.device.length > 0) {
                        jQuery.each(result.device, function(index, item) {
                            barDataBattery.push(item.cycle);
                            barLabelBattery.push(item.battery_id);
                            dataForBatCycle.push(item);
                        });
                        $.ChartJsBattery.init(barDataBattery, barLabelBattery);
                        setBatteryDataInTable(dataForBatCycle);
                        setTimeout(function() {
                            //setLineImage();
                            const barChartImgBattery = document.getElementById('barBattery')
                            hardwareUrlBattery = barChartImgBattery.toDataURL("img/png")
                        }, 3000);
                    }
                    else {
                        $.ChartJsBattery.init(barDataBattery, barLabelBattery);
                    }
                    $('.battery_faulty').text(result.total_fault_battery);
                });
            });

            /* Reset Button*/
            $(document).on('click', '#resetBtn', function() {
                //$('#country').prop('selectedIndex',0);
                // $('#project').find('option').remove().end().append(projectHtml);
                // $('#country').find('option').remove().end().append(countryHtml);
                // $('#pro_manager').find('option').remove().end().append(pmHtml);
                // $('#ssm_device').find('option').remove().end().append(ssmHtml);
                // $("input[type=date]").val("");
                //arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''};
                if (initialRole == '3') {
                    arr = {
                        'user_id': user_id,
                        'country': initialCountry,
                        'project': Number('0'),
                        'pro_manager': Number('0'),
                        'ssm': '',
                        'from_date': '',
                        'to_date': ''
                    }
                } else if (initialRole == '2') {
                    arr = {
                        'user_id': user_id,
                        'country': '',
                        'project': Number('0'),
                        'pro_manager': Number(initialPM),
                        'ssm': '',
                        'from_date': '',
                        'to_date': ''
                    }
                } else if (initialRole == '4') {
                    arr = {
                        'user_id': user_id,
                        'country': '',
                        'project': Number($('#project').val()),
                        'pro_manager': Number('0'),
                        'ssm': '',
                        'from_date': '',
                        'to_date': ''
                    }
                } else {
                    arr = {
                        'user_id': user_id,
                        'country': '',
                        'project': Number('0'),
                        'pro_manager': Number('0'),
                        'ssm': '',
                        'from_date': '',
                        'to_date': ''
                    }
                }
                $('#filterBtn').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: "assets/api/new_map_data.php",
                    data: JSON.stringify(arr)
                }).done(function(result) {
                    //$("#morris-line-example").empty();
                    //$("#morris-line-carbon").empty();
                    //resetLineGraph();
                    solarDataForGraph = [];
                    gridDataForGraph = [];
                    batteryDataForGraph = [];
                    datesForGraph = [];

                    dataForCarbonGraph = [];
                    datesForCarbonGraph = [];
                    if (result.energy_data.length == 0) {
                        $("#errMsg").text('Sorry! No data found.').show().delay(10000).hide("slow");
                        energyChartData = $.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        $.ChartJsLine.respChart($("#lineChart"), 'Line', energyChartData.lineCharts, energyChartData.lineOpt);
                        $.ChartJsCarbon.init(dataForCarbonGraph, datesForCarbonGraph);
                    } else {
                        chartData = result.energy_data;
                        carbonChartData = result.carbon_emission;
                        //$.MorrisCharts.init(chartData, carbonChartData);
                        if(energyDT!='') {
                            energyDT.destroy();
                        }
                        setEnergyDataInTable(chartData);
                        if(carbonDT!='') {
                            carbonDT.destroy();
                        }
                        setCO2DataInTable(carbonChartData);
                        jQuery.each(chartData, function(index, item) {
                            solarDataForGraph.push(item.a);
                            gridDataForGraph.push(item.b);
                            batteryDataForGraph.push(item.c);
                            //datesForGraph.push(item.y);
                            /* Converting to current timezone */
                            var dbDateTime = new Date(item.y);
                            var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                            var dbOffset = dbDateTime.getTimezoneOffset();
                            var thisTimeZoneMs = dbDateTimeMs - (dbOffset * 60 * 1000);
                            var thisTimeZone = new Date(thisTimeZoneMs);
                            datesForGraph.push(thisTimeZone);
                        });
                        jQuery.each(carbonChartData, function(index, item) {
                            dataForCarbonGraph.push(item.total_foot_print);
                            datesForCarbonGraph.push(item.date);
                        });
                        //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        energyChartData = $.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        $.ChartJsLine.respChart($("#lineChart"), 'Line', energyChartData.lineCharts, energyChartData.lineOpt);
                        $.ChartJsCarbon.init(dataForCarbonGraph, datesForCarbonGraph);
                        setTimeout(function() {
                            setLineImage();
                        }, 3000);
                    }
                    if (result.project.length > 0) {
                        $('#project').find('option').remove();
                        $('#project').append('<option selected disabled>Project</option>');
                        jQuery.each(result.project, function(index, item) {
                            $('#project').append($('<option/>', {
                                value: item.id,
                                text: item.name
                            }));
                        });
                    } else if (result.project.length == 0) {
                        $('#project').find('option').not(':first').remove();
                        $('#project').append('<option disabled>No Data Found</option>');
                    }
                    if (result.project_manager.length > 0) {
                        $('#pro_manager').find('option').remove();
                        $('#pro_manager').append('<option selected disabled>Team Leader</option>');
                        jQuery.each(result.project_manager, function(index, item) {
                            $('#pro_manager').append($('<option/>', {
                                value: item.id,
                                text: item.name
                            }));
                        });
                    } else if (result.project_manager.length == 0) {
                        $('#pro_manager').find('option').not(':first').remove();
                        $('#pro_manager').append('<option disabled>No Data Found</option>');
                    }
                    if (result.device.length > 0) {
                        $('#ssm_device').find('option').remove();
                        $('#ssm_device').append('<option selected disabled>SSM</option>');
                        jQuery.each(result.device, function(index, item) {
                            $('#ssm_device').append($('<option/>', {
                                value: item.ssm_id,
                                text: item.ref
                            }));
                        });
                    } else if (result.device.length == 0) {
                        $('#ssm_device').find('option').not(':first').remove();
                        $('#ssm_device').append('<option disabled>No Data Found</option>');
                    }
                    $('#country').find('option').remove();
                    $('#country').append('<option selected disabled>Country</option>');
                    jQuery.each(result.country, function(index, item) {
                        $('#country').append($('<option/>', {
                            value: item.country,
                            text: item.country,
                        }));
                    });
                });
                /* Battery Chart Individual */
                $.ajax({
                type: "POST",
                url: "assets/api/battery_cycle_data.php",
                data: JSON.stringify(arr)
                }).done(function(result) {
                    console.log(result.device);
                    $('#barBattery').remove();
                    $('.batteryCycleContainer').append('<canvas id="barBattery" height="350"></canvas>');
                    barDataBattery = [];
                    barLabelBattery = [];
                    hardwareUrlBattery = '';
                    dataForBatCycle = [];
                    if(batteryDT!='') {
                        batteryDT.destroy();
                    }
                    //var data = jQuery.parseJSON(result);
                    if (result.device.length > 0) {
                        jQuery.each(result.device, function(index, item) {
                            barDataBattery.push(item.cycle);
                            barLabelBattery.push(item.battery_id);
                            dataForBatCycle.push(item);
                        });
                        $.ChartJsBattery.init(barDataBattery, barLabelBattery);
                        setBatteryDataInTable(dataForBatCycle);
                        setTimeout(function() {
                            //setLineImage();
                            const barChartImgBattery = document.getElementById('barBattery')
                            hardwareUrlBattery = barChartImgBattery.toDataURL("img/png")
                        }, 3000);
                    }
                    else {
                        $.ChartJsBattery.init(barDataBattery, barLabelBattery);
                    }
                    $('.battery_faulty').text(result.total_fault_battery);
                });
            });
            /* Battery Chart Total */
            if(initialRole=='0') {
                var barData = [];
                var barLabel = [];
                var hardwareUrl = "";
                $.ajax({
                    type: "POST",
                    url: "assets/api/battery_cycle_data.php",
                    data: JSON.stringify({
                        'user_id': user_id
                    })
                }).done(function(result) {
                    console.log(result);
                    //var data = jQuery.parseJSON(result);
                    if (result.res.length > 0) {
                        jQuery.each(result.res, function(index, item) {
                            barData.push(item.total_batteries);
                            barLabel.push(item.range);
                        });
                        $.ChartJs.init(barData, barLabel);
                        setHardwareDataInTable(result.res);
                        $('.battery_faulty').text(result.total_fault_battery);
                        setTimeout(function() {
                            //setLineImage();
                            const barChartImg = document.getElementById('bar')
                            hardwareUrl = barChartImg.toDataURL("img/png")
                        }, 3000);
                    }
                });
            }
            
            /* Geofence Chart */
            var gfData = [];
            var gfLabel = [];
            var gfUrl = "";
            $.ajax({
                type: "POST",
                url: "assets/api/geofence_alert_report.php",
                data: JSON.stringify({
                    'user_id': user_id
                })
            }).done(function(result) {
                console.log(result);
                //var data = jQuery.parseJSON(result);
                if (result.res.length > 0) {
                    jQuery.each(result.res, function(index, item) {
                        gfData.push(item.count);
                        gfLabel.push(item.country);
                    });
                    $.ChartJsPie.init(gfData, gfLabel);
                    setSecurityDataInTable(result.res);
                    setTimeout(function() {
                        //setLineImage();
                        const pieChartImg = document.getElementById('pie')
                        gfUrl = pieChartImg.toDataURL("img/png")
                    }, 3000);
                }
            });
            /* Capture for pdf */
            window.jsPDF = window.jspdf.jsPDF;
            $('#faulty-smb').DataTable({
                searching: false,
                paging: false,
                sorting: false,
                dom: 'tB',
                buttons: [{
                    extend: 'pdf',
                    text: 'DownLoad',
                    className: 'smb-error',
                    customize: function(doc) {
                        doc.content[1].table.body[0].forEach(function(h) {
                            h.fillColor = '#005aa7';
                        });
                        doc.content.splice(0, 0, {
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            width: 150,
                            image: planLogo
                        });
                        doc.content.push({
                            margin: [-20, 10, 0, 0],
                            alignment: 'center',
                            width: 150,
                            image: tespackPowered
                        });
                    },
                    filename: function() {
                        return 'error-report'
                    }
                }]
            });

            var id = $('#data-id').val();
            $.ajax({
                url: `/assets/api/ticket_support_data.php?user_id=${id}`,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#part-replace').DataTable({
                        data: data.ret_data,
                        columns: [{
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                data: 'replacement'
                            },
                            {
                                data: 'quantity'
                            },
                            {
                                data: 'ref'
                            },
                            {
                                data: 'country'
                            },
                            {
                                data: 'project'
                            },
                            {
                                data: 'responsible'
                            },
                            {
                                data: 'email'
                            },
                            {
                                data: 'phone'
                            }

                        ],
                        searching: false,
                        paging: false,
                        sorting: false,
                        dom: 'tB',
                        language: {
                            emptyTable: "No Replacements requested by this User",
                            infoEmpty: "No Replacements requested by this User"
                        },
                        buttons: [{
                            extend: 'pdf',
                            text: 'DownLoad Replacement History',
                            title: function() {
                                return 'Product Replacement History ';
                            },
                            className: 'btn-plan btn-parts',
                            footer: true,
                            customize: function(doc) {
                                doc.content[1].table.body[0].forEach(function(h) {
                                    h.fillColor = '#005aa7';
                                });
                                doc.content[1].table.body.slice(-1)[0].forEach(function(h) {
                                    h.fillColor = '#005aa7';
                                });
                                doc.content.splice(0, 0, {
                                    margin: [0, 0, 0, 0],
                                    alignment: 'center',
                                    width: 150,
                                    image: tespackPowered
                                });
                                doc.content.splice(0, 0, {
                                    margin: [0, 0, 0, 0],
                                    alignment: 'center',
                                    width: 150,
                                    image: planLogo
                                });
                            },
                            filename: function() {
                                return 'parts-info'
                            }
                        }],
                        drawCallback: function(settings) {
                            // if (data.length === 0) {
                            //     var noDataMessage = "<tr><td colspan='" + settings.aoColumns.length + "' class='dataTables_empty'>No Replacements requested by this User</td></tr>";
                            //     $(settings.nTBody).html(noDataMessage);
                            // }
                            $(".dt-buttons").css('display', 'none');
                        }

                    });


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }
            });




            // $('#part-replace').DataTable({
            //     searching: false,
            //     paging: false,
            //     sorting: false,
            //     dom: 'tB',
            //     buttons: [{
            //         extend: 'pdf',
            //         text: 'DownLoad Replacement Info',
            //         title: function() {
            //             return 'Product Replacement List ';
            //         },
            //         className: 'parts-replace',
            //         footer: true,
            //         customize: function(doc) {
            //             doc.content[1].table.body[0].forEach(function(h) {
            //                 h.fillColor = '#005aa7';
            //             });
            //             doc.content[1].table.body.slice(-1)[0].forEach(function(h) {
            //                 h.fillColor = '#005aa7';
            //             });
            //             doc.content.splice(0, 0, {
            //                 margin: [0, 0, 0, 12],
            //                 alignment: 'center',
            //                 width: 150,
            //                 image: planLogo
            //             });
            //             doc.content.push({
            //                 margin: [-20, 10, 0, 0],
            //                 alignment: 'center',
            //                 width: 150,
            //                 image: tespackPowered
            //             });
            //         },
            //         filename: function() {
            //             return 'parts-info'
            //         }
            //     }],
            //     "footerCallback": function(row, data, start, end, display) {
            //         var api = this.api();

            //         api.columns(10, {
            //             page: 'current'
            //         }).every(function() {
            //             var sum = this
            //                 .data()
            //                 .reduce(function(a, b) {
            //                     var x = parseFloat(a) || 0;
            //                     var y = parseFloat(b) || 0;
            //                     return x + y;
            //                 }, 0);

            //             $(this.footer()).html(sum);
            //         });
            //     }
            // });
            $('.buttons-pdf').removeClass('btn-secondary');
            $('.buttons-pdf').addClass('btn-plan');

            /* Download Reports */
            $("#btn-energy-report").click(function() {
                html2canvas(document.getElementById('morris-line-example')).then(canvas => {
                    var w = document.getElementById("morris-line-example").offsetWidth;
                    var h = document.getElementById("morris-line-example").offsetHeight;

                    var img = canvas.toDataURL("image/jpeg", 1);

                    var doc = new jsPDF('L', 'pt', [w, h + 100]);
                    doc.addImage(planLogo, 'png', 10, 20, 150, 50);
                    doc.addImage(tespackPowered, 'png', w - 170, 20, 150, 50);
                    doc.text('Energy Report', w / 2.5, 80);
                    doc.addImage(img, 'JPEG', 10, 90, w, h - 20);
                    doc.save('energy-report.pdf');
                }).catch(function(e) {
                    console.log(e.message);
                });
            });
            $("#btn-carbon-report").click(function() {
                html2canvas(document.getElementById('morris-line-carbon')).then(canvas => {
                    var w = document.getElementById("morris-line-carbon").offsetWidth;
                    var h = document.getElementById("morris-line-carbon").offsetHeight;

                    var img = canvas.toDataURL("image/jpeg", 1);

                    var doc = new jsPDF('L', 'pt', [w, h + 100]);
                    doc.addImage(planLogo, 'png', 10, 20, 150, 50);
                    doc.addImage(tespackPowered, 'png', w - 170, 20, 150, 50);
                    doc.text('Energy Report', w / 2.5, 80);
                    doc.addImage(img, 'JPEG', 10, 90, w, h - 20);
                    doc.save('carbon-report.pdf');
                }).catch(function(e) {
                    console.log(e.message);
                });
            });
            $("#btn-security-report").click(function() {
                html2canvas(document.getElementById('pie')).then(canvas => {
                    var w = document.getElementById("pie").offsetWidth;
                    var h = document.getElementById("pie").offsetHeight;
                    var img = canvas.toDataURL("image/jpeg", 1);

                    var doc = new jsPDF('L', 'pt', [w, h + 100]);
                    doc.addImage(planLogo, 'png', 10, 20, 150, 50);
                    doc.addImage(tespackPowered, 'png', 300, 20, 150, 50);
                    doc.text('Security Report', 160, 80);
                    doc.addImage(img, 'JPEG', 10, 90, w, h - 20);
                    doc.save('security-report.pdf');
                }).catch(function(e) {
                    console.log(e.message);
                });
            });
            $("#btn-hardware-report").click(function() {
                html2canvas(document.getElementById('bar')).then(canvas => {
                    var w = document.getElementById("bar").offsetWidth;
                    var h = document.getElementById("bar").offsetHeight;

                    var img = canvas.toDataURL("image/jpeg", 1);

                    var doc = new jsPDF('L', 'pt', [w, h + 100]);
                    doc.addImage(planLogo, 'png', 10, 20, 150, 50);
                    doc.addImage(tespackPowered, 'png', w - 170, 20, 150, 50);
                    doc.text('Hardware Report', w / 2.5, 80);
                    doc.addImage(img, 'JPEG', 10, 100, w, h);
                    doc.save('hardware-report.pdf');
                }).catch(function(e) {
                    console.log(e.message);
                });
            });
            $(".btn-download-all").click(function() {
                $("#btn-hardware-report, #btn-energy-report, #btn-security-report, .smb-error, .parts-replace").trigger("click");
                $('.before-dl').css('display', 'none');
                $('.after-dl').css('display', 'block');
            });
        });
    </script>

</body>

</html>