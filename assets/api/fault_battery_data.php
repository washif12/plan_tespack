<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
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
            $response =  selectFaultBatteriesData();
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

function selectFaultBatteriesData()
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM battery_cycle_data where battery_cycle >=500";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body'] = $res;
        // var_dump($response);
        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}

 