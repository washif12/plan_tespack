<?php
session_start();
require __DIR__ . '/../assets/api/classes/JwtHandler.php';
if(isset($_POST['submit'])){
    $jwt = new JwtHandler();
    $token_data = $jwt->jwtDecodeData($_SESSION['token']);

    $data_arr =  array(
        "id" => $_POST['id']    
    );

    $data = json_encode($data_arr);
    //$url = 'https://tespack-smb-map-services.appspot.com/api/logout.php';
    //$url = 'http://5.161.107.4/assets/api/logout.php';
    $url = 'https://tesinsight.com/assets/api/logout.php';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $res = curl_exec($ch);
    curl_close($ch);
    $resp = json_decode($res);
    //print_r ($resp);

    if($resp->success == 1){
        //session_unset();
        unset($_SESSION['token']);
    
        $data_arr =  array(
            "user_id" => $_POST['id'],
            "section" => "User",
            "command" => "Logged out",
            "user_trc_details" => $_POST["user_trc_details"],
            "description" => $token_data->data->name." logged out from the system"

        );
    
        $data = json_encode($data_arr);
        //$url = 'https://tespack-smb-map-services.appspot.com/api/logout.php';
        $url = 'https://tesinsight.com/assets/api/activity_log.php';
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $res = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($res);

        session_destroy();
        header('location:../login.php');
    }
    
    else if ($resp->success == 0) {
        
        $_SESSION['error'] = $resp->message;
        header('location:../stats.php');

    }
}

?>