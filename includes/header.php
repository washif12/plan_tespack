<?php
session_start();
require __DIR__ . '/../assets/api/classes/database.php';
require __DIR__ . '/../assets/api/classes/JwtHandler.php';
//$token = $_SESSION['token'];
//if(isset($_SESSION['token'])) {
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
                $fullName = $fname.' '.$lname;
                $phone = $data["phone"];
                $address = $data["address"];
                $country = $data["country"];
                $email = $data["email"];
                $role = $data["role"];
                $image_path = $data["image_path"];
                $_SESSION['login_role'] = $role;
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