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
            $response =  selectLastData($input);
            break;
        case 'PUT':
            $response = IDIsExist($input);
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
    // if (!array_key_exists("user_id", $data)) {
    //     return unprocessableEntityResponse('user_id is required');
    // }
    if (!array_key_exists("battery_id", $data)) {
        return unprocessableEntityResponse('battery_id is required');
    }
    if (!array_key_exists("battery_cycle", $data)) {
        return unprocessableEntityResponse('battery_cycle is required');
    }
    if (!array_key_exists("battery_percentage", $data)) {
        return unprocessableEntityResponse('battery_percentage is required');
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

    $res_info =  IDIsExist($data);
    if ($res_info['body']->res != 1) {
        return unprocessableEntityResponse('Invalid battery_id provided');
    } else {
        try {
            $sql = "INSERT INTO tbm_battery_details (battery_id, cycle, current_voltage, current_battery_percentage, created_at, user_details, created_by, created_at_usertime) VALUES (:battery_id, :battery_cycle, :voltage, :battery_percentage,  now(), :user_details,  :user_id, :user_time);";
            $sth = $conn->prepare($sql);
            $status = $sth->execute(array(
                'battery_id' => trim(strtolower($data['battery_id'])),
                'battery_cycle'  => trim($data['battery_cycle']),
                'voltage'  => trim($data['voltage']),
                'battery_percentage'  => trim($data['battery_percentage']),
                'user_details'  => trim($data['user_details']),
                'user_time'  => trim($data['user_time']),
                'user_id'  => trim($data['user_id'])
            ));
            $res['success'] = "all information saved succesfully";
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
function updateData($data)
{
    if (!array_key_exists("req_for", $data)) {
        return unprocessableEntityResponse('req_for is required');
    }

    if ($data['req_for'] == 0) {
        $response = insertData($data);
    }

    if ($data['req_for'] == 1) {
        if ((!array_key_exists("battery_id", $data)) && (!empty($data['battery_id']))) {
            return unprocessableEntityResponse('battery_id is required');
        }
        if ((!array_key_exists("user_id", $data)) || (empty($data['user_id']))) {
            return unprocessableEntityResponse('user_id is required');
        }
        if ((!array_key_exists("w_start_date", $data)) || (empty($data['w_start_date']))) {
            return unprocessableEntityResponse('w_start_date is required');
        }
        if ((!array_key_exists("w_end_date", $data)) || empty($data['w_end_date'])) {
            return unprocessableEntityResponse('w_end_date is required');
        }

        $db_connection = new Database();
        $conn = $db_connection->dbConnection();
        $res_info =  IDIsExist($data);
        if ($res_info['body']->res != 1) {
            return unprocessableEntityResponse('Invalid battery_id provided');
        } else {
            $sql = "update tbm_battery_info set warranty_start_date = :start_date, created_by = :user_id,
            warranty_end_date = :end_date, updated_at = now() where  battery_id = :battery_id";

            $res = null;
            try {
                $query =  $conn->prepare($sql);
                $res = $query->execute(array(
                    'battery_id' => trim(strtolower($data['battery_id'])),
                    'user_id' => trim($data['user_id']),
                    'start_date'  => trim($data['w_start_date']),
                    'end_date'  => trim($data['w_end_date']),

                ));
                if ($res == 1) {
                    $res = "Saved succesfully";
                }
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }
        $conn = null;
        $response['header_status_code'] = 'HTTP/1.1 201 ok';
        $response['body']['status'] = 1;
        $response['body']['success'] = $res;
    }
    return $response;
}
function selectLastData($data)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "select * from tbm_battery_info order by auto_id desc limit 1";
    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute();
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
function selectLastDataByUser($data)
{
    // if (!array_key_exists("foreign_id", $data)) {
    //     return unprocessableEntityResponse('foreign_id is required');
    // }
    // if (!array_key_exists("foreign_st", $data)) {
    //     return unprocessableEntityResponse('foreign_st is required');
    // }
    $limit = $data["limit"];
    $limit = empty($data['limit']) ? "limit 10" : "limit $limit";

    $offset = $data["offset"];
    $offset = empty($data['offset']) ? "" : "and n1.notification_id < $offset";

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT n1.* FROM notification n1 WHERE n1.created_by = ? $offset  order by n1.notification_id desc $limit";
    // $sql = "SELECT n1.* FROM notification n1 LEFT JOIN notification n2 ON
    // (n1.foreign_id = n2.foreign_id AND n1.notification_id < n2.notification_id)
    // WHERE n2.notification_id IS NULL and  n1.created_by = ? $offset  order by n1.created_at desc $limit";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($data['user_id']));
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
function deleteData()
{
    return "delete Data";
}

function IDIsExist($data)
{
    if (!array_key_exists("battery_id", $data)) {
        return unprocessableEntityResponse('battery_id is required');
    }
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT CAST(EXISTS (SELECT * FROM tbm_battery_info WHERE battery_id = ?  )as int)as  res";
    // $sql = "SELECT *, (select EXISTS (SELECT * FROM tbm_battery_info WHERE battery_id = ? ))as  res FROM tbm_battery_info WHERE battery_id = ?";
    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($data['battery_id']));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }

    try {
        $sql1 = "SELECT *, CAST((SELECT EXISTS (SELECT * FROM tbm_battery_info WHERE battery_id = ?)) AS INT) as res FROM tbm_battery_info WHERE battery_id = ?";

        $query1 =  $conn->prepare($sql1);
        $query1->execute(array($data['battery_id'], $data['battery_id']));
        $query1->setFetchMode(PDO::FETCH_OBJ);
        $ress = $query1->fetch();

        if (empty($ress)) {
            $ress = [];
        }
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }

    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 ok';
    $response['body'] = $res;
    $response['body']->battery_info = $ress;

    return $response;
}

function notificationIsExist($id, $user_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT  EXISTS (SELECT * FROM notification WHERE notification_id = ? and created_by = ? )as  notify";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($id, $user_id));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return json_encode($res, JSON_FORCE_OBJECT);
}
