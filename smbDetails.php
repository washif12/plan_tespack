<?php
session_start();
require __DIR__.'/assets/api/classes/database.php';
require __DIR__.'/assets/api/classes/JwtHandler.php';
//$token = $_SESSION['token'];
if($_SESSION['token']== true) {
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
  

    $jwt = new JwtHandler();
    $token_data = $jwt->jwtDecodeData($_SESSION['token']);
    if($token_data == 'Expired token'):
        $_SESSION['error'] = 'Sorry! Your session expired, Please Log in to continue.';
        header('location:login.php');
    else:
        $user_id = $token_data->data->user_id; 
        try{
            $check = "SELECT * FROM users WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
            $check_stmt->execute();
            if($check_stmt->rowCount()):
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                $fname = $data["fname"];
                $lname = $data["lname"];
                $phone = $data["phone"];
                $address = $data["address"];
                $country = $data["country"];
                $email = $data["email"];
                $role = $data["role"];
                $image_path = $data["image_path"];
                $_SESSION['login_role'] = $role;
                $id = $_GET['id'];
                $check_device = "SELECT * FROM devices WHERE ssm_id=:id";
                $check_device_stmt = $conn->prepare($check_device);
                $check_device_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $check_device_stmt->execute();
                if($check_device_stmt->rowCount()):
                    $data_device = $check_device_stmt->fetch(PDO::FETCH_ASSOC);
                    $ref = $data_device['ref'];
                    $info_id = $data_device['id'];
                endif;
            else:
                $_SESSION['error'] = 'Sorry! You are not registered in our Platform.';
                header('location:login.php');
        
            endif;
        }
        catch(PDOException $e){
            $_SESSION['error'] = 'Sorry! There is some issue in the server, try again later.';
            header('location:login.php');
        }
    endif;
}
else {
    $_SESSION['error'] = 'Sorry! Please Log in to continue.';
    header('location:login.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons 
        <link rel="shortcut icon" href="assets/images/favicon.ico">-->

        <!-- App title -->
        <title>Plan - International </title>
        <!-- Basic Css files -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="assets/plugins/morris/morris.css">
        <!-- ION Slider -->
        <link href="assets/plugins/ion-rangeslider/ion.rangeSlider.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/ion-rangeslider/ion.rangeSlider.skinModern.css" rel="stylesheet" type="text/css"/>
        <!-- Dropzone css -->
        <link href="assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
    </head>


    <body class="fixed-left">
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
                        <input type="hidden" value="<?php echo $user_id; ?>" id="data-id">
                        <input type="hidden" value="<?php echo $id; ?>" id="ssm-id">
                        <input type="hidden" value="<?php echo $info_id; ?>" id="info-id">
                        <div class="sidebar-inner slimscrollleft">
                            <div id="sidebar-menu">
                                <ul>
        
                                    <!--<li class="menu-title">Main</li>-->
        
                                    <li class="">
                                        <a href="stats.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/dashboard-white.png"></div><span> Dashboard Statistics </span></a>
                                    </li>

                                    <?php if($role=='1'||$role=='3' || $role == '2'): ?>
                                    <li>
                                        <a href="user.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/admin-white.png"></div><span> Users </span></a>
                                    </li>
                                    <?php else:
                                    endif; ?>

                                    <li>
                                        <a href="map.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/map-white.png"></div><span> Map </span></a>
                                    </li>

                                    <li>
                                        <a href="geoFencing.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/geofencing-white.png"></div><span> Geofencing </span></a>
                                    </li>

                                    <?php if($role=='1'||$role=='3' || $role == '0'): ?>
                                    <li>
                                        <a href="countries.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/countries-white.png"></div><span> Countries </span></a>
                                    </li>
                                    <?php else:
                                    endif; ?>

                                    <li>
                                        <a href="smb.php" class="waves-effect active"><div class="custom-icon"><img src="assets/images/icons/sidebar/smb-white.png"></div><span> SSM </span></a>
                                    </li>

                                    <li>
                                        <a href="teams.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/teams-white.png"></div><span> Teams </span></a>
                                    </li>

                                    <li>
                                        <a href="projects.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/projects-white.png"></div><span> Projects </span></a>
                                    </li>

                                    <li>
                                        <a href="trainings.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/training-white.png"></div><span> SSM Tutorials </span></a>
                                    </li>

                                    <li>
                                        <a href="tickets.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/ticket-support-white.png"></div><span> Ticket Support </span></a>
                                    </li>

                                    <li>
                                        <a href="report.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/reports-white.png"></div><span> Reports </span></a>
                                    </li>

                                    <li>
                                        <a href="logs.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/logs-white.png"></div><span> Logs </span></a>
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
                                            <h3 class="page-title"><?php echo $ref; ?> </h3>
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
                            <input type="hidden" value="<?php echo $user_id; ?>" id="data-ud">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30 img-responsive" style="background-image: url(assets/images/smb/bg.png);background-size: 100% 100%;min-height: 350px;width:100%;background-position: center;background-repeat: no-repeat;border-radius:20px;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-5"></div>
                                                        <div class="col-7">
                                                            <div class="row m-t-20">
                                                                <div class="col-12 text-left">
                                                                    <p class="text-white font-32">SSM Information</p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-6" id="live_data_status">
                                                                            <!-- <h6 class="text-white">
                                                                                Online <i class="mdi mdi-checkbox-blank-circle text-success font-10"></i>
                                                                            </h6> -->
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <h6 class="text-white bat_status">
                                                                                <!--CONNECTED <i class="mdi mdi-checkbox-blank-circle text-success font-10"></i>-->
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 m-b-10">
                                                                    <div class="row">
                                                                        <div class="col-6 text-white font-10" style="display: inline-block;">
                                                                            <p style="margin-bottom: 0px;"><img src="assets/images/smb/signal.png"> Signal</p>
                                                                        </div>
                                                                        <div class="col-6 text-left font-10" style="color: #ffd600;padding: 0px;margin: auto;border-right: 2px solid white;">
                                                                            <p style="margin-bottom: 0px;"><b id="sig_st"></b></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 m-b-10">
                                                                    <div class="row h-100">
                                                                        <div class="col-6 text-white font-10" style="display: inline-block;margin: auto;">
                                                                            <p style="margin-bottom: 0px;">Network</p>
                                                                        </div>
                                                                        <div class="col-6 text-left font-10" style="color: #ffd600;padding: 0px;margin: auto;">
                                                                            <p style="margin-bottom: 0px;"><b id="net"></b></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 m-b-10">
                                                                    <div class="row">
                                                                        <div class="col-3 text-white font-10" style="display: inline-block;">
                                                                            <p style="margin-bottom: 0px;"><img src="assets/images/smb/www.png"> Last Seen</p>
                                                                        </div>
                                                                        <div class="col-9 text-left font-10" style="color: #ffd600;padding: 0px;margin: auto;">
                                                                            <p style="margin-bottom: 0px;"><b id="last_update"></b></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 m-b-10">
                                                                    <div class="row">
                                                                        <div class="col-6 text-white font-10" style="display: inline-block;">
                                                                            <p style="margin-bottom: 0px;"><img src="assets/images/smb/clock.png">&nbsp;&nbsp;Total Sessions</p>
                                                                        </div>
                                                                        <div class="col-3 text-left font-10" style="color: #ffd600;padding: 0px;margin: auto;">
                                                                            <p style="margin-bottom: 0px;"><b id="total_session"></b></p>
                                                                        </div>
                                                                        <div class="col-3 text-left font-10" style="padding: 0px;">
                                                                            <button class="btn btn-sm btn-white font-10 text-plan" disabled data-toggle="modal" data-target="">
                                                                                <i class="fa fa-wifi"></i>&nbsp;Near Wifi
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 m-b-20">
                                                                    <div class="row">
                                                                        <div class="col-6 text-white font-10" style="display: inline-block;">
                                                                            <p style="margin-bottom: 0px;"><img src="assets/images/smb/temp_white.png">&nbsp;&nbsp;Temperature</p>
                                                                        </div>
                                                                        <div class="col-3 text-left font-10" style="color: #ffd600;padding: 0px;margin: auto;">
                                                                            <p style="margin-bottom: 0px;"><b id="device_temperature"></b></p>
                                                                        </div>
                                                                        <div class="col-3 font-10" style="display: inline-block;padding: 0px;">
                                                                            <!-- <button class="btn btn-sm bg-white text-plan" data-container="body"
                                                                             data-toggle="popover" data-placement="top" disabled style="border-radius: 20px;width: 50%;cursor: pointer;"
                                                                             data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                                                                               <b>Alerts</b> 
                                                                            </button> -->
                                                                            <button class="btn btn-sm btn-white font-10 text-plan" disabled data-toggle="modal" data-target="">
                                                                                Alerts
                                                                            </button>
                                                                        </div>
                                                                        <!--<div class="col-6 text-left font-10" style="color: #ffd600;padding: 0px;margin: auto;">
                                                                            <p style="margin-bottom: 0px;"><b>Update Battery 30</b></p>
                                                                        </div>-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 m-b-10">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <p class="text-white font-10 imei"></p>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <p class="text-white font-10 emei"></p>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button class="btn btn-sm bg-white text-plan view_btn" style="border-radius: 20px;width: 100%;cursor: pointer;" id="smb_<?php echo $info_id;?>"><b>INFO</b></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body" style="padding: 0;">
                                                    <h4 class="text-plan text-center m-b-30">GEO LOCATIONS</h4>
                                                    <!--<p class="text-center m-b-20"><span class="text-muted"><b>Last Seen</b></span>&nbsp;&nbsp;&nbsp;<span class="text-plan"><b>Helsinki, Finland</b></span></p>-->
                                                    <div class="row">
                                                        <div class="col-6 m-b-20">
                                                            <div class="sos-status text-center" style="border: 1px solid gray;margin: auto;width: 60%;border-radius: 10px;float: right;">  
                                                                <img src="assets/images/smb/timeline.png" width="50px" height="50px" data-src='assets/images/smb/timeline.png' data-hover='assets/images/smb/timeline-white.png' class="img-fluid img-sos" style="margin: 20px;">
                                                                <p class="text-center text-dark"><b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Click to see the SSMs last locations"></i>&nbsp;TIMELINE</b></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 m-b-20">
                                                            <div class="live-status text-center" style="border: 1px solid gray;margin: auto;width: 60%;border-radius: 10px;float: left;">   
                                                                <img src="assets/images/smb/locate.png" width="50px" height="50px" data-src='assets/images/smb/locate.png' data-hover='assets/images/smb/locate-white.png' class="img-fluid img-live" style="margin: 20px;">
                                                                <p class="text-center text-dark"><b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Locate Device Current Location"></i>&nbsp;LOCATE</b></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 m-b-20">
                                                            <div class="text-center" style="border: 1px solid gray;margin: auto;width: 60%;border-radius: 10px;float: right;">   
                                                                <!--report-status  <img src="assets/images/smb/block.png" width="50px" height="50px" data-src='assets/images/smb/block.png' data-hover='assets/images/smb/block-white.png' class="img-fluid img-report" style="margin: 20px;"> -->
                                                                <img src="assets/images/smb/block.png" width="50px" height="50px" class="img-fluid img-report" style="margin: 20px;">
                                                                <p class="text-center text-dark block-smb-text"><b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Coming Soon!"></i>&nbsp;BLOCK SSM</b></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 m-b-20">
                                                            <div class="gf-status text-center" style="border: 1px solid gray;margin: auto;width: 60%;border-radius: 10px;float: left;">   
                                                                <img src="assets/images/smb/sos.png" width="50px" height="50px" data-src='assets/images/smb/sos.png' data-hover='assets/images/smb/sos-white.png' class="img-fluid img-gf"  style="margin: 20px;">
                                                                <p class="text-center text-dark sos-text"><b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="This will turn RED if device is in Danger"></i>&nbsp;ACTIVATE SOS</b></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12" style="margin: auto;">
                                                            <!-- <h5 class="text-center power_source_ok">
                                                                <span class="text-plan">Power Source Ok</span>
                                                                <i class="mdi mdi-checkbox-blank-circle text-success font-10"></i>
                                                            </h5>
                                                            <h5 class="text-center power_source_err">
                                                                <span class="text-plan">Power Source Error</span>
                                                                <i class="mdi mdi-checkbox-blank-circle text-danger font-10"></i>
                                                            </h5> -->
                                                            <div class="row">
                                                                <div class="col-6" style="margin: auto;">
                                                                    <h3 class="text-muted text-center m-b-10">Power Source Status</h3>
                                                                    <h5 class="text-center">
                                                                        <span class="text-plan" id="power_source_status"></span>
                                                                    </h5>
                                                                </div>
                                                                <div class="col-6" style="margin: auto;">
                                                                    <h3 class="text-muted text-center m-b-10">Power Source Type</h3>
                                                                    <h5 class="text-center">
                                                                        <span class="text-plan" id="power_source_type"></span>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <h1 class="text-plan text-center m-b-10"><img src="assets/images/smb/charge-blue.png" class="charging" style="padding-bottom: 10px;"><b id="total_charge"></b></h1>
                                                            <h4 class="text-plan text-center m-b-10">Overall Status</h4>
                                                        </div>
                                                        <div class="col-12 text-center">
                                                            <div class="row" id="power_bank_container">
                                                                <!--<div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                    <div class="card m-b-10">
                                                                        <div class="card-body" style="padding: 0;">
                                                                            <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank 1</b></p>
                                                                            <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- 31424242442</p>
                                                                            <div class="row">
                                                                                <div class="col-6" style="padding: 0;"><h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;"><img src="assets/images/smb/battery-blue.png" height="25px"></h5></div>
                                                                                <div class="col-6" style="padding: 0;"><h4 class="text-plan text-left" style="margin-bottom: 5px;margin-top: 5px;">90%</h4></div>
                                                                                <div class="col-6 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-center" style="margin-bottom: 5px;font-size: x-small;"><b>Capacity</b></p>
                                                                                    <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;"><b>40W</b></p>
                                                                                </div>
                                                                                <div class="col-3 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Cycles</b></p>
                                                                                    <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>400</b></p>
                                                                                </div>
                                                                                <div class="col-3 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Type</b></p>
                                                                                    <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>A</b></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                    <div class="card m-b-10">
                                                                        <div class="card-body" style="padding: 0;">
                                                                            <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank 2</b></p>
                                                                            <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- 31424242442</p>
                                                                            <div class="row">
                                                                                <div class="col-6" style="padding: 0;"><h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;"><img src="assets/images/smb/battery-blue.png" height="25px"></h5></div>
                                                                                <div class="col-6" style="padding: 0;"><h4 class="text-plan text-left" style="margin-bottom: 5px;margin-top: 5px;">90%</h4></div>
                                                                                <div class="col-6 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-center" style="margin-bottom: 5px;font-size: x-small;"><b>Capacity</b></p>
                                                                                    <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;"><b>40W</b></p>
                                                                                </div>
                                                                                <div class="col-3 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Cycles</b></p>
                                                                                    <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>400</b></p>
                                                                                </div>
                                                                                <div class="col-3 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Type</b></p>
                                                                                    <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>A</b></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                    <div class="card m-b-10">
                                                                        <div class="card-body" style="padding: 0;">
                                                                            <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank 3</b></p>
                                                                            <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- 31424242442</p>
                                                                            <div class="row">
                                                                                <div class="col-6" style="padding: 0;"><h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;"><img src="assets/images/smb/battery-blue.png" height="25px"></h5></div>
                                                                                <div class="col-6" style="padding: 0;"><h4 class="text-plan text-left" style="margin-bottom: 5px;margin-top: 5px;">90%</h4></div>
                                                                                <div class="col-6 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-center" style="margin-bottom: 5px;font-size: x-small;"><b>Capacity</b></p>
                                                                                    <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;"><b>40W</b></p>
                                                                                </div>
                                                                                <div class="col-3 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Cycles</b></p>
                                                                                    <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>400</b></p>
                                                                                </div>
                                                                                <div class="col-3 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Type</b></p>
                                                                                    <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>A</b></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                    <div class="card m-b-10">
                                                                        <div class="card-body" style="padding: 0;">
                                                                            <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank 4</b></p>
                                                                            <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- 31424242442</p>
                                                                            <div class="row">
                                                                                <div class="col-12" style="padding: 0;">
                                                                                    <h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;">
                                                                                        <img src="assets/images/smb/dead-battery.png" style="max-width: 48px;">
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="col-12 text-center" style="padding: 0;">
                                                                                    <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;">
                                                                                        <b>Power Bank Disconnected</b>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                    <div class="card m-b-10">
                                                                        <div class="card-body" style="padding: 0;">
                                                                            <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank 5</b></p>
                                                                            <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- 31424242442</p>
                                                                            <div class="row">
                                                                                <div class="col-6" style="padding: 0;"><h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;"><img src="assets/images/smb/battery-blue.png" height="25px"></h5></div>
                                                                                <div class="col-6" style="padding: 0;"><h4 class="text-plan text-left" style="margin-bottom: 5px;margin-top: 5px;">90%</h4></div>
                                                                                <div class="col-6 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-center" style="margin-bottom: 5px;font-size: x-small;"><b>Capacity</b></p>
                                                                                    <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;"><b>40W</b></p>
                                                                                </div>
                                                                                <div class="col-3 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Cycles</b></p>
                                                                                    <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>400</b></p>
                                                                                </div>
                                                                                <div class="col-3 text-center" style="padding: 0;">
                                                                                    <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Type</b></p>
                                                                                    <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>A</b></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                    <div class="card m-b-10">
                                                                        <div class="card-body" style="padding: 0;">
                                                                            <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank 6</b></p>
                                                                            <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- 31424242442</p>
                                                                            <div class="row">
                                                                                <div class="col-12" style="padding: 0;">
                                                                                    <h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;">
                                                                                        <img src="assets/images/smb/critical-battery.png" style="max-width: 48px;">
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="col-12 text-center" style="padding: 0;">
                                                                                    <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;">
                                                                                        <b>Damage Detected</b>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12" style="margin: auto;">
                                                            <h2 class="text-muted text-center m-b-20">Energy Statistics</h2>
                                                        </div>
                                                        <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                                            <label for="example-text-input-lg" class="col-form-label">From</label>
                                                        </div>
                                                        <div class="form-group col-xl-5 col-lg-5 col-md-4 col-sm-4 col-xs-4">
                                                            <input type="date" id="date-from" class="form-control" max="<?php echo date("Y-m-d"); ?>">
                                                        </div>
                                                        <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                                            <label for="example-text-input-lg" class="col-form-label">To</label>
                                                        </div>
                                                        <div class="form-group col-xl-5 col-lg-5 col-md-4 col-sm-4 col-xs-4">
                                                            <input type="date" id="date-to" class="form-control" max="<?php echo date("Y-m-d"); ?>">
                                                        </div>
                                                        <div class="col-8"></div>
                                                        <div class="form-group col-4 text-right">
                                                            <button class="btn btn-sm btn-plan" id="filterBtn">FILTER</button>
                                                        </div>
                                                        <div class="col-4 text-center m-b-10">
                                                            <span class="badge font-14" style="line-height: normal;background-color: #fff;border-radius:0px;cursor:pointer;color:#fddd3e;">Solar Energy</span><span class="badge font-14 text-white" style="line-height: normal;border-radius: 0px;background-color:#005aa7;" id="sol_energy_amount"></span>
                                                        </div>
                                                        <div class="col-4 text-center m-b-10">
                                                            <span class="badge font-14" style="line-height: normal;background-color: #fff;border-radius:0px;cursor:pointer;color:#000;">Grid Energy</span><span class="badge font-14 text-white" style="line-height: normal;border-radius: 0px;background-color:#005aa7;" id="grid_energy_amount"></span>
                                                        </div>
                                                        <div class="col-4 text-center m-b-10">
                                                            <span class="badge font-14" style="line-height: normal;background-color: #fff;border-radius:0px;cursor:pointer;color:#45eb80;">Battery Energy</span><span class="badge font-14 text-white" style="line-height: normal;border-radius: 0px;background-color:#005aa7;" id="bat_energy_amount"></span>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <p class="text-center text-danger" id="errMsgGraph"></p>
                                                            <p class="text-center text-success" id="msgSuccessGraph"></p>
                                                        </div>
                                                        <div class="col-12 energyGraphContainer">
                                                            <canvas id="lineChart" height="350"></canvas>
                                                        </div>
                                                    </div>
                                                    <!-- <div id="morris-line-example" class=""></div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body">
                                                    <h2 class="text-muted text-center m-b-30"><img src="assets/images/smb/projector icon.png">&nbsp;Video Projector</h2>
                                                    <!--<p class="text-center m-b-20"><span class="text-muted"><b>Last Seen</b></span>&nbsp;&nbsp;&nbsp;<span class="text-plan"><b>Helsinki, Finland</b></span></p>-->
                                                    <!-- <div class="row">
                                                        <div class="col-10" style="margin: auto;">
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-3"><h6 class="text-plan">Model</h6></div>
                                                                <div class="col-3"><h6>Optoma, LDM***8T<h6></div>
                                                                <div class="col-3"><h6 class="text-plan">Wattage</h6></div>
                                                                <div class="col-3"> <h6>72Watts</h6></div>
                                                            </div>
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-3"><h6 class="text-plan">Date</h6></div>
                                                                <div class="col-3"><h6>ABCDEF</h6></div>
                                                                <div class="col-3"><h6 class="text-plan">Change</h6></div>
                                                                <div class="col-3"> <h6>ABCDEF*</h6></div>
                                                            </div>
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-3"><h6 class="text-plan">Hours</h6></div>
                                                                <div class="col-3"><h6>ABCDEF</h6></div>
                                                            </div>
                                                        </div>

                                                    </div> -->
                                                    <div class="row">
                                                        <div class="col-8 text-center" style="margin: auto;">
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-6"><h6 class="text-plan">Model</h6></div>
                                                                <div class="col-6"><h6>Optoma, LDM***8T<h6></div>
                                                            </div>
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-6"><h6 class="text-plan">Wattage</h6></div>
                                                                <div class="col-6"> <h6>72Watts</h6></div>
                                                            </div>
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-6"><h6 class="text-plan">Date</h6></div>
                                                                <div class="col-6"> <h6>2023-02-22</h6></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card m-b-30" style="border-radius:20px;">
                                                <div class="card-body">
                                                    <h2 class="text-muted text-center m-b-30"><img src="assets/images/smb/solar-cell-efficiency.png" width="80">&nbsp;Solar Panel</h2>
                                                    <!--<p class="text-center m-b-20"><span class="text-muted"><b>Last Seen</b></span>&nbsp;&nbsp;&nbsp;<span class="text-plan"><b>Helsinki, Finland</b></span></p>-->
                                                    <div class="row">
                                                        <div class="col-8 text-center" style="margin: auto;">
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-6"><h6 class="text-plan">Power</h6></div>
                                                                <div class="col-6"><h6>90 Watts<h6></div>
                                                            </div>
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-6"><h6 class="text-plan">Model</h6></div>
                                                                <div class="col-6"> <h6>A90WS Mono</h6></div>
                                                            </div>
                                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                                <div class="col-6"><h6 class="text-plan">Capacity</h6></div>
                                                                <div class="col-6"><h6>90W</h6></div>
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
                            © <?php echo date('Y');?> Tespack - All rights reserved .
                        </footer>

                    </div> <!-- content Page-->
                </div> <!-- Wrapper-->
                <!-- View modal -->
                <div id="viewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-plan">
                                <h5 class="col-11 text-center modal-title mt-0" id="viewHeader"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-9 info-view">
                                        <div class="col-12">
                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-4 text-plan"><b>Reference Number</b></div>
                                                <div class="col-2 text-plan" id="ref_no"></div>
                                                <div class="col-3 text-plan"><b>Model</b></div>
                                                <div class="col-3 text-plan" id="model"></div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-12">
                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-4 text-plan"><b>Origin</b></div>
                                                <div class="col-2 text-plan"></div>
                                                <div class="col-3 text-plan"><b>Power Source Model</b></div>
                                                <div class="col-3 text-plan"></div>
                                            </div>
                                        </div> -->
                                        <div class="col-12">
                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-4 text-plan"><b>Project Assigned</b></div>
                                                <div class="col-2 text-plan" id="project_assigned"></div>
                                                <div class="col-3 text-plan"><b>Project Country</b></div>
                                                <div class="col-3 text-plan" id="country_pro"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-4 text-plan"><b>SSM Responsible</b></div>
                                                <div class="col-2 text-plan" id="ssm_responsible"></div>
                                                <div class="col-3 text-plan"><b>Date Delivered</b></div>
                                                <div class="col-3 text-plan" id="deliver_date"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-4 text-plan"><b>Emergency Contact</b></div>
                                                <div class="col-2 text-plan" id="contact_no"></div>
                                                <div class="col-3 text-plan"><b>Date Assigned</b></div>
                                                <div class="col-3 text-plan" id="assign_date"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 info-view">
                                        <div>
                                        <h5 class="text-plan">Notes</h5>
                                        <p class="text-plan" id="notes"></p>
                                        
                                        <!--<button class="btn btn-sm btn-plan info-edit-btn"><i class="fa fa-edit pro-edit"></i> Edit</button>-->
                                        
                                        </div>
                                    </div>
                                    <!-- <div class="col-12 info-view">
                                        <div class="text-center">
                                        <h5 class="text-plan">Device Accessories</h5>
                                        <table class="table table-borderless text-center m-b-20" style="width: 90%;margin: auto;">
                                            <thead>
                                                <tr>
                                                    <th class="col-4">Accessory Name</th>
                                                    <th class="col-8">Description</th>
                                                </tr>
                                            </thead>           
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Project A</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Project B</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-12 info-form">
                                        <div style="margin-bottom: 20px;">
                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-3 text-plan" style="margin: auto;"><b>Reference Number</b></div>
                                                <div class="col-3">
                                                    <input class="form-control" value="123456789">
                                                </div>
                                                <div class="col-3 text-plan" style="margin: auto;"><b>Model</b></div>
                                                <div class="col-3">
                                                    <input class="form-control" value="V">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 20px;">
                                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-3 text-plan" style="margin: auto;"><b>Country</b></div>
                                            <div class="col-3">
                                                <select class="form-control">
                                                    <option>Finland</option>
                                                    <option>Congo</option>
                                                    <option>Costa Rica</option>
                                                </select>
                                            </div>
                                            <div class="col-3 text-plan" style="margin: auto;"><b>Date Delivered</b></div>
                                            <div class="col-3">
                                                <input class="form-control" type="date" value="2021-04-27">
                                            </div>
                                        </div>
                                        </div>
                                        <div style="margin-bottom: 20px;">
                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-3 text-plan" style="margin: auto;"><b>Project Assigned</b></div>
                                                <div class="col-3">
                                                    <select class="form-control">
                                                        <option>Project Name</option>
                                                        <option>Project Name</option>
                                                        <option>Project Name</option>
                                                    </select>
                                                </div>
                                                <div class="col-3 text-plan" style="margin: auto;"><b>Project Country</b></div>
                                                <div class="col-3">
                                                    <select class="form-control">
                                                        <option>Finland</option>
                                                        <option>Congo</option>
                                                        <option>Costa Rica</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 20px;">
                                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                                <div class="col-3 text-plan" style="margin: auto;"><b>SSM Responsible</b></div>
                                                <div class="col-3">
                                                    <select class="form-control">
                                                        <option>SSM 123456789</option>
                                                        <option>SSM 123456789</option>
                                                        <option>SSM 123456789</option>
                                                    </select>
                                                </div>
                                                <div class="col-3 text-plan" style="margin: auto;"><b>Date Assigned</b></div>
                                                <div class="col-3">
                                                    <input class="form-control" type="date" value="2021-04-27">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    <div class="col-12 info-form">
                                        <h5 class="text-plan">Notes</h5>
                                        <textarea id="editDesc" style="width: 100%;margin-bottom: 10px;padding: 10px;height: 65%;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</textarea>
                                        
                                    </div> -->
                                </div>
                            </div>
                            <div class="modal-footer info-footer">
                                <button type="button" class="btn btn-secondary info-cancel">Cancel</button>
                                <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- view modal -->
                <!-- Profile modal -->
                <?php include_once('includes/modal/profile.php'); ?>
                <!-- Profile modal -->
                <!-- Notification modal -->
                <?php include_once('includes/modal/notification.php'); ?>
                <!-- Notification modal -->
                <!-- Logout modal -->
                <?php include_once('includes/modal/logout.php'); ?>
                <!-- Logout modal -->
                <!-- Timeline modal -->
                <div id="timelineModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-plan">
                                <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel">TIMELINE</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center text-danger font-16" id="errMsg"></p>
                                        <p class="text-center font-16" style="color:#008037;" id="msgSuccess"></p>
                                    </div>
                                    <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label for="example-text-input-lg" class="col-form-label">From</label>
                                    </div>
                                    <div class="form-group col-xl-5 col-lg-5 col-md-4 col-sm-4 col-xs-4">
                                        <input type="date" class="form-control" id="start_date" max="<?php echo date("Y-m-d"); ?>">
                                    </div>
                                    <div class="form-group col-xl-1 col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label for="example-text-input-lg" class="col-form-label">To</label>
                                    </div>
                                    <div class="form-group col-xl-5 col-lg-5 col-md-4 col-sm-4 col-xs-4">
                                        <input type="date" class="form-control" id="end_date" max="<?php echo date("Y-m-d"); ?>">
                                    </div>
                                    <div class="col-8"></div>
                                    <div class="form-group col-4 text-right">
                                        <button class="btn btn-plan timeline-map-btn" id="filter_btn">FILTER</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="gmaps-markers" class="gmaps" style="width: 100%;display: none;"></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- Timeline modal -->
                <!-- LOCATE modal -->
                <div id="locateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-plan">
                                <h6 class="col-11 text-center modal-title mt-0" id="myModalLabelLocate">
                                    
                                </h6>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="gmaps-markers-locate" class="gmaps" style="width: 100%;display: none;"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-8 col-sm-12 col-xs-12" style="margin: auto;">
                                    <div class="p-3">
                                        <h5 class="font-16 m-b-20 mt-0">Check last locations</h5>
                                        <input type="text" id="range">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12" style="margin: auto;">
                                    <button type="button" class="btn btn-plan" style="border-radius: 30px;">
                                        <i class="fa fa-share-alt text-white"> Share Informations</i>
                                    </button>
                                </div>    
                            </div> -->
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- LOCATE modal -->
                <!-- sos modal -->
                <div id="sosModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-plan">
                                <h5 class="col-11 text-center modal-title mt-0" id="sosHeader"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center text-danger" id="errMsgSOS"></p>
                                        <p class="text-center text-success" id="msgSuccessSOS"></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-plan m-b-0"><b>GNSS</b></p>
                                        <div class="row font-12" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Longitude:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_lat"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Latitude:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_lng"></div>
                                        </div>
                                        <!-- <p class="text-plan m-b-0"><b>GMS</b></p>
                                        <div class="row font-12" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Longitude:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Latitude:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Speed Over Ground:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Course Over Ground</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"></div>
                                        </div> -->
                                        <p class="text-plan m-b-0"><b>Other Informations</b></p>
                                        <div class="row font-12" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>IMSI:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_imei"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>EMEI:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_emei"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Last Seen Position:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_last_pos"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Signal Quality:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_sig"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Local Time:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_time"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Emergency Contact:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_contact"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>Battery Remaining:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_bat"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12"><b>SSM Responsible:</b></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12" id="sos_responsible"></div>
                                        </div>
                                        <!-- <div class="row font-14" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <a class="btn btn-plan btn-sm text-white" data-toggle="modal" data-target="#wifiModal"><b>Near WIFI Networks</b></a>
                                                
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <a class="btn btn-plan btn-sm text-white" data-toggle="modal" data-target="#networkModal"><b>Near Cellular Networks</b></a>
                                                
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <a class="btn btn-plan btn-sm text-white"><i class="fa fa-share-alt"></i> <b>Share Informations</b></a>
                                                
                                            </div>
                                        </div> -->
                                        <p class="text-plan m-b-0"><b>Find in Map</b></p>
                                        <div class="row font-12" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-12">
                                                <div id="gmaps-markers-sos" class="gmaps" style="width: 80%;height: 350px;margin: auto;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- sos modal -->
                <!-- wifi modal -->
                <div id="wifiModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-plan">
                                <h6 class="col-11 text-center modal-title mt-0" id="myModalLabel">Near WIFI Networks</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-plan m-b-0"><b>WIFI A</b></p>
                                        <div class="row font-10" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>SSID:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Mac:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Signal:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Channel:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-4 col-sm-6 col-xs-6"><b>Signal To Noise:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                        </div>
                                        <p class="text-plan m-b-0"><b>WIFI B</b></p>
                                        <div class="row font-10" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>SSID:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Mac:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Signal:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Channel:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-4 col-sm-6 col-xs-6"><b>Signal To Noise:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- wifi modal -->
                <!-- network modal -->
                <div id="networkModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-plan">
                                <h6 class="col-11 text-center modal-title mt-0" id="myModalLabel">Near Cellular Networks</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-plan m-b-0"><b>Operator 1</b></p>
                                        <div class="row font-10" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>MCC:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>MNC:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>RXLev:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Cell Id:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Arfcn:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Lac:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Bsic:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                        </div>
                                        <p class="text-plan m-b-0"><b>Operator 2</b></p>
                                        <div class="row font-10" style="margin-top: 10px; margin-bottom: 10px;">
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>MCC:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>MNC:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>RXLev:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Cell Id:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Arfcn:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Lac:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"><b>Bsic:</b></div>
                                            <div class="col-md-2 col-sm-6 col-xs-6"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- network modal -->
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <!-- google maps api -->
        <script src="https://maps.google.com/maps/api/js?key=AIzaSyDsfrDPuaM-HIXsGsFwmujW-CrE36KtmTE"></script>

        <!-- Gmaps file -->
        <script src="assets/plugins/gmaps/gmaps.min.js"></script>
        <script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <!--Morris Chart
        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>
        <script src="assets/pages/morris.init.js"></script>-->
        <!-- Chart JS -->
        <script src="assets/plugins/moment/moment.js"></script>
        <script src="assets/plugins/chart.js/chart.min.js"></script>
        <script src="assets/pages/chartjs.init.js"></script>
        <!-- Range slider js -->
        <script src="assets/plugins/ion-rangeslider/ion.rangeSlider.min.js"></script>
        <script src="assets/pages/rangeslider-init.js"></script>
        <!-- Dropzone js -->
        <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
        <!-- Profile js -->
        <script src="assets/js/common/profile.js"></script>
        <script src="assets/js/pages/ssmDetails.js"></script>
        <script src="assets/js/notification.js"></script>
    </body>
</html>