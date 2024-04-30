<?php include_once('includes/header.php'); ?>
    <!-- DataTables -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Dropzone css -->
    <link href="assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
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
                                        <a href="smb.php" class="waves-effect active"><div class="custom-icon"><img src="assets/images/icons/sidebar/smb-white.png"></div><span> SSM </span></a>
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
                                    <h3 class="page-title"> SSM </h3>
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
                                <input type="hidden" value="<?php echo $user_id; ?>" id="data-id">
                                <input type="hidden" value="<?php echo $fullName; ?>" id="data-name">
                                <input type="hidden" value="<?php echo $user_id; ?>" id="data-ud">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card m-b-30">
                                                <div class="card-body">
                                                <input type="hidden" id="user_trc_details" value="<?php echo $db_connection::get_user_track_details()?>">
                                                    <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">
                                                        <div class="custom-icon-table"><img src="assets/images/icons/sidebar/smb-white.png"></div>SSM</h2>
                                                    <?php if($role=='1'||$role=='3'|| $role == '0'): ?>
                                                    <button type="button" class="btn btn-plan waves-effect waves-light" style="border-radius: 30px;" data-toggle="modal" data-target="#addModal">+Add SSM</button>
                                                    <?php else:?>
                                                    
                                                    <?php endif; ?>
                                                    <p class="text-muted m-b-30 font-14"></p>
                                                    <table id="datatable" class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                        <tr>
                                                            <!-- <th class="no-sort"><input type="checkbox" class='checkall' id='checkall'>
                                                                <button type="button" class="btn btn-sm btn-plan del-btn">Delete All</button>
                                                            </th> -->
                                                            <th>ID</th>
                                                            <th class="no-sort">Model</th>
                                                            <th>Reference Number</th>
                                                            <th>Country Delivered</th>
                                                            <th>Date</th>
                                                            <th>Emergency Contact</th>
                                                            <th>Notes</th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                        </tr>
                                                        </thead>
                    
                    
                                                        <tbody>
                                                            <?php
                                                            include('backend/smb/read.php');
                                                            ?>
                                                        <!--<tr>
                                                            <td><input type="checkbox" class="checkItem" id="checkItem"></td>
                                                            <td>1</td>
                                                            <td>V</td>
                                                            <td>123456789</td>
                                                            <td>Finland</td>
                                                            <td>27-04-2021</td>
                                                            <td>04302839</td>
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
                                                            <td><a type="button" class="btn btn-plan waves-effect waves-light" href="./smbDetails.php" target="_blank">View</a></td>
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
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel">SSM 123456789</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-3 text-plan"><b>Reference Number</b></div>
                                    <div class="col-3">123456789</div>
                                    <div class="col-3 text-plan"><b>Model</b></div>
                                    <div class="col-3">V</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-3 text-plan"><b>Country Delivered</b></div>
                                    <div class="col-3">Finland</div>
                                    <div class="col-3 text-plan"><b>Date</b></div>
                                    <div class="col-3">27-04-2021</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div>
                                <h5 class="text-plan">Notes</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- view modal -->
    <!-- Edit modal -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i>&nbsp; Change SSM</h5>
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
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Reference Number</b></div>
                                    <div class="col-3">
                                        <input class="form-control" id="refEdit">
                                    </div>
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Model</b></div>
                                    <div class="col-3">
                                        <input class="form-control" id="modelEdit">
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Country Delivered</b></div>
                                    <div class="col-3">
                                        <?php
                                        if ($role == '3') : ?>
                                            <select id="countryEdit" readonly class="form-control">
                                                <option selected value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                            </select>
                                        <?php
                                        elseif ($role == '1' || $role == '2'|| $role == '0') : ?>
                                            <select id="countryEdit" class="form-control">
                                                <option selected disabled>Select a Country</option>
                                                <?php
                                                $sql = "SELECT DISTINCT country FROM countries";
                                                $sql_stmt = $conn->prepare($sql);
                                                $sql_stmt->execute();

                                                if ($sql_stmt->rowCount()) :
                                                    while ($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option value="<?php echo $data["country"]; ?>">
                                                            <?php echo $data["country"]; ?></option><?php
                                                                                                }
                                                                                            else :
                                                                                                echo "Sorry! No Country Found.";

                                                                                            endif;
                                                                                                    ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Date</b></div>
                                    <div class="col-3">
                                        <input class="form-control" type="date" id="dateEdit">
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Emergency contact</b></div>
                                    <div class="col-3">
                                        <input class="form-control" id="contactEdit">
                                    </div>
                                    <div class="col-6"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <h5 class="text-plan">Notes</h5>
                            <textarea id="editDesc" style="width: 100%;margin-bottom: 10px;padding: 10px;height: 65%;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</textarea>

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
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i>&nbsp; Add SSM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center text-danger" id="errMsg"></p>
                            <p class="text-center text-success" id="msgSuccess"></p>
                        </div>
                        <div class="col-12">
                            <div style="margin-bottom: 20px;">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Reference Number</b></div>
                                    <div class="col-3">
                                        <input id="ref_no" class="form-control">
                                    </div>
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Model</b></div>
                                    <div class="col-3">
                                        <input id="model" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Country Delivered</b></div>
                                    <div class="col-3">
                                        <?php
                                        if ($role == '3') : ?>
                                            <select id="country" readonly class="form-control">
                                                <option selected value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                            </select>
                                        <?php
                                        elseif ($role == '1' || $role == '2'|| $role == '0') : ?>
                                            <select id="country" class="form-control">
                                                <option selected disabled>Select a Country</option>
                                                <?php
                                                $sql = "SELECT DISTINCT country FROM countries";
                                                $sql_stmt = $conn->prepare($sql);
                                                $sql_stmt->execute();

                                                if ($sql_stmt->rowCount()) :
                                                    while ($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option value="<?php echo $data["country"]; ?>">
                                                            <?php echo $data["country"]; ?></option><?php
                                                                                                }
                                                                                            else :
                                                                                                echo "Sorry! No Country Found.";

                                                                                            endif;
                                                                                                    ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Date</b></div>
                                    <div class="col-3">
                                        <input id="date" class="form-control" type="date">
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Emergency contact</b></div>
                                    <div class="col-3">
                                        <input id="contact" class="form-control">
                                    </div>
                                    <div class="col-6"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <h5 class="text-plan">Notes</h5>
                            <textarea id="note" style="width: 100%;margin-bottom: 10px;padding: 10px;height: 65%;"></textarea>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="button" id="addSmb" class="btn btn-plan waves-effect waves-light">Add</button>
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

    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>
    <script src="assets/js/pages/ssm.js"></script>
    <script src="assets/js/notification.js"></script>
</body>

</html>