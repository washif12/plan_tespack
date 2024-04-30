<?php
session_start();
require __DIR__ . '/assets/api/classes/database.php';
require __DIR__ . '/assets/api/classes/JwtHandler.php';
//$token = $_SESSION['token'];
/*if($token == true) {*/
if ($_SESSION['token'] == true) {
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
   
    $jwt = new JwtHandler();
    $token_data = $jwt->jwtDecodeData($_SESSION['token']);
    if ($token_data == 'Expired token') :
        $_SESSION['error'] = 'Sorry! Your session expired, Please Log in to continue.';
        header('location:login.php');
    else :
        $user_id = $token_data->data->user_id;
        try {
            $check = "SELECT * FROM users WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($user_id)), PDO::PARAM_STR);
            $check_stmt->execute();
            if ($check_stmt->rowCount()) :
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                $fname = $data["fname"];
                $lname = $data["lname"];
                $phone = $data["phone"];
                $address = $data["address"];
                $country = $data["country"];
                $email = $data["email"];
                $role = $data["role"];
                $image_path = $data["image_path"];
                if ($role == '1' || $role == '3' || $role == '0') :
                else :
                    unset($_SESSION['token']);
                    session_destroy();
                    header('location:login.php');
                endif;
            else :
                $_SESSION['error'] = 'Sorry! You are not registered in our Platform.';
                header('location:login.php');

            endif;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Sorry! There is some issue in the server, try again later.';
            header('location:login.php');
        }
    endif;
} else {
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
    <!-- DataTables -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Dropzone css -->
    <link href="assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
    <!-- Dropdown
        <link rel="stylesheet" href="assets/plugins/country-region-dropdown/assets/css/geodatasource.css">
        <link rel="gettext" type="application/x-po" href="assets/plugins/country-region-dropdown/languages/en/LC_MESSAGES/en.po">-->

</head>


<body class="fixed-left">
    <div id="overlay-loader">
        <div class="cv-spinner">
            <!--<span class="spinner-new"></span>-->
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
                    <!--<a href="index.php" class="logo text-center">Fonik</a>-->
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

                        <?php if ($role == '1' || $role == '3') : ?>
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

                        <li>
                            <a href="countries.php" class="waves-effect active"><div class="custom-icon"><img src="assets/images/icons/sidebar/countries-white.png"></div><span> Countries </span></a>
                        </li>
                        <li>
                            <a href="smb.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/smb-white.png"></div><span> SSM </span></a>
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
                                        <a href="trainings.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/training-white.png"></div><span> SSM Tutorials </span></a>
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
                                <h3 class="page-title"> Countries </h3>
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
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                    <input type="hidden" id="user_trc_details" value="<?php echo $db_connection::get_user_track_details()?>">
                                        <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">
                                            <div class="custom-icon-table"><img src="assets/images/icons/sidebar/countries-white.png"></div>Countries
                                        </h2>
                                        <button type="button" class="btn btn-plan waves-effect waves-light" style="border-radius: 30px;" data-toggle="modal" data-target="#addModal">+Add Country</button>
                                        <p class="text-success m-b-30 font-20 text-center"></p>
                                        <table id="datatable" class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort"><input type="checkbox" class='checkall' id='checkall'>
                                                        <button type="button" class="btn btn-sm btn-plan del-btn">Delete All</button>
                                                    </th>
                                                    <th>ID</th>
                                                    <th class="no-sort"></th>
                                                    <th>Country</th>
                                                    <th>Region</th>
                                                    <th>Notes</th>
                                                    <th class="no-sort"></th>
                                                    <th class="no-sort"></th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                include('backend/country/read.php');
                                                ?>
                                                <!--<tr>
                                                            <td><input type="checkbox" class='checkItem' id='checkItem'></td>
                                                            <td>1</td>
                                                            <td>
                                                                <img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>
                                                            </td>
                                                            <td>Finland</td>
                                                            <td>Helsinki</td>
                                                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                            <td>
                                                                <a href="" class="waves-effect dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <div class="custom-icon-table"><img src="assets/images/icons/edit-blue.svg"></div>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editModal">Edit</a>
                                                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#delModal">Delete</a>
                                                                </div>
                                                            </td>
                                                            <td><button type="button" class="btn btn-plan waves-effect waves-light" data-toggle="modal" data-target="#viewModal">View</button></td>
                                                        </tr>-->
                                            </tbody>
                                        </table>
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

    <!-- View modal -->
    <div id="viewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel">Showing entry <span id="viewHead"></span> &nbsp;<i class="fa fa-globe"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div style="margin-bottom: 20px;">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;">
                                    <div class="col-3 text-plan"><b>Country</b></div>
                                    <div id="modalCountry" class="col-3"></div>
                                    <div class="col-3 text-plan"><b>Region</b></div>
                                    <div id="modalRegion" class="col-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <!--<img class="rounded mr-2" alt="200x200" style="width:150px;height: 150px;margin-bottom: 10px;" src="assets/images/backImage.jpg" data-holder-rendered="true">-->
                                </div>
                                <div class="col-8">
                                    <h5 class="text-plan">Notes</h5>
                                    <p id="modalNote"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                            </div>-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- view modal -->
    <!-- Edit modal -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i>&nbsp; Edit entry <span id="editHead"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center text-danger" id="errMsgEdit"></p>
                            <p class="text-center text-success" id="msgSuccessEdit"></p>
                        </div>
                        <div class="col-12">
                            <div style="margin-bottom: 20px;">
                                <?php if (isset($_SESSION['token'])) {
                                    $jwt = new JwtHandler();
                                    $token_data = $jwt->jwtDecodeData($_SESSION['token']); ?>
                                    <input type="hidden" value="<?php echo $token_data->data->user_id;?>" id="data-id">
                                    <input type="hidden" value="<?php echo $token_data->data->name;?>" id="data-name">
                                <?php } ?>
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-2 text-plan" style="margin: auto;"><b>Country</b></div>
                                    <div class="col-4 editAppend">
                                        <!--<select id="countryEdit" class="form-control gds-cr" country-data-default-value="" country-data-region-id="gds-cr-one" data-language="en"></select>
                                                <select id="countryEdit" class="form-control crs-country" data-default-value="" data-region-id="edit_region"></select>-->
                                    </div>
                                    <div class="col-2 text-plan" style="margin: auto;"><b>Region</b></div>
                                    <div class="col-4">
                                        <select class="form-control regionEdit" id="edit_region" data-default-value=""></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div>
                                <div class="row">
                                    <div class="col-4">
                                        <!--<h5 class="text-plan">Change Image</h5>
                                                    <form action="#" class="dropzone" style="border:none; padding:0px;width: 80%;text-align: center;margin-bottom: 20px;">
                                                        <div class="fallback text-center">
                                                            <input name="file" type="file">
                                                        </div>
                                                        <div class="dz-message needsclick" style="margin: 0px;position: relative;">
                                                            <img class="rounded mr-2" alt="200x200" style="width: 100%;display: block;max-height: 140px;" src="assets/images/backImage.jpg" data-holder-rendered="true">
                                                            <div class="overlay-dropzone"><i class="fa fa-edit edit-overlay text-white"></i> Change Image</div>
                                                        </div>
                                                    </form>-->
                                    </div>
                                    <div class="col-8">
                                        <h5 class="text-plan">Notes</h5>
                                        <textarea id="editDesc" style="width: 100%;margin-bottom: 10px;padding: 10px;height: 65%;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-plan edit_btn">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- Edit modal -->
    <!-- Add modal -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i> &nbsp; Country</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center text-danger" id="errMsg"></p>
                            <p class="text-center text-success" id="msgSuccess"></p>
                        </div>


                        <form id="addCountry">
                            <div class="col-12">
                                <div style="margin-bottom: 20px;">
                                    <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                        <div class="col-2 text-plan" style="margin: auto;"><b>Country</b></div>
                                        <div class="col-4">
                                            <?php if (isset($_SESSION['token'])) {
                                                $jwt = new JwtHandler();
                                                $token_data = $jwt->jwtDecodeData($_SESSION['token']); ?>
                                                <input type="hidden" value="<?php

                                                                            // var_dump($token_data);
                                                                            echo $token_data->data->user_id;

                                                                            ?>" id="data-id">
                                                <input type="hidden" value="<?php

                                                                            // var_dump($token_data);
                                                                            echo $token_data->data->name;
                                                                            ?>" id="data-name">
                                            <?php } ?>
                                            <!--<select class="form-control">
                                                        <option selected disabled>Select a Country</option>
                                                        <option>Finland</option>
                                                        <option>Congo</option>
                                                        <option>Costa Rica</option>
                                                    </select>
                                                    <select id="countrySelection" class="form-control gds-cr" country-data-region-id="gds-cr-two" data-language="en"></select>-->
                                                    <?php if($role=='3'): ?>
                                                    <select id="countrySelection" class="form-control crs-country" data-region-id="add_region" data-default-value="<?php echo $country; ?>" readonly disabled></select>
                                                    <?php else: ?>
                                                    <select id="countrySelection" class="form-control crs-country" data-region-id="add_region"></select>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-2 text-plan" style="margin: auto;"><b>Region</b></div>
                                                <div class="col-4">
                                                    <!--<select class="form-control">
                                                        <option selected disabled>Select a Region</option>
                                                        <option>Helsinki</option>
                                                        <option>San jose</option>
                                                        <option>Brazaville</option>
                                                    </select>-->
                                            <select class="form-control" id="add_region"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div>
                                    <div class="row">
                                        <div class="col-4">
                                            <!--<h5 class="text-plan">Change Image</h5>
                                                        <form action="#" class="dropzone" style="border:none; padding:0px;width: 80%;text-align: center;margin-bottom: 20px;">
                                                            <div class="fallback text-center">
                                                                <input name="file" type="file">
                                                            </div>
                                                            <div class="dz-message needsclick" style="margin: 0px;position: relative;">
                                                                <img class="rounded mr-2" alt="200x200" style="width: 100%;display: block;max-height: 140px;" src="assets/images/default.jpg" data-holder-rendered="true">
                                                                <div class="overlay-dropzone"><i class="fa fa-edit edit-overlay text-white"></i> Add Image</div>
                                                            </div>
                                                        </form>-->
                                        </div>
                                        <div class="col-8">
                                            <h5 class="text-plan">Notes</h5>
                                            <textarea id="note" style="width: 100%;margin-bottom: 10px;padding: 10px;height: 65%;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="button" id="insertCountry" class="btn btn-plan waves-effect waves-light">Add</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- Add modal -->
    <!-- Delete modal -->
    <?php include_once('includes/modal/delete.php'); ?>
    <!-- delete modal -->
    <!-- Profile modal -->
    <?php include_once('includes/modal/profile.php'); ?>
    <!-- Profile modal -->
    <!-- Notification modal -->
    <?php include_once('includes/modal/notification.php'); ?>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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
    <!-- Select dt examples 
         <script src="assets/plugins/datatables/select.min.js"></script>-->

    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>
    <!-- Dropdown 
        <script src="assets/plugins/country-region-dropdown/assets/js/geodatasource-cr.min.js"></script>
        <script src="assets/plugins/country-region-dropdown/assets/js/Gettext.js"></script>-->
    <script src="assets/plugins/country-region-selector/dist/crs.min.js"></script>
    <script src="assets/js/pages/countries.js"></script>
    <script src="assets/js/notification.js"></script>
</body>

</html>