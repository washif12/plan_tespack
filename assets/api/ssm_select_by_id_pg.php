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

    $ssm_id = "";
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $res_user_id =  userIsExist($input['user_id']);
    $res_user_id = json_decode($res_user_id, true);
   // var_dump($input);
    if ($res_user_id['user_id'] != 1 || empty($input['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {
    switch ($req_method) {
        case 'POST':
            if (!empty($input['ssm_id'])) {
                $response = selectDataByssmId($input);
            } else {
                $response = selectData("");
            }
            break;
        // case 'POST':
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

        $out = Database::executeRoutedFn('ssm_data__select_by_ssmid', $data);
    
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['success'] = 1;
    return $response;

    // // $limit = $inputData["limit"];
    // // $limit = empty($inputData['limit']) ? '' : "limit $limit";

    // $db_connection = new Database();
    // $conn = $db_connection->dbConnection();
    // $sql = "SELECT m1.* FROM ssm m1 LEFT JOIN ssm m2 ON
    // (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) WHERE m2.auto_id IS NULL order by m1.auto_id desc";

    // $res = null;

    // try {
    //     $query = $conn->prepare($sql);
    //     $query->execute();
    //     $query->setFetchMode(PDO::FETCH_OBJ);
    //     $res = $query->fetchAll();
    //     for ($i = 0; $i < sizeof($res); $i++) {
    //         $res[$i]->power_bank_details = select_power_Bank_Data_By_ssmId($res[$i]->ssm_id);
    //         // $res[$i]->gms_details = select_Gsm_Data_By_ssmId($res[$i]->ssm_id);
    //         $res[$i]->near_wifi_details =  select_near_Wifi_Data_By_ssmId($res[$i]->ssm_id);
    //         $res[$i]->gnss_location_details = select_Gsm_Location_Data_By_ssmId($res[$i]->ssm_id);
    //         $res[$i]->near_cellular_operator_details = select_near_Cellular_Operator_Data_By_ssmId($res[$i]->ssm_id);
    //         $res[$i]->device_runtime = select_device_runtime_By_ssmId($res[$i]->ssm_id);
    //         $res[$i]->total_charge_avg = select_total_poc($res[$i]->ssm_id);
    //     }

    //     // $response['body']['country'] = selectCountryData("");
    //     // $response['body']['project'] = selectProjectData("");
    //     // $response['body']['project_manager'] = selectProject_managerData("");
    //     // $response['body']['device'] = selectDeviceData("");
    //     $response['body']['res'] = $res;
    //     $response['body']['success'] = 1;
    //     // $response['body']['total_device'] = count($res);
    // } catch (\PDOException $e) {
    //     exit($e->getMessage());
    // }
    // $conn = null;
    // $response['header_status_code'] = 'HTTP/1.1 200 OK';

    // return $response;
}
function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 200 Unprocessable Entity';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
    ];
    return $response;
}
function autoID()
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;
    $sql = "select ifnull(max(cast(subString(ssm_id,locate('-',ssm_id)+1,
    length(ssm_id)-locate('-',ssm_id)) as UNSIGNED)),0)+1 as id from ssm order by auto_id";
    try {

        $query =  $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    return "ssm-" . $res['id'];
}
function insertData($data)
{
    if (!array_key_exists("ssm_id", $data)) {
        return unprocessableEntityResponse('ssm_id is required');
    }
    if (!array_key_exists("s_s", $data)) {
        return unprocessableEntityResponse('s_s is required');
    }
    if (!array_key_exists("op", $data)) {
        return unprocessableEntityResponse('op is required');
    }
    // if (!array_key_exists("last_seen_time", $data)) {
    //     return unprocessableEntityResponse('last_seen_time is required');
    // }
    // if (!array_key_exists("last_seen_position", $data)) {
    //     return unprocessableEntityResponse('last_seen_positon is required');
    // }
    if (!array_key_exists("t_sn", $data)) {
        return unprocessableEntityResponse('t_sn is required');
    }
    if (!array_key_exists("imei", $data)) {
        return unprocessableEntityResponse('imei is required');
    }
    if (!array_key_exists("emei", $data)) {
        return unprocessableEntityResponse('emei is required');
    }
    if (!array_key_exists("p_s", $data)) {
        return unprocessableEntityResponse('p_s is required');
    }
    if (!array_key_exists("p_s_sta", $data)) {
        return unprocessableEntityResponse('p_s_sta is required');
    }
    if (!array_key_exists("t_ch", $data)) {
        return unprocessableEntityResponse('t_ch is required');
    }
    if (!array_key_exists("b_sta", $data)) {
        return unprocessableEntityResponse('b_sta is required');
    }
    if ((empty($data['sos'])) || (!array_key_exists("sos", $data))) {
        $data['sos'] = "0";
        // return unprocessableEntityResponse('name is required');
    }
    // if (!array_key_exists("sos_activated", $data)) {
    //     return unprocessableEntityResponse('sos_activated is required');
    // }
    if($data['b_sta']==0){
        $data['b_sta'] = "disconnected";
    }
    if($data['b_sta']==1){
        $data['b_sta'] = "charging";
    }
    if($data['b_sta']==2){
        $data['b_sta'] = "output";
    }
    if($data['b_sta']==3){
        $data['b_sta'] = "charging + output";
    }
    if($data['p_s']==0){
        $data['p_s'] = "disconnected";
    }
    if($data['p_s']==1){
        $data['p_s'] = "battery";
    }
    if($data['p_s']==2){
        $data['p_s'] = "grid";
    }
    if($data['p_s']==3){
        $data['p_s'] = "grid + battery";
    }
    if($data['p_s_sta']==0){
        $data['p_s_sta'] = "disconnected";
    }
    if($data['p_s_sta']==1){
        $data['p_s_sta'] = "charging";
    }
    if($data['p_s_sta']==2){
        $data['p_s_sta'] = "charging + output";
    }
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $ssm_id = "";
    
    // if ((!array_key_exists("id", $data)) || ($data['id']=="ssm-0101")) {
    //     // $ssm_id =  autoID();
    //     $res = "ok";
       
    //     $ssm_id = "ssm-01012";
    // } else {
    //     $res_ssm_id = ssmIsExist($data['id']);
    //     $res_ssm_id = json_decode($res_ssm_id, true);
    //     if ($res_ssm_id['ssm_id'] != 1) {
    //         return unprocessableEntityResponse('ssm_id not valid');
    //     }
    //     $ssm_id = $data['id'];
    // }
    if((!array_key_exists("ssm_id", $data))|| (!checkIDFormat($data['ssm_id']))){
        return unprocessableEntityResponse('ssm_id not provided or not valid');
    }

    $res = null;
    $sql = "INSERT INTO ssm(ssm_id, signal_strangth, network_id, last_seen_time, total_session, 
     imei, emei, power_source_type, power_source_status, total_charge, sos_activated, created_at,
    updated_at, battery_status) VALUES( :ssm_id,  :signal_strangth, :network_id, now(), :total_session,
    :imei, :emei, :power_source_type, :power_source_status, :total_charge, :sos_activated,
     NOW(), NOW(), :battery_status)";
    try {
        $sth = $conn->prepare($sql);
        $status = $sth->execute(array(
            'ssm_id' => trim($data['ssm_id']),
            'signal_strangth'  => trim($data['s_s']),
            'network_id' => trim($data['op']),
            'total_session' => trim($data['t_sn']),
            'imei' => trim($data['imei']),
            'emei' => trim($data['emei']),
            'power_source_type' => trim($data['p_s']),
            'power_source_status' => trim($data['p_s_sta']),
            'total_charge' => trim($data['t_ch']),
            'sos_activated' => trim($data['sos']),
            'battery_status' => trim($data['b_sta']),
        ));
        $res = "all data inserted successfully";
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }

    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = [
        "post" => $res,
        "ssm_id" => $ssm_id
    ];
    return $response;
}
function updateDate()
{
    return "update Data";
}
function selectDataByssmId($ssm_id)
{
    try {

        $out = Database::executeRoutedFn('ssm_data__select_by_ssmid', $ssm_id);
    
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['success'] = 1;
    return $response;
    // $db_connection = new Database();
    // $conn = $db_connection->dbConnection();
    // // $sql = "SELECT * FROM ssm WHERE ssm_id  = ?";
    // $sql = "SELECT * FROM ssm WHERE ssm_id  = ? order by created_at desc";

    // $res = null;

    // try {
    //     $query =  $conn->prepare($sql);
    //     $query->execute(array($ssm_id));
    //     // $query->setFetchMode(PDO::FETCH_OBJ);
    //     $query->setFetchMode(PDO::FETCH_ASSOC);
    //     $res = $query->fetch();
    //     $res['power_bank_details'] = select_power_Bank_Data_By_ssmId($ssm_id);
    //     // $res['gms_details'] = select_Gsm_Data_By_ssmId($ssm_id);
    //     $res['near_wifi_details'] =  select_near_Wifi_Data_By_ssmId($ssm_id);
    //     $res['gnss_location_details'] = select_Gsm_Location_Data_By_ssmId($ssm_id);
    //     $res['near_cellular_operator_details'] = select_near_Cellular_Operator_Data_By_ssmId($ssm_id);
    //     $res['device_runtime'] = select_device_runtime_By_ssmId($ssm_id);
    //     $res['total_charge_avg'] = select_total_poc($ssm_id);
    // } catch (\PDOException $e) {
    //     exit($e->getMessage());
    // }
    // $conn = null;
    // $response['header_status_code'] = 'HTTP/1.1 200 OK';
    // $response['body'] = $res;
    // // var_dump($response);
    // return $response;
}
function selectsummarizeDataByssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    // $sql = "SELECT * FROM ssm WHERE ssm_id  = ?";
    $sql = "SELECT s.*, (SELECT COUNT(p.ssm_id) FROM power_bank p WHERE p.ssm_id = s.ssm_id) as total_power_bank,
    (SELECT COUNT(n.ssm_id) FROM near_wifi n WHERE n.ssm_id = s.ssm_id) as total_near_wifi,
    (SELECT COUNT(c.ssm_id) FROM near_cellular_operator c WHERE c.ssm_id = s.ssm_id) as total_near_cellular_operator
     FROM  ssm s WHERE s.ssm_id = ? ORDER BY updated_at DESC LIMIT 1";

    $res = null;

    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($ssm_id));
        // $query->setFetchMode(PDO::FETCH_OBJ);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $res;
    // var_dump($response);
    return $response;
}
function select_Gsm_Data_By_ssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM gms WHERE ssm_id  = ? order by created_at desc limit 1";

    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}

function select_total_poc($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT floor(AVG(A.poc)) as total_charge_avg FROM (SELECT power_bank.poc FROM power_bank where ssm_id = ? ORDER BY created_at DESC LIMIT 6) A";

    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res->total_charge_avg;
}
function select_Gsm_Location_Data_By_ssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM gnss_loaction WHERE ssm_id = ? order by created_at  desc limit 1";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function select_near_Wifi_Data_By_ssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM near_wifi WHERE ssm_id = ? order by created_at  desc limit 6";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function select_near_Cellular_Operator_Data_By_ssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM near_cellular_operator WHERE ssm_id = ? order by created_at desc limit 1";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}

function select_power_Bank_Data_By_ssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    // $sql = "SELECT * FROM power_bank WHERE ssm_id = ? order by created_at desc limit 6";
    // $sql = "SELECT *, (select exists(select battery_id from tbm_battery_info where battery_id = s.battery_id)) as is_valid  FROM power_bank s WHERE s.ssm_id = ? order by created_at desc limit 6";
    $sql = "SELECT *, 
                (CASE 
                    WHEN battery_id = '0000000000000000' THEN true
                    ELSE EXISTS(SELECT battery_id FROM tbm_battery_info WHERE battery_id = s.battery_id)
            END) as is_valid  
            FROM power_bank s  where s.ssm_id = ? 
            ORDER BY power_bank_id DESC 
            LIMIT 6;";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function select_device_runtime_By_ssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM grid_solar_totaluse WHERE ssm_id = ? order by created_at desc limit 1";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        
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
function checkIDFormat($string) {
    $length = strlen($string);
    $firstSix = substr($string, 0, 7); 
    $last = substr($string, -2); 
    if ($firstSix === 'SSM-TES' && $last === '11') {
        return true;
    } else {
        return false;
    }
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