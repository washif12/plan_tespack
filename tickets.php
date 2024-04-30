<?php include_once('includes/header.php'); ?>
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
                            <a href="tickets.php" class="waves-effect active">
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
                    <h3 class="page-title">Ticket Support </h3>
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
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" id="user_trc_details" value="<?php echo $db_connection::get_user_track_details() ?>">
                                            <h2 class="mt-0 text-white bg-plan text-center m-b-30 " style="padding-bottom: 20px;padding-top: 20px;border-top-left-radius: 150px;border-top-right-radius: 150px;">
                                                <div class="custom-icon-table"><img src="assets/images/icons/sidebar/ticket-support-white.png"></div>Ticket Support
                                            </h2>
                                            <p class="text-plan m-b-30 font-14 text-center"><b>Note: </b>If you wish to request technical support or encounter an issue with yous SMB, please provide us you SSM reference number.<br>
                                            <b>All the fields (except the attachment) need to be filled in order to successfully send us Support Requests.</b></p>
                                            <p class="text-center text-danger errMsg"></p>
                                            <p class="text-center text-success msgSuccess"></p>
                                        </div>
                                        <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-xl-6" style="margin: auto;width: 100%;">
                                            <div class="row">
                                                <!-- <div class="col-2 text-left"><h6>Subject*</h6></div> -->
                                                <div class="form-group col-12 m-b-30">
                                                    <input type="text" class="form-control" id="subject" placeholder="Subject (Required)" required>
                                                </div>
                                            </div>
                                                <input type="hidden" value="<?php echo $user_id; ?>" id="data-id">
                                                <input type="hidden" value="<?php echo $fullName; ?>" id="data-name">
                                                <input type="hidden" value="<?php echo $user_id; ?>" id="data-ud">
                                            <div class="row">
                                                <div class="form-group col-6 m-b-30">
                                                    <?php if ($role == '3'||$role == '2'||$role == '4') : ?>
                                                        <select class="form-control dependentSelect" id="country" readonly disabled>
                                                            <option selected disabled value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                                        </select>
                                                    <?php else : ?>
                                                        <select class="form-control dependentSelect" id="country">
                                                            <option selected disabled>Country (Required)</option>
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
                                                <div class="form-group col-6">
                                                    <select class="form-control dependentSelect" id="project" required>
                                                        <option selected disabled>Project (Required)</option>
                                                        <?php
                                                        $project = "SELECT * FROM projects";
                                                        $project_stmt = $conn->prepare($project);
                                                        $project_stmt->execute();

                                                        if ($project_stmt->rowCount()) :
                                                            while ($data_project = $project_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                <option value="<?php echo $data_project["id"]; ?>">
                                                                    <?php echo $data_project["name"]; ?></option><?php
                                                                                                                }
                                                                                                            else :
                                                                                                                echo "Sorry! No Projects Found.";

                                                                                                            endif;
                                                                                                                    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-12 m-b-30">
                                                    <!-- <input type="text" class="form-control" id="ref" placeholder="SSM Reference Number" required> -->
                                                    <?php if ($role == '1') : ?>
                                                        <select class="form-control" id="ref">
                                                            <option selected disabled>SSM Reference Number (Required)</option>
                                                            <?php
                                                            $ssm = "SELECT * FROM devices";
                                                            $ssm_stmt = $conn->prepare($ssm);
                                                            $ssm_stmt->execute();

                                                            if ($ssm_stmt->rowCount()) :
                                                                while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                    <option value="<?php echo $data_ssm["ref"]; ?>">
                                                                        <?php echo $data_ssm["ref"]; ?></option><?php
                                                                                                            }
                                                                                                        else :
                                                                                                            echo "Sorry! SSM Found.";

                                                                                                        endif;
                                                                                                                ?>
                                                        </select>
                                                        <?php elseif ($role == '3') : ?>
                                                        <select class="form-control" id="ref">
                                                            <option selected disabled>SSM Reference Number (Required)</option>
                                                            <?php
                                                            $ssm = "SELECT * FROM devices WHERE country=:country";
                                                            $ssm_stmt = $conn->prepare($ssm);
                                                            $ssm_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                                                            $ssm_stmt->execute();

                                                            if ($ssm_stmt->rowCount()) :
                                                                while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                    <option value="<?php echo $data_ssm["ref"]; ?>">
                                                                        <?php echo $data_ssm["ref"]; ?></option><?php
                                                                                                            }
                                                                                                        else :
                                                                                                            echo "Sorry! No SSM Found.";

                                                                                                        endif;
                                                                                                                ?>
                                                        </select>
                                                        <?php elseif ($role == '2') : ?>
                                                        <select class="form-control" id="ref">
                                                            <option selected disabled>SSM Reference Number (Required)</option>
                                                            <?php
                                                            $ssm = "SELECT a.* FROM devices as a left join project_managers as b on a.team_id=b.team_id WHERE b.reg_id=:login_id";
                                                            $ssm_stmt = $conn->prepare($ssm);
                                                            $ssm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
                                                            $ssm_stmt->execute();

                                                            if ($ssm_stmt->rowCount()) :
                                                                while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                    <option value="<?php echo $data_ssm["ref"]; ?>">
                                                                        <?php echo $data_ssm["ref"]; ?></option><?php
                                                                                                            }
                                                                                                        else :
                                                                                                            echo "Sorry! No SSM Found.";

                                                                                                        endif;
                                                                                                                ?>
                                                        </select>
                                                        <?php elseif ($role == '4') : ?>
                                                        <select class="form-control" id="ref">
                                                            <option selected disabled>SSM Reference Number (Required)</option>
                                                            <?php
                                                            $ssm = "SELECT a.* FROM devices as a left join team_members as b on a.team_id=b.team_id WHERE b.reg_id=:login_id";
                                                            $ssm_stmt = $conn->prepare($ssm);
                                                            $ssm_stmt->bindValue(':login_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
                                                            $ssm_stmt->execute();

                                                            if ($ssm_stmt->rowCount()) :
                                                                while ($data_ssm = $ssm_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                    <option value="<?php echo $data_ssm["ref"]; ?>">
                                                                        <?php echo $data_ssm["ref"]; ?></option><?php
                                                                                                            }
                                                                                                        else :
                                                                                                            echo "Sorry! No SSM Found.";

                                                                                                        endif;
                                                                                                                ?>
                                                        </select>
                                                        <?php endif; ?>
                                                </div>
                                            </div>

                                            <!--<div class="row">
                                                                <div class="form-group col-12 m-b-30">
                                                                    <input type="email" class="form-control" id="useremail" placeholder="Email">
                                                                </div>
                                                            </div>-->

                                            <div class="row">
                                                <div class="form-group col-6 m-b-30">
                                                    <input type="email" class="form-control" id="cc" placeholder="CC (Required)" required>
                                                </div>
                                                <div class="form-group col-6">
                                                    <input type="email" class="form-control" id="bcc" placeholder="BCC (Required)" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-12 m-b-30">
                                                    <!--<input type="file" class="filestyle" id="attach" data-buttonname="btn-plan">-->
                                                    <form action="assets/api/emailInvite/ticketSupport.php" class="dropzone">
                                                        <div class="dz-message needsclick">
                                                            Drop files here or click to upload
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-12 m-b-30">
                                                    <textarea required class="form-control" rows="5" id="message" placeholder="Write your message (Required)"></textarea>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h6>Would you like to place an order or request any replacements? (Required)</h6>
                                                </div>
                                                <label for="radioYes" class="col-3 font-16 col-form-label">Yes</label>
                                                <div class="form-group col-3 m-b-30">
                                                    <input type="radio" class="form-control" id="radioYes" value="1" name="confirm" style="width:20px;">
                                                </div>
                                                <label for="radioNo" class="col-3 font-16 col-form-label">No</label>
                                                <div class="form-group col-3">
                                                    <input type="radio" class="form-control" id="radioNo" value="2" name="confirm" style="width:20px;">
                                                </div>
                                            </div>

                                            <div class="row replace-part">
                                                <div class="form-group col-6 m-b-30">
                                                    <select class="form-control" id="product" required>
                                                        <option value="" selected disabled>Product</option>
                                                        <option>Power Bank</option>
                                                        <option>Solar Panel</option>
                                                        <option>Portable Projector Screen</option>
                                                        <option>Projector</option>
                                                        <option>Tesloop cable ( Joins Solar Panels)</option>
                                                        <option>HDMI Cable</option>
                                                        <option>SD Memory Card 16GB</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <input class="form-control" type="number" id="quantity" min="1" max="9" placeholder="Quantity" required/>
                                                </div>
                                            </div>

                                            <div class="form-group row m-t-40">
                                                <div class="col-12 text-center">
                                                    <button class="btn btn-lg w-md waves-effect waves-light font-32 send_btn" style="width: 30%;background-color: #ee008b;color: white;"><b>SEND</b></button>
                                                </div>
                                            </div>
                                            <div class="form-group row m-t-40">
                                                <div class="col-12 text-center">
                                                    <p class="text-center text-danger errMsg"></p>
                                                    <p class="text-center text-success msgSuccess"></p>
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

    <script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- Dropzone js -->
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <!-- Profile js -->
    <script src="assets/js/common/profile.js"></script>
    <script src="assets/js/notification.js"></script>
    <script>
        /* Dropzone handle */
        Dropzone.autoDiscover = false;
        var replaceVal;
        var formInput = new FormData();
        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: false,
            acceptedFiles: ".png,.jpg,.jpeg,.pdf,.docx,.doc",
            maxFiles: 1,
            maxFilesize: 5,
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("error", function(file, message, xhr) {
                    //if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
                });
    
                this.on('sending', function(file, xhr, formData) {
                    /*$("#eventInfo").find("input").each(function(){
                        formData.append($(this).attr("name"), $(this).val());
                    });*/
                    $("#overlay-loader").fadeIn(300);
                    formData.append('sub', $("#subject").val());
                    formData.append('cc', $("#cc").val());
                    formData.append('bcc', $("#bcc").val());
                    formData.append('country', $("#country").val());
                    formData.append('project', $("#project").val());
                    formData.append('msg', $("#message").val());
                    formData.append('ref', $("#ref").val());
                    formData.append('product', $("#product").val());
                    formData.append('quantity', $("#quantity").val());
                    formData.append('replace', replaceVal);
                    formData.append('user_id', $("#data-id").val());

                });
                this.on("success", function(file, responseText) {
                    var result = JSON.parse(responseText);
                    console.log(responseText)

                    if (result.success == 0) {
                        $("#overlay-loader").fadeOut(300);
                        this.removeAllFiles();
                        this.addFile(file);
                        $(".errMsg").html('<i class="fa fa-times-circle"></i>' + result.message).show().delay(20000).hide("slow");
                    } else if (result.success == 1) {

                        //start Activity

                        var formData = {
                            user_id: $("#data-id").val(),
                            section: 'Ticket Support',
                            command: 'Requested',
                            user_trc_details: document.getElementById("user_trc_details").value,
                            description: `${$("#data-name").val()} requested for support. <br>Subject : ${$("#subject").val()} ${replaceVal == 1 ?  `and requested for replacement` :""}`
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
                        //myDropzone.removeFile(file);
                        this.removeAllFiles();
                        $("#subject").val('');
                        $("#cc").val('');
                        $("#bcc").val('');
                        $("#country").val('');
                        $('#country').prop('selectedIndex', 0);
                        $("#message").val('');
                        $("#project").val('');
                        $('#project').prop('selectedIndex', 0);
                        $('input[type=radio]').attr("checked", false);
                        $(".replace-part").hide(1000);
                        replaceVal = '';
                        $("#ref").val('');
                        
                        $(".msgSuccess").html('<i class="fa fa-check-circle"></i>' + result.message).show().delay(10000).hide("slow");
                    }
                });
            }
        });
        $(document).ready(function() {
            var user_id = $("#data-id").val();
            loadNotification(user_id);
            /* radio button */
            $(".replace-part").hide();
            $('input[type="radio"]').click(function() {
                replaceVal = $(this).val();
                if (replaceVal == 1) {
                    $(".replace-part").show(1000);
                } else {
                    $(".replace-part").hide(1000);
                    $("#quantity").val('');
                    $("#product").val('');
                    $('#product').prop('selectedIndex', 0);
                }
            });
            /* Form Handling */
            $(document).ajaxSend(function() {
                $("#overlay-loader").fadeIn(300);
            });
            $(document).ajaxStop(function() {
                $("#overlay-loader").fadeOut(300);
            });

            function insertModalReset() {
                window.location.reload();
            }
            $(".send_btn").click(function(event) {
                $("#overlay-loader").fadeIn(300);
                //myDropzone.processQueue();
                if (myDropzone.getQueuedFiles().length > 0) {
                    myDropzone.processQueue();
                } else {
                    var formInput = {
                        sub: $("#subject").val(),
                        cc: $("#cc").val(),
                        bcc: $("#bcc").val(),
                        country: $("#country").val(),
                        msg: $("#message").val(),
                        project: $("#project").val(),
                        product: $("#product").val(),
                        quantity: $("#quantity").val(),
                        ref: $("#ref").val(),
                        user_id: $("#data-id").val(),
                        replace: replaceVal
                    };
                    console.log(formInput);

                    $.ajax({
                        type: "POST",
                        url: "/assets/api/emailInvite/ticketSupport.php",
                        data: formInput
                    }).done(function(data) {
                        $("#overlay-loader").fadeOut(300);
                        var result = JSON.parse(data);
                        console.log(result);

                        if (result.success == 0) {
                            $(".errMsg").html('<i class="fa fa-times-circle"></i>' + result.message).show().delay(20000).hide("slow");
                        } else if (result.success == 1) {

                            //start Activity

                            var formData = {
                                user_id: $("#data-id").val(),
                                section: 'Ticket Support',
                                command: 'Requested',
                                user_trc_details: document.getElementById("user_trc_details").value,
                                description: `${$("#data-name").val()} requested for support. <br>Subject : ${formInput.sub} ${formInput.replace == 1 ?  `and requested for replacement` :""}`
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
                            $("#subject").val('');
                            $("#cc").val('');
                            $("#bcc").val('');
                            $("#country").val('');
                            $('#country').prop('selectedIndex', 0);
                            $("#message").val('');
                            $("#project").val('');
                            $('#project').prop('selectedIndex', 0);
                            $('input[type=radio]').attr("checked", false);
                            $(".replace-part").hide(1000);
                            replaceVal = '';
                            $("#ref").val('');
                            $(".msgSuccess").html('<i class="fa fa-check-circle"></i>' + result.message).show().delay(5000).hide("slow");
                        }
                    });
                }
                /*var formInput = {
                    file: $("#attach").val(),
                    sub: $("#subject").val(),
                    cc: $("#cc").val(),
                    bcc: $("#bcc").val(),
                    country: $("#country").val(),
                    msg: $("#message").val(),
                    project: $("#project").val(),
                    product: $("#product").val(),
                    quantity: $("#quantity").val(),
                    ref: $("#ref").val(),
                    replace: replaceVal
                };

                $.ajax({
                    type: "POST",
                    url: "assets/api/emailInvite/ticketSupport.php",
                    data: formData
                }).done(function (result) {
                    console.log(result);
                    if(result.success==0){
                        $("#errMsg").html('<i class="fa fa-times-circle"></i>'+result.message).show().delay(5000).hide("slow");
                    }
                    else if(result.success==1){
                        $("#msgSuccess").html('<i class="fa fa-check-circle"></i>'+data.message).show().delay(5000).hide("slow");
                    }
                });*/
            });
            /* Changing dropdowns on select */
            var arr = {
                'country': '',
                'project': ''
            }
            // $(document).on('change', '.dependentSelect', function() {
            //     if ($(this).attr("id") == 'country') {
            //         arr.country = $(this).val();
            //     } else if ($(this).attr("id") == 'project') {
            //         arr.project = $(this).val();
            //     }
            //     console.log(arr);
            //     $.ajax({
            //         type: "POST",
            //         url: "backend/others/selectData.php",
            //         data: arr,
            //         success: function(result) {
            //             var data = jQuery.parseJSON(result);
            //             console.log(data);
            //             if (data.success == 1) {
            //                 if (data.projects.length > 0) {
            //                     $('#project').find('option').not(':first').remove();
            //                     jQuery.each(data.projects, function(index, item) {
            //                         $('#project').append($('<option/>', {
            //                             value: item.id,
            //                             text: item.name
            //                         }));
            //                     });
            //                 } else if (data.projects.length == 0) {
            //                     $('#project').find('option').not(':first').remove();
            //                     $('#project').append('<option disabled>No Data Found</option>');
            //                 }
            //             } else if (data.success == 2) {
            //                 $('#country').find('option').not(':first').remove();
            //                 $('#country').append($('<option/>', {
            //                     value: data.countries[0].country,
            //                     text: data.countries[0].country
            //                 }));
            //             }
            //         }
            //     });
            // });
        });
    </script>

</body>

</html>