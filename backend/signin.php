<?php

ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
session_start();
require __DIR__.'/../assets/api/classes/JwtHandler.php';

if(isset($_POST['submit'])){ 
    $data_array =  array(
      "email" => $_POST['email'],
      "password" => $_POST['password']      
    );

    // var_dump($data_arr);
    // exit();
    /*$data_array =  array(
        "smb_id" => 'SMB',
        "key" => 'SMB',
        "lat" => 'SMB',
        "lng" => 'SMB',
        "alt" => 'SMB',
        "speed" => 'SMB', 
        "course" => 'SMB'   
      );*/
    $token_trc = $_POST['user_trc_details'];
    $data = json_encode($data_array);
    //$url = 'http://5.161.107.4/assets/api/signin.php';
    //$url = 'https://tespack-smb-map-services.appspot.com/api/signin.php';
    //$url = 'http://5.161.107.4/assets/api/smbData.php';
    $url = 'https://tesinsight.com/assets/api/signin.php';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($result);
    //print_r ($response);

    if($response->success == 1){
        $_SESSION['login'] = $response->message;
        $_SESSION['token'] = $response->token;


        $jwt = new JwtHandler();
        $token_data = $jwt->jwtDecodeData($_SESSION['token']);
        // var_dump($token_data);
        $user_id = $token_data->data->user_id; 
        $data_arr =  array(
          "user_id" =>  $user_id,
          "section" => "User",
          "command" => "logged in",
          "user_trc_details" => $token_trc,
          "description" => $token_data->data->name. " logged in the system"

      );
      //print_r($data_arr);
      $data = json_encode($data_arr);
        $url = 'https://tesinsight.com/assets/api/activity_log.php';
        // $url = 'https://tesinsight.com/assets/api/signin.php';
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
        var_dump($resp);

        header('location:../stats.php');
    }
    
    else if ($response->success == 0) {
        
        $_SESSION['error'] = $response->message;
        header('location:../login.php');
    }
}
