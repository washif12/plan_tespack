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
                $response = compareAndNotificationInsert($input);
                break;
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
    // $in_formet =  gettype(json_decode(file_get_contents('php://input'), TRUE));
    // if ($in_formet != 'array') {
    //     $response = unprocessableEntityResponse('Invalid input format provided');
    // }
    header($response['header_status_code']);
    if (!empty($response['body'])) {
        echo json_encode($response['body']);
    }
}
function compareAndNotificationInsert($data)
{
    try {
        $out = Database::executeRoutedFn('ssm_compare_and_notification__insert', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['status'] = 1;
    return $response;
    // $db_connection = new Database();
    // $conn = $db_connection->dbConnection();

    // if (!array_key_exists("user_id", $data)) {
    //     return unprocessableEntityResponse('user_id is required');
    // }
    // $res = null;
    // $response =[];
    // $sql = "";
    // try {
    //     $res = preCheckDevice("SELECT * FROM geofencing g  where g.created_by = ?", $data['user_id']);

      
    //     $device = [];
    //     $i = 0;
    //     foreach ($res as $key) {
           
    //        $res[$i]->device = preCheckDevice("SELECT m1.*, gd.id as geofence_device_id FROM gnss_loaction m1 LEFT JOIN gnss_loaction m2 ON (m1.ssm_id = m2.ssm_id AND m1.gnss_location_id < m2.gnss_location_id) 
    //        left join geofence_device gd on gd.ssm_id = m1.ssm_id WHERE  m2.gnss_location_id IS NULL and   gd.geofence_id = ? order by m1.ssm_id desc", $key->id);
    //         $i++;
    //     }
    // } catch (\PDOException $e) {
    //     exit($e->getMessage());
    // }
    // $conn = null;
    // $response['body']['res'] = $res;
    // // $response['body']['res']['device'] = $device;
    // $response['body']['status'] = 1;
    // $response['header_status_code'] = 'HTTP/1.1 201 Created';
}

function geofence_device_exist_or_not__list($data)
{
    try {
        $out = Database::executeRoutedFn('geofence_device_exist_or_not__list', $data);
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

function checkDevice($sql, $item, $geofence_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    // $sql = "SELECT * FROM gms WHERE ssm_id  = ?";
    // var_dump($sql, $item, $geofence_id);
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($item, $geofence_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function preCheckDevice($sql, $geofence_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    // $sql = "SELECT * FROM gms WHERE ssm_id  = ?";

    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($geofence_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function ssmIsExist($ssm_id, $sql)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    if (empty($sql)) {

        $sql = "SELECT  EXISTS (select ssm_id from ssm where ssm_id = ?  )as  ssm_id";
    }
    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return json_encode($res, JSON_FORCE_OBJECT);
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
