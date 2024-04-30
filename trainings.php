<?php include_once('includes/header.php'); ?>


    <!-- Magnific popup -->
    <link href="assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
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
                            <a href="trainings.php" class="waves-effect active">
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
                    <h3 class="page-title">SSM Training </h3>
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
                <input type="hidden" value="<?php echo $user_id; ?>" id="data-id">
                <input type="hidden" value="<?php echo $fname.' '.$lname; ?>" id="data-name">
                <input type="hidden" value="<?php echo $role; ?>" id="data-role">
                <div class="header-bg-training">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-10 m-t-30 pt-5 text-center" style="width: 100%;margin: auto;">
                                <h1 class="text-white m-t-40 m-b-40" style="font-size: 60px;">SSM TRAINING</h1>
                                <!-- <input class="search__input" type="text" placeholder="Search"> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-30" style="border: none;box-shadow: none;">
                                <div class="card-body text-center">
                                    <div class="row m-b-30">
                                        <div class="col-12">
                                            <h2 class="mt-0 text-plan text-center m-b-10 " style="padding-top: 20px;">
                                                LEARN HOW TO USE SOLAR MEDIA BACKPACK</h2>
                                            <p class="text-plan m-b-20 font-20 text-secondary">Developed by Tespack and Plan International.</p>
                                            <?php if($role=='3'||$role=='2'||$role=='1'||$role=='0'): ?>
                                                <button type="button" class="btn btn-plan" style="border-radius: 30px;" data-toggle="modal" data-target="#addModal">+Add New</button>
                                            <?php else:
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="row" id="video-section">
                                        <input type="hidden" id="user_trc_details" value="<?php echo $db_connection::get_user_track_details() ?>">

                                        <?php
                                        include('backend/trainings/read.php');
                                        ?>
                                        <!--<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="card" style="width: 90%;margin: auto;">
                                                                <img src="assets/images/product.png" class="card-img-top" alt="...">
                                                                <a href="#" data-toggle="modal" data-target="#editModal">
                                                                    <i class="fa fa-edit edit-overlay text-plan"></i>
                                                                </a>
                                                                <a href="https://www.youtube.com/watch?v=XYiruiKsaxU" class="popup-youtube">
                                                                    <img src="assets/images/play.png" class="overlay" width="60px">
                                                                </a>
                                                                <div class="card-body text-center">
                                                                  <h5 class="card-title">Video title</h5>
                                                                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="card" style="width: 90%;margin: auto;">
                                                                <img src="assets/images/product.png" class="card-img-top" alt="...">
                                                                <a href="#" data-toggle="modal" data-target="#editModal">
                                                                    <i class="fa fa-edit edit-overlay text-plan"></i>
                                                                </a>
                                                                <a href="https://www.youtube.com/watch?v=XYiruiKsaxU" class="popup-youtube">
                                                                    <img src="assets/images/play.png" class="overlay" width="60px">
                                                                </a>
                                                                <div class="card-body text-center">
                                                                  <h5 class="card-title">Video title</h5>
                                                                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="card" style="width: 90%;margin: auto;">
                                                                <img src="assets/images/product.png" class="card-img-top" alt="...">
                                                                <a href="#" data-toggle="modal" data-target="#editModal">
                                                                    <i class="fa fa-edit edit-overlay text-plan"></i>
                                                                </a>
                                                                <a href="https://www.youtube.com/watch?v=XYiruiKsaxU" class="popup-youtube">
                                                                    <img src="assets/images/play.png" class="overlay" width="60px">
                                                                </a>
                                                                <div class="card-body text-center">
                                                                  <h5 class="card-title">Video title</h5>
                                                                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="card" style="width: 90%;margin: auto;">
                                                                <img src="assets/images/product.png" class="card-img-top" alt="...">
                                                                <a href="#" data-toggle="modal" data-target="#editModal">
                                                                    <i class="fa fa-edit edit-overlay text-plan"></i>
                                                                </a>
                                                                <a href="https://www.youtube.com/watch?v=XYiruiKsaxU" class="popup-youtube">
                                                                    <img src="assets/images/play.png" class="overlay" width="60px">
                                                                </a>
                                                                <div class="card-body text-center">
                                                                  <h5 class="card-title">Video title</h5>
                                                                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                                </div>
                                                            </div>
                                                        </div>-->
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
    <!-- Add modal -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i> &nbsp;Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center text-danger" id="errMsg"></p>
                            <p class="text-center text-success" id="msgSuccess"></p>
                        </div>
                        <!--<div class="col-4 text-center"></div>
                                    <div class="col-4 text-center">
                                        <form action="#" class="dropzone" style="border:none; padding:0px;text-align: center;margin-bottom: 20px;">
                                            <div class="fallback text-center">
                                                <input name="file" type="file">
                                            </div>
                                            <div class="dz-message needsclick" style="margin: 0px;">
                                                <img class="rounded-circle mr-2" alt="200x200" style="width: 200px;height: 200px;" src="assets/images/default.jpg" data-holder-rendered="true">
                                            </div>
                                            <div class="dz-message needsclick" style="margin: 0px;position: relative;">
                                                <img class="rounded mr-2" alt="200x200" style="width: 100%;display: block;max-height:200px;" src="assets/images/default.jpg" data-holder-rendered="true">
                                                <div class="overlay-dropzone"><i class="fa fa-edit edit-overlay text-white"></i> Add Image</div>
                                            </div>
                                        </form>
                                        <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                            <h5 class="text-plan">Change image</h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center"></div>-->
                        <div class="col-12">
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3">
                                    <h6 class="text-plan">Title</h6>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="title">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3">
                                    <h6 class="text-plan">Video Link</h6>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="link">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3">
                                    <h6 class="text-plan">Description</h6>
                                </div>
                                <div class="col-6">
                                    <textarea id="desc" class="form-control" style="width: 100%;margin-bottom: 10px;padding: 10px;height: 65%;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="addTut" class="btn btn-primary">Add</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- Add modal -->
    <!-- Edit modal -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i>&nbsp; Edit Tutorial <span id="editHead"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center text-danger" id="errMsgEdit"></p>
                            <p class="text-center text-success" id="msgSuccessEdit"></p>
                        </div>
                        <!--<div class="col-12 text-center">
                                        <form action="#" class="dropzone" style="border:none; padding:0px;text-align: center;margin-bottom: 20px;">
                                            <div class="fallback text-center">
                                                <input name="file" type="file">
                                            </div>
                                            <div class="dz-message needsclick" style="margin: 0px;">
                                                <img class="rounded-circle mr-2" alt="200x200" style="width: 200px;height: 200px;" src="assets/images/product.png" data-holder-rendered="true">
                                            </div>
                                        </form>
                                        <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                            <h5 class="text-plan">Change image</h5>
                                        </div>
                                    </div>-->
                        <div class="col-12">
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3">
                                    <h6 class="text-plan">Title</h6>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="editTitle">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3">
                                    <h6 class="text-plan">Video Link</h6>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" id="editLink">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3">
                                    <h6 class="text-plan">Description</h6>
                                </div>
                                <div class="col-6">
                                    <textarea id="editDesc" class="form-control" style="width: 100%;margin-bottom: 10px;padding: 10px;height: 65%;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary edit_btn">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- Edit modal -->
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

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <!-- Magnific popup -->
    <script src="assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="assets/pages/lightbox.js"></script>
    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>
    <script src="assets/js/pages/training.js"></script>
    <script src="assets/js/notification.js"></script>
</body>

</html>