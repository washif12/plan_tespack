<?php
session_start();

if(isset($_POST['submit'])){
    $data_array =  array(
      "fname" => $_POST['fName'],
      "lname" => $_POST['lName'],
      "email" => $_POST['usermail'],
      "phone" => $_POST['phone'],
      "address" => $_POST['address'],
      "country" => $_POST['country'],
      "role" => $_POST['role'],
      "pass" => $_POST['pass'],
      "checkPass" => $_POST['checkPass']      
    );

    $data = json_encode($data_array);
    
    $url = 'http://5.161.107.4/assets/api/signup.php';
    //$url = 'https://tespack-smb-map-services.appspot.com/api/signup.php';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($result);
    print_r ($response);

    if($response->success == 1){
        $_SESSION['message'] = $response->message;
        //header('location:index.php');
        header('Location:../register.php');
    }
    
    else if ($response->success == 0) {
        
        $_SESSION['error'] = $response->message;
        header('Location:../register.php');
    }
}
/*
{
    "fname":"Washif",
    "lname":"Hossain",
    "email":"Washif@as.com",
    "phone":"Washif",
    "address":"Washif",
    "country":"Washif",
    "pass":"Washif",
    "checkPass":"Washif"
}
*/
?>