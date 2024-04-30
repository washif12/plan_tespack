<?php include_once('includes/header.php'); ?>
<?php
// phpinfo();
?>
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
                                        <a href="smb.php" class="waves-effect"><div class="custom-icon"><img src="assets/images/icons/sidebar/smb-white.png"></div><span> SSM </span></a>
                                    </li>

                                    <li>
                                        <a href="teams.php" class="waves-effect active"><div class="custom-icon"><img src="assets/images/icons/sidebar/teams-white.png"></div><span> Teams </span></a>
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
                                            <h3 class="page-title"> Teams </h3>
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
                                        <div class="col-12">
                                            <div class="card m-b-30">
                                                <div class="card-body">
                                                    <input type="hidden" id="user_trc_details" value="<?php echo $db_connection::get_user_track_details()?>">
                                                    <input type="hidden" value="<?php echo $user_id;?>" id="data-id">
                                                    <input type="hidden" value="<?php echo $fullName;?>" id="data-name">

                                                    <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">
                                                    <div class="custom-icon-table"><img src="assets/images/icons/sidebar/teams-white.png"></div>Teams</h2>
                                                    <?php if($role=='1'||$role=='3'||$role=='0'): ?>
                                                    <button type="button" class="btn btn-plan waves-effect waves-light" style="border-radius: 30px;" data-toggle="modal" data-target="#addModal">+Add Team</button>
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
                                                            <!--<th class="no-sort"></th>-->
                                                            <th>Team Name</th>
                                                            <th>Project Manager</th>
                                                            <th class="no-sort">Emergency Contact</th>
                                                            <th>Team Members</th>
                                                            <th class="no-sort">Total SSM</th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                        </tr>
                                                        </thead>
                    
                    
                                                        <tbody>
                                                        <?php
                                                            include('backend/teams/read.php');
                                                            //include('https://tespack-smb-map-services.appspot.com/api/teams/read.php');
                                                            ?>
                                                        <!--<tr>
                                                            <td><input type="checkbox" class='checkItem' id='checkItem'></td>
                                                            <td>1</td>
                                                            <td>
                                                                <img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>
                                                            </td>
                                                            <td>Coding Red</td>
                                                            <td><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2" onError="this.onerror=null;this.src='assets/images/onerror.png';"/>Tiger Nixon</td>
                                                            <td>473973957</td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-plan popover-selector" id="" data-container="body" data-html="true"
                                                                 data-toggle='popover' data-trigger="hover" title="Team Members" data-content="<div class='popover-content'></div>">2</button>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-plan popover-selector" id="" data-container="body" data-html="true"
                                                                 data-toggle='popover' data-trigger="hover" title="SSM Reference Numbers" data-content="<div class='popover-content'></div>">2</button>
                                                            </td>
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
                                        </div> <!-- end col -->
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
                                <h5 class="col-11 text-center modal-title mt-0" id="teamHeader"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12" style="border-bottom: 3px solid rgb(223, 223, 223);">
                                        <div class="row">
                                            <!-- <div class="col-6">
                                                <div class="text-center m-b-20">
                                                    <h5 class="text-plan">Image</h5>
                                                </div>
                                                <div class="text-center">
                                                    <img class="rounded mr-2" alt="200x200" style="width:150px;height: 150px;margin-bottom: 10px;" src="assets/images/backImage.jpg" data-holder-rendered="true">
                                                </div>
                                            </div> -->
                                            <div class="col-6" style="width: 100%;margin: auto;">
                                                <div class="text-center m-b-20">
                                                    <h5 class="text-plan">Emergency Contact</h5>
                                                </div>
                                                <div class="text-center">
                                                <h6 class="text-plan" id="teamContact"></h6>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12">
                                        <div id="accordion">
                                            <!-- Project Manager Section-->
                                            <div class="card">
                                                <a href="#managers" class="text-plan" data-toggle="collapse"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne">
                                                    <div class="card-header p-3" id="managerHeading">
                                                        <h6 class="m-0">
                                                            Project Managers
                                                            <i class="fa fa-chevron-down"></i>
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="managers" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                    <!--<div style="border-bottom: 3px solid rgb(223, 223, 223);">
                                                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;">
                                                            <div class="col-3 text-plan"><img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></div>
                                                            <div class="col-3">Name</div>
                                                            <div class="col-3 text-plan">name@email.com</div>
                                                            <div class="col-3">+358045034</div>
                                                        </div>
                                                    </div>-->
                                                </div>
                                            </div>
                                            <!-- Project Manager Section Ends -->
                                            <!-- Team members Section -->
                                            <div class="card">
                                                <a href="#members" class="text-plan collapsed" data-toggle="collapse"
                                                                aria-expanded="false"
                                                                aria-controls="collapseTwo">
                                                    <div class="card-header p-3" id="memberHead">
                                                        <h6 class="m-0">
                                                            Team Members
                                                            <i class="fa fa-chevron-down"></i>
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="members" class="collapse" aria-labelledby="memberHead" data-parent="#accordion">
                                                    
                                                </div>
                                            </div>
                                            <!-- Team members Section ends -->
                                            <!-- Assigned SSM Section -->
                                            <div class="card">
                                                <a href="#assignedSMB" class="text-plan collapsed" data-toggle="collapse"
                                                                aria-expanded="false"
                                                                aria-controls="collapseThree">
                                                    <div class="card-header p-3" id="smbHead">
                                                        <h6 class="m-0">
                                                            Assigned SMB
                                                            <i class="fa fa-chevron-down"></i>
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="assignedSMB" class="collapse" aria-labelledby="smbHead" data-parent="#accordion">
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
                                                            <tbody id="smbInfo">
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Assigned SSM Section ends -->
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
                                <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i>&nbsp; Edit</h5>
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
                                                <!-- <div class="col-4">
                                                    <h5 class="text-plan">Change Image</h5>
                                                    <form action="#" class="dropzone" style="border:none; padding:0px;width: 80%;text-align: center;margin-bottom: 20px;">
                                                        <div class="fallback text-center">
                                                            <input name="file" type="file">
                                                        </div>
                                                        <div class="dz-message needsclick" style="margin: 0px;position: relative;">
                                                            <img class="rounded mr-2" alt="200x200" style="width: 100%;display: block;max-height: 140px;" src="assets/images/backImage.jpg" data-holder-rendered="true">
                                                            <div class="overlay-dropzone"><i class="fa fa-edit edit-overlay text-white"></i> Change Image</div>
                                                        </div>
                                                    </form>
                                                </div> -->
                                                <div class="col-6">
                                                    <h5 class="text-plan">Team Name</h5>
                                                    <input type="text" class="form-control m-b-20" id="teamNameEdit" required>
                                                </div>
                                                <div class="col-6">
                                                    <h5 class="text-plan">Emergency Contact</h5>
                                                    <input type="text" class="form-control m-b-20" id="contactEdit" required>
                                                    <!-- <textarea class="form-control" id="contactEdit" required></textarea> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- Project Manager Section-->
                                        <div style="margin-bottom: 20px;display: inline-block;width: 100%;">
                                            <h5 class="text-plan" style="float: left;">Project Managers</h5>
                                            
                                        </div>
                                        <table id="datatable_pm" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <tbody id="pmEdit">
                                                
                                            </tbody>
                                        </table>
                                        <div style="display: inline-block;width: 100%;text-align:center;">
                                            <!-- <i id="addPMEdit" class="mdi mdi-plus font-40 text-plan text-center" style="cursor:pointer;"></i> -->
                                            <button type="button" class="btn" id="addPMEdit"><i class="mdi mdi-plus font-40 text-plan text-center"></i></button>
                                        </div>
                                        <!-- Project Manager Section Ends -->
                                        <!-- Team members Section -->
                                        <div style="margin-bottom: 20px;">
                                            <h5 class="text-plan">Team Members</h5>
                                        </div>
                                        <table id="datatable_tm" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <tbody id="tmEdit">
                                                
                                            </tbody>
                                        </table>
                                        <div style="display: inline-block;width: 100%;text-align:center;">
                                            <!-- <i id="addTMEdit" class="mdi mdi-plus font-40 text-plan text-center" style="cursor:pointer;"></i> -->
                                            <button type="button" class="btn" id="addTMEdit"><i class="mdi mdi-plus font-40 text-plan text-center"></i></button>
                                        </div>
                                        <!-- Team members Section ends -->
                                        <!-- Assigned SSM Section -->
                                        <div style="margin-bottom: 20px;">
                                            <h5 class="text-plan">Assigned SMB</h5>
                                        </div>
                                        <div>
                                            <table id="datatable_smb" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <!--<th>SSM Number</th>-->
                                                    <th>SSM Reference</th>
                                                    <th>Model</th>
                                                    <th>SSM Responsible</th>
                                                    <th></th>
                                                </tr>
                                                </thead> 
                                                <tbody id="SMBEdit">
                                                    
                                                </tbody>
                                            </table>
                                            <div style="display: inline-block;width: 100%;text-align:center;">
                                                <button type="button" class="btn" id="addSMBRowEdit"><i class="mdi mdi-plus font-40 text-plan text-center"></i></button>
                                            </div>
                                        </div>
                                        <!-- Assigned SSM Section ends -->
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
                                <h5 class="col-11 text-center modal-title mt-0" id="myModalLabel"><i class="fa fa-edit"></i>&nbsp; Add Team</h5>
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
                                                <div class="col-6">
                                                    <h5 class="text-plan">Team Name</h5>
                                                    <input type="text" class="form-control m-b-20" id="teamName" placeholder="Team Name" required>
                                                </div>
                                                <div class="col-6">
                                                    <h5 class="text-plan">Emergency Contact</h5>
                                                    <input type="text" class="form-control m-b-20" id="contactAdd" placeholder="Emergency Contact" required>
                                                    <!-- <textarea class="form-control"  id="contactAdd" placeholder="Emergency Contact" required></textarea> -->
                                                </div>
                                                <!-- <div class="col-4">
                                                    <h5 class="text-plan">Change Image</h5>
                                                    <form action="#" class="dropzone" style="border:none; padding:0px;width: 80%;text-align: center;margin-bottom: 20px;">
                                                        <div class="fallback text-center">
                                                            <input name="file" type="file">
                                                        </div>
                                                        <div class="dz-message needsclick" style="margin: 0px;position: relative;">
                                                            <img class="rounded mr-2" alt="200x200" style="width: 100%;display: block;max-height: 140px;" src="assets/images/default.jpg" data-holder-rendered="true">
                                                            <div class="overlay-dropzone"><i class="fa fa-edit edit-overlay text-white"></i> Add Image</div>
                                                        </div>
                                                    </form>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- Project Manager Section-->
                                        <div style="margin-bottom: 10px;display: inline-block;width: 100%;">
                                            <h5 class="text-plan" style="float: left;">Project Managers</h5>
                                        </div>
                                        <table id="datatable_pm_add" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <tbody id="pm">
                                                <tr>
                                                    <!--<td>1</td>
                                                    <td><img src="assets/images/default.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></td>-->
                                                    <td>
                                                    <?php
                                                        if($role=='3'):?>
                                                            <select class="form-control selectPM" id="selectPM_1" name="manager[]" mng-name="mn[]">
                                                                <option selected disabled value="">Select a Project Manager</option>
                                                                <?php

                                                                $sql = "SELECT a.name,a.reg_id FROM project_managers as a left join users as b on a.reg_id=b.id where a.team_id IS NULL AND b.country=:country";
                                                                $sql_stmt = $conn->prepare($sql);
                                                                $sql_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                                                                $sql_stmt->execute();
                                                                
                                                                if($sql_stmt->rowCount()):
                                                                    $pm_count = $sql_stmt->rowCount();
                                                                    while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?>
                                                                        <option value="<?php echo $data["reg_id"];?>" m-name="<?php echo $data["name"];?>">
                                                                        <?php echo $data["name"];?></option><?php
                                                                    }
                                                                else:
                                                                    echo "Sorry! No Project Managers Found.";
                                                                    $pm_count = 0;
                                                                endif;
                                                                ?>
                                                            </select>
                                                        <?php
                                                        elseif($role=='1'||$role=='2'||$role =='0'):?>
                                                            <select class="form-control selectPM" id="selectPM_1" name="manager[]" mng-name="mn[]">
                                                                <option selected disabled value="">Select a Project Manager</option>
                                                                <?php
                                                                $sql = "SELECT * FROM project_managers WHERE team_id IS NULL";
                                                                $sql_stmt = $conn->prepare($sql);
                                                                $sql_stmt->execute();
                                                                
                                                                if($sql_stmt->rowCount()):
                                                                    $pm_count = $sql_stmt->rowCount();
                                                                    while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?>
                                                                        <option value="<?php echo $data["reg_id"];?>" m-name="<?php echo $data["name"];?>">
                                                                        <?php echo $data["name"];?></option><?php
                                                                    }
                                                                else:
                                                                    echo "Sorry! No Project Manager is Available.";
                                                                    $pm_count = 0;
                                                                endif;
                                                                ?>
                                                            </select>
                                                        <?php endif; ?>
                                                        <input type="hidden" value="<?php echo $pm_count; ?>" id="pmCount">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="pmEmail_1" class="form-control" readonly placeholder="Email">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="pmContact_1" class="form-control" readonly placeholder="Contact No">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="pmCountry_1" class="form-control" readonly placeholder="Ccountry">
                                                    </td>
                                                    <td><!--<i class="mdi mdi-delete font-20 text-plan removePM" style="cursor:pointer;"></i>--></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div style="display: inline-block;width: 100%;text-align:center;">
                                            <!--<i id="addPM" class="mdi mdi-plus font-40 text-plan text-center" style="cursor:pointer;"></i>-->
                                            <button type="button" class="btn" id="addPM"><i class="mdi mdi-plus font-40 text-plan text-center"></i></button>
                                        </div>
                                        <!-- Project Manager Section Ends -->
                                        <!-- Team members Section -->
                                        <div style="margin-bottom: 10px;">
                                            <h5 class="text-plan">Team Members</h5>
                                        </div>
                                        <table id="datatable_tm_add" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <tbody id="tm">
                                                <tr>
                                                    <!--<td>1</td>
                                                    <td><img src="assets/images/default.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/></td>-->
                                                    <td>
                                                    <?php
                                                    if($role=='3'):?>
                                                        <select class="form-control selectTM" id="selectTM_1" name="member[]" mem-name="mem[]">
                                                            <option selected disabled value="">Select a Team Member</option>
                                                            <?php
                                                            //$select = "SELECT * FROM team_members";
                                                            $select = "SELECT a.name,a.reg_id FROM team_members as a left join users as b on a.reg_id=b.id where a.team_id IS NULL AND b.country=:country";
                                                            $select_stmt = $conn->prepare($select);
                                                            $select_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                                                            $select_stmt->execute();
                                                            
                                                            if($select_stmt->rowCount()):
                                                                $tm_count = $select_stmt->rowCount();
                                                                while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {?>
                                                                    <option value="<?php echo $data["reg_id"];?>" me-name="">
                                                                    <?php echo $data["name"];?></option><?php
                                                                }
                                                            else:
                                                                echo "Sorry! No Team Member Found.";
                                                                $tm_count = 0;
                                                            endif;
                                                            ?>
                                                        </select>
                                                    <?php
                                                    elseif($role=='1'||$role == '2'|| $role == '0'):?>
                                                        <select class="form-control selectTM" id="selectTM_1" name="member[]" mem-name="mem[]">
                                                            <option selected disabled value="">Select a Team Member</option>
                                                            <?php
                                                            $select = "SELECT * FROM team_members WHERE team_id IS NULL";
                                                            $select_stmt = $conn->prepare($select);
                                                            $select_stmt->execute();
                                                            
                                                            if($select_stmt->rowCount()):
                                                                $tm_count = $select_stmt->rowCount();
                                                                while($data = $select_stmt->fetch(PDO::FETCH_ASSOC)) {?>
                                                                    <option value="<?php echo $data["reg_id"];?>">
                                                                    <?php echo $data["name"];?></option><?php
                                                                }
                                                            else:
                                                                echo "Sorry! No Team Member Found.";
                                                                $tm_count = 0;
                                                            endif;
                                                            ?>
                                                        </select>
                                                    <?php endif; ?>
                                                    <input type="hidden" value="<?php echo $tm_count; ?>" id="tmCount">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="tmEmail_1" class="form-control" readonly placeholder="Email">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="tmContact_1" class="form-control" readonly placeholder="Contact No">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="tmCountry_1" class="form-control" readonly placeholder="Country">
                                                    </td>
                                                    <td><!--<i class="mdi mdi-delete font-20 text-plan removeTM"></i>--></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div style="display: inline-block;width: 100%;text-align:center;">
                                            <!--<i id="addTM" class="mdi mdi-plus font-40 text-plan text-center" style="cursor:pointer;"></i>-->
                                            <button type="button" class="btn" id="addTM"><i class="mdi mdi-plus font-40 text-plan text-center"></i></button>
                                        </div>
                                        <!-- Team members Section ends -->
                                        <!-- Assigned SSM Section -->
                                        <div style="margin-bottom: 20px;">
                                            <h5 class="text-plan">Assigned SMB</h5>
                                        </div>
                                        <div>
                                            <table id="datatable_smb_add" class="table table-borderless dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <!--<th>SSM Number</th>-->
                                                    <th>SSM Reference</th>
                                                    <th>Model</th>
                                                    <th>SSM Responsible</th>
                                                    <th></th>
                                                </tr>
                                                </thead> 
                                                <tbody id="SMBAdd">
                                                    <tr>
                                                        <td>
                                                        <?php
                                                        if($role=='1'||$role=='2'|| $role == '0'):?>
                                                            <select class="form-control smbRef" id="smbRef_1" name="device[]" device-name="de[]">
                                                                <option selected disabled value="">Select an SMB</option>
                                                                <?php
                                                                $device = "SELECT * FROM devices WHERE team_id IS NULL";
                                                                $device_stmt = $conn->prepare($device);
                                                                $device_stmt->execute();
                                                                
                                                                if($device_stmt->rowCount()):
                                                                    $smb_count = $device_stmt->rowCount();
                                                                    while($data = $device_stmt->fetch(PDO::FETCH_ASSOC)) {?>
                                                                        <option value="<?php echo $data["id"];?>">
                                                                        <?php echo $data["ref"];?></option><?php
                                                                    }
                                                                else:?>
                                                                    <option disabled><?php echo "Sorry! There is No Device or all are assigned.";?></option><?php
                                                                    $smb_count = 0;
                                                                endif;
                                                                ?>
                                                            </select>
                                                        <?php
                                                        elseif($role=='3'):?>
                                                            <select class="form-control smbRef" id="smbRef_1" name="device[]" device-name="de[]">
                                                                <option selected disabled value="">Select an SMB</option>
                                                                <?php
                                                                $device = "SELECT * FROM devices WHERE team_id IS NULL AND country=:country";
                                                                $device_stmt = $conn->prepare($device);
                                                                $device_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                                                                $device_stmt->execute();
                                                                
                                                                if($device_stmt->rowCount()):
                                                                    $smb_count = $device_stmt->rowCount();
                                                                    while($data = $device_stmt->fetch(PDO::FETCH_ASSOC)) {?>
                                                                        <option value="<?php echo $data["id"];?>">
                                                                        <?php echo $data["ref"];?></option><?php
                                                                    }
                                                                else:?>
                                                                    <option disabled><?php echo "Sorry! There is No Device or all are assigned.";?></option><?php
                                                                    $smb_count = 0;
                                                                endif;
                                                                ?>
                                                            </select>
                                                        <?php endif; ?>
                                                        <input type="hidden" value="<?php echo $smb_count; ?>" id="smbCount">    
                                                        </td>
                                                        <td>
                                                        <input type="text" id="smbModelAdd_1" readonly class="form-control" placeholder="Model">
                                                        </td>
                                                        <td>
                                                            <select class="form-control smbResp" id="smbResp_1" name="responsible[]" responsible-name="re[]">
                                                            <option selected disabled value="">Select SSM Responsible</option>
                                                            </select>
                                                        </td>
                                                        <td><!--<i class="mdi mdi-delete font-20 text-plan removeSMBRow"></i>--></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div style="display: inline-block;width: 100%;text-align:center;">
                                                <button type="button" class="btn" id="addSMBRow"><i class="mdi mdi-plus font-40 text-plan text-center"></i></button>
                                            </div>
                                        </div>
                                        <!-- Assigned SSM Section ends -->
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-plan" id="createTeam">Add</button>
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
        <script src="assets/js/notification.js"></script>
        <script>
            $(document).ready(function(){
                /* Ajax Loader */
                $(document).ajaxSend(function() {
                    $("#overlay-loader").fadeIn(300);
                });
                $(document).ajaxStop(function() {
                    $("#overlay-loader").fadeOut(300);
                });
                var user_id = $("#data-id").val();
                var pmInDb = $("#pmCount").val();
                var tmInDb = $("#tmCount").val();
                var smbInDb = $("#smbCount").val();
                loadNotification(user_id);

                if($('.selectPM').val() == null) {
                    $('#smbRef_1').prop('disabled', true);
                    $('#smbResp_1').prop('disabled', true);
                    //$('#addSMBRow').css('display','none');
                    $('#addSMBRow').prop('disabled', true);
                    $('#addPM').prop('disabled', true);
                    $('#addTM').prop('disabled', true);
                }
                
                /* Adding rows on PLUS icon Click */
                var i = 1;
                var j = 1;
                var k = 1;
                $("#addPM").click(function () {
                    i++;
                    var html = '<tr><td><?php if($role=="3"):?> <select class="form-control selectPM" id="selectPM_'+i+'" name="manager[]" mng-name="mn[]"><option selected disabled value="">Select a Project Manager</option><?php $sql = "SELECT a.name,a.reg_id FROM project_managers as a left join users as b on a.reg_id=b.id where a.team_id IS NULL AND b.country=:country";$sql_stmt = $conn->prepare($sql); $sql_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["reg_id"];?>" m-name="<?php echo $data["name"];?>"> <?php echo $data["name"];?></option><?php } else: echo "Sorry! No Project Managers Found."; endif; ?></select><?php elseif($role=="1"||$role=="2"|| $role == '0'):?><select class="form-control selectPM" id="selectPM_'+i+'" name="manager[]" mng-name="mn[]"><option selected disabled value="">Select a Project Manager</option><?php $sql="SELECT * FROM project_managers WHERE team_id IS NULL";$sql_stmt = $conn->prepare($sql);$sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?><option value="<?php echo $data["reg_id"];?>"><?php echo $data["name"];?></option><?php }else: echo "Sorry! No Project Managers Found.";endif;?></select><?php endif; ?></td><td><input type="text" id="pmEmail_'+i+'" class="form-control" readonly placeholder="Email"></td><td><input type="text" id="pmContact_'+i+'" class="form-control" readonly placeholder="Contact No"></td><td><input type="text" id="pmCountry_'+i+'" class="form-control" readonly placeholder="Country"></td><td><i class="mdi mdi-delete font-20 text-plan removePM" style="cursor:pointer;"></i></td></tr>';
                    $('#pm').append(html);
                    if($("#datatable_pm_add > tbody > tr").length >= pmInDb) {
                        $('#addPM').prop('disabled', true);
                    } else {
                        $('#addPM').prop('disabled', false);
                    }
                });
                $("#pm").on("click", ".removePM", function() {
                    $(this).closest('tr').remove();
                    if($("#datatable_pm_add > tbody > tr").length >= pmInDb) {
                        $('#addPM').prop('disabled', true);
                    } else {
                        $('#addPM').prop('disabled', false);
                    }
                });
                $("#addTM").click(function () {
                    j++;
                    var html = '<tr><td><?php if($role=="3"):?> <select class="form-control selectTM" id="selectTM_'+j+'" name="member[]" mem-name="mem[]"><option selected disabled value="">Select a Team Member</option><?php $sql = "SELECT a.name,a.reg_id FROM team_members as a left join users as b on a.reg_id=b.id where a.team_id IS NULL AND b.country=:country";$sql_stmt = $conn->prepare($sql); $sql_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["reg_id"];?>"> <?php echo $data["name"];?></option><?php } else: echo "Sorry! No Team Members Found."; endif; ?></select><?php elseif($role=="1"||$role=="2"|| $role == '0'):?><select class="form-control selectTM" id="selectTM_'+j+'" name="member[]" mem-name="mem[]"><option selected disabled value="">Select a Team Member</option><?php $sql = "SELECT * FROM team_members WHERE team_id IS NULL";$sql_stmt = $conn->prepare($sql);$sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?><option value="<?php echo $data["reg_id"];?>"><?php echo $data["name"];?></option><?php }else: echo "Sorry! No Team Members Found.";endif;?></select><?php endif; ?></td><td><input type="text" id="tmEmail_'+j+'" class="form-control" readonly placeholder="Email" ></td><td><input type="text" id="tmContact_'+j+'" class="form-control" readonly placeholder="Contact No"></td><td><input type="text" id="tmCountry_'+j+'" class="form-control" readonly placeholder="Country"></td><td><i class="mdi mdi-delete font-20 text-plan removeTM" style="cursor:pointer;"></i></td></tr>';
                    $('#tm').append(html);
                    if($("#datatable_tm_add > tbody > tr").length >= tmInDb) {
                        $('#addTM').prop('disabled', true);
                    } else {
                        $('#addTM').prop('disabled', false);
                    }
                });
                $("#tm").on("click", ".removeTM", function() {
                    $(this).closest('tr').remove();
                    if($("#datatable_tm_add > tbody > tr").length >= tmInDb) {
                        $('#addTM').prop('disabled', true);
                    } else {
                        $('#addTM').prop('disabled', false);
                    }
                });
                $("#addSMBRow").click(function () {
                    k++;
                    var html = '<tr><td><?php if($role=="1"||$role=="2"|| $role == '0'):?> <select class="form-control smbRef" id="smbRef_'+k+'" name="device[]" device-name="de[]"> <option selected disabled value="">Select an SSM</option> <?php $device = "SELECT * FROM devices WHERE team_id IS NULL"; $device_stmt = $conn->prepare($device); $device_stmt->execute(); if($device_stmt->rowCount()): while($data = $device_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["id"];?>"> <?php echo $data["ref"];?></option><?php } else:?> <option disabled><?php echo "Sorry! There is No Device or all are assigned.";?></option><?php endif; ?> </select> <?php elseif($role=="3"):?> <select class="form-control smbRef" id="smbRef_'+k+'" name="device[]" device-name="de[]"> <option selected disabled value="">Select an SSM</option> <?php $device = "SELECT * FROM devices WHERE team_id IS NULL AND country=:country"; $device_stmt = $conn->prepare($device); $device_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $device_stmt->execute(); if($device_stmt->rowCount()): while($data = $device_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["id"];?>"> <?php echo $data["ref"];?></option><?php } else:?> <option disabled><?php echo "Sorry! There is No Device or all are assigned.";?></option><?php endif; ?> </select> <?php endif; ?></td><td><input type="text" id="smbModelAdd_'+k+'" readonly class="form-control" placeholder="Model"></td><td><select class="form-control smbResp" id="smbResp_'+k+'" name="responsible[]" responsible-name="re[]"><option selected disabled value="">Select SSM Responsible</option></select></td><td><i class="mdi mdi-delete font-20 text-plan removeSMBRow" style="cursor:pointer;"></i></td></tr>';
                    $('#SMBAdd').append(html);
                    $('#smbResp_'+k).prop('disabled', true);
                    if($("#datatable_smb_add > tbody > tr").length >= smbInDb) {
                        $('#addSMBRow').prop('disabled', true);
                    } else {
                        $('#addSMBRow').prop('disabled', false);
                    }
                });
                $("#SMBAdd").on("click", ".removeSMBRow", function() {
                    $(this).closest('tr').remove();
                    if($("#datatable_smb_add > tbody > tr").length >= smbInDb) {
                        $('#addSMBRow').prop('disabled', true);
                    } else {
                        $('#addSMBRow').prop('disabled', false);
                    }
                });
                /* Get Data on Selection */
                $(document).on('change','.selectPM', function() {
                    //console.log(pmInDb+' '+$("#datatable_pm_add > tbody > tr").length);
                    $('.smbResp').find('option').not(':first').remove();
                    if($(this).val() != null){
                        $('#smbRef_1').prop('disabled', false);
                        $("select[name='manager[]']").map(function(){return $(this).val();}).get().forEach(function(item) {
                            $.ajax({
                                type: "POST",
                                url: "backend/teams/selectData.php",
                                data: {respId:item},
                                success: function(result){
                                    var data = jQuery.parseJSON(result);
                                    $('.smbResp').append($('<option/>', {
                                        value: data.fields[0],
                                        text: data.fields[1],
                                        
                                    }));
                                }
                            });
                        });
                    }
                    var pmId = $(this).attr("id").split("_")[1];
                    $.ajax({
                        type: "POST",
                        url: "backend/teams/selectData.php",
                        data: {id:this.value},
                        success: function(result){
                            var data = jQuery.parseJSON(result);
                            $("#pmEmail_"+pmId).val(data.fields[0]);
                            $("#pmContact_"+pmId).val(data.fields[1]);
                            $("#pmCountry_"+pmId).val(data.fields[2]);
                        }
                    });
                    //$('#addPM').prop('disabled', false);
                    if($("#datatable_pm_add > tbody > tr").length >= pmInDb) {
                        $('#addPM').prop('disabled', true);
                    } else {
                        $('#addPM').prop('disabled', false);
                    }
                });
                $(document).on('change','.selectTM', function() {
                    var tmId = $(this).attr("id").split("_")[1];
                    $.ajax({
                        type: "POST",
                        url: "backend/teams/selectData.php",
                        data: {userId:this.value},
                        success: function(result){
                            var data = jQuery.parseJSON(result);
                            console.log(data);
                            $("#tmEmail_"+tmId).val(data.fields[0]);
                            $("#tmContact_"+tmId).val(data.fields[1]);
                            $("#tmCountry_"+tmId).val(data.fields[2]);
                        }
                    });
                    //$('#addTM').prop('disabled', false);
                    if($("#datatable_tm_add > tbody > tr").length >= tmInDb) {
                        $('#addTM').prop('disabled', true);
                    } else {
                        $('#addTM').prop('disabled', false);
                    }
                });
                $(document).on('change','.smbRef', function() {
                    var deviceId = $(this).attr("id").split("_")[1];
                    console.log(deviceId);
                    $('#smbResp_'+deviceId).prop('disabled', false);
                    $('#smbResp_'+deviceId).find('option').not(':first').remove();
                    $("select[name='manager[]']").map(function(){return $(this).val();}).get().forEach(function(item) {
                        $.ajax({
                            type: "POST",
                            url: "backend/teams/selectData.php",
                            data: {respId:item},
                            success: function(result){
                                var data = jQuery.parseJSON(result);
                                $('#smbResp_'+deviceId).append($('<option/>', {
                                    value: data.fields[0],
                                    text: data.fields[1]
                                }));
                            }
                        });
                    });
                    $.ajax({
                        type: "POST",
                        url: "backend/teams/selectData.php",
                        data: {devID:this.value},
                        success: function(result){
                            var data = jQuery.parseJSON(result);
                            console.log(data);
                            $("#smbModelAdd_"+deviceId).val(data.fields[0]);
                            //$("#tmContact_"+deviceId).val(data.fields[1]);
                        }
                    });
                    //$('#addSMBRow').prop('disabled', false);
                    if($("#datatable_smb_add > tbody > tr").length >= smbInDb) {
                        $('#addSMBRow').prop('disabled', true);
                    } else {
                        $('#addSMBRow').prop('disabled', false);
                    }
                });
                /* Create Teams */
                function insertModalReset() {
                    window.location.reload();
                }
                $("#createTeam").click(function (event) {
                    var formData = {
                        team: $("#teamName").val(),
                        contact: $("#contactAdd").val(),
                        manager: $("select[name='manager[]']").map(function(){return $(this).val();}).get(),
                        member: $("select[name='member[]']").map(function(){return $(this).val();}).get(),
                        smb_ref: $("select[name='device[]']").map(function(){return $(this).val();}).get(),
                        smb_resp: $("select[name='responsible[]']").map(function(){return $(this).val();}).get(),


                        // mn: $("select[mng-name='mn[]']").map(function(){return $(this).find(':selected').text();}).get(),
                        // mem: $("select[mem-name='mem[]']").map(function(){return $(this).find(':selected').text();}).get(),
                        // dev: $("select[device-name='de[]']").map(function(){return $(this).find(':selected').text();}).get(),
                        // ref: $("select[responsible-name='re[]']").map(function(){return $(this).find(':selected').text();}).get(),
                        mn: $("select[mng-name='mn[]']").map(function(){return $(this).val() ? $(this).find(':selected').text() : "";}).get(),
                        mem: $("select[mem-name='mem[]']").map(function(){return $(this).val() ? $(this).find(':selected').text() : "";}).get(),
                        dev: $("select[device-name='de[]']").map(function(){return $(this).val() ? $(this).find(':selected').text() : "";}).get(),
                        ref: $("select[responsible-name='re[]']").map(function(){return $(this).val() ? $(this).find(':selected').text() : "";}).get(),
                       
                        
                    };
                    
                    // console.log(formData);
                    let man_index = 0;
                    let manager_str = "";
                    formData.mn.map((index)=>{
                        manager_str += index.trim();
                        if(man_index >= 0){
                            manager_str += " and "
                        }
                    })

                    manager_str = manager_str.slice(0, manager_str.length - 4);

                    let mem_index = 0;
                    member_str = "";
                    formData.mem.map((index)=>{
                        member_str += index.trim();
                        if(man_index >= 0){
                            mem_index += " and "
                        }
                    })
                    member_str = member_str.slice(0, member_str.length - 4);
                  

                    let dev_index = 0;
                    device_str = "";
                    formData.dev.map((index)=>{
                        device_str += index.trim();
                        if(dev_index >= 0){
                            device_str += " and "
                        }
                    })
                    device_str = device_str.slice(0, device_str.length - 4);

                    let ref_index = 0;
                    reference_str = "";
                    formData.ref.map((index)=>{
                        reference_str += index.trim();
                        if(ref_index >= 0){
                            reference_str += " and "
                        }
                    })
                    reference_str = reference_str.slice(0, reference_str.length - 4);
        
                    $.ajax({
                        type: "POST",
                        url: "backend/teams/create.php",
                        data: formData,
                        encode: true,
                        success: function (result) {
                            var data = jQuery.parseJSON(result);
                            console.log(data);
                            if(data.success==0){
                                console.log(data.message);
                                $("#errMsg").text(data.message).show().delay(10000).hide("slow");
                            }
                            else if(data.success==1){
                                       
                                //start Add  Activity
                                var formData = {
                                    user_id: $("#data-id").val(),
                                    section: 'Team',
                                    command: 'Added',
                                    user_trc_details : document.getElementById("user_trc_details").value,
                                    description: `${$("#data-name").val()} Added ${$("#teamName").val()} as a new team,<br>${manager_str} as team manager, <br>${member_str} as team member,<br>${device_str} as device, and <br>${reference_str} as device responsible`
                                };
                                console.log(formData);
                             
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

                                //end add Activity log//

                                $("#msgSuccess").text(data.message).show().delay(4000).hide("slow");
                            }
                        }
                    });
                });
                $(document).on('click','.view_btn',function () {
                    $("#viewModal").modal("show");
                    var viewId = $(this).attr("id").split("_")[1];
                    console.log(viewId);
                    var imgSrc;
                    $.ajax({
                        type: "POST",
                        url: "backend/teams/modal.php",
                        data: {id:viewId},
                        success: function(result) {
                            var data = jQuery.parseJSON(result);
                            console.log(data);
                            $("#teamHeader").text(data.name);
                            $("#teamContact").text(data.contact);
                            jQuery.each(data.pm, function(index, item) {
                                if(item.image_path==null) {
                                    imgSrc = 'assets/uploads/propic.png';
                                } else {
                                    imgSrc = item.image_path;
                                }
                                $('#managers').append('<div style="border-bottom: 3px solid rgb(223, 223, 223);"><div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan"><img src="'+imgSrc+'" alt="user-image" class="thumb-sm rounded-circle mr-2"/></div><div class="col-3">'+item.fname+' '+item.lname+'</div><div class="col-3 text-plan">'+item.email+'</div><div class="col-3">'+item.phone+'</div></div></div>');
                            });
                            jQuery.each(data.tm, function(index, item) {
                                if(item.image_path==null) {
                                    imgSrc = 'assets/uploads/propic.png';
                                } else {
                                    imgSrc = item.image_path;
                                }
                                $('#members').append('<div style="border-bottom: 3px solid rgb(223, 223, 223);"><div class="row" style="margin-top: 10px; margin-bottom: 10px;text-align:center;"><div class="col-3 text-plan"><img src="'+imgSrc+'" alt="user-image" class="thumb-sm rounded-circle mr-2"/></div><div class="col-3">'+item.fname+' '+item.lname+'</div><div class="col-3 text-plan">'+item.email+'</div><div class="col-3">'+item.phone+'</div></div></div>');
                            });
                            jQuery.each(data.smb, function(index, item) {
                                $('#smbInfo').append('<tr><td>'+item.id+'</td><td>'+item.model+'</td><td>'+item.ref+'</td><td>'+item.name+'</td></tr>');
                            });
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                });
                $('#viewModal').on('hidden.bs.modal', function(e) {
                    $(this).find('#managers').html('');
                    $(this).find('#members').html('');
                    $(this).find('#smbInfo').html('');
                });
                $(document).on('click','.del_modal',function () {
                    $("#delModal").modal("show");
                    var delId = $(this).attr("id").split("_")[1];
                    var dataName = $(this).attr("name");
                    $(".del_btn").click(function () {
                        $.ajax({
                            type: "POST",
                            url: "backend/teams/delete.php",
                            data: {id:delId},
                            success: function(data) {
                                 //start Deleted Activity
                            var formData = {
                                user_id: $("#data-id").val(),
                                section: 'Team',
                                command: 'Deleted',
                                user_trc_details : document.getElementById("user_trc_details").value,
                                description: `${$("#data-name").val()} Deleted ${dataName} From the Team List`
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

                            //end Deleted Activity log//
                                console.log(data);
                                //location.reload();
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    });
                });
                /* Edit Modal*/
                let editLoadData = '';
                //var table_pm = $('#datatable_pm').DataTable();
                //var table_tm = $('#datatable_tm').DataTable();
                //var table_smb = $('#datatable_smb').DataTable();
                var x=0;
                var y=0;
                var z=0;
                $(document).on('click','.edit_modal',function () {
                    //x=0;y=0;z=0;
                    $("#editModal").modal("show");
                    var editId = $(this).attr("id").split("_")[1];
                    console.log(editId);
                    $.ajax({
                        type: "POST",
                        url: "backend/teams/modal.php",
                        data: {id:editId},
                        success: function(result) {
                            //x++;y++;z++;
                            var data = jQuery.parseJSON(result);
                            console.log(data);
                            editLoadData = data;
                            console.log(x+' '+y+' '+z);
                            $("#teamNameEdit").val(data.name);
                            $("#contactEdit").val(data.contact);
                            if(data.pm.length>0) {
                                jQuery.each(data.pm, function(index, item) {
                                    $('#pmEdit').append('<tr><td><?php if($role=="3"):?> <select class="form-control selectPMEdit" id="selectPMEdit_'+x+'" name="managerEdit[]"" mng-name="mnEdit[]"><?php $sql = "SELECT a.name,a.reg_id FROM project_managers as a left join users as b on a.reg_id=b.id where a.team_id IS NULL AND b.country=:country";$sql_stmt = $conn->prepare($sql); $sql_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["reg_id"];?>"> <?php echo $data["name"];?></option><?php } else: ?><option value="'+item.id+'">'+item.fname+' '+item.lname+'</option><?php endif; ?></select><?php elseif($role=="1"||$role=="2"|| $role == '0'):?><select class="form-control selectPMEdit" id="selectPMEdit_'+x+'" name="managerEdit[]" mng-name="mnEdit[]"><?php $sql = "SELECT * FROM project_managers WHERE team_id IS NULL";$sql_stmt = $conn->prepare($sql);$sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?><option value="<?php echo $data["reg_id"];?>"><?php echo $data["name"];?></option><?php }else:?><option value="'+item.id+'">'+item.fname+' '+item.lname+'</option><?php endif;?></select><?php endif; ?></td><td><input type="text" id="pmEmailEdit_'+x+'" class="form-control" readonly></td><td><input type="text" id="pmContactEdit_'+x+'" class="form-control" readonly></td><td><i class="mdi mdi-delete font-20 text-plan removePMEdit" style="cursor:pointer;"></i></td></tr>');
                                    $('#selectPMEdit_'+x).append($('<option/>', {
                                        value: item.id,
                                        text: item.full_name
                                    }));
                                    $("#selectPMEdit_"+x).val(item.id);
                                    $("#pmEmailEdit_"+x).val(item.email);
                                    $("#pmContactEdit_"+x).val(item.phone);
                                    x++;
                                });
                                // $("select[name='managerEdit[]']").map(function(){return $(this).val();}).get().forEach(function(item) {
                                //     $.ajax({
                                //         type: "POST",
                                //         url: "backend/teams/selectData.php",
                                //         data: {respId:item},
                                //         success: function(result){
                                //             var data = jQuery.parseJSON(result);
                                //             //$('.smbRespEdit').html('');
                                //             $('.smbRespEdit').append($('<option/>', {
                                //                 value: data.fields[0],
                                //                 text: data.fields[1]
                                //             }));
                                //         }
                                //     });
                                // });
                            }
                            else{x=0;}
                            if(data.tm.length>0) {
                                jQuery.each(data.tm, function(index, item) {
                                    $('#tmEdit').append('<tr><td><?php if($role=="3"):?> <select class="form-control selectTMEdit" id="selectTMEdit_'+y+'" name="memberEdit[]" mem-name="memEdit[]"><?php $sql = "SELECT a.name,a.reg_id FROM team_members as a left join users as b on a.reg_id=b.id where a.team_id IS NULL AND b.country=:country";$sql_stmt = $conn->prepare($sql); $sql_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["reg_id"];?>"> <?php echo $data["name"];?></option><?php } else:?><option value="'+item.id+'">'+item.fname+' '+item.lname+'</option><?php endif; ?></select><?php elseif($role=="1"||$role=="2"|| $role == '0'):?><select class="form-control selectTMEdit" id="selectTMEdit_'+y+'" name="memberEdit[]" mem-name="memEdit[]"><?php $sql = "SELECT * FROM team_members WHERE team_id IS NULL";$sql_stmt = $conn->prepare($sql);$sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?><option value="<?php echo $data["reg_id"];?>"><?php echo $data["name"];?></option><?php }else:?><option value="'+item.id+'">'+item.fname+' '+item.lname+'</option><?php endif;?></select><?php endif; ?></td><td><input type="text" id="tmEmailEdit_'+y+'" class="form-control" readonly></td><td><input type="text" id="tmContactEdit_'+y+'" class="form-control" readonly></td><td><i class="mdi mdi-delete font-20 text-plan removeTMEdit" style="cursor:pointer;"></i></td></tr>');
                                    $('#selectTMEdit_'+y).append($('<option/>', {
                                        value: item.id,
                                        text: item.full_name
                                    }));
                                    $("#selectTMEdit_"+y).val(item.id);
                                    $("#tmEmailEdit_"+y).val(item.email);
                                    $("#tmContactEdit_"+y).val(item.phone);
                                    y++;
                                });
                            }
                            else{y=0;}
                            if(data.smb.length>0) {
                                jQuery.each(data.smb, function(index, item) {
                                    $('#SMBEdit').append('<tr><td><?php if($role=="1"||$role=="2"|| $role == '0'):?> <select class="form-control smbRefEdit" id="smbRefEdit_'+z+'" name="deviceEdit[]" device-name="deEdit[]"><?php $device = "SELECT * FROM devices"; $device_stmt = $conn->prepare($device); $device_stmt->execute(); if($device_stmt->rowCount()): while($data = $device_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["id"];?>"> <?php echo $data["ref"];?></option><?php } else:?><option value="'+item.id+'">'+item.ref+'</option><?php endif; ?> </select> <?php elseif($role=="3"):?> <select class="form-control smbRefEdit" id="smbRefEdit_'+z+'" name="deviceEdit[]" device-name="deEdit[]"><?php $device = "SELECT * FROM devices WHERE country=:country"; $device_stmt = $conn->prepare($device); $device_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $device_stmt->execute(); if($device_stmt->rowCount()): while($data = $device_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["id"];?>"> <?php echo $data["ref"];?></option><?php } else:?> <option disabled><?php echo "Sorry! There is No Device or all are assigned.";?></option><?php endif; ?> </select> <?php endif; ?></td><td><input type="text" id="smbModelEdit_'+z+'" readonly class="form-control text-center"></td><td><select class="form-control smbRespEdit" id="smbRespEdit_'+z+'" name="responsibleEdit[]" responsible-name="reEdit[]"]></select></td><td><i class="mdi mdi-delete font-20 text-plan removeSMBRowEdit" style="cursor:pointer;"></i></td></tr>');
                                    $("#smbRefEdit_"+z).val(item.id);
                                    $("#smbModelEdit_"+z).val(item.model);
                                    // $('#smbRespEdit_'+z).append($('<option/>', {
                                    //     value: item.pmid,
                                    //     text: item.name
                                    // }));
                                    //$('#smbRespEdit_'+z).val(item.pmid);
                                    z++;
                                });
                                var check = [];
                                jQuery.each(data.smb, function(index, item) {
                                    if(jQuery.inArray(item.pmid, check)>=0) {
                                        $('#smbRespEdit_'+index).val(item.pmid);
                                    }
                                    else {
                                        $('.smbRespEdit').append($('<option/>', {
                                            value: item.pmid,
                                            text: item.name
                                        }));
                                        $('#smbRespEdit_'+index).val(item.pmid);
                                        check.push(item.pmid);
                                    }
                                });
                            }
                            else{z=0;}
                            //console.log(Number(pmInDb)+1);
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                    if($("#datatable_pm > tbody > tr").length >= Number(pmInDb)+1) {
                        $('#addPMEdit').prop('disabled', true);
                    } else {
                        $('#addPMEdit').prop('disabled', false);
                    }
                    if($("#datatable_tm > tbody > tr").length >= Number(tmInDb)+1) {
                        $('#addTMEdit').prop('disabled', true);
                    } else {
                        $('#addTMEdit').prop('disabled', false);
                    }
                    if($("#datatable_smb > tbody > tr").length >= Number(smbInDb)+1) {
                        $('#addSMBRowEdit').prop('disabled', true);
                    } else {
                        $('#addSMBRowEdit').prop('disabled', false);
                    }
                    $(document).on('click','#addPMEdit',function (event) {
                        event.stopImmediatePropagation()
                        $('#pmEdit').append('<tr><td><?php if($role=="3"):?> <select class="form-control selectPMEdit" id="selectPMEdit_'+x+'" name="managerEdit[]"" mng-name="mnEdit[]"><option selected disabled value="">Select a Project Manager</option><?php $sql = "SELECT a.name,a.reg_id FROM project_managers as a left join users as b on a.reg_id=b.id where a.team_id IS NULL AND b.country=:country";$sql_stmt = $conn->prepare($sql); $sql_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["reg_id"];?>"> <?php echo $data["name"];?></option><?php } else: echo "Sorry! No Project Managers Found."; endif; ?></select><?php elseif($role=="1"||$role=="2"|| $role == '0'):?><select class="form-control selectPMEdit" id="selectPMEdit_'+x+'" name="managerEdit[]" mng-name="mnEdit[]"><option selected disabled value="">Select a Project Manager</option><?php $sql = "SELECT * FROM project_managers WHERE team_id IS NULL";$sql_stmt = $conn->prepare($sql);$sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?><option value="<?php echo $data["reg_id"];?>"><?php echo $data["name"];?></option><?php }else: echo "Sorry! No Project Managers Found.";endif;?></select><?php endif; ?></td><td><input type="text" id="pmEmailEdit_'+x+'" class="form-control" readonly></td><td><input type="text" id="pmContactEdit_'+x+'" class="form-control" readonly></td><td><i class="mdi mdi-delete font-20 text-plan removePMEdit" style="cursor:pointer;"></i></td></tr>');
                        x++;
                        if($("#datatable_pm > tbody > tr").length >= Number(pmInDb)+1) {
                            $('#addPMEdit').prop('disabled', true);
                        } else {
                            $('#addPMEdit').prop('disabled', false);
                        }
                    });

                    $("#pmEdit").on("click", ".removePMEdit", function() {
                        $(this).closest('tr').remove();
                        //console.log($("select[name='managerEdit[]']").map(function(){return $(this).val();}).get());
                        if($("#datatable_pm > tbody > tr").length >= Number(pmInDb)+1) {
                            $('#addPMEdit').prop('disabled', true);
                        } else {
                            $('#addPMEdit').prop('disabled', false);
                        }
                    });
                    $("#addTMEdit").click(function (event) {
                        event.stopImmediatePropagation()
                        $('#tmEdit').append('<tr><td><?php if($role=="3"):?> <select class="form-control selectTMEdit" id="selectTMEdit_'+y+'" name="memberEdit[]" mem-name="memEdit[]"><option selected disabled value="">Select a Team Member</option><?php $sql = "SELECT a.name,a.reg_id FROM team_members as a left join users as b on a.reg_id=b.id where a.team_id IS NULL AND b.country=:country";$sql_stmt = $conn->prepare($sql); $sql_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["reg_id"];?>"> <?php echo $data["name"];?></option><?php } else: echo "Sorry! No Team Members Found."; endif; ?></select><?php elseif($role=="1"||$role=="2"|| $role == '0'):?><select class="form-control selectTMEdit" id="selectTMEdit_'+y+'" name="memberEdit[]" mem-name="memEdit[]"><option selected disabled value="">Select a Team Member</option><?php $sql = "SELECT * FROM team_members WHERE team_id IS NULL";$sql_stmt = $conn->prepare($sql);$sql_stmt->execute();if($sql_stmt->rowCount()): while($data = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {?><option value="<?php echo $data["reg_id"];?>"><?php echo $data["name"];?></option><?php }else: echo "Sorry! No Team Members Found.";endif;?></select><?php endif; ?></td><td><input type="text" id="tmEmailEdit_'+y+'" class="form-control" readonly></td><td><input type="text" id="tmContactEdit_'+y+'" class="form-control" readonly></td><td><i class="mdi mdi-delete font-20 text-plan removeTMEdit" style="cursor:pointer;"></i></td></tr>');
                        y++;
                        if($("#datatable_tm > tbody > tr").length >= Number(tmInDb)+1) {
                            $('#addTMEdit').prop('disabled', true);
                        } else {
                            $('#addTMEdit').prop('disabled', false);
                        }
                    });
                    $("#tmEdit").on("click", ".removeTMEdit", function() {
                        $(this).closest('tr').remove();
                        if($("#datatable_tm > tbody > tr").length >= Number(tmInDb)+1) {
                            $('#addTMEdit').prop('disabled', true);
                        } else {
                            $('#addTMEdit').prop('disabled', false);
                        }
                    });
                    $(document).on('click','#addSMBRowEdit',function (event) {
                        event.stopImmediatePropagation();
                        $('#SMBEdit').append('<tr><td><?php if($role=="1"||$role=="2"|| $role == '0'):?> <select class="form-control smbRefEdit" id="smbRefEdit_'+z+'" name="deviceEdit[]" device-name="deEdit[]"> <option selected disabled value="">Select an SMB</option> <?php $device = "SELECT * FROM devices WHERE team_id IS NULL"; $device_stmt = $conn->prepare($device); $device_stmt->execute(); if($device_stmt->rowCount()): while($data = $device_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["id"];?>"> <?php echo $data["ref"];?></option><?php } else:?> <option disabled><?php echo "Sorry! There is No Device or all are assigned.";?></option><?php endif; ?> </select> <?php elseif($role=="3"):?> <select class="form-control smbRefEdit" id="smbRefEdit_'+z+'" name="deviceEdit[]" device-name="deEdit[]"> <option selected disabled value="">Select an SMB</option> <?php $device = "SELECT * FROM devices WHERE team_id IS NULL AND country=:country"; $device_stmt = $conn->prepare($device); $device_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR); $device_stmt->execute(); if($device_stmt->rowCount()): while($data = $device_stmt->fetch(PDO::FETCH_ASSOC)) {?> <option value="<?php echo $data["id"];?>"> <?php echo $data["ref"];?></option><?php } else:?> <option disabled><?php echo "Sorry! There is No Device or all are assigned.";?></option><?php endif; ?> </select> <?php endif; ?></td><td><input type="text" id="smbModelEdit_'+z+'" readonly class="form-control text-center"></td><td><select class="form-control smbRespEdit" id="smbRespEdit_'+z+'" name="responsibleEdit[]" responsible-name="reEdit[]"]></select></td><td><i class="mdi mdi-delete font-20 text-plan removeSMBRowEdit" style="cursor:pointer;"></i></td></tr>');
                        $('#smbRespEdit_'+z).prop('disabled', true);
                        z++;
                        if($("#datatable_smb > tbody > tr").length >= Number(smbInDb)+1) {
                            $('#addSMBRowEdit').prop('disabled', true);
                        } else {
                            $('#addSMBRowEdit').prop('disabled', false);
                        }
                    });
                    $("#SMBEdit").on("click", ".removeSMBRowEdit", function() {
                        $(this).closest('tr').remove();
                        console.log($("#datatable_smb > tbody > tr").length);
                        console.log(smbInDb);
                        if($("#datatable_smb > tbody > tr").length >= Number(smbInDb)+1) {
                            $('#addSMBRowEdit').prop('disabled', true);
                        } else {
                            $('#addSMBRowEdit').prop('disabled', false);
                        }
                    });
                    /* Get Data on Selection */
                    $(document).on('change','.selectPMEdit', function(event) {
                        event.stopImmediatePropagation();
                        console.log($("select[name='managerEdit[]']").map(function(){return $(this).val();}).get());
                        //$('.smbRespEdit').html('');
                        //$('.smbRespEdit').find('option').not(':first').remove();
                        $('.smbRespEdit').find('option').remove();
                        if($(this).val() != null){
                            //$('#smbRef_1').prop('disabled', false);
                            $("select[name='managerEdit[]']").map(function(){return $(this).val();}).get().forEach(function(item) {
                                $.ajax({
                                    type: "POST",
                                    url: "backend/teams/selectData.php",
                                    data: {respId:item},
                                    success: function(result){
                                        var data = jQuery.parseJSON(result);
                                        //$('.smbRespEdit').html('');
                                        $('.smbRespEdit').append($('<option/>', {
                                            value: data.fields[0],
                                            text: data.fields[1]
                                        }));
                                    }
                                });
                            });
                        }
                        var pmId = $(this).attr("id").split("_")[1];
                        $.ajax({
                            type: "POST",
                            url: "backend/teams/selectData.php",
                            data: {id:this.value},
                            success: function(result){
                                var data = jQuery.parseJSON(result);
                                $("#pmEmailEdit_"+pmId).val(data.fields[0]);
                                $("#pmContactEdit_"+pmId).val(data.fields[1]);
                            }
                        });
                    });
                    $(document).on('change','.selectTMEdit', function() {
                        var tmId = $(this).attr("id").split("_")[1];
                        $.ajax({
                            type: "POST",
                            url: "backend/teams/selectData.php",
                            data: {userId:this.value},
                            success: function(result){
                                var data = jQuery.parseJSON(result);
                                console.log(data);
                                $("#tmEmailEdit_"+tmId).val(data.fields[0]);
                                $("#tmContactEdit_"+tmId).val(data.fields[1]);
                            }
                        });
                    });
                    $(document).on('change','.smbRefEdit', function() {
                        //$('.smbRespEdit').html('');
                        var deviceId = $(this).attr("id").split("_")[1];
                        $('#smbRespEdit_'+deviceId).prop('disabled', false);
                        //$('#smbResp_'+deviceId).find('option').not(':first').remove();
                        $('#smbRespEdit_'+deviceId).find('option').remove();
                        $("select[name='managerEdit[]']").map(function(){return $(this).val();}).get().forEach(function(item) {
                            $.ajax({
                                type: "POST",
                                url: "backend/teams/selectData.php",
                                data: {respId:item},
                                success: function(result){
                                    var data = jQuery.parseJSON(result);
                                    console.log(data);
                                    //$('.smbRespEdit').html('');
                                    $('#smbRespEdit_'+deviceId).append($('<option/>', {
                                        value: data.fields[0],
                                        text: data.fields[1]
                                    }));
                                }
                            });
                        });
                        $.ajax({
                            type: "POST",
                            url: "backend/teams/selectData.php",
                            data: {devID:this.value},
                            success: function(result){
                                var data = jQuery.parseJSON(result);
                                console.log(data);
                                $("#smbModelEdit_"+deviceId).val(data.fields[0]);
                                }
                        });
                    });
                    $(".edit_btn").unbind().click(function () {
                        var editFormData = {
                            team: $("#teamNameEdit").val(),
                            contact: $("#contactEdit").val(),
                            manager: $("select[name='managerEdit[]']").map(function(){return $(this).val();}).get(),
                            member: $("select[name='memberEdit[]']").map(function(){return $(this).val();}).get(),
                            smb_ref: $("select[name='deviceEdit[]']").map(function(){return $(this).val();}).get(),
                            smb_resp: $("select[name='responsibleEdit[]']").map(function(){return $(this).val();}).get(),
                            team_id : editId,

                            mnEdit: $("select[mng-name='mnEdit[]']").map(function(){return $(this).val() ? $(this).find(':selected').text() : "";}).get(),
                            memEdit: $("select[mem-name='memEdit[]']").map(function(){return $(this).val() ? $(this).find(':selected').text() : "";}).get(),
                            devEdit: $("select[device-name='deEdit[]']").map(function(){return $(this).val() ? $(this).find(':selected').text() : "";}).get(),
                            refEdit: $("select[responsible-name='reEdit[]']").map(function(){return $(this).val() ? $(this).find(':selected').text() : "";}).get(),
                        };
                        console.log(editFormData);
                       
                        $.ajax({
                            type: "POST",
                            url: "backend/teams/update.php",
                            data: editFormData,
                            }).done(function (result) {
                            var data = jQuery.parseJSON(result);
                            console.log(data);
                            if(data.success==0){
                                $("#errMsgEdit").text(data.message).show().delay(3000).hide("slow");
                            }
                            else if(data.success==1){
                                        //start activity log//
                                    let checkEditData = '';
                                    let limit = 0;
                                    if (editLoadData.name != editFormData.team) {
                                        checkEditData += `Teame Name : ${editLoadData.name} to ${editFormData.team} |`;
                                        limit += 1;
                                    }
                                    if (editLoadData.contact != editFormData.contact) {
                                        checkEditData += `Emergency Contact : ${editLoadData.contact} to <br>${editFormData.contact} |`
                                        limit += 1;
                                    }
                                   
                                    let addTeam = '', removeTeam = '', addDevice = '', removeDevice = '', addResponsible = '', removeResponsible = '';
                                    let addPm = '', removePm = '', xh = '', a = 0, r = 0;



                                    // console.log(editFormData.mnEdit);
                                    // console.log(editLoadData.pm);
                                    // console.log(editFormData.memEdit);
                                    // console.log(editLoadData.tm)
                                    // console.log(editFormData.devEdit);
                                    // console.log(editLoadData.smb)
                                    // console.log("break");
                                   

                                   function compareArrayWithObject(array, object) {
                                        let msg = "";
                                        const objectNames = object.map(item => item.full_name.trim());

                                        for (let i = 0; i < array.length; i++) {
                                            if(array[i].length > 0){
                                                const index = objectNames.indexOf(array[i].trim());
                                            
                                            if (index === -1) {
                                                // console.log(`${array[i]} is added`);
                                                msg += `${array[i].trim()} is added,`;
                                            } else {
                                                objectNames.splice(index, 1);
                                                }
                                            }

                                        }
                                        
                                        objectNames.forEach(fullName => {
                                            msg += `${fullName.trim()} is removed,`;
                                            // console.log(`${fullName} is removed`);
                                        });
                                        // console.log(msg)
                                        msg = msg.slice(0, -1);
                                        return msg;
                                    }
                                   let resProjectManager = compareArrayWithObject(editFormData.mnEdit,editLoadData.pm);
                                   console.log(resProjectManager);

                                   let resTeamMember = compareArrayWithObject(editFormData.memEdit,editLoadData.tm);
                                   console.log(resTeamMember);

                                   let resDevice = compareArrayWithObject(editFormData.devEdit,editLoadData.smb);
                                   console.log(resDevice);
                                  // return;

                                    checkEditData = checkEditData.replaceAll(" |", ", ");
                                    checkEditData = checkEditData.slice(0, checkEditData.length - 2);
                             
                                    // console.log("aa", editFormData, editLoadData, checkEditData, addPm, removePm, addTeam, removeTeam, addDevice, removeDevice)
                                    if(checkEditData.length > 0 && resProjectManager.length > 0 && resTeamMember.length > 0 && resDevice.length > 0){
                                        return;
                                    }
                                    var formData = {
                                        user_id: $("#data-id").val(),
                                        section: 'Team',
                                        command: 'Edited',
                                        user_trc_details : $('#user_trc_details').val(),
                                        description: `${$("#data-name").val()} Edited Team Details ${checkEditData}.<br>${resProjectManager ? `Project Managers : ${resProjectManager} <br>` : ""} ${resTeamMember ? `Team Members : ${resTeamMember}<br>` : ""}${resDevice ? `Assigned SSM: ${resDevice}` : ""}`
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

                                $("#msgSuccessEdit").text('You have successfully edited this record!').show().delay(4000).hide("slow");
                            }
                        });
                    });
                });
                
                $('#editModal').on('hidden.bs.modal', function(e) {
                    
                    x=0;y=0;z=0;
                    $('#datatable_pm > tbody').find("tr").remove();
                    $(this).find('#tmEdit').html('');
                    $(this).find('#SMBEdit').html('');
                    $(this).find('#pmEdit').html('');
                    //table_pm.clear().draw();
                });
                /* Selectboxes in the table */
                $("#checkall").click(function() {
                    $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                    $('.del-btn').css('display','inline-block');
                    $('.checkItem').each(function(){
                        $(this).css('visibility','visible');
                    });
                });

                $("input[type=checkbox]").click(function() {
                    if (!$(this).prop("checked")) {
                        $("#checkall").prop("checked", false);
                        $('.del-btn').css('display','none');
                        $('.checkItem').each(function(){
                            $(this).css('visibility','hidden');
                        });
                    }
                });
                $('.checkItem').each(function(){
                    if (!$(this).prop("checked")) {
                        $(this).css('visibility','hidden');
                    }
                    else if ($(this).prop("checked")) {
                        $(this).css('visibility','visible');
                    }
                });

                /* Profile edit popup */
                
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