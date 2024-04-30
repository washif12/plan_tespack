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
    $get_frm = gettype($input);

    switch ($req_method) {
        // case 'GET':
        //     $response = select_grid_solar_total_use_data($input);
        //     break;
        case 'POST':
            $response =  battery_cycle__paginate_for_report($input);
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

    header($response['header_status_code']);
    if (!empty($response['body'])) {
        echo json_encode($response['body']);
    }
}
function battery_cycle__paginate_for_report($data)
{
    try {
        $out = Database::executeRoutedFn('battery_cycle__paginate_for_report', $data);
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
function insertData($data)
{
}
function updateDate()
{
    return "update Data";
}
function totalfaultBatteriesData()
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT count(id) as total_fault_battery FROM battery_cycle_data where battery_cycle>=500";
    // $sql = "SELECT count(power_bank_id) as total_fault_battery FROM power_bank where cycle>=500";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function totalBatteriesData()
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT count(id)  as total_battery FROM battery_cycle_data";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res['total_battery'];
}
function select_grid_solar_total_use_data($input)
{

    $sql = [];
    $x = 0;
    $inst = 0;
    for ($i = 50; $i <= 500; $i = $i + 50) {
        $inst = $x == 0 ? $x : 1 + $i - 50;
        $sql[$x] = "select count(id) total_batteries, max(battery_cycle) highest_cycle from battery_cycle_data where (battery_cycle between $inst and $i)";
        $x++;
    }

    $temp = 50;
    $res = [];
    $inst = 0;
    $c = 0;
    for ($i = 0; $i < $x; $i++) {
        $inst = $i == 0 ? $i : 1 + $temp - 50;
        $range = "$inst-$temp";
        $res[$i] = executeQuery($sql[$i]);
        $res[$i]['range'] = $range;
        $temp += 50;
    }
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = totalfaultBatteriesData();
    $response['body']['res'] = $res;
    return $response;
}
function executeQuery($sql)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    // $response['body']['sql'] = $sql;
    // echo ($sql);
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    return $res;
}
function deleteData()
{
    return "delete Data";
}
