<?php
session_start();
// $servername = "localhost";
// $username = "tespack";
// $password = "password";
// $dbname = "plan_tespack";
// Create connection
//$conn = new mysqli(null, $username, $password, $dbname, null, $servername);
//$conn = new mysqli($servername, $username, $password, $dbname);
require __DIR__.'/assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
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
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

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
        <div class="wrapper-page-login">
            <div class="row">
                <div class="card login-holder col-xs-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="card-body">

                        <h1 class="text-center" style="margin-top: -100px;">
                            <a href="login.php" class="logo logo-admin"><img src="assets/images/plan-logo.png" height="150" alt="logo"></a>
                        </h1>

                        <h1 class="text-center text-white m-t-40" style="font-family: veneer !important;">
                            PASSWORD RESET
                        </h1>
                        <?php
                        if (isset($_GET['token'])):
                            $token = $_GET['token'];
                            $sql = "SELECT * FROM password_reset WHERE token=:token LIMIT 1";
                            //$result = mysqli_query($conn, $sql);
                            //$user = mysqli_fetch_assoc($result);
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':token', $token);
                            $stmt->execute();
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            $email = $user['email'];
                            $now = time();
                            $verify_date = strtotime($user['created_at']);
                            $expired = $now - $verify_date;
                        
                            //if (mysqli_num_rows($result) > 0):
                            if ($stmt->rowCount() > 0):
                                if ( $expired<=3600 ):?>
                                    <h3 class="text-center text-white m-t-40" style="font-family: veneer !important;">
                                        Enter your New Password
                                    </h3>
                                    <div class="p-3 text-center">
                                        <p class="text-success font-16" style="color:#008037;" id="msgSuccess"></p>
                                        <p class="text-warning font-16" id="errMsg"></p>

                                        
                                        <div class="row" style="margin: auto;">
                                            <div class="form-group col-12 m-b-30" style="display: flex;">
                                                <i class="fa fa-user icon"></i>
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" style="height: 50px;font-size: 20px;border-radius: 0px;">
                                            </div>
                                        </div>
                                        <div class="row" style="margin: auto;">
                                            <div class="form-group col-12 m-b-30" style="display: flex;">
                                                <i class="fa fa-user icon"></i>
                                                <input type="password" name="confirm-pass" class="form-control" id="checkPass" placeholder="Confirm Password" style="height: 50px;font-size: 20px;border-radius: 0px;">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="email" id="email" style="display:none;" value='<?php echo $email;?>'>
                                        <div class="form-group row m-t-40">
                                            <div class="col-12 text-center">
                                                <button id="resetBtn" class="btn btn-lg w-md waves-effect waves-light font-32" style="width: 50%;background-color: #f2c400;color: black;" type="button"><b>RESET</b></button>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                elseif ($expired > 3600):?>
                                    <p class="text-center text-plan"><b>Your link has expired! Please send us your email again.</b></p>
                                    <div class="form-group m-t-20 row" style="margin:auto">
                                        <div class="col-12 text-center">
                                            <a href="forgot-pass.php" class="btn btn-warning font-18">Reset Password</a>
                                        </div>
                                    </div>
                                <?php endif;
                            else:?>
                                <p class="text-center text-plan"><b>You are using an Invalid Token! Try using a valid one.</b></p>
                                <div class="form-group m-t-20 row" style="margin:auto">
                                    <div class="col-12 text-center">
                                        <a href="forgot-pass.php" class="btn btn-warning font-18">Reset Password</a>
                                    </div>
                                </div>
                            <?php endif;
                        else:?>
                            <p class="text-center text-plan"><b>No Token Provided!</b></p>
                            <div class="form-group m-t-20 row" style="margin:auto">
                                <div class="col-12 text-center">
                                    <a href="forgot-pass.php" class="btn btn-warning font-18">Reset Password</a>
                                </div>
                            </div>
                        <?php endif;
                        ?>
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
                $("#resetBtn").click(function (event) {
                    var formData = {
                        email: $("#email").val(),
                        pass: $("#password").val(),
                        checkPass: $("#checkPass").val()
                    };
                    console.log(formData);

                    $.ajax({
                        type: "POST",
                        url: "assets/api/setPassword.php",
                        //url: "api/signup.php",
                        data: formData
                    }).done(function (result) {
                        //var data = jQuery.parseJSON(result);
                        console.log(result);
                        if(result.success==0){
                            $("#errMsg").html('<i class="fa fa-times-circle"></i>'+result.message).show().delay(5000).hide("slow");
                        }
                        else if(result.success==1){
                            $("#msgSuccess").html('<i class="fa fa-check-circle"></i>'+result.message+'<p>. You can </p><a href="login.php" class="text-warning font-18">Login</a>').show();
                            $("#password").val('');
                            $("#checkPass").val('');
                            //window.location.href='message.php';
                        }
                    });
                });
            });
        </script>
    </body>
</html>