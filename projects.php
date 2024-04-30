<?php include_once('includes/header.php'); ?>
    <!-- DataTables -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/select.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Dropzone css -->
    <link href="assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
    <!-- Dropdown-->
    <link rel="stylesheet" href="assets/plugins/country-region-dropdown/assets/css/geodatasource.css">
    <link rel="gettext" type="application/x-po" href="assets/plugins/country-region-dropdown/languages/en/LC_MESSAGES/en.po">
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
                            <a href="projects.php" class="waves-effect active">
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
                    <h3 class="page-title"> Projects </h3>
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
                                    <input type="hidden" id="user_trc_details" value="<?php echo $db_connection::get_user_track_details() ?>">
                                    <input type="hidden" value="<?php
                                                                echo $token_data->data->name;
                                                                ?>" id="data-name">

                                    <input type="hidden" value="<?php
                                                                echo $token_data->data->user_id;
                                                                ?>" id="data-id">
<input type="hidden" value="<?php echo $user_id; ?>" id="data-ud">
                                    <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">
                                        <div class="custom-icon-table"><img src="assets/images/icons/sidebar/projects-white.png"></div>Projects
                                    </h2>
                                    <?php if ($role == '1' || $role == '3'|| $role == '0') :
                                        $cond = "SELECT a.* FROM teams AS a LEFT JOIN projects AS b ON a.id = b.team_id WHERE b.team_id IS NULL";
                                        $cond_stmt = $conn->prepare($cond);
                                        $cond_stmt->execute();

                                        if ($cond_stmt->rowCount()) : ?>
                                            <button type="button" class="btn btn-plan waves-effect waves-light" style="border-radius: 30px;" data-toggle="modal" data-target="#addModal">+Add Project</button>
                                        <?php
                                        else : ?>
                                            <p class="text-plan m-b-30 font-14"><b>Notice:</b> All teams have been allocated to a project, please create a new team or delegate this extra project to your selected team. </p>
                                            <button type="button" class="btn btn-plan waves-effect waves-light" style="border-radius: 30px;" data-toggle="modal" data-target="#addModal">+Add Project</button>
                                    <?php
                                        endif;
                                    else :

                                    endif; ?>
                                    <p class="text-muted m-b-30 font-14"></p>
                                    <table id="datatable" class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="no-sort"><input type="checkbox" class='checkall' id='checkall'>
                                                    <button type="button" class="btn btn-sm btn-plan del-btn">Delete All</button>
                                                </th>
                                                <th>ID</th>
                                                <!--<th class="no-sort"></th>-->
                                                <th>Project Name</th>
                                                <th>Project Manager</th>
                                                <th>Country</th>
                                                <th>Region</th>
                                                <th class="no-sort">Total SSM</th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php
                                            include('backend/projects/read.php');
                                            ?>
                                            <!--<tr>
                                                            <td><input type="checkbox" class='checkItem' id='checkItem'></td>
                                                            <td>1</td>
                                                            <td>
                                                                <img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>
                                                            </td>
                                                            <td>Coding School</td>
                                                            <td><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2" onError="this.onerror=null;this.src='assets/images/onerror.png';"/>Tiger Nixon</td>
                                                            <td><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>Costa Rica</td>
                                                            <td>San Jose</td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-plan popover-selector" id="" data-container="body" data-html="true"
                                                                 data-toggle='popover' data-trigger="hover" title="SSM Reference Numbers" data-content="<div class='popover-content'></div>">2</button>
                                                            </td>
                                                            <td>
                                                                <a href="" class="waves-effect dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <div class="custom-icon-table"><img src="assets/images/icons/edit-blue.svg"></div>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a class="drMpdown-item" href="#" data-toggle="modal" data-target="#editModal">Edit</a>
                                                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#delModal">Delete</a>
                                                                </div>
                                                            </td>
                                                            <td><button type="button" class="btn btn-plan waves-effect waves-light" data-toggle="modal" data-target="#viewModal">View</button></td>
                                                        </tr>-->
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div> <!-- end col -->
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
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel">Coding School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <img class="rounded mr-2" alt="200x200" style="width:150px;height: 150px;margin-bottom: 10px;" src="assets/images/backImage.jpg" data-holder-rendered="true">
                        </div>
                        <div class="col-8">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <h5 class="text-plan">Description</h5>
                                <p id="projectViewDesc"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;">
                                    <div class="col-3 text-plan"><b>Country</b></div>
                                    <div class="col-3" id="projectViewCountry"></div>
                                    <div class="col-3 text-plan"><b>Region</b></div>
                                    <div class="col-3" id="projectViewReg"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="text-align: center;">
                                <h5 class="text-plan" id="projectViewTeam"></h5>
                            </div>
                            <!-- Project Manager Section-->
                            <div style="margin-bottom: 20px;">
                                <h5 class="text-plan">Project Managers</h5>
                            </div>
                            <div id="projectViewPM" style="border-bottom: 3px solid rgb(223, 223, 223);">

                            </div>
                            <!-- Project Manager Section Ends -->
                            <!-- Team members Section -->
                            <div style="margin-bottom: 20px;">
                                <h5 class="text-plan">Team Members</h5>
                            </div>
                            <div id="projectViewTM" style="border-bottom: 3px solid rgb(223, 223, 223);">

                            </div>
                            <!-- Team members Section ends -->
                            <!-- Assigned SSM Section -->
                            <div style="margin-bottom: 20px;">
                                <h5 class="text-plan">Assigned SSM</h5>
                            </div>
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <table id="datatable" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SSM Number</th>
                                            <th>Model</th>
                                            <th>SSM Reference</th>
                                            <th>SSM Responsible</th>
                                        </tr>
                                    </thead>
                                    <tbody id="projectViewSMB">

                                    </tbody>
                                </table>
                            </div>
                            <!-- Assigned SMB Section ends -->
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
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i>&nbsp; Coding School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center text-danger" id="errMsgEdit"></p>
                            <p class="text-center text-success" id="msgSuccessEdit"></p>
                        </div>
                        <div class="col-12">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
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
                                        <h5 class="text-plan">Project Name</h5>
                                        <input type="text" class="form-control m-b-20" id="projectEditName">
                                        <h5 class="text-plan">Description</h5>
                                        <textarea id="projectEditDesc" style="width: 100%;margin-bottom: 10px;padding: 10px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;">
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Country</b></div>
                                    <div class="col-3">
                                        <?php
                                        if ($role == '3') : ?>
                                            <select id="projectEditCountry" readonly class="form-control">
                                                <option selected value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                            </select>
                                        <?php
                                        elseif ($role == '1' || $role == '2'|| $role == '0') : ?>
                                            <select id="projectEditCountry" class="form-control">
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
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Region</b></div>
                                    <div class="col-3">
                                        <select id="projectEditReg" class="form-control">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-center m-t-20">
                                <p class="text-plan m-b-30 font-14 team_repeatEdit"></p>
                                <select class="form-control" id="projectEditTeam" style="width: 30%;text-align-last: center;display: inline-block;font-size: 20px;padding: 0px;">
                                    <option selected disabled>Select a Team</option>
                                    <?php
                                    $sql = "SELECT * FROM teams";
                                    //$sql = "SELECT a.* FROM teams AS a LEFT JOIN projects AS b ON a.id = b.team_id WHERE b.team_id IS NULL";
                                    $sql_stmt = $conn->prepare($sql);
                                    $sql_stmt->execute();

                                    if ($sql_stmt->rowCount()) :
                                        while ($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $data["id"]; ?>">
                                                <?php echo $data["name"]; ?></option><?php
                                                                                    }
                                                                                else :
                                                                                    echo "Sorry! No Teams Found.";

                                                                                endif;
                                                                                        ?>
                                </select>
                            </div>
                            <!-- Project Manager Section-->
                            <div style="margin-bottom: 20px;display: inline-block;width: 100%;">
                                <h5 class="text-plan" style="float: left;">Project Managers</h5>
                                <!-- <i class="mdi mdi-delete font-32 text-plan" style="float: right;margin: 5px 0px;"></i> -->
                            </div>
                            <div id="projectEditPM" style="border-bottom: 3px solid rgb(223, 223, 223);">

                            </div>
                            <!-- Project Manager Section Ends -->
                            <!-- Team members Section -->
                            <div style="margin-bottom: 20px;">
                                <h5 class="text-plan">Team Members</h5>
                            </div>
                            <div id="projectEditTM" style="border-bottom: 3px solid rgb(223, 223, 223);">

                            </div>
                            <!-- Team members Section ends -->
                            <!-- Assigned SMB Section -->
                            <div style="margin-bottom: 20px;">
                                <h5 class="text-plan">Assigned SSM</h5>
                            </div>
                            <div>
                                <table id="datatable" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SSM Number</th>
                                            <th>Model</th>
                                            <th>SSM Reference</th>
                                            <th>SSM Responsible</th>
                                        </tr>
                                    </thead>
                                    <tbody id="projectEditSMB">

                                    </tbody>
                                </table>
                            </div>
                            <!-- Assigned SMB Section ends -->
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
    <!-- Add New modal -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-plan">
                    <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i>&nbsp; Add new project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center text-danger" id="errMsg"></p>
                            <p class="text-center text-success" id="msgSuccess"></p>
                        </div>
                        <div class="col-12">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <div class="row">
                                    <div class="col-4">
                                        <!--<h5 class="text-plan">Add Image</h5>
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
                                        <h5 class="text-plan">Project Name</h5>
                                        <input type="text" class="form-control m-b-20" id="projectName" placeholder="Project Name">
                                        <h5 class="text-plan">Description</h5>
                                        <textarea id="description" style="width: 100%;margin-bottom: 10px;padding: 10px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;">
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Country</b></div>
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
                                    <div class="col-3 text-plan" style="margin: auto;"><b>Region</b></div>
                                    <div class="col-3">
                                        <select id="region" class="form-control">
                                            <option selected disabled>Select a Region</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-center m-t-20">
                                <p class="text-plan m-b-30 font-14 team_repeat"></p>
                                <select class="form-control text-plan selectTeam" id="teamId" style="width: 30%;text-align-last: center;display: inline-block;font-size: 20px;padding: 0px;">
                                    <option selected disabled>Select a Team</option>
                                    <?php
                                    $sql = "SELECT * FROM teams";
                                    //$sql = "SELECT a.* FROM teams AS a LEFT JOIN projects AS b ON a.id = b.team_id WHERE b.team_id IS NULL";
                                    $sql_stmt = $conn->prepare($sql);
                                    $sql_stmt->execute();

                                    if ($sql_stmt->rowCount()) :
                                        while ($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $data["id"]; ?>">
                                                <?php echo $data["name"]; ?></option><?php
                                                                                    }
                                                                                else :
                                                                                    echo "Sorry! No Teams Found.";

                                                                                endif;
                                                                                        ?>
                                </select>
                            </div>
                            <!-- Project Manager Section-->
                            <div style="margin-bottom: 20px;display: inline-block;width: 100%;">
                                <h5 class="text-plan" style="float: left;">Project Managers</h5>
                                <i class="mdi mdi-delete font-32 text-plan" style="float: right;margin: 5px 0px;"></i>
                            </div>
                            <div id="assignedPM" style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <!--<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;">
                                                <div class="col-3 text-plan"><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></div>
                                                <div class="col-3">Name</div>
                                                <div class="col-3 text-plan">name@email.com</div>
                                                <div class="col-3">+358045034</div>
                                            </div>-->
                            </div>
                            <!-- Project Manager Section Ends -->
                            <!-- Team members Section -->
                            <div style="margin-bottom: 20px;">
                                <h5 class="text-plan">Team Members</h5>
                            </div>
                            <div id="assignedTM" style="border-bottom: 3px solid rgb(223, 223, 223);">
                                <!--<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;">
                                                <div class="col-3 text-plan"><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></div>
                                                <div class="col-3">Name</div>
                                                <div class="col-3 text-plan">name@email.com</div>
                                                <div class="col-3">+358045034</div>
                                            </div>-->
                            </div>
                            <!-- Team members Section ends -->
                            <!-- Assigned SMB Section -->
                            <div style="margin-bottom: 20px;">
                                <h5 class="text-plan">Assigned SSM</h5>
                            </div>
                            <div>
                                <table id="datatable" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SSM Number</th>
                                            <th>Model</th>
                                            <th>SSM Reference</th>
                                            <th>SSM Responsible</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assignedSMB">

                                    </tbody>
                                </table>
                            </div>
                            <!-- Assigned SMB Section ends -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-plan" id="createProject">Add</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- Add new modal -->
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

    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>
    <!-- Dropdown -->
    <script src="assets/plugins/country-region-dropdown/assets/js/geodatasource-cr.min.js"></script>
    <script src="assets/plugins/country-region-dropdown/assets/js/Gettext.js"></script>
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
            var user_id = $("#data-id").val();
    loadNotification(user_id);
            function insertModalReset() {
                window.location.reload();
            }
            $('#region').prop('disabled', true);
            $('#projectEditReg').prop('disabled', true);
            if ($('#country').val() != null) {
                $('#region').prop('disabled', false);
                $('#region').find('option').not(':first').remove();
                $.ajax({
                    type: "POST",
                    url: "backend/projects/selectData.php",
                    data: {
                        country: $('#country').val()
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        jQuery.each(data.fields, function(index, item) {
                            $('#region').append($('<option/>', {
                                value: item,
                                text: item
                            }));
                        });
                    }
                });
            }
            /* Get Region on Country Selection */
            $(document).on('change', '#country', function() {
                $('#region').prop('disabled', false);
                $('#region').find('option').not(':first').remove();
                $.ajax({
                    type: "POST",
                    url: "backend/projects/selectData.php",
                    data: {
                        country: this.value
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        jQuery.each(data.fields, function(index, item) {
                            $('#region').append($('<option/>', {
                                value: item,
                                text: item
                            }));
                        });
                    }
                });
            });
            /* Get Data on Selection in Add */
            $(document).on('change', '.selectTeam', function() {
                $('#addModal').find('#assignedPM').html('');
                $('#addModal').find('#assignedTM').html('');
                $('#addModal').find('#assignedSMB').html('');
                var teamID = this.value;
                $.ajax({
                    type: "POST",
                    url: "backend/projects/selectData.php",
                    data: {
                        id: teamID
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        console.log(data.smb.length);
                        if (data.assigned == '1') {
                            $('.team_repeat').text('This team has already been allocated to a project, please create a new team or delegate this extra project to your selected team');
                        }
                        else if (data.assigned == '0') {
                            $('.team_repeat').text('This team has not been allocated to a project, you can allocate this team to  this project.');
                        }
                        if (data.pm.length > 0) {
                            jQuery.each(data.pm, function(index, item) {
                                $('#assignedPM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan">' + item.fname + ' ' + item.lname + '</div><div class="col-3 text-plan">' + item.country + '</div><div class="col-3 text-plan">' + item.email + '</div><div class="col-3">' + item.phone + '</div></div>');
                            });
                        } else if (data.pm.length == 0) {
                            $('#assignedPM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan"><h5>No Project manager assigned to this team</h5></div></div>');
                        }
                        if (data.tm.length > 0) {
                            jQuery.each(data.tm, function(index, item) {
                                $('#assignedTM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan">' + item.fname + ' ' + item.lname + '</div><div class="col-3 text-plan">' + item.country + '</div><div class="col-3 text-plan">' + item.email + '</div><div class="col-3">' + item.phone + '</div></div>');
                            });
                        } else if (data.tm.length == 0) {
                            $('#assignedTM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan"><h5>No Team member assigned to this team</h5></div></div>');
                        }
                        if (data.smb.length > 0) {
                            jQuery.each(data.smb, function(index, item) {
                                $('#assignedSMB').append('<tr><td>' + item.id + '</td><td>' + item.model + '</td><td>' + item.ref + '</td><td>' + item.name + '</td></tr>');
                            });
                        } else if (data.smb.length == 0) {
                            $('#assignedTM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan"><h5>No SMB assigned to this team</h5></div></div>');
                        }
                    }
                });
            });
            /* Get Data on Selection in Edit */
            $(document).on('change', '#projectEditTeam', function() {
                $('#editModal').find('#projectEditSMB').html('');
                $('#editModal').find('#projectEditTM').html('');
                $('#editModal').find('#projectEditPM').html('');
                var teamID = this.value;
                $.ajax({
                    type: "POST",
                    url: "backend/projects/selectData.php",
                    data: {
                        id: this.value
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        if (data.assigned == '1') {
                            $('.team_repeatEdit').text('This team has already been allocated to a project, please create a new team or delegate this extra project to your selected team');
                        }
                        else if (data.assigned == '0') {
                            $('.team_repeatEdit').text('This team has not been allocated to a project, you can allocate this team to  this project.');
                        }
                        console.log(data);
                        jQuery.each(data.pm, function(index, item) {
                            $('#projectEditPM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan">' + item.fname + ' ' + item.lname + '</div><div class="col-3 text-plan">' + item.country + '</div><div class="col-3 text-plan">' + item.email + '</div><div class="col-3">' + item.phone + '</div></div>');
                        });
                        jQuery.each(data.tm, function(index, item) {
                            $('#projectEditTM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan">' + item.fname + ' ' + item.lname + '</div><div class="col-3 text-plan">' + item.country + '</div><div class="col-3 text-plan">' + item.email + '</div><div class="col-3">' + item.phone + '</div></div>');
                        });
                        jQuery.each(data.smb, function(index, item) {
                            $('#projectEditSMB').append('<tr><td>' + item.id + '</td><td>' + item.model + '</td><td>' + item.ref + '</td><td>' + item.name + '</td></tr>');
                        });
                    }
                });
            });
            /* Get Region on Country Selection */
            $(document).on('change', '#projectEditCountry', function() {
                $('#projectEditReg').prop('disabled', false);
                $('#editModal').find('#projectEditReg').html('');
                //$('#projectEditReg').find('option').not(':first').remove();
                $.ajax({
                    type: "POST",
                    url: "backend/projects/selectData.php",
                    data: {
                        country: this.value
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        jQuery.each(data.fields, function(index, item) {
                            $('#projectEditReg').append($('<option/>', {
                                value: item,
                                text: item
                            }));
                        });
                    }
                });
            });
            $("#createProject").click(function(event) {
                var formData = {
                    project: $("#projectName").val(),
                    country: $("#country").val(),
                    region: $("#region").val(),
                    desc: $("#description").val(),
                    team: $("#teamId").val(),
                };
                let teamName = $("#teamId").find(':selected').text();

                $.ajax({
                    type: "POST",
                    url: "backend/projects/create.php",
                    data: formData,
                    encode: true,
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        console.log(data);
                        if (data.success == 0) {
                            console.log(data.message);
                            $("#errMsg").text(data.message).show().delay(10000).hide("slow");
                        } else if (data.success == 1) {
                            //start Activity
                            var formData = {
                                user_id: $("#data-id").val(),
                                section: 'Project',
                                command: 'Added',
                                user_trc_details: document.getElementById("user_trc_details").value,
                                description: `${$("#data-name").val()} Added ${$("#projectName").val()} as a project,<br>Country : ${$("#country").val()}, Region : ${$("#region").val()},<br>Team : ${teamName.trim()}
                                        `
                            };
                            $.ajax({
                                type: "POST",
                                url: "/assets/api/activity_log.php",
                                data: JSON.stringify(formData),
                                contentType: "application/json",
                                success: function(result) {
                                    // console.log(result)
                                },

                                error: function(jqXHR, textStatus, errorThrown) {
                                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                                }
                            })

                            //end Activity log//

                            $("#msgSuccess").text(data.message).show().delay(4000).hide("slow", insertModalReset);
                        }
                    }
                });
            });
            $(".view_btn").click(function() {
                $("#viewModal").modal("show");
                var viewId = $(this).attr("id").split("_")[1];
                $.ajax({
                    type: "POST",
                    url: "backend/projects/modal.php",
                    data: {
                        id: viewId
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        console.log(data);
                        if (data.team == 1) {
                            $("#myModalLabel").text(data.name);
                            $("#projectViewCountry").text(data.country);
                            $("#projectViewReg").text(data.region);
                            $("#projectViewDesc").text(data.description);
                            $("#projectViewTeam").text(data.teamName);
                            jQuery.each(data.pm, function(index, item) {
                                $('#projectViewPM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan">' + item.fname + ' ' + item.lname + '</div><div class="col-3 text-plan">' + item.country + '</div><div class="col-3 text-plan">' + item.email + '</div><div class="col-3">' + item.phone + '</div></div>');
                            });
                            jQuery.each(data.tm, function(index, item) {
                                $('#projectViewTM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan">' + item.fname + ' ' + item.lname + '</div><div class="col-3 text-plan">' + item.country + '</div><div class="col-3 text-plan">' + item.email + '</div><div class="col-3">' + item.phone + '</div></div>');
                            });
                            jQuery.each(data.smb, function(index, item) {
                                $('#projectViewSMB').append('<tr><td>' + item.id + '</td><td>' + item.model + '</td><td>' + item.ref + '</td><td>' + item.name + '</td></tr>');
                            });
                        } else {
                            $("#myModalLabel").text(data.name);
                            $("#projectViewCountry").text(data.country);
                            $("#projectViewReg").text(data.region);
                            $("#projectViewDesc").text(data.description);
                            $("#projectViewTeam").text("No Team is assigned to this Project");
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
            $('#viewModal').on('hidden.bs.modal', function(e) {
                $(this).find('#projectViewPM').html('');
                $(this).find('#projectViewTM').html('');
                $(this).find('#projectViewSMB').html('');
            });
            $('#editModal').on('hidden.bs.modal', function(e) {
                $(this).find('#projectEditPM').html('');
                $(this).find('#projectEditTM').html('');
                $(this).find('#projectEditSMB').html('');
            });
            $('#addModal').on('hidden.bs.modal', function(e) {
                $(this).find('#projectName').val('');
                $(this).find('#description').val('');
                $('#country option:first').prop('selected', true);
                $('#region option:first').prop('selected', true);
                $('#teamId option:first').prop('selected', true);
                $(this).find('#assignedPM').html('');
                $(this).find('#assignedTM').html('');
                $(this).find('#assignedSMB').html('');
            });
            $(document).on('click', '.del_modal', function() {
                $("#delModal").modal("show");
                var delId = $(this).attr("id").split("_")[1];
                var dataName = $(this).attr("name");
                $(".del_btn").click(function() {
                    $.ajax({
                        type: "POST",
                        url: "backend/projects/delete.php",
                        data: {
                            id: delId
                        },
                        success: function(data) {
                            //start Activity
                            var formData = {
                                user_id: $("#data-id").val(),
                                section: 'Project',
                                command: 'Deleted',
                                user_trc_details: document.getElementById("user_trc_details").value,
                                description: `${$("#data-name").val()} Deleted ${dataName} From Project List`
                            };
                            $.ajax({
                                type: "POST",
                                url: "/assets/api/activity_log.php",
                                data: JSON.stringify(formData),
                                contentType: "application/json",
                                success: function(result) {
                                    // console.log(result)
                                },

                                error: function(jqXHR, textStatus, errorThrown) {
                                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                                }
                            })

                            //end Activity log//
                            location.reload();
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                });
            });
            $(document).on('click', '.edit_modal', function() {
                $("#editModal").modal("show");
                if ($('#projectEditCountry').val() != null) {
                    $('#projectEditReg').prop('disabled', false);
                    $('#editModal').find('#projectEditReg').html('');
                    //$('#projectEditReg').find('option').not(':first').remove();
                    $.ajax({
                        type: "POST",
                        url: "backend/projects/selectData.php",
                        data: {
                            country: $('#projectEditCountry').val()
                        },
                        success: function(result) {
                            var data = jQuery.parseJSON(result);
                            jQuery.each(data.fields, function(index, item) {
                                $('#projectEditReg').append($('<option/>', {
                                    value: item,
                                    text: item
                                }));
                            });
                        }
                    });
                }
                var editId = $(this).attr("id").split("_")[1];
                let editLoadData;
                $.ajax({
                    type: "POST",
                    url: "backend/projects/modal.php",
                    data: {
                        id: editId
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        editLoadData = data;
                        console.log(data);
                        $("#projectEditName").val(data.name);
                        $("#projectEditCountry").val(data.country);
                        $("#projectEditReg").append($('<option/>', {
                            value: data.region,
                            text: data.region
                        }));
                        $("#projectEditDesc").val(data.description);
                        if (data.team == '1') {
                            $("#projectEditTeam").val(data.idTeam);
                        }
                        jQuery.each(data.pm, function(index, item) {
                            $('#projectEditPM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan">' + item.fname + ' ' + item.lname + '</div><div class="col-3 text-plan">' + item.country + '</div><div class="col-3 text-plan">' + item.email + '</div><div class="col-3">' + item.phone + '</div></div>');
                        });
                        jQuery.each(data.tm, function(index, item) {
                            $('#projectEditTM').append('<div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan">' + item.fname + ' ' + item.lname + '</div><div class="col-3 text-plan">' + item.country + '</div><div class="col-3 text-plan">' + item.email + '</div><div class="col-3">' + item.phone + '</div></div>');
                        });
                        jQuery.each(data.smb, function(index, item) {
                            $('#projectEditSMB').append('<tr><td>' + item.id + '</td><td>' + item.model + '</td><td>' + item.ref + '</td><td>' + item.name + '</td></tr>');
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });


                $(".edit_btn").click(function() {
                    var editFormData = {
                        project: $("#projectEditName").val(),
                        country: $("#projectEditCountry").val(),
                        region: $("#projectEditReg").val(),
                        desc: $("#projectEditDesc").val(),
                        team: $("#projectEditTeam").val(),
                        teamName: $("#projectEditTeam").find(':selected').text(),
                        project_id: editId
                    };

                    $.ajax({
                        type: "POST",
                        url: "backend/projects/update.php",
                        data: editFormData,
                    }).done(function(result) {
                        var data = jQuery.parseJSON(result);
                        console.log(data);
                        if (data.success == 0) {
                            $("#errMsgEdit").text(data.message).show().delay(3000).hide("slow");
                        } else if (data.success == 1) {

                            //start activity log//
                            let checkEditData = '';
                            let limit = 0;

                            if (editLoadData.name.trim() != editFormData.project.trim()) {
                                checkEditData += `Project Name : ${editLoadData.name} to ${editFormData.project} |`;
                                limit += 1;
                            }
                            if (editLoadData.teamName.trim() != editFormData.teamName.trim()) {
                                checkEditData += `<br>Team : ${editLoadData.teamName} to ${editFormData.teamName.trim()} |`
                                limit += 1;
                            }
                            if (editLoadData.country.trim() != editFormData.country.trim()) {
                                checkEditData += ` <br>Country : ${editLoadData.country} to ${editFormData.country} |`
                                limit += 1;
                            }
                            if (editLoadData.region.trim() != editFormData.region.trim()) {
                                checkEditData += `<br>Region : ${editLoadData.region} to ${editFormData.region} |`
                                limit += 1;
                            }

                            checkEditData = checkEditData.replaceAll(" |", ", ");
                            checkEditData = checkEditData.slice(0, checkEditData.length - 2);

                            var formData = {
                                user_id: $("#data-id").val(),
                                section: 'Project',
                                command: 'Edited',
                                user_trc_details: document.getElementById("user_trc_details").value,
                                description: `${$("#data-name").val()} Edited project details <br>${checkEditData} `
                            };
                            $.ajax({
                                type: "POST",
                                url: "/assets/api/activity_log.php",

                                data: JSON.stringify(formData),
                                contentType: "application/json",
                                success: function(result) {
                                    // console.log(success)
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                                }

                            })

                            //end activity log//
                            $("#msgSuccessEdit").text('You have successfully edited this record!').show().delay(4000).hide("slow", insertModalReset);
                        }
                    });
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
            /* Popover on table item hover */
            $(".popover-selector").on("mouseover", function() {
                $('.popover-content').html('<ul><li>hello</li></ul>');
                /*$("[data-toggle='popover']").popover({
                    sanitize: false,
                    html: true,
                    content: function() {
                        return $('#popover-content').html();
                        //var content = $(this).attr("data-popover-content");
                        //return $(content).children(".list").html();
                    }
                });*/
            });
        });

    </script>
</body>

</html>