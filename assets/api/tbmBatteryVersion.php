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


        switch ($req_method) {

            case 'POST':
                $response = insertData($input);
                break;
            case 'PATCH':
                $response = selectAllVersion($input);
                break;
            case 'PUT':
                $response = autoID();
                break;
                // case 'DELETE':
                //     $response = deleteData();
                //     break;
            default:
                $response['header_status_code'] = 'HTTP/1.1 404 page not found';
                break;
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
function autoID()
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;
    $sql = "select ifnull(max(cast(subString(auto_id,locate('-',auto_id)+1,
    length(auto_id)-locate('-',auto_id)) as UNSIGNED)),0)+1 as id from tbm_battery_version order by auto_id";
    try {

        $query =  $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    $response['header_status_code'] = 'HTTP/1.1 201 ok';
    $response['body']['version'] = 'v' . $res['id'];
    return $response;
}


function selectDataByVersion($data)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;
    $res_user_id =  userIsExist($data['user_id']);
    $res_user_id = json_decode($res_user_id, true);

    if ($res_user_id['user'] != 1) {
        return unprocessableEntityResponse('user_id not valid');
    }
    try {
        $sql = "select * from tbm_battery_version where version_id = ?";
        $query =  $conn->prepare($sql);
        $query->execute(array(trim($data['version'])));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 ok';

    $response['body']['status'] = 1;
    $response['body']['res'] = $res;
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
function insertData($data)
{
    if (!array_key_exists("user_id", $data)) {
        return unprocessableEntityResponse('user_id is required');
    }
    if (!array_key_exists("version", $data)) {
        return unprocessableEntityResponse('version is required');
    }
    if (!array_key_exists("m_name", $data)) {
        return unprocessableEntityResponse('m_name is required');
    }
    if (!array_key_exists("m_mobile", $data)) {
        return unprocessableEntityResponse('m_mobile is required');
    }
    if (!array_key_exists("cell_supplier_name", $data)) {
        return unprocessableEntityResponse('cell_supplier_name is required');
    }
    $date = "";
    $previous_id =  "";

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;

    $res_user_id =  userIsExist($data['user_id']);
    $res_user_id = json_decode($res_user_id, true);

    if ($res_user_id['user'] != 1) {
        return unprocessableEntityResponse('user_id is required');
    }
    try {
        $sql = "insert tbm_battery_version(version_id, manufacturer_name,
                manufacturer_address, manufacturer_mobile, cell_supplier_name, cell_supplier_details, created_at, created_by, firmware_version) values(:version, :m_name, :m_address, :m_mobile, :cell_s_name, :cell_s_details, now(), :user_id, :firmware_version);";
        $sth = $conn->prepare($sql);
        $status = $sth->execute(array(
            'version' => trim($data['version']),
            'm_mobile'  => trim($data['m_mobile']),
            'm_name'  => trim($data['m_name']),
            'm_address'  => trim($data['m_address']),
            'cell_s_name'  => trim($data['cell_supplier_name']),
            'cell_s_details'  => trim($data['cell_supplier_details']),
            'user_id'  => trim($data['user_id']),
            'firmware_version'  => trim($data['f_version'])
        ));
        $res['success'] = "Information Saved succesfully";
        $res['status'] = 1;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }

    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = $res;
    return $response;
}
function selectAllVersion($data)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "select * from tbm_battery_version order by auto_id desc";
    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 ok';

    $response['body']['status'] = 1;
    $response['body']['res'] = $res;
    return $response;
}