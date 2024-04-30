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
    <style>
        .text-wrap {
            white-space: pre-wrap !important;
        }
    </style>
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
                            <a href="logs.php" class="waves-effect active">
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
                    <h3 class="page-title"> Logs </h3>
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

                                    <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">

                                        <div class="custom-icon-table"><img src="assets/images/icons/sidebar/logs-white.png"></div>Activity Log
                                    </h2>
                                    <p class="text-muted m-b-30 font-14"></p>
                                    <input type="hidden" value="<?php echo $user_id; ?>" id="data-ud">
                                    <input type="hidden" value="<?php echo $user_id; ?>" id="data-id">
                                    <input type="hidden" value="<?php echo $country; ?>" id="data-country">
                                    <input type="hidden" value="<?php echo $role; ?>" id="data-role">
                                    <table id="dataTable" class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <thead>
                                            <tr>
                                                <!--<th class="no-sort"></th>-->
                                                <th>SN</th>
                                                <th>User Name</th>
                                                <th>User ID</th>
                                                <th>Section</th>
                                                <th>Activity</th>
                                                <th>Description</th>
                                                <th class="no-sort">Date</th>
                                                <th class="no-sort">Time</th>
                                                <th class="no-sort">User Details</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <!--<th class="no-sort"></th>-->
                                                <th>SN</th>
                                                <th>User Name</th>
                                                <th>User ID</th>
                                                <th>Section</th>
                                                <th>Activity</th>
                                                <th>Description</th>
                                                <th class="no-sort">Date</th>
                                                <th class="no-sort">Time</th>
                                                <th class="no-sort">User Details</th>
                                            </tr>
                                        </tfoot>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- Content  -->
        <footer class="footer">
            © 2021 Tespack - All rights reserved .
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
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>
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
    <script src="assets/js/notification.js"></script>
    <script>
        $(document).ready(function() {
            // $.ajax({

            //     url: 'https://jsonplaceholder.typicode.com/todos',
            //     dataType: 'json',
            //     success: function(data) {
            //         for (var i = 0; i < data.length; i++) {
            //             var row = $('<tr><td>' + data[i].userId + '</td><td>' + data[i].id + '</td><td>' + data[i].title + '</td><td>' + data[i].completed + '</td></tr>');
            //             $('#myTable').append(row);
            //         }
            //     },
            //     error: function(jqXHR, textStatus, errorThrown) {
            //         alert('Error: ' + textStatus + ' - ' + errorThrown);
            //     }
            // });

            var user_id = $("#data-id").val();
    loadNotification(user_id);

            var id = $('#data-id').val();
            // var table = $('#datatable').DataTable();
            $.ajax({
                url: `/assets/api/activity_log.php`,
                type: "PATCH",
                data: JSON.stringify({
                    user_id: id,
                    country: $('#data-country').val(),
                    role: $('#data-role').val()
                }),
                contentType: "application/json",
                dataType: 'json',
                success: function(data) {
                    $('#dataTable').DataTable({
                        data: data.ret_data,
                        columns: [{
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                data: 'full_name'
                            },
                            {
                                data: 'user_id'
                            },
                            {
                                data: 'section'
                            },
                            {
                                data: 'command'
                            },
                            {
                                data: 'description',
                                class: 'text-wrap'

                            },
                            {
                                data: 'date'
                            },
                            {
                                data: 'time'
                            },
                            {
                                data: 'ip'
                            }
                        ],
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }
            });



        });
    </script>

</body>

</html>