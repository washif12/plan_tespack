<?php
session_start();

if(isset($_POST['submit'])){ 
    $data_array =  array(
      "email" => $_POST['email']      
    );

    $data = json_encode($data_array);
    //$url = 'https://tespack-smb-map-services.appspot.com/api/pass_reset.php';
    //$url = 'http://5.161.107.4/assets/api/emailInvite/pass_reset.php';
    $url = 'https://tesinsight.com/assets/api/emailInvite/pass_reset.php';
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
    //print_r ($response->success);

    if($response->success == 1){
        $_SESSION['message'] = $response->message;
        header('location:../forgot-pass.php');
    }
    
    else if ($response->success == 0) {
        
        $_SESSION['error'] = $response->message;
        header('location:../forgot-pass.php');
    }
}

?>