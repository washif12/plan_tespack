<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE");
// header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require __DIR__ . '/classes/database.php';

processRequest();
function processRequest()
{
    $req_method = $_SERVER["REQUEST_METHOD"];

    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    // $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $ssm_id = "";
    // $res_user_id =  userIsExist($input['user_id']);
    // $res_user_id = json_decode($res_user_id, true);
    // if ($res_user_id['user_id'] != 1 || empty($input['user_id'])) {
    //     $response = unprocessableEntityResponse("user_id not provided or not valid");
    //     $response['body']['success'] = 0;
    // } else {
        switch ($req_method) {
            case 'POST':
                $response = insertAndUpdateSerial($input);
                break;
            case 'PATCH':
                $response =  generateSerial($input);
                break;
            case 'PUT':
                $response = IDIsExist($input);
                break;
            default:
                $response['header_status_code'] = 'HTTP/1.1 404 page not found';
                break;
        // }
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
function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
        'status' => 0
    ];
    return $response;
}
function ssmIsExist($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT  EXISTS (select ssm_id from ssm where ssm_id = ?  )as  ssm_id";

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

    $sql = "SELECT  EXISTS (select * from users where id = ?  and role = 0)as user_id";

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
function insertData($data)
{
    if (!array_key_exists("user_id", $data)) {
        return unprocessableEntityResponse('user_id is required');
    }
    if (!array_key_exists("battery_id", $data)) {
        return unprocessableEntityResponse('battery_id is required');
    }
    if (!array_key_exists("version", $data)) {
        return unprocessableEntityResponse('version is required');
    }
    $date = "";
    $previous_id =  "";
    if (!array_key_exists("w_start_date", $data)) {
        $date = 'created_at';
    }
    if (!empty($data['w_start_date']) || array_key_exists("w_start_date", $data)) {
        $date = 'updated_at';
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
            $sql = "insert into tbm_battery_info (battery_id, title, content, des1, des2,  $date, created_by,warranty_start_date, warranty_end_date, user_details, version) values(:battery_id, :title, :content, :des1, :des2, now(), :user_id, :warranty_start_date, :warranty_end_date, :user_details, :version)";
            $sth = $conn->prepare($sql);
            $status = $sth->execute(array(
                'battery_id' => trim(strtolower($data['battery_id'])),
                'title'  => trim($data['title']),
                'content'  => trim($data['content']),
                'des1'  => trim($data['previous_battery_id']),
                'des2'  => trim($data['reason']),
                'warranty_start_date'  => trim($data['w_start_date']),
                'warranty_end_date'  => trim($data['w_end_date']),
                'user_id'  => trim($data['user_id']),
                'user_details'  => trim($data['user_details']),
                'version'  => trim($data['version']),
            ));
            $res['success'] = "Saved succesfully";
            $res['status'] = 1;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = $res;
    return $response;
}
function insertAndUpdateSerial($data)
{
    if(!validateSecretKey($data['s_k'])){
        return unprocessableEntityResponse('unwanted attempts! try using a valid token.');
    }

    try {
        $out = Database::executeRoutedFn('ssm_serial__upsert', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['status'] = 1;
    return $response;
}
function generateSerial($data)
{
    if(!validateSecretKey($data['s_k'])){
        return unprocessableEntityResponse('unwanted attempts! try using a valid token.');
    }
    try {
        $out = Database::executeRoutedFn('ssm_id_generate', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['status'] = 1;
    return $response;
}

function deleteData()
{
    return "delete Data";
}

function IDIsExist($data)
{
    if(!validateSecretKey($data['s_k'])){
        return unprocessableEntityResponse('unwanted attempts! try using a valid token.');
    }
    try {
        $out = Database::executeRoutedFn('ssm_id_is_exists_or_not__check', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['status'] = 1;
    return $response;
}
function validateSecretKey($string) {
    $db_connection = new Database();
    if(md5($db_connection->secretKey) == $string){
        $db_connection  = null;
        return true;
    }else{
        $db_connection  = null;
        return false;
    }
}
