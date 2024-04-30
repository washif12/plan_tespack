<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
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
                $response = beforeInsert($input);
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
function beforeInsert($data)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    if (!array_key_exists("ssm", $data)) {
        return unprocessableEntityResponse('ssm is required');
    }
    $ssm_list = $data['ssm'];
    $count = 0;
    $res = 0;
    $temp = 0;
    $curn_geofenId = "";
    $total_device = "";

    if (count($ssm_list) == 0) {
        $response['body']['error_msg'] = "Invalid ssm formet";
        $response['body']['status'] = 3;
        $response['header_status_code'] = 'HTTP/1.1 201 Created';
        return $response;
    }
    $pre_str = preCheckDevice("SELECT geofence_id FROM geofence_device where  ssm_id = ?", $ssm_list[0]);
    $curn_geofenId = $pre_str[0]->geofence_id;

    $i = 0;

    foreach ($ssm_list as $item) {
        $curr_st = preCheckDevice("SELECT geofence_id FROM geofence_device where  ssm_id = ?", $item);
        // var_dump($curn_geofenId);
        if ($curn_geofenId != $curr_st[0]->geofence_id) {
            $curn_geofenId = "";
            break;
        }
        if ($curr_st[0]->geofence_id == null) {
            $curn_geofenId = null;
            // break;
        }

        if ($curn_geofenId == $curr_st[0]->geofence_id) {
            $curn_geofenId = $curr_st[0]->geofence_id;
        }
    }
    if (!is_null($curn_geofenId)) {
        if (!empty($curn_geofenId)) {


            $total_device  = preCheckDevice("SELECT count(ssm_id) as total_ssm FROM geofence_device where  geofence_id = ?", $curn_geofenId);

            $total_device = $total_device[0]->total_ssm;

            if ($total_device >= 1) {
                foreach ($ssm_list as $item) {
                    $curr = checkDevice("SELECT * FROM geofence_device where ssm_id = ? and geofence_id = ?", $item, $pre_str[0]->geofence_id);
                    if (count($curr)  > 0) {
                        $count++;
                    }
                    // print_r($count);
                    if (count($curr)  == 0) {
                        $res = 1;
                        break;
                    }
                }
            } else {
                $temp = 1;
            }
        } else {
            $res = 1;
        }
    } else {
        $temp = 1;
    }
    // $ress = (object)[]; 
    if ($res == 1 || $count != $total_device) {
        $response['body']['msg'] = "ssm not matched";
        $response['body']['status'] = 0;
        $response['header_status_code'] = 'HTTP/1.1 201 Created';
    }
    if ($count == $total_device) {
        $ress = preCheckDevice("select * from geofencing  where id = ?", $pre_str[0]->geofence_id);
        $device = [];
        $i = 0;
        foreach ($ssm_list as $key) {

            $device[$i] = preCheckDevice("select g.* from geofence_device gd inner join gnss_loaction g on g.ssm_id = gd.ssm_id where g.ssm_id = ? order by g.gnss_location_id desc limit 1", $key)[0];
            $i++;
        }

        $ress[0]->device = $device;
        $response['body']['msg'] = "all matched";
        $response['body']['status'] = 1;
        $response['body']['res'] = $ress;

        $response['header_status_code'] = 'HTTP/1.1 201 Created';
    }
    if ($temp == 1) {
        $device = [];
        $i = 0;
        foreach ($ssm_list as $key) {

            $device[$i] = preCheckDevice("select g.* from gnss_loaction g where g.ssm_id = ? order by g.gnss_location_id desc limit 1", $key)[0];
            $i++;
        }

        if (is_null($device[0])) {
            $device = "device not exists or location not found";
        }
        $response['body']['res'] = $device;
        $response['body']['msg'] = "SSM can be store";
        $response['body']['status'] = 2;
        $response['header_status_code'] = 'HTTP/1.1 201 Created';
    }

    return $response;
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

function checkDevice($sql, $item, $geofence_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    // $sql = "SELECT * FROM gms WHERE ssm_id  = ?";

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
