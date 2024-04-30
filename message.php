<?php
require __DIR__.'/assets/api/classes/database.php';
session_start();
?>

<!DOCTYPE html>
<html>
    <head>

        <!-- App title -->
        <title>Plan - International </title>
        
        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="assets/css/custom-reg.css" rel="stylesheet" type="text/css" />

    </head>


    <body>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="row">
                <div class="card" style="width:100%!important;min-height: 100%;background-color: #0072ce;opacity: 0.9;">
                    <div class="card-body">

                        <h1 class="text-center">
                            <a href="#" class="logo logo-admin"><img src="assets/images/plan-logo.png" height="100" alt="logo"></a>
                        </h1>

                        <div class="p-3">
                            <!--<h4 class="text-muted font-18 m-b-5 text-center">Free Register</h4>
                            <p class="text-muted text-center">Get your free account now.</p>-->
                            <div class="row">
                                <div class="col-12 text-center" style="width:60%;margin: auto;">
                                    <h4 class="text-center text-success">
                                        <i class="fa fa-check-circle"></i> You have successfully registered. Please verify your email to continue.
                                    </h4>
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

        <!-- App js -->
        <script src="assets/js/app.js"></script> 
    </body>
</html>