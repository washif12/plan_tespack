<?php
require __DIR__.'/assets/api/classes/database.php';
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />-->

        <!-- App Icons 
        <link rel="shortcut icon" href="assets/images/favicon.ico">-->

        <!-- App title -->
        <title>Plan - International </title>
        
        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="assets/css/custom-reg.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

    </head>


    <body>
        <div id="overlay-loader">
            <div class="cv-spinner">
                <!--<span class="spinner-new"></span>-->
                <img class="spinner-img" src="assets/images/tespack-logo.png">
                <p class="loading-text font-16" style="color:#ffcc05;font-weight:500;">Please Wait</p>
            </div>
        </div>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="row">
                <div class="card form-holder">
                    <div class="card-body">

                        <h1 class="text-center">
                            <a href="#" class="logo logo-admin"><img src="assets/images/plan-logo.png" height="100" alt="logo"></a>
                        </h1>

                        <div class="p-3">
                            <!--<h4 class="text-muted font-18 m-b-5 text-center">Free Register</h4>
                            <p class="text-muted text-center">Get your free account now.</p>-->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <img src="assets/images/default.jpg" alt="user-image" class="rounded-circle" style="width: 300px;height: 300px;display: block;margin: auto;"/>
                                    <div class="overlay text-center">
                                        <a href="#" class="text-dark font-20" style="top: 35%;left:40%;position: absolute;">
                                            <!--<img src="assets/images/camera.png">&nbsp; <b>Take Photo</b>-->
                                        </a>
                                        <a href="#" class="text-dark font-20" style="top: 50%;left:40%;position: absolute;">
                                            <!--<img src="assets/images/browse.png">&nbsp; <b>Browse</b>-->
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center text-white">
                            POWERED BY
                        </h5>

                        <h1 class="text-center">
                            <a href="#" class="logo logo-admin"><img src="assets/images/tespack.png" height="55" alt="logo"></a>
                        </h1>

                    </div>
                </div>
                <div class="card img-holder">
                    <?php if (isset($_GET['role']) && isset($_GET['name']) && isset($_GET['email'])):
                        $email = $_GET['email'];
                        $db_connection = new Database();
                        $conn = $db_connection->dbConnection();
                        $check_email = "SELECT email FROM users WHERE email=:email";
                        $check_email_stmt = $conn->prepare($check_email);
                        $check_email_stmt->bindValue(':email', $email,PDO::PARAM_STR);
                        $check_email_stmt->execute();
            
                        if($check_email_stmt->rowCount()):?>
                        <div class="" style="margin:auto;width:80%;">
                            <h1 class="text-center text-danger">
                            <i class="fa fa-times-circle"></i> Sorry! This link is already used, You can not use this anymore.
                            </h1>
                        </div>
                        <?php else:
                            $check_invite_email = "SELECT email FROM invited_emails WHERE email=:email";
                            $check_invite_email_stmt = $conn->prepare($check_invite_email);
                            $check_invite_email_stmt->bindValue(':email', $email,PDO::PARAM_STR);
                            $check_invite_email_stmt->execute();
                            if($check_invite_email_stmt->rowCount()):
                                $invite_email = "SELECT * FROM invited_emails WHERE email=:email ORDER BY id DESC LIMIT 1";
                                $invite_email_stmt = $conn->prepare($invite_email);
                                $invite_email_stmt->bindValue(':email', $email,PDO::PARAM_STR);
                                $invite_email_stmt->execute();
        
                                $result = $invite_email_stmt->fetch(PDO::FETCH_ASSOC);
                                $now = time();
                                $verify_date = strtotime($result['invited_at']);
                                $expired = $now - $verify_date;
                
                                if($expired<=7200):?>
                                <div class="card-body">

                                    <h1 class="text-center m-t-40">
                                        SSM REGISTRATION
                                    </h1>
                                    <h4 class="text-center">Hello <?php echo $_GET["name"];?> , You are registering as <?php echo $_GET["role"];?></h4>

                                    <div class="p-3">
                                        <p class="font-16" style="color:#008037;" id="msgSuccess"></p>
                                        <p class="text-danger font-16" id="errMsg"></p>
                                        <!--<h4 class="text-muted font-18 m-b-5 text-center">Free Register</h4>
                                        <p class="text-muted text-center">Get your free account now.</p>-->

                                        <!--<form method="POST" action="backend/signup.php" class="form-horizontal m-t-30">-->
                                            <div class="row">
                                                <div class="form-group col-6 m-b-30">
                                                    <input type="text" class="form-control" name="fName" id="fname" placeholder="First Name" required>
                                                </div>
                                                <div class="form-group col-6">
                                                    <input type="text" class="form-control" name="lName" id="lname" placeholder="Last Name" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6 m-b-30">
                                                    <input type="text" class="form-control" value='<?php echo $_GET["email"];?>' id="email" readonly>
                                                </div>
                                                <div class="form-group col-6">
                                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6 m-b-30">
                                                    <textarea type="text" class="form-control" name="address" id="address" placeholder="Address" required></textarea>
                                                </div>
                                                <div class="form-group col-6">
                                                    <!--<select id="country" class="form-control crs-country"></select>-->
                                                    <select id="country" class="form-control" required>
                                                        <option selected disabled>Country</option>
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
                                                </div>
                                                <input type="text" class="form-control" id="role" style="display:none;" value='<?php echo $_GET["role"];?>'>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6 m-b-30">
                                                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" required>
                                                </div>
                                                <div class="form-group col-6">
                                                    <input type="password" class="form-control" name="checkPass" id="checkPass" placeholder="Confirm Password" required>
                                                </div>
                                            </div>

                                            <div class="form-group row m-t-40">
                                                <div class="col-12 text-center">
                                                    <button id="regBtn" type="button" class="btn btn-lg w-md font-32" style="width: 50%;background-color: #ee008b;color: white;"><b>Register</b></button>
                                                </div>
                                            </div>

                                            <!--<div class="form-group m-t-10 mb-0 row">
                                                <div class="col-12 m-t-20">
                                                    <p class="font-14 text-muted mb-0">By registering you agree to the <a href="#">Terms of Use</a></p>
                                                </div>
                                            </div>-->
                                    </div>

                                </div>
                                <?php else: ?>
                                    <div class="" style="margin:auto;width:80%;">
                                        <h1 class="text-center text-danger">
                                        <i class="fa fa-times-circle"></i> Sorry! You can not use this link, Your link has expired.
                                        </h1>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="" style="margin:auto;width:80%;">
                                    <h1 class="text-center text-danger">
                                    <i class="fa fa-times-circle"></i> Sorry! You are trying an old invitation link, it no longer exists.
                                    </h1>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="" style="margin:auto;width:80%;">
                            <h1 class="text-center text-danger" style="margin:auto;">
                            <i class="fa fa-times-circle"></i> Sorry! You do not have access to Register in this Platform.
                            </h1>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!--<div class="m-t-40 text-center">
                <p>Already have an account ? <a href="pages-login.php" class="font-500 font-14 text-primary font-secondary"> Login </a> </p>
                <p>© 2018 Tespack. Crafted with <i class="mdi mdi-heart text-danger"></i> by Washif</p>
            </div>-->
        </div>
        <!-- jQuery -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/plugins/country-region-selector/dist/crs.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script> 
        <script>
            $(document).ready(function() {
                /* Ajax Loader */
                $(document).ajaxSend(function() {
                    $("#overlay-loader").fadeIn(300);
                });
                $(document).ajaxStop(function() {
                    $("#overlay-loader").fadeOut(300);
                });
                function insertModalReset() {
                    window.location.reload();
                }
                $("#regBtn").click(function (event) {
                    var formData = {
                        fname: $("#fname").val(),
                        lname: $("#lname").val(),
                        email: $("#email").val(),
                        phone: $("#phone").val(),
                        country: $("#country").val(),
                        address: $("#address").val(),
                        role: $("#role").val(),
                        pass: $("#pass").val(),
                        checkPass: $("#checkPass").val()
                    };
                    console.log(formData);

                    $.ajax({
                        type: "POST",
                        url: "assets/api/signup.php",
                        //url: "api/signup.php",
                        data: formData
                    }).done(function (result) {
                        //var data = jQuery.parseJSON(result);
                        console.log(result);
                        if(result.success==0){
                            $("#errMsg").html('<i class="fa fa-times-circle"></i>'+result.message).show().delay(5000).hide("slow");
                        }
                        else if(result.success==1){
                            /*$("#msgSuccess").html('<i class="fa fa-check-circle"></i>'+result.message).show().delay(5000).hide("slow");
                            $("#fname").val('');
                            $("#lname").val('');
                            $("#phone").val('');
                            $("#country").val('');
                            $("#address").val('');
                            $("#pass").val('');
                            $("#checkPass").val('');
                            $("#email").val('');
                            $("#role").val('');*/
                            window.location.href='message.php';
                        }
                    });
                });
            });
        </script>
    </body>
</html>