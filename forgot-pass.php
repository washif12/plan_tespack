<?php
session_start();
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
        
        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="assets/css/custom-reg.css" rel="stylesheet" type="text/css" />

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    </head>


    <body>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page-login">
            <div class="row">
                <div class="card login-holder col-xs-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="card-body">

                        <h1 class="text-center" style="margin-top: -100px;">
                            <a href="#" class="logo logo-admin"><img src="assets/images/plan-logo.png" height="150" alt="logo"></a>
                        </h1>

                        <h1 class="text-center text-white m-t-40" style="font-family: veneer !important;">
                            PASSWORD RESET
                        </h1>
                        <h3 class="text-center text-white m-t-40" style="font-family: veneer !important;">
                            Enter your Email and password reset instructions will be sent to you!
                        </h3>
                        <?php if(isset($_SESSION["message"])): ?>
                            <p class="text-center text-success"><b><?php echo $_SESSION["message"];session_destroy(); ?></p></b>
                            <?php endif ?>
                            <?php if(isset($_SESSION["error"])): ?>
                            <p class="text-center text-plan"><b><?php echo $_SESSION["error"];session_destroy(); ?></p></b>
                            <?php endif ?>

                        <div class="p-3">
                            <!--<h4 class="text-muted font-18 m-b-5 text-center">Free Register</h4>
                            <p class="text-muted text-center">Get your free account now.</p>-->

                            <form class="form-horizontal m-t-10 text-center" action="backend/pass_reset.php" method="post">
                                <div class="row" style="margin: auto;">
                                    <div class="form-group col-12 m-b-30" style="display: flex;">
                                        <i class="fa fa-user icon"></i>
                                        <input type="text" name="email" class="form-control" id="email" placeholder="Email" style="height: 50px;font-size: 20px;border-radius: 0px;">
                                    </div>
                                </div>

                                <div class="form-group row m-t-40">
                                    <div class="col-12 text-center">
                                        <button name="submit" class="btn btn-lg w-md waves-effect waves-light font-32" style="width: 50%;background-color: #f2c400;color: black;" type="submit"><b>SEND</b></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row m-t-20">
                <div class="card logo-holder col-xs-12 col-sm-10 col-md-10 col-lg-6 col-xl-5">
                    <div class="card-body">
                        <h5 class="text-center text-white">
                            POWERED BY
                        </h5>

                        <h1 class="text-center">
                            <a href="#" class="logo logo-admin"><img src="assets/images/tespack.png" height="55" alt="logo"></a>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <!--<script>
            $(document).ready(function() {
                function insertModalReset() {
                    window.location.reload();
                }
                $("#submit").click(function (event) {
                    var formData = {
                        email: $("#email").val(),
                        pass: $("#pass").val(),
                    };
                    console.log(formData);
                    $.ajax({
                        type: "POST",
                        //url: "assets/api/signup.php",
                        url: "api/signin.php",
                        data: formData
                    }).done(function (result) {
                        //var data = jQuery.parseJSON(result);
                        console.log(result);
                        if(result.success==0){
                            $("#errMsg").html('<i class="fa fa-times-circle"></i>'+result.message).show().delay(5000).hide("slow");
                        }
                    });
                });
            });
        </script>-->
    </body>
</html>