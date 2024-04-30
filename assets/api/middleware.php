<?php
session_start();

if (!$_SESSION['token']) {
    return unprocessableEntityResponse422("unwanted attempts! try using a valid token."); 
} 

$jwt = new JwtHandler();
$token_data = $jwt->jwtDecodeData($_SESSION['token']);

if ($token_data == 'Expired token') {
    return unprocessableEntityResponse422("unwanted attempts! try using a valid token.");
}
if(!$token_data->data->user_id){
    return unprocessableEntityResponse422("unwanted attempts! try using a valid token.");
}
if(!($token_data->data->role>=0)){
    return unprocessableEntityResponse422("unwanted attempts! try using a valid token.");
}

function unprocessableEntityResponse422($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
    ];
    
    header($response['header_status_code']);

    if (!empty($response['body'])) {
        echo json_encode($response['body']);
    }
    exit();
}
