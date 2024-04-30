<?php include_once('includes/header.php'); ?>
    <link href="assets/js/Bootstrap-Multiselect/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css">
    <!-- Dropzone css -->
    <link href="assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
    <style>
        .multiselect {
            text-align: left !important;
        }

        .form-check-label {
            color: white !important;
        }

        /*#create-gf {
                display: hidden;
            }*/
        #create-info,
        #create-map,
        #create-btn,
        #update-info,
        #update-btn,
        #update-map {
            display: none;
        }
    </style>
</head>


<body class="fixed-left">
    <!-- Loader -->
    <div id="overlay-loader">
        <div class="cv-spinner">
            <!--<span class="spinner-new"></span>-->
            <img class="spinner-img" src="assets/images/tespack-logo.png">
            <p class="loading-text font-16" style="color:#ffcc05;font-weight:500;">Please Wait</p>
        </div>
    </div>
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
                            <a href="geoFencing.php" class="waves-effect active">
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
                    <h3 class="page-title"> Geofencing </h3>
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
                    <div class="row">
                    <input type="hidden" value="<?php echo $user_id; ?>" id="data-ud">
                    <input type="hidden" value="<?php echo $role; ?>" id="user-role">
                    <input type="hidden" value="<?php echo $country; ?>" id="user-country">
                        <div class="col-12">
                            <div class="card m-b-30">
                                <div class="card-body">

                                    <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">
                                        <div class="custom-icon-table"><img src="assets/images/icons/sidebar/geofencing-white.png"></div>Geofencing
                                    </h2>
                                    <h6 class="mt-0 text-plan text-center m-b-30">
                                        Note: You Must Select One or Multiple Devices From Same Team in order to Create Geofence. Click on the Existing Geofence Button for Necessary Info.
                                    </h6>
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
                                        <div class="form-group col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 text-right">
                                            <?php if ($role == '1' || $role == '0') : ?>
                                            <select class="form-control text-white bg-plan" id="ssm_device" multiple="multiple">
                                                <!--<option selected disabled>SSM</option>-->
                                                <?php
                                                $ssm = "SELECT * FROM devices";
                                                $ssm_stmt = $conn->prepare($ssm);
                                                $ssm_stmt->execute();

                                                if ($ssm_stmt->rowCount()) :
                                                    while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option value="<?php echo $data_ssm["ssm_id"]; ?>">
                                                            <?php echo $data_ssm["ref"]; ?></option><?php
                                                                                                }
                                                                                            else :
                                                                                                echo "Sorry! SSM Found.";

                                                                                            endif;
                                                                                                    ?>
                                            </select>
                                            <?php elseif ($role == '3') : ?>
                                            <select class="form-control text-white bg-plan" id="ssm_device" multiple="multiple">
                                                <!--<option selected disabled>SSM</option>-->
                                                <?php
                                                $ssm = "SELECT * FROM devices WHERE country=:country";
                                                $ssm_stmt = $conn->prepare($ssm);
                                                $ssm_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                                                $ssm_stmt->execute();

                                                if ($ssm_stmt->rowCount()) :
                                                    while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option value="<?php echo $data_ssm["ssm_id"]; ?>">
                                                            <?php echo $data_ssm["ref"]; ?></option><?php
                                                                                                }
                                                                                            else :
                                                                                                echo "Sorry! No SSM Found.";

                                                                                            endif;
                                                                                                    ?>
                                            </select>
                                            <?php elseif ($role == '2') : ?>
                                            <select class="form-control text-white bg-plan" id="ssm_device" multiple="multiple">
                                                <!--<option selected disabled>SSM</option>-->
                                                <?php
                                                $ssm = "SELECT a.* FROM devices as a left join project_managers as b on a.team_id=b.team_id WHERE b.reg_id=:login_id";
                                                $ssm_stmt = $conn->prepare($ssm);
                                                $ssm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
                                                $ssm_stmt->execute();

                                                if ($ssm_stmt->rowCount()) :
                                                    while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option value="<?php echo $data_ssm["ssm_id"]; ?>">
                                                            <?php echo $data_ssm["ref"]; ?></option><?php
                                                                                                }
                                                                                            else :
                                                                                                echo "Sorry! No SSM Found.";

                                                                                            endif;
                                                                                                    ?>
                                            </select>
                                            <?php elseif ($role == '4') : ?>
                                            <select class="form-control text-white bg-plan" id="ssm_device" multiple="multiple">
                                                <!--<option selected disabled>SSM</option>-->
                                                <?php
                                                $ssm = "SELECT a.* FROM devices as a left join team_members as b on a.team_id=b.team_id WHERE b.reg_id=:login_id";
                                                $ssm_stmt = $conn->prepare($ssm);
                                                $ssm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
                                                $ssm_stmt->execute();

                                                if ($ssm_stmt->rowCount()) :
                                                    while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option value="<?php echo $data_ssm["ssm_id"]; ?>">
                                                            <?php echo $data_ssm["ref"]; ?></option><?php
                                                                                                }
                                                                                            else :
                                                                                                echo "Sorry! No SSM Found.";

                                                                                            endif;
                                                                                                    ?>
                                            </select>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                                            <h6 class="text-plan text-center m-b-30">
                                                <!--You must select one or more SSM in order to create Geofence-->
                                            </h6>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                                            <button class="btn btn-plan" id="gfList">Existing Geofence</button>
                                            <button class="btn btn-plan" id="resetBtn">Reset Dropdowns</button>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <p class="text-center text-danger" id="errMsg"></p>
                                            <p class="text-center text-success" id="msgSuccess"></p>
                                        </div>
                                        <!-- <div class="col-12">
                                            <div class="row text-center">
                                                <div class="col-6"><h6 class="text-plan text-center m-b-30">Devices</h6></div>
                                                <div class="col-6"><h6 class="text-plan text-center m-b-30">Geofence Created?</h6></div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-12 m-b-20" id="view-map">
                                            <h6 class="text-plan text-center m-b-30">
                                                Select a SSM From Dropdown to create or update the Geofencing area
                                            </h6>
                                            <div id="gmaps-view" class="gmaps"></div>
                                        </div>
                                    </div>
                                    <div class="row text-center" id="create-gf">
                                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 m-b-20" id="create-info">
                                            <h5 class="text-plan text-center m-b-20">
                                                Geofence Information
                                            </h5>
                                            <h6 class="text-plan text-danger drawing_tool m-b-10">
                                            </h6>
                                            <div class="row">
                                                <!-- <div class="col-12">
                                                    <div class="card text-center m-b-10">
                                                        <div class="mb-2 card-body text-muted pt-0">
                                                            <h5 class="text-plan">Address</h5>
                                                            <input class="form-control" id="pac-input" type="text" placeholder="Enter Address">
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-12">
                                                    <div class="card text-center m-b-10">
                                                        <div class="mb-2 card-body text-muted pt-0 pb-0">
                                                            <h5 class="text-plan">Co-ordinates</h5>
                                                            <h6 class="text-plan latlngHead"></h6>
                                                            <div id="latlng" class="text-plan text-center row"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="card text-center m-b-10">
                                                        <div class="mb-2 card-body text-muted pt-0 pb-0">
                                                            <h5 class="text-plan">Area</h5>
                                                            <h6 class="text-plan shapeArea"></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="card text-center m-b-10">
                                                        <div class="mb-2 card-body text-muted pt-0 pb-0">
                                                            <h5 class="text-plan">Duration</h5>
                                                            <div class="row">
                                                                <div class="form-group col-3">
                                                                    <label for="example-text-input-lg" class="col-form-label">From</label>
                                                                </div>
                                                                <div class="form-group col-9">
                                                                    <input type="date" class="form-control" id="date-from">
                                                                </div>
                                                                <div class="form-group col-3">
                                                                    <label for="example-text-input-lg" class="col-form-label">To</label>
                                                                </div>
                                                                <div class="form-group col-9">
                                                                    <input type="date" class="form-control" id="date-to">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 m-b-20" id="create-map">
                                            <h6 class="text-plan text-center m-b-30">
                                                Select a Tool to create the Geofencing area
                                            </h6>
                                            <div id="gmaps-markers" class="gmaps-geofence"></div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-10 m-t-10" id="create-btn">
                                        <?php if ($role == '1' || $role == '3' || $role == '2' || $role == '0') : ?>
                                            <button id="filterBtn" class="btn btn-lg w-md btn-plan font-24" style="width: 30%;"><b>CREATE GEOFENCE</b></button>
                                        <?php else :
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 m-b-20" id="update-info">
                                            <h5 class="text-plan text-center m-b-20">
                                                Geofence Information
                                            </h5>
                                            <h6 class="text-plan text-danger drawing_tool-update m-b-10">
                                            </h6>
                                            <div class="row">
                                                <!-- <div class="col-12">
                                                    <div class="card text-center m-b-10">
                                                        <div class="mb-2 card-body text-muted pt-0">
                                                            <h5 class="text-plan">Address</h5>
                                                            <input class="form-control" id="pac-input-update" type="text" placeholder="Enter Address">
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-12">
                                                    <div class="card text-center m-b-10">
                                                        <div class="mb-2 card-body text-muted pt-0 pb-0">
                                                            <h5 class="text-plan">Co-ordinates</h5>
                                                            <h6 class="text-plan latlngHead-update"></h6>
                                                            <div id="latlng-update" class="text-plan text-center row"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="card text-center m-b-10">
                                                        <div class="mb-2 card-body text-muted pt-0 pb-0">
                                                            <h5 class="text-plan">Area</h5>
                                                            <h6 class="text-plan shapeArea-update"></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="card text-center m-b-10">
                                                        <div class="mb-2 card-body text-muted pt-0 pb-0">
                                                            <h5 class="text-plan">Duration</h5>
                                                            <div class="row">
                                                                <div class="form-group col-3">
                                                                    <label for="example-text-input-lg" class="col-form-label">From</label>
                                                                </div>
                                                                <div class="form-group col-9">
                                                                    <input type="date" class="form-control" id="date-from-update">
                                                                </div>
                                                                <div class="form-group col-3">
                                                                    <label for="example-text-input-lg" class="col-form-label">To</label>
                                                                </div>
                                                                <div class="form-group col-9">
                                                                    <input type="date" class="form-control" id="date-to-update">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 m-b-20" id="update-map">
                                            <h6 class="text-plan text-center m-b-30">
                                                Select a Tool or change inputs to update the Geofence
                                            </h6>
                                            <div id="gmaps-update" class="gmaps-geofence"></div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-10 m-t-10" id="update-btn">
                                            <div class="row">
                                                <?php if ($role == '1' || $role == '3' || $role == '2' || $role == '0') : ?>
                                                <div class="col-6"><button id="updateBtn" class="btn w-md btn-plan font-20" style="width: 60%;"><b>UPDATE GEOFENCE</b></button></div>
                                                <div class="col-6"><button id="dltBtn" class="btn w-md btn-plan font-20" style="width: 60%;"><b>DELETE GEOFENCE</b></button></div>
                                                <?php else :
                                                endif; ?>
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
            <?php echo date('Y'); ?> Tespack - All rights reserved .
        </footer>

    </div> <!-- content Page-->
    </div> <!-- Wrapper-->
    <!-- Delete modal -->
    <?php include_once('includes/modal/delete.php'); ?>
    <!-- delete modal -->
    <!-- Profile modal -->
    <?php include_once('includes/modal/profile.php'); ?>
    <!-- Profile modal -->
    <!-- Notification modal -->
    <?php include_once('includes/modal/notification.php'); ?>
    <!-- Notification modal -->
    <!-- Logout modal -->
    <?php include_once('includes/modal/logout.php'); ?>
    <!-- Logout modal -->
    <!-- GF List modal -->
    <div id="gfListModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel">Device List with Geofence Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="gfInfoDiv">
                            <div class="row text-center">
                                <div class="col-6"><h6 class="text-plan text-center m-b-30">Devices</h6></div>
                                <div class="col-6"><h6 class="text-plan text-center m-b-30">Geofence Created?</h6></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- GF List modal -->
    <!-- jQuery  -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/Bootstrap-Multiselect/dist/js/bootstrap-multiselect.js"></script>
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
    <!-- google maps api -->
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDsfrDPuaM-HIXsGsFwmujW-CrE36KtmTE&libraries=drawing,places,geometry"></script>

    <!-- Gmaps file -->
    <script src="assets/plugins/gmaps/gmaps.min.js"></script>
    <script src="assets/js/notification.js"></script>
    <!-- Background js -->
    <script src="assets/js/common/resetData.js"></script>
    <!-- demo codes 
        <script src="assets/pages/gmaps.js"></script>-->


    <script>
        $(document).ready(function() {
            //$("#create-gf").hide();
            //var user_id = '';
            var user_id = $("#data-ud").val();
            var initialRole = $("#user-role").val();
            var initialCountry = $("#user-country").val();
            var initialPM = $('#pro_manager').val();
            var device_id_for_gf='';
            var method = 0;
            gfChange(user_id, device_id_for_gf, method);
            loadNotification(user_id);
            setInterval(function() {
                method = 0;
                gfChange(user_id, device_id_for_gf, method);
            }, 60000);
            var dev_associated = [];
            var arr = {
                'user_id': user_id,
                'country': '',
                'project': Number('0'),
                'pro_manager': Number('0'),
                'ssm': ''
            }
            var arr_ssm = {
                'user_id': user_id,
                'ssm': ''
            }
            if(initialRole=='3') {
                arr = {'user_id': user_id, 'country': initialCountry, 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
            }
            else if(initialRole=='2') {
                arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number($('#pro_manager').val()), 'ssm': '', 'from_date': '', 'to_date': ''}
            }
            else if(initialRole=='4') {
                arr = {'user_id': user_id, 'country': '', 'project': Number($('#project').val()), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
            }
            else {
                arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
            }
            const iconCustom = {
                url: "assets/images/tespack-logo.png", // url
                scaledSize: new google.maps.Size(30, 30), // scaled size
            };
            /* Showing initial all the Devices in the map */
            $.ajax({
                type: "POST",
                url: "assets/api/ssm_data_for_map.php",
                data: JSON.stringify(arr)
            }).done(function(result) {
                console.log(result);
                if(result.res.length>0) {
                    map_view = new GMaps({
                        div: '#gmaps-view'
                    });
                    let infowindow = new google.maps.InfoWindow();
                    var bounds = new google.maps.LatLngBounds();
                    jQuery.each(result.res, function(index, item) {
                        // console.log(JSON.parse(item.device_responsible))
                        //console.log(item.gnss_location_details.length);
                        //if(item.gnss_location_details.length > 0) {
                        if(item.gnss_location_details!=null) {
                            map_view.addMarker({
                                lat: item.gnss_location_details[0].latitude,
                                lng: item.gnss_location_details[0].longitude,
                                details: {
                                    database_id: 42,
                                    author: 'HPNeo'
                                },
                                icon: iconCustom,
                                click: function(e) {

                                },
                                mouseover: function() {
                                    infowindow.open(map_view, this);
                                    infowindow.setContent("<h4>" + item.gnss_location_details[0].latitude +
                                        "</h4><p><b>Latitude:</b> " + item.gnss_location_details[0].latitude + "</p><p><b>Longitude:</b> " + item.gnss_location_details[0].longitude +
                                        "</p><p><b>Team:</b> " + item.team_name + "</p><p><b>SMB Ref. No-:</b> " + item.ssm_id +
                                        "</p><p><b>Last Seen:</b> " + item.last_seen_time + "</p>")
                                },
                                mouseout: function() {
                                    infowindow.close();
                                }
                            });
                            bounds.extend(new google.maps.LatLng(item.gnss_location_details[0].latitude, item.gnss_location_details[0].longitude));
                            }
                        });
                        map_view.fitBounds(bounds);
                    } else {
                        $("#errMsg").text('Sorry no device found.').show().delay(30000).hide("slow");
                    }
                if(result.device.length>0) {
                    jQuery.each(result.device, function(index, item) {
                        dev_associated.push(item.ref);
                    });
                } else {
                    dev_associated = [];
                }
                console.log(dev_associated);
            });
            /* Get Initial dropdowns */
            var projectHtml = $('#project').get(0).innerHTML;
            var countryHtml = $('#country').get(0).innerHTML;
            var pmHtml = $('#pro_manager').get(0).innerHTML;
            var ssmHtml = $('#ssm_device').get(0).innerHTML;
            
            /* Changing dropdowns on select */
            var selected_project;
            var selected_pm;
            var selected_ssm;
            var multiSelectData = [];
            var drawnShape;
            var polyMarker = [];
            let drawing_tool;
            var storedData;
            /* Geofence Button */
            if (selected_ssm == null && drawnShape == null) {
                $('#filterBtn').prop('disabled', true);
            } else {
                $('#filterBtn').prop('disabled', false);
            }
            $(document).on('change', 'select', function() {
                $("#overlay-loader").fadeIn(300);
                // if ($(this).attr("id") == 'country') {
                //     arr.country = $(this).val();
                // } else if ($(this).attr("id") == 'project') {
                //     arr.project = $(this).val();
                //     selected_project = $(this).find("option:selected").text();
                // } else if ($(this).attr("id") == 'pro_manager') {
                //     arr.pro_manager = $(this).val();
                //     selected_pm = $(this).find("option:selected").text();
                // }
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
                    /*if($(this).val() != null){
                        $('#filterBtn').prop('disabled', false);
                    }
                    else {
                        $('#filterBtn').prop('disabled', true);
                    }*/
                }
                var selectData = {
                    type: $(this).attr("id"),
                    value: $(this).val()
                };
                if ($(this).attr("id") == 'country' || $(this).attr("id") == 'project' || $(this).attr("id") == 'pro_manager') {
                    $.ajax({
                        type: "POST",
                        url: "assets/api/ssm_data_for_map.php",
                        data: JSON.stringify(arr),
                        success: function(result) {
                            $("#overlay-loader").fadeOut(300);
                            //var data = jQuery.parseJSON(result);
                            console.log(result);
                            if(result.res.length>0) {
                                map_view = new GMaps({
                                    div: '#gmaps-view'
                                });
                                let infowindow = new google.maps.InfoWindow();
                                var bounds = new google.maps.LatLngBounds();
                                jQuery.each(result.res, function(index, item) {
                                    //console.log(item.gnss_location_details[0].latitude)
                                    //if(item.gnss_location_details.length>0) {
                                    if(item.gnss_location_details!=null) {
                                        map_view.addMarker({
                                            lat: item.gnss_location_details[0].latitude,
                                            lng: item.gnss_location_details[0].longitude,
                                            details: {
                                                database_id: 42,
                                                author: 'HPNeo'
                                            },
                                            icon: iconCustom,
                                            click: function(e) {

                                            },
                                            mouseover: function() {
                                                infowindow.open(map_view, this);
                                                infowindow.setContent("<h4>" + item.gnss_location_details[0].latitude +
                                                    "</h4><p><b>Latitude:</b> " + item.gnss_location_details[0].latitude + "</p><p><b>Longitude:</b> " + item.gnss_location_details[0].longitude +
                                                    "</p><p><b>Team:</b> " + item.team_name + "</p><p><b>SMB Ref. No-:</b> " + item.ssm_id +
                                                    "</p><p><b>Last Seen:</b> " + item.last_seen_time + "</p>")
                                            },
                                            mouseout: function() {
                                                infowindow.close();
                                            }
                                        });
                                        bounds.extend(new google.maps.LatLng(item.gnss_location_details[0].latitude, item.gnss_location_details[0].longitude));
                                    }
                                });
                                map_view.fitBounds(bounds);
                            } else {
                                $("#errMsg").text('Sorry no device found.').show().delay(5000).hide("slow");
                            }
                            if (result.status == 1) {
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
                                    //$('#ssm_device').find('option').not(':first').remove();
                                    multiSelectData = [];
                                    $('#ssm_device').find('option').remove();
                                    jQuery.each(result.device, function(index, item) {
                                        /*$('#ssm_device').append($('<option/>', {
                                            value: item.id,
                                            text: item.ref
                                        }));*/
                                        multiSelectData.push({
                                            label: item.ref,
                                            value: item.ssm_id
                                        });
                                    });
                                    $("#ssm_device").multiselect('dataprovider', multiSelectData);
                                } else if (result.device.length == 0) {
                                    //$('#ssm_device').multiselect('destroy');
                                    //$('#ssm_device').find('option').remove();
                                    multiSelectData = [];
                                    $("#ssm_device").multiselect('dataprovider', multiSelectData);
                                    //$("#ssm_device").multiselect('disable');
                                    //$('#ssm_device').multiselect('updateButtonText','No Data Found');
                                    //$('#ssm_device').append('<option disabled>No Data Found</option>');
                                }
                                $('#country').find('option').not(':first').remove();
                                jQuery.each(result.country, function(index, item) {
                                    $('#country').append($('<option/>', {
                                        value: item.country,
                                        text: item.country,
                                    }));
                                });
                            } /*else if (result.success == 2) {
                                $('#country').find('option').not(':first').remove();
                                jQuery.each(result.country, function(index, item) {
                                    $('#country').append($('<option/>', {
                                        value: item.country,
                                        text: item.country,
                                    }));
                                });
                                if (result.project_manager.length > 0) {
                                    $('#pro_manager').find('option').not(':first').remove();
                                    jQuery.each(result.project_manager, function(index, item) {
                                        $('#pro_manager').append($('<option/>', {
                                            value: item.team_id,
                                            text: item.name
                                        }));
                                    });
                                } else if (result.project_manager.length == 0) {
                                    $('#pro_manager').find('option').not(':first').remove();
                                    $('#pro_manager').append('<option disabled>No Data Found</option>');
                                }
                                if (result.device.length > 0) {
                                    multiSelectData = [];
                                    $('#ssm_device').find('option').remove();
                                    jQuery.each(result.device, function(index, item) {
                                        multiSelectData.push({
                                            label: item.ref,
                                            value: item.ssm_id
                                        });
                                    });
                                    $("#ssm_device").multiselect('dataprovider', multiSelectData);
                                } else if (result.device.length == 0) {
                                    multiSelectData = [];
                                    $("#ssm_device").multiselect('dataprovider', multiSelectData);
                                }
                            } else if (result.success == 3) {
                                $('#country').find('option').not(':first').remove();
                                jQuery.each(result.country, function(index, item) {
                                    $('#country').append($('<option/>', {
                                        value: item.country,
                                        text: item.country,
                                    }));
                                });
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
                                if (result.device.length > 0) {
                                    multiSelectData = [];
                                    $('#ssm_device').find('option').remove();
                                    jQuery.each(result.device, function(index, item) {
                                        multiSelectData.push({
                                            label: item.ref,
                                            value: item.ssm_id
                                        });
                                    });
                                    $("#ssm_device").multiselect('dataprovider', multiSelectData);
                                } else if (result.device.length == 0) {
                                    multiSelectData = [];
                                    $("#ssm_device").multiselect('dataprovider', multiSelectData);
                                }
                            }*/
                            /*else if (result.success == 4) {
                                $('#country').find('option').not(':first').remove();
                                jQuery.each(result.country, function(index, item) {
                                    $('#country').append($('<option/>', {
                                        value: item.country,
                                        text: item.country,
                                    }));
                                });
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
                                            value: item.team_id,
                                            text: item.name
                                        }));
                                    });
                                } else if (result.project_manager.length == 0) {
                                    $('#pro_manager').find('option').not(':first').remove();
                                    $('#pro_manager').append('<option disabled>No Data Found</option>');
                                }
                            }*/
                        }
                    });
                } else if ($(this).attr("id") == 'ssm_device') {
                    arr_ssm.ssm = $(this).val();
                    storedData= '';
                    //selected_ssm = $(this).find("option:selected").text();
                    $.ajax({
                        type: "POST",
                        url: "assets/api/geofencing_device_data_check_pg.php",
                        data: JSON.stringify(arr_ssm),
                        success: function(result) {
                            $("#overlay-loader").fadeOut(300);
                            //var data = jQuery.parseJSON(result);
                            console.log(result);
                            if (result.status == '2') {
                                $("#errMsg").hide("slow");
                                $("#view-map").hide("slow");
                                $("#msgSuccess").text('No Geofence for this combination of SSMs is created, you can create a new Geofence').show().delay(4000);
                                //$("#create-gf").show('slow');
                                $("#create-info").show('slow');
                                $("#create-map").show('slow');
                                $("#create-btn").show('slow');
                                map = new GMaps({
                                    div: '#gmaps-markers'
                                });
                                var bounds = new google.maps.LatLngBounds();
                               
                                // if( result.res){
                                //     return;
                                // }
                                // result.res && result.res.forEach((index, item) => {
                                //         map.addMarker({
                                //             lat: item.latitude,
                                //             lng: item.longitude,
                                //             icon: iconCustom,
                                //             click: function(e) {

                                //             }
                                //         });
                                //         bounds.extend(new google.maps.LatLng(item.latitude, item.longitude));
                                //     })
                                if (result.res.length > 0) {
                                    jQuery.each(result.res, function(index, item) {
                                        map.addMarker({
                                            lat: item.latitude,
                                            lng: item.longitude,
                                            icon: iconCustom,
                                            click: function(e) {

                                            }
                                        });
                                        bounds.extend(new google.maps.LatLng(item.latitude, item.longitude));
                                    });
                                }
                                else {
                                    console.log(result.res);
                                }
                                map.fitBounds(bounds);
                                if(initialRole=='1'||initialRole=='2'||initialRole=='3'||initialRole=='0') {
                                    var drawingManager = new google.maps.drawing.DrawingManager({
                                        //drawingMode: google.maps.drawing.OverlayType.MARKER,
                                        drawingControl: true,
                                        drawingControlOptions: {
                                            position: google.maps.ControlPosition.TOP_CENTER,
                                            drawingModes: [
                                                google.maps.drawing.OverlayType.CIRCLE,
                                                //google.maps.drawing.OverlayType.POLYGON,
                                                //google.maps.drawing.OverlayType.RECTANGLE,
                                            ],
                                        },
                                        // markerOptions: {
                                        //     icon: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
                                        // },
                                        circleOptions: {
                                            draggable: true
                                        }
                                    });
                                } else {
                                    var drawingManager = new google.maps.drawing.DrawingManager({
                                        //drawingMode: google.maps.drawing.OverlayType.MARKER,
                                        drawingControl: true,
                                        drawingControlOptions: {
                                            position: google.maps.ControlPosition.TOP_CENTER,
                                            drawingModes: [
                                                //google.maps.drawing.OverlayType.CIRCLE,
                                                //google.maps.drawing.OverlayType.POLYGON,
                                                //google.maps.drawing.OverlayType.RECTANGLE,
                                            ],
                                        }
                                    });
                                }
                                drawingManager.setMap(map.map);
                                
                                google.maps.event.addListener(drawingManager, "drawingmode_changed", function() {
                                    drawing_tool = drawingManager.getDrawingMode();
                                    //console.log(drawing_tool);
                                    if (drawing_tool == 'circle') {
                                        $('.drawing_tool').text('Geofence Shape: Circle');
                                        $('.latlngHead').html("Center Co-ordinates and Radius" + "<br>");
                                        if (drawnShape) {
                                            drawnShape.setMap(null);
                                            polyMarker.forEach(marker => {
                                                marker.setMap(null);
                                            });
                                            polyMarker = [];
                                        }
                                        $('#latlng').text('');
                                        $('#latlng').html('');
                                        $('.shapeArea').text('');
                                        $('#filterBtn').prop('disabled', true);
                                    } else if (drawing_tool == 'polygon') {
                                        $('.drawing_tool').text('Geofence Shape: Polygon');
                                        $('.latlngHead').html("Polygon points" + "<br>");
                                    } else if (drawing_tool == 'rectangle') {
                                        $('.drawing_tool').text('Geofence Shape: Rectangle');
                                        $('.latlngHead').html("Rectangle points " + "<br>");
                                    } else {
                                        $('.drawing_tool').text('Click on the map to drag');
                                    }
                                });
                                var drawnShape;
                                google.maps.event.addListener(drawingManager, 'circlecomplete', function(circle) {
                                    //console.log(circle);
                                    drawingManager.setDrawingMode(null);
                                    var circleLng = circle.getCenter().lng().toFixed(6);
                                    var circleLat = circle.getCenter().lat().toFixed(6);
                                    var circleRad = circle.getRadius().toFixed(2);
                                    var circleArea = (Math.PI * circleRad * circleRad).toFixed(2);
                                    $('.shapeArea').text(circleArea + ' sq meters');

                                    //$('#latlng').text(circleLat + ',' + circleLng);
                                    $('#latlng').html('<label class="col-4 col-form-label">Latitude</label><div class="col-8"><input class="form-control" id="newLat" type="text" value="' + circleLat + '"></div>' + '<br><br>' +
                                        '<label class="col-4 col-form-label">Longitude</label><div class="col-8"><input class="form-control" id="newLng" type="text" value="' + circleLng + '"></div>' + '<br><br>' +
                                        '<label class="col-4 col-form-label">Radius(Meters)</label><div class="col-8"><input class="form-control" id="circleRadius" type="text" value="' + circleRad + '"></div>' + '<br>');
                                    $("#circleRadius").bind("input", function() {
                                        var newRad = parseFloat($(this).val());
                                        circle.setRadius(parseFloat($(this).val()));
                                        var newCircleArea = (Math.PI * newRad * newRad).toFixed(2);
                                        $('.shapeArea').text(newCircleArea + ' sq meters');
                                    });
                                    $("#newLat").bind("input", function() {
                                        circle.setCenter(new google.maps.LatLng(parseFloat($(this).val()), circleLng));
                                    });
                                    $("#newLng").bind("input", function() {
                                        circle.setCenter(new google.maps.LatLng(circleLat, parseFloat($(this).val())));
                                    });
                                    /* On drag change center cords */
                                    circle.addListener("bounds_changed", showNewCordCreation);
                                    function showNewCordCreation() {
                                        var draggedCircleLatCreate = circle.getCenter().lat().toFixed(6);
                                        var draggedCircleLngCreate = circle.getCenter().lng().toFixed(6);
                                        $("#newLat").val(draggedCircleLatCreate);
                                        $("#newLng").val(draggedCircleLngCreate);
                                    }
                                    drawnShape = circle;
                                    /* Geofence Button */
                                    if (selected_ssm == null && drawnShape == null) {
                                        $('#filterBtn').prop('disabled', true);
                                    } else {
                                        $('#filterBtn').prop('disabled', false);
                                    }
                                });
                                $('#filterBtn').unbind().click(function() {
                                    $("#overlay-loader").fadeIn(300);
                                    //console.log(drawnShape);
                                    var drawnShapeStr = stringify(drawnShape);
                                    //console.log(drawnShapeStr)
                                    //console.log(JSON.parse(drawnShape))
                                    // var formData = JSON.stringify({
                                    //     user_id: user_id,
                                    //     ssm: arr_ssm.ssm,
                                    //     from_date: $("#date-from").val(),
                                    //     to_date: $("#date-to").val(),
                                    //     shape_type: drawing_tool,
                                    //     shape_details: drawnShapeStr,
                                    // });
                                    $.ajax({
                                        type: "PATCH",
                                        url: "assets/api/geofencing_data_api.php",
                                        data: JSON.stringify({
                                            user_id: user_id,
                                            ssm: arr_ssm.ssm,
                                            from_date: $("#date-from").val(),
                                            to_date: $("#date-to").val(),
                                            shape_type: drawing_tool,
                                            shape_details: drawnShapeStr,
                                        }),
                                        success:  function (result) {
                                            $("#overlay-loader").fadeOut(300);
                                            console.log(result.success);
                                            if (result.success == '0') {
                                                $("#errMsg").text('There is an error, please check your inputs').show().delay(4000);
                                            } else if (result.success == '1') {
                                                method = 1;
                                                $("#msgSuccess").text('New geofence created successfully!').show().delay(4000);
                                                $("#errMsg").hide("slow");
                                                createDivReset();
                                                drawnShape = '';
                                                gfChange(user_id, arr_ssm.ssm, method);
                                            }
                                        },
                                        error: function(err) {
                                            console.log(err);
                                        }
                                    })
                                });
                            } else if (result.status == '1') {
                                $("#errMsg").hide("slow");
                                $("#view-map").hide("slow");
                                $("#msgSuccess").text('Geofence for this combination of SSMs is already created, you can edit or delete the geofence').show().delay(4000);
                                $("#update-info").show('slow');
                                $("#update-map").show('slow');
                                $("#update-btn").show('slow');
                                storedData = result.res['0'];
                                console.log(storedData);
                                var circle_details = JSON.parse(storedData.shape_details);
                                //console.log(parseFloat(circle_details.center.lat.toFixed(6)));
                                //console.log(circle_details.center.lng);
                                //console.log(storedData.id);
                                $("#update-info").show('slow');
                                $("#update-map").show('slow');
                                mapUpdate = new google.maps.Map(document.getElementById('gmaps-update'), {
                                    lat: parseFloat(circle_details.center.lat),
                                    lng: parseFloat(circle_details.center.lng)
                                });
                                var boundsUpdate = new google.maps.LatLngBounds();
                                if (storedData.device.length > 0) {
                                    jQuery.each(storedData.device, function(index, item) {
                                        /*mapUpdate.addMarker({
                                            lat: parseFloat(item.latitude),
                                            lng: parseFloat(item.longitude),
                                            click: function(e) {

                                            }
                                        });*/
                                        marker = new google.maps.Marker({
                                            position: new google.maps.LatLng(parseFloat(item.latitude), parseFloat(item.longitude)),
                                            map: mapUpdate,
                                            icon: iconCustom
                                        });
                                        boundsUpdate.extend(new google.maps.LatLng(parseFloat(item.latitude), parseFloat(item.longitude)));
                                    });
                                    
                                }
                                boundsUpdate.extend(marker.getPosition());
                                mapUpdate.fitBounds(boundsUpdate);
                                var newCircleLat = parseFloat(circle_details.center.lat.toFixed(6));
                                var newCircleLng = parseFloat(circle_details.center.lng.toFixed(6));
                                var newCircleRad = circle_details.radius;
                                var newCircleArea = (Math.PI * newCircleRad * newCircleRad).toFixed(2);
                                var newCircle = new google.maps.Circle({
                                    center: {
                                        lat: newCircleLat,
                                        lng: newCircleLng
                                    },
                                    radius: newCircleRad,
                                    draggable: true,
                                    map: mapUpdate
                                });
                                /* On drag change center cords */
                                newCircle.addListener("bounds_changed", showNewCord);
                                function showNewCord() {
                                    var draggedCircleLat = newCircle.getCenter().lat().toFixed(6);
                                    var draggedCircleLng = newCircle.getCenter().lng().toFixed(6);
                                    $("#newLat-update").val(draggedCircleLat);
                                    $("#newLng-update").val(draggedCircleLng);
                                }
                                gf_id = storedData.id;
                                $('.shapeArea-update').text(newCircleArea + ' sq meters');
                                //$('#latlng').text(circleLat + ',' + circleLng);
                                $('#latlng-update').html('<label class="col-4 col-form-label">Latitude</label><div class="col-8"><input class="form-control" id="newLat-update" type="text" value="' + newCircleLat + '"></div>' + '<br><br>' +
                                    '<label class="col-4 col-form-label">Longitude</label><div class="col-8"><input class="form-control" id="newLng-update" type="text" value="' + newCircleLng + '"></div>' + '<br><br>' +
                                    '<label class="col-4 col-form-label">Radius(Meters)</label><div class="col-8"><input class="form-control" id="circleRadius-update" type="text" value="' + newCircleRad + '"></div>' + '<br>');
                                $("#circleRadius-update").bind("input", function() {
                                    var newCircleRad = parseFloat($(this).val());
                                    newCircle.setRadius(parseFloat($(this).val()));
                                    var newCircleAreaUpdate = (Math.PI * newCircleRad * newCircleRad).toFixed(2);
                                    $('.shapeArea-update').text(newCircleAreaUpdate + ' sq meters');
                                });
                                $("#newLat-update").bind("input", function() {
                                    newCircle.setCenter(new google.maps.LatLng(parseFloat($(this).val()), newCircleLng));
                                });
                                $("#newLng-update").bind("input", function() {
                                    newCircle.setCenter(new google.maps.LatLng(newCircleLat, parseFloat($(this).val())));
                                });
                                if(initialRole=='1'||initialRole=='2'||initialRole=='3'||initialRole=='0') {
                                    var drawingManager = new google.maps.drawing.DrawingManager({
                                        //drawingMode: google.maps.drawing.OverlayType.MARKER,
                                        drawingControl: true,
                                        drawingControlOptions: {
                                            position: google.maps.ControlPosition.TOP_CENTER,
                                            drawingModes: [
                                                google.maps.drawing.OverlayType.CIRCLE,
                                                //google.maps.drawing.OverlayType.POLYGON,
                                                //google.maps.drawing.OverlayType.RECTANGLE,
                                            ],
                                        },
                                        // markerOptions: {
                                        //     icon: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
                                        // },
                                        circleOptions: {
                                            draggable: true
                                        }
                                    });
                                } else {
                                    var drawingManager = new google.maps.drawing.DrawingManager({
                                        //drawingMode: google.maps.drawing.OverlayType.MARKER,
                                        drawingControl: true,
                                        drawingControlOptions: {
                                            position: google.maps.ControlPosition.TOP_CENTER,
                                            drawingModes: [
                                                //google.maps.drawing.OverlayType.CIRCLE,
                                                //google.maps.drawing.OverlayType.POLYGON,
                                                //google.maps.drawing.OverlayType.RECTANGLE,
                                            ],
                                        }
                                    });
                                }
                                drawingManager.setMap(mapUpdate);
                                google.maps.event.addListener(drawingManager, "drawingmode_changed", function() {
                                    drawing_tool = drawingManager.getDrawingMode();
                                    //console.log(drawing_tool);
                                    if (drawing_tool == 'circle') {
                                        if (newCircle) {
                                            newCircle.setMap(null);
                                            // polyMarker.forEach(marker => {
                                            //     marker.setMap(null);
                                            // });
                                            // polyMarker = [];
                                        }
                                        $('#latlng-update').text('');
                                        $('#latlng-update').html('');
                                        $('.shapeArea-update').text('');
                                        //$('#filterBtn').prop('disabled', true);
                                        $('.drawing_tool-update').text('Geofence Shape: Circle');
                                        $('.latlngHead-update').html("Center Co-ordinates and Radius" + "<br>");
                                    } else {
                                        $('.drawing_tool-update').text('Click on the map to drag');
                                    }
                                });
                                var drawnShapeUpdate;
                                google.maps.event.addListener(drawingManager, 'circlecomplete', function(circle) {
                                    console.log(circle);
                                    drawingManager.setDrawingMode(null);
                                    var newCircleLat = circle.getCenter().lng().toFixed(6);
                                    var newCircleLng = circle.getCenter().lat().toFixed(6);
                                    var newCircleRad = circle.getRadius().toFixed(6);
                                    var newCircleArea = (Math.PI * newCircleRad * newCircleRad).toFixed(2);
                                    $('.shapeArea-update').text(newCircleArea + ' sq meters');
                                    //$('#latlng').text(circleLat + ',' + circleLng);
                                    $('#latlng-update').html('<label class="col-4 col-form-label">Latitude</label><div class="col-8"><input class="form-control" id="newLat-update" type="text" value="' + newCircleLat + '"></div>' + '<br><br>' +
                                        '<label class="col-4 col-form-label">Longitude</label><div class="col-8"><input class="form-control" id="newLng-update" type="text" value="' + newCircleLng + '"></div>' + '<br><br>' +
                                        '<label class="col-4 col-form-label">Radius(Meters)</label><div class="col-8"><input class="form-control" id="circleRadius-update" type="text" value="' + newCircleRad + '"></div>' + '<br>');
                                    $("#circleRadius-update").bind("input", function() {
                                        var newCircleRad = parseFloat($(this).val());
                                        newCircle.setRadius(parseFloat($(this).val()));
                                        var newCircleAreaUpdate = (Math.PI * newCircleRad * newCircleRad).toFixed(2);
                                        $('.shapeArea').text(newCircleAreaUpdate + ' sq meters');
                                    });
                                    $("#newLat-update").bind("input", function() {
                                        newCircle.setCenter(new google.maps.LatLng(parseFloat($(this).val()), newCircleLng));
                                    });
                                    $("#newLng-update").bind("input", function() {
                                        newCircle.setCenter(new google.maps.LatLng(newCircleLat, parseFloat($(this).val())));
                                    });
                                    circle.addListener("bounds_changed", showNewCordUpdate);
                                    function showNewCordUpdate() {
                                        var draggedCircleLatUpdate = circle.getCenter().lat().toFixed(6);
                                        var draggedCircleLngUpdate = circle.getCenter().lng().toFixed(6);
                                        $("#newLat-update").val(draggedCircleLatUpdate);
                                        $("#newLng-update").val(draggedCircleLngUpdate);
                                    }
                                    drawnShapeUpdate = circle;
                                });
                                $('#updateBtn').unbind().click(function() {
                                //$(document).on('click', '#updateBtn', function() {
                                    $("#overlay-loader").fadeIn(300);
                                    if (drawnShapeUpdate != null) {
                                        console.log('drawn');
                                        var newCircleStr = stringify(drawnShapeUpdate);
                                    } else if (newCircle) {
                                        console.log('fetched');
                                        var newCircleStr = stringify(newCircle);
                                    }
                                    console.log(newCircleStr);
                                    //console.log(JSON.parse(drawnShape))
                                    var formDataUpdate = JSON.stringify({
                                        user_id: user_id,
                                        ssm: arr_ssm.ssm,
                                        geofence_id: gf_id,
                                        from_date: $("#date-from").val(),
                                        to_date: $("#date-to").val(),
                                        shape_type: 'circle',
                                        shape_details: newCircleStr,
                                    });
                                    $.ajax({
                                        type: "PUT",
                                        url: "assets/api/geofencing_data_api.php",
                                        data: formDataUpdate,
                                        success: function(result) {
                                            $("#overlay-loader").fadeOut(300);
                                            console.log(result.success);
                                            if (result.success == '0') {
                                                $("#msgSuccess").hide("slow");
                                                $("#errMsg").text('There is an error, please check your inputs').show().delay(4000);
                                            } else if (result.success == '1') {
                                                method = 2;
                                                $("#msgSuccess").text('Geofence updated successfully!').show().delay(4000);
                                                $("#errMsg").hide("slow");
                                                updateDivReset();
                                                newCircle = '';
                                                drawnShapeUpdate = '';
                                                gfChange(user_id, arr_ssm.ssm, method);
                                            }
                                        },
                                        error: function(err) {
                                            console.log(err);
                                            $("#errMsg").text('There is an error, please check your inputs').show().delay(4000);
                                            $("#msgSuccess").hide("slow");
                                        }
                                    })
                                });
                                $('#dltBtn').unbind().click(function() {
                                    //console.log(storedData);
                                    $("#delModal").modal("show");
                                    $(".del_btn").unbind().click(function() {
                                        $.ajax({
                                            type: "DELETE",
                                            url: "assets/api/geofencing_data_api.php",
                                            data: JSON.stringify({
                                                user_id: user_id,
                                                geofence_id: gf_id
                                            }),
                                            success: function(result) {
                                                console.log(result);
                                                $("#delModal").modal("hide");
                                                $("#msgSuccess").text('You have successfully deleted the Geofence!').show().delay(4000);
                                                $("#errMsg").hide("slow");
                                                updateDivReset();
                                                newCircle = '';
                                                drawnShapeUpdate = '';
                                            }
                                        });
                                    });
                                });
                            } else if (result.status == '0') {
                                $("#errMsg").text('This is an invalid combination of SSM. Please select a valid comination in order to create or update geofence.').show().delay(4000);
                                $("#msgSuccess").hide("slow");
                                createDivReset();
                                updateDivReset();
                            } else if (result.status == '3') {
                                $("#errMsg").text('Please Select an SSM to continue').show().delay(4000);
                                $("#msgSuccess").hide("slow");
                                createDivReset();
                                updateDivReset();
                            }
                        }
                    });
                }
            });
            /* Functions to reset on select change */
            function createDivReset() {
                $("#create-info").hide('slow');
                $("#create-map").hide('slow');
                $("#create-btn").hide('slow');
                $('#latlng').text('');
                $('#latlng').html('');
                $('.shapeArea').text('');
                $('.drawing_tool').text('');
                $('.latlngHead').html("");
            }

            function updateDivReset() {
                $("#update-info").hide('slow');
                $("#update-map").hide('slow');
                $("#update-btn").hide('slow');
                $('#latlng-update').text('');
                $('#latlng-update').html('');
                $('.shapeArea-update').text('');
                $('.drawing_tool-update').text('');
                $('.latlngHead-update').html("");
            }
            /* Function to remove circular json error */
            function stringify(obj) {
                let cache = [];
                let str = JSON.stringify(obj, function(key, value) {
                    if (typeof value === "object" && value !== null) {
                        if (cache.indexOf(value) !== -1) {
                            // Circular reference found, discard key
                            return;
                        }
                        // Store value in our collection
                        cache.push(value);
                    }
                    return value;
                });
                cache = null; // reset the cache
                return str;
            }
            /* Reset Button*/
            $(document).on('click', '#resetBtn', function() {
                $("#overlay-loader").fadeIn(300);
                //$('#country').prop('selectedIndex',0);
                // $('#project').find('option').remove().end().append(projectHtml);
                // $('#country').find('option').remove().end().append(countryHtml);
                // $('#pro_manager').find('option').remove().end().append(pmHtml);
                // $('#ssm_device').find('option').remove().end().append(ssmHtml);
                // arr = {
                //     'user_id': user_id,
                //     'country': '',
                //     'project': Number('0'),
                //     'pro_manager': Number('0'),
                //     'ssm': ''
                // };
                if(initialRole=='3') {
                    arr = {'user_id': user_id, 'country': initialCountry, 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
                }
                else if(initialRole=='2') {
                    arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number(initialPM), 'ssm': '', 'from_date': '', 'to_date': ''}
                }
                else if(initialRole=='4') {
                    arr = {'user_id': user_id, 'country': '', 'project': Number($('#project').val()), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
                }
                else {
                    arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
                }
                $.ajax({
                        type: "POST",
                        url: "assets/api/ssm_data_for_map.php",
                        data: JSON.stringify(arr),
                        success: function(result) {
                            $("#overlay-loader").fadeOut(300);
                            $("#view-map").show("slow");
                            console.log(result);
                            map_view = new GMaps({
                                div: '#gmaps-view'
                            });
                            let infowindow = new google.maps.InfoWindow();
                            var bounds = new google.maps.LatLngBounds();
                            jQuery.each(result.res, function(index, item) {
                            // console.log(JSON.parse(item.device_responsible))
                                //console.log(item.gnss_location_details.length);
                                //if(item.gnss_location_details.length > 0) {
                                if(item.gnss_location_details!=null) {
                                    map_view.addMarker({
                                        lat: item.gnss_location_details[0].latitude,
                                        lng: item.gnss_location_details[0].longitude,
                                        details: {
                                            database_id: 42,
                                            author: 'HPNeo'
                                        },
                                        icon: iconCustom,
                                        click: function(e) {

                                        },
                                        mouseover: function() {
                                            infowindow.open(map_view, this);
                                            infowindow.setContent("<h4>" + item.gnss_location_details[0].latitude +
                                                "</h4><p><b>Latitude:</b> " + item.gnss_location_details[0].latitude + "</p><p><b>Longitude:</b> " + item.gnss_location_details[0].longitude +
                                                "</p><p><b>Team:</b> " + item.team_name + "</p><p><b>SMB Ref. No-:</b> " + item.ssm_id +
                                                "</p><p><b>Last Seen:</b> " + item.last_seen_time + "</p>")
                                        },
                                        mouseout: function() {
                                            infowindow.close();
                                        }
                                    });
                                    bounds.extend(new google.maps.LatLng(item.gnss_location_details[0].latitude, item.gnss_location_details[0].longitude));
                                    }
                                });
                                map_view.fitBounds(bounds);
                                createDivReset();
                                updateDivReset();
                            if (result.status == 1) {
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
                                    multiSelectData = [];
                                    $('#ssm_device').find('option').remove();
                                    jQuery.each(result.device, function(index, item) {
                                        multiSelectData.push({
                                            label: item.ref,
                                            value: item.ssm_id
                                        });
                                    });
                                    $("#ssm_device").multiselect('dataprovider', multiSelectData);
                                } else if (result.device.length == 0) {
                                    multiSelectData = [];
                                    $("#ssm_device").multiselect('dataprovider', multiSelectData);
                                }
                                $('#country').find('option').remove();
                                $('#country').append('<option selected disabled>Country</option>');
                                jQuery.each(result.country, function(index, item) {
                                    $('#country').append($('<option/>', {
                                        value: item.country,
                                        text: item.country,
                                    }));
                                });
                            }
                        }
                    });
            });

            /* Multiple Selection */
            $('#ssm_device').multiselect({
                inheritClass: true,
                includeSelectAllOption: true,
                buttonWidth: '100%',
                nonSelectedText: 'SSM',
                disableIfEmpty: true,
                includeSelectAllIfMoreThan: 1,
                maxHeight: 200
            });
            /* GF List Modal */
            $(document).on('click', '#gfList', function() {
                $("#overlay-loader").fadeIn(300);
                $('#gfListModal').modal('show');
                var noGeofence = [];
                var geofenceDev = [];
                /* Getting geofence info */
                $.ajax({
                    type: "PATCH",
                    url: "/assets/api/geofencing_data_by_user_pg.php",
                    data: JSON.stringify({
                        'user_id': user_id
                    })
                }).done(function(result) {
                    $("#overlay-loader").fadeOut(300);
                    $('#gfInfoDiv').html('');
                    console.log(result);
                    if(result.status=='1') {
                        if(result.res.length>0) {
                            jQuery.each(result.res, function(index, item) {
                                if(item.is_exists==false){
                                    noGeofence.push(item);
                                }
                                else {
                                    geofenceDev.push(item);
                                }
                            });
                        }
                    }
                    console.log(geofenceDev);
                    if(noGeofence.length>0) {
                        jQuery.each(noGeofence, function(index, item) {
                            if(dev_associated.includes(item.ssm_id)) {
                                $('#gfInfoDiv').append(`<div class="row text-center">
                                                            <div class="col-4"><p class="text-plan text-center"><b>`+item.ssm_id+`</b></p></div>
                                                            <div class="col-4"><p class="text-danger text-center">No</p></div>
                                                            <div class="col-4"><p class="text-plan text-center">`+item.team_name+`</p></div>
                                                        </div>`);
                            }
                        });
                    }
                    if(geofenceDev.length>0) {
                        jQuery.each(geofenceDev, function(index, item) {
                            jQuery.each(item, function(indexDev, itemDev) {
                                let groups = itemDev.map(x => {if(dev_associated.includes(x.ssm_id)) {return x.ssm_id;}else {return 0;}}).join(", ");
                                console.log(itemDev);
                                if(groups.charAt(0)!='0'){
                                    $('#gfInfoDiv').append(`<div class="row text-center">
                                                                <div class="col-4"><p class="text-plan text-center"><b>`+groups+`</b></p></div>
                                                                <div class="col-4"><p class="text-success text-center">Yes</p></div>
                                                                <div class="col-4"><p class="text-plan text-center">`+itemDev[0].team_name+`</p></div>
                                                            </div>`);
                                }
                            });
                        }); 
                    }
                });
            });
            /* Selectboxes in the table */
            $("#checkall").click(function() {
                $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                $('.del-btn').css('display', 'inline-block');
                $('.checkItem').each(function() {
                    $(this).css('visibility', 'visible');
                });
            });

            $("input[type=checkbox]").click(function() {
                if (!$(this).prop("checked")) {
                    $("#checkall").prop("checked", false);
                    $('.del-btn').css('display', 'none');
                    $('.checkItem').each(function() {
                        $(this).css('visibility', 'hidden');
                    });
                }
            });
            $('.checkItem').each(function() {
                if (!$(this).prop("checked")) {
                    $(this).css('visibility', 'hidden');
                } else if ($(this).prop("checked")) {
                    $(this).css('visibility', 'visible');
                }
            });
            /* Map 
            var map = new GMaps({
                div: '#gmaps-markers',
                lat: 60.1699,
                lng: 24.9384
            });
            var marker = map.addMarker({
                lat: 60.1699,
                lng: 24.9384,
                title: 'Helsinki',
                details: {
                author: 'HPNeo'
                },
                animation: google.maps.Animation.DROP,
                click: function(e){
                if(console.log)
                    console.log(e);
                alert('You clicked in this marker');
                }
            });*/
            // Create the search box and link it to the UI element.
            // const input = document.getElementById("pac-input");
            // const searchBox = new google.maps.places.SearchBox(input);
            // //map.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // // Bias the SearchBox results towards current map's viewport.
            // map.addListener("bounds_changed", () => {
            //     searchBox.setBounds(map.getBounds());
            // });
            // let markers = [];

            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            // searchBox.addListener("places_changed", () => {
            //     const places = searchBox.getPlaces();

            //     if (places.length == 0) {
            //         return;
            //     }

            //     // Clear out the old markers.
            //     markers.forEach((marker) => {
            //         marker.setMap(null);
            //     });
            //     markers = [];

            //     // For each place, get the icon, name and location.
            //     const bounds = new google.maps.LatLngBounds();

            //     places.forEach((place) => {
            //         if (!place.geometry || !place.geometry.location) {
            //             console.log("Returned place contains no geometry");
            //             return;
            //         }

            //         const icon = {
            //             url: place.icon,
            //             size: new google.maps.Size(71, 71),
            //             origin: new google.maps.Point(0, 0),
            //             anchor: new google.maps.Point(17, 34),
            //             scaledSize: new google.maps.Size(25, 25),
            //         };

            //         // Create a marker for each place.
            //         markers.push(
            //             new google.maps.Marker({
            //                 map,
            //                 icon,
            //                 title: place.name,
            //                 position: place.geometry.location,
            //             })
            //         );
            //         if (place.geometry.viewport) {
            //             // Only geocodes have viewport.
            //             bounds.union(place.geometry.viewport);
            //         } else {
            //             bounds.extend(place.geometry.location);
            //         }
            //     });
            //     map.fitBounds(bounds);
            // });



        });
    </script>
</body>

</html>