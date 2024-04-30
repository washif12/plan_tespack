<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// require __DIR__ . '/classes/database.php';
require __DIR__ . '/classes/database.php';
require __DIR__ . '/classes/JwtHandler.php';
require __DIR__ . '/middleware.php';
processRequest();
function processRequest()
{
    $req_method = $_SERVER["REQUEST_METHOD"];

    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    // $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $ssm_id = "";
    $res_user_id =  userIsExist($input['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    if ($res_user_id['user_id'] != 1 || empty($input['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {
        switch ($req_method) {
            case 'POST':
                $response = selectData($input);
                break;
                // case 'PATCH':
                //     $response =  insertData($input);
                //     break;
                // case 'PUT':
                //     $response = updateDate();
                //     break;
                // case 'DELETE':
                //     $response = deleteData();
                //     break;
            default:
                $response['header_status_code'] = 'HTTP/1.1 404 page not found';
                break;
        }
    }
    $in_formet =  gettype(json_decode(file_get_contents('php://input'), TRUE));
    if ($in_formet != 'array') {
        $response = unprocessableEntityResponse('Invalid input format provided');
    }
    header($response['header_status_code']);
    if (!empty($response['body'])) {
        echo json_encode($response['body']);
    }
}
function selectData($data)
{
    try {
        $out = Database::executeRoutedFn('filter_paginate', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['status'] = 1;
    return $response;

}
function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body']['status'] = 0;
    $response['body'] = [
        'error_msg' => $msg,
    ];
    return $response;
}


function userIsExist($user_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    // $sql = "SELECT  EXISTS (select ssm_id from ssm where ssm_id = ?  )as  ssm_id";
    $sql = "SELECT  EXISTS (SELECT * FROM users WHERE id = ?  )as  user_id";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($user_id));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return json_encode($res, JSON_FORCE_OBJECT);
}
