<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH, DELETE");
// header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require __DIR__ . '/classes/database.php';


processRequest();
function processRequest()
{
    $req_method = $_SERVER["REQUEST_METHOD"];
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);

    // $response['header_status_code'] = 'HTTP/1.1 201 Created';
    switch ($req_method) {
        case 'GET':
            $response = selectLastData();
            // $response = selectData();
            break;
        case 'POST':
            $response =  insertData($input);
            break;
        case 'PUT':
            $response = selectLastData($input);
            break;
        case 'PATCH':
            $response = selectLastData($input);
            break;
        case 'DELETE':
            $response = deleteData();
            break;
        default:
            $response['header_status_code'] = 'HTTP/1.1 404 page not found';
            break;
    }
    header($response['header_status_code']);
    if (!empty($response['body'])) {
        echo json_encode($response['body']);
    }
}


function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
    ];
    return $response;
}
function userIsExist($user_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT  EXISTS (select * from tbm_user where user_id = ?  )as user";

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
function batteryIsExist($battery_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT  EXISTS (select * from tbm_battery_info where battery_id = ? )as battery";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($battery_id));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
        if($res['battery'] == 0 ){
            $query =  $conn->prepare("select * from tbm_battery_info order by desc auto_id");
            $query->execute(array($battery_id));
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $res = $query->fetch(); 
        }
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 ok';
    return $response;
}
function validateUser($data)
{
    if (!array_key_exists("user_name", $data)) {
        return unprocessableEntityResponse('user_name is required');
    }
    if (!array_key_exists("password", $data)) {
        return unprocessableEntityResponse('password is required');
    }

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT  EXISTS (select * from tbm_user where user_name = ?  and password = md5(?) )as res";
    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($data['user_name'], $data['password']));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
        if($res['res'] == 0){
            $response['body']['error_msg'] = "invalid data provided";
            $response['body']['status'] = 0;
         }
         if($res['res'] == 1){
            $response['body']['msg'] =  "ok";
            $response['body']['status'] = 1;
          }
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 ok';
    return $response;
}
function insertData($data)
{
    if (!array_key_exists("user_id", $data)) {
        return unprocessableEntityResponse('user_id is required');
    }
    if (!array_key_exists("battery_id", $data)) {
        return unprocessableEntityResponse('battery_id is required');
    }

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;

    $res_user_id =  userIsExist($data['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    
    if ($res_user_id['user'] != 1) {
        $res['error_msg'] = "user not valid ";
    } else {
        try {
                $sql = "insert into tbm_battery_info (battery_id, title, content, des1, des2,created_at, created_by) values(:battery_id, :title, :content, :des1, :des2, now(), :user_id)";
                $sth = $conn->prepare($sql);
                $status = $sth->execute(array(
                    'battery_id' => trim(strtolower($data['battery_id'])),
                    'title'  => trim($data['title']),
                    'content'  => trim($data['content']),
                    'des1'  => trim($data['des1']),
                    'des2'  => trim($data['des2']),
                    'user_id'  => trim($data['user_id']),
                ));
            $res['success'] = "all data inserted successfully";
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    $conn = null;

    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = $res;
    return $response;
}
function updateDate()
{
    return "update Data";
}
function selectLastData($data)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $res = null;
    try {
        $query =  $conn->prepare("select * from tbm_battery_info order by auto_id desc");
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetch(); 
        // if($res == false){
        //     $res = [];
        // }
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 ok';

    $response['body']['status'] = 1;
    $response['body']['res'] = $res;
    return $response;
}
function deleteData()
{
    return "delete Data";
}
