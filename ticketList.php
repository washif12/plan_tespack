<?php
session_start();
require __DIR__ . '/assets/api/classes/database.php';
require __DIR__ . '/assets/api/classes/JwtHandler.php';
//$token = $_SESSION['token'];
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
                //$_SESSION['login_role'] = $role;
                if ($role == '0') :
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
                                <a href="ticketList.php" class="waves-effect active">
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
                    <h3 class="page-title"> Ticket List </h3>
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

                                    <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">

                                        <div class="custom-icon-table"><img src="assets/images/icons/sidebar/logs-white.png"></div>Ticket Support Inbox
                                    </h2>
                                    <p class="text-muted m-b-30 font-14"></p>
                                    <input type="hidden" value="<?php echo $user_id; ?>" id="data-id">
                                    <input type="hidden" value="<?php echo $country; ?>" id="data-country">
                                    <input type="hidden" value="<?php echo $role; ?>" id="data-role">
                                    <table id="dataTable" class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Project Name</th>
                                                <th>SSM Reference</th>
                                                <th>Country</th>
                                                <th>Responsible</th>
                                                <th>Subject</th>
                                                <th>Replacement</th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Project Name</th>
                                                <th>SSM Reference</th>
                                                <th>Country</th>
                                                <th>Responsible</th>
                                                <th>Subject</th>
                                                <th>Replacement</th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>
                                                <!-- <th>ID</th>
                                            <th>Replacement</th>
                                            <th>Quantity</th>
                                            <th>Reference</th>
                                            <th>Country</th>
                                            <th>Project</th>
                                            <th>Responsible</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Attachment</th> -->
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
            © 2021 Tespack - All rights reserved.
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
                        <div class="col-12">
                            <h5 class="text-center text-danger" id="errMsg"></h5>
                            <h5 class="text-center text-success" id="msgSuccess"></h5>
                        </div>
                        <div class="col-12">
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3 text-plan"><b>Subject</b></div>
                                <div class="col-9 text-plan" id="subject"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3 text-plan"><b>Project</b></div>
                                <div class="col-3 text-plan" id="project_name"></div>
                                <div class="col-3 text-plan"><b>Country</b></div>
                                <div class="col-3 text-plan" id="country_pro"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3 text-plan"><b>SSM Reference</b></div>
                                <div class="col-3 text-plan" id="ref_no"></div>
                                <div class="col-3 text-plan"><b>SSM Responsible</b></div>
                                <div class="col-3 text-plan" id="ssm_resp"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3 text-plan"><b>Phone</b></div>
                                <div class="col-3 text-plan" id="contact_no"></div>
                                <div class="col-3 text-plan"><b>Email</b></div>
                                <div class="col-3 text-plan" id="resp_email"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-3 text-plan"><b>Replacement</b></div>
                                <div class="col-3 text-plan" id="replace_item"></div>
                                <div class="col-3 text-plan"><b>quantity</b></div>
                                <div class="col-3 text-plan" id="replace_count"></div>
                            </div>
                        </div>
                        <div class="col-12 info-view">
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-6 text-plan">
                                    <h5 class="text-plan">Message</h5>
                                </div>
                                <div class="col-6 text-plan">
                                    <h5 class="text-plan">Attachments</h5>
                                </div>
                                <div class="col-6 text-plan" id="notes"></div>
                                <div class="col-6">
                                    <div class="row" id="attach">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer info-footer">
                    <button type="button" class="btn btn-secondary info-cancel">Cancel</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- view modal -->
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

            // var table = $('#datatable').DataTable();
            /* Function to load tickets */
            const setTicketDataInTable = (id) => {
                $.ajax({
                    url: `/assets/api/ticket_support_data.php?user_id=${id}&limit=200`,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        $('#dataTable').DataTable({
                            order: [
                                [0, 'desc']
                            ],
                            data: data.ret_data,
                            columns: [
                                /*{
                                                                    render: function(data, type, row, meta) {
                                                                        return meta.row + meta.settings._iDisplayStart + 1;
                                                                    }
                                                                },*/
                                {
                                    data: 'id'
                                },
                                {
                                    data: 'project'
                                },
                                {
                                    data: 'ref'
                                },
                                {
                                    data: 'country'
                                },
                                {
                                    data: 'responsible'
                                },
                                {
                                    data: 'subject'
                                },
                                {
                                    data: 'replacement',
                                    render: function(data, type, row, meta) {
                                        if (data == '') {
                                            return 'Not Requested'
                                        } else {
                                            return data;
                                        }
                                    }
                                },
                                {
                                    data: 'id',
                                    render: function(data, type, row, meta) {
                                        return '<a id="view_' + data + '" type="button" class="btn btn-plan view_btn text-white">Details</a>'
                                        //return '<img src="'+data+'" class="rounded-circle">';
                                    }
                                },
                                {
                                    data: 'resolved',
                                    render: function(data, type, row, meta) {
                                        if (data == 0) {
                                            return '<a id="reset_' + row.id + '" type="button" class="btn btn-plan reset_btn text-white">Resolve</a>'
                                        } else {
                                            return '<span class="badge badge-success font-16">Resolved</span>'
                                        }
                                    }
                                }

                            ],

                        });


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }
            setTicketDataInTable(user_id);
            /* Info Button cliuck show details */
            $(document).on('click', '.view_btn', function() {
                $("#attach").html('');
                $("#errMsg").text('');
                $("#msgSuccess").text('');
                $("#viewModal").modal("show");
                var viewId = $(this).attr("id").split("_")[1];
                //console.log(viewId);
                $.ajax({
                    type: "POST",
                    url: "backend/admin/ticketList.php",
                    data: {
                        id: viewId
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        console.log(data);
                        if (data.success == '1') {
                            $("#viewHeader").text('Ticket from ' + data.responsible + ' of project ' + data.project + ' in ' + data.country);
                            $("#ref_no").text(data.ref);
                            $("#subject").text(data.subject);
                            $("#contact_no").text(data.phone);
                            $("#resp_email").text(data.email);
                            $("#country_pro").text(data.country);
                            $("#ssm_resp").text(data.responsible);
                            $("#project_name").text(data.project);
                            $("#notes").text(data.message);
                            if (data.replacement == '') {
                                $("#replace_item").text('No replacement requested');
                                $("#replace_count").text('-');
                            } else {
                                $("#replace_item").text(data.replacement);
                                $("#replace_count").text(data.quantity);
                            }
                            if (data.image_path == '') {
                                $("#attach").append(`<p class="text-center text-danger" style="padding-left:15px">No Attachments</p>`);
                            } else {
                                $("#attach").append(`<div class="col-6">
                                    <img class="mr-2" alt="200x200" style="width:100px;margin-bottom: 10px;" src="` + data.image_path + `">
                                    </div>`);
                            }
                            if (data.resolved == '1') {
                                $("#msgSuccess").text('This issue is already resolved.');
                            } else {
                                $("#errMsg").text('This issue is not yet resolved.');
                            }
                        } else {
                            $("#errMsg").text('Sorry there is an error. Please try again later.').show().delay(10000).hide("slow");
                        }
                    },
                    error: function(err) {
                        //console.log(err);
                        $("#errMsg").text('Sorry there is an error. Please try again later.').show().delay(10000).hide("slow");
                    }
                });
            });
            $(document).on('click', '.reset_btn', function() {
                var tktId = $(this).attr("id").split("_")[1];
                console.log(tktId);
                $.ajax({
                    type: "POST",
                    url: "backend/admin/ticketResolve.php",
                    data: {
                        id: tktId
                    },
                    success: function(result) {
                        var data = jQuery.parseJSON(result);
                        console.log(data);
                        if (data.success == '1') {
                            //setTicketDataInTable(users_id);
                            location.reload();
                        } else {

                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

        });
    </script>

</body>

</html>