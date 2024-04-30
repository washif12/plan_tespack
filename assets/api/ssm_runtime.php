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
            $response = $input;
            // $response = selectData();
            break;
        case 'POST':
            $response =  insertData($input);
            break;
        case 'PUT':
            $response = updateDate();
            break;
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
function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
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
function insertData($data)
{

    if(!validateSecretKey($data['s_k'])){
        return unprocessableEntityResponse('unwanted attempts! try using a valid token.');
    }

    if (!array_key_exists("ssm_id", $data)) {
        return unprocessableEntityResponse('ssm_id is required');
    }
    if (!array_key_exists("totalUses", $data)) {
        return unprocessableEntityResponse('totalUses  is required');
    }
    if (!array_key_exists("f_battery", $data)) {
        return unprocessableEntityResponse('f_battery is required');
    }
    if (!array_key_exists("f_grid", $data)) {
        return unprocessableEntityResponse('f_grid is required');
    }
    if (!array_key_exists("f_solar", $data)) {
        return unprocessableEntityResponse('f_solar is required');
    }
    if (!array_key_exists("t_sn", $data)) {
        return unprocessableEntityResponse('t_sn is required');
    }
    if (empty($data["t_sn"])) {
        $data["t_sn"] = '0.0';
    }
    try {
        $res = Database::executeRoutedFn('grid_solar_totaluse__upsert', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    // if (!compareWithPreviousData($data)['res']) {


    //     $db_connection = new Database();
    //     $conn = $db_connection->dbConnection();

    //     $res = null;

    //     $res_ssm_id =  ssmIsExist($data['ssm_id']);
    //     $res_ssm_id = json_decode($res_ssm_id, true);
    //     if ($res_ssm_id['ssm_id'] != 1) {
    //         $res['error_msg'] = "ssm_id not valid";
    //     } else {
    //         try {
    //             $sql = "insert into grid_solar_totaluse(user_usage, from_battery, from_grid, from_solar, ssm_id, date, time, created_at, total_session) values(:user_usage, :from_battery, :from_grid, :from_solar, :ssm_id, now(), now(), now(), :total_session)";
    //             $sth = $conn->prepare($sql);
    //             $status = $sth->execute(array(
    //                 'user_usage' => trim($data['totalUses']),
    //                 'from_battery'  => trim($data['f_battery']),
    //                 'from_grid' => trim(strtolower($data['f_grid'])),
    //                 'from_solar' => trim(strtolower($data['f_solar'])),
    //                 'ssm_id' => trim(strtoupper($data['ssm_id'])),
    //                 'total_session' => trim($data['t_sn']),
    //             ));
    //             $res['success'] = "all data inserted successfully";
    //         } catch (\PDOException $e) {
    //             exit($e->getMessage());
    //         }
    //     }
    // }else{
    //     $res['success'] = "Same data eliminated from posting";
    // }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = $res;
    return $response;
}
function updateDate()
{
    return "update Data";
}
function selectData()
{
    return "select Data";
}
function compareWithPreviousData($data)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "select exists (select * from grid_solar_totaluse where user_usage = :user_usage and 
    total_session = :total_session and from_battery = :from_battery and ssm_id = :ssm_id and from_grid = :from_grid 
    and from_solar = :from_solar order by id desc limit 1) as res";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array(
            'user_usage' => trim($data['totalUses']),
            'from_battery' => trim($data['f_battery']),
            'from_grid' => trim(strtolower($data['f_grid'])),
            'from_solar' => trim(strtolower($data['f_solar'])),
            'ssm_id' => trim(strtoupper($data['ssm_id'])),
            'total_session' => trim($data['t_sn']),
        ));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}


function compareMaxRow($data)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "select * from grid_solar_totaluse where total_session = (
                select max(CAST(a.total_session  AS SIGNED) ) from (
                    SELECT 
                        *
                    FROM 
                        grid_solar_totaluse
                    WHERE 
                        id
                        between 
                        (select id from grid_solar_totaluse where total_session = '0.0' and ssm_id = :ssm_id order by id desc limit 1) 
                    AND 
                        (select id from grid_solar_totaluse where ssm_id = :ssm_id order by id desc limit 1)
                ) as a
        ) order by id desc limit 1";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array(
            'ssm_id' => trim(strtoupper($data['ssm_id']))
        ));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}

function validateSecretKey($string) {
    $db_connection = new Database();
    if(md5($db_connection->secretKey) == $string){
        return true;
    }else{
        return false;
    }
}
