<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require __DIR__ . '/classes/database.php';
// require __DIR__ . '/classes/ database.php';

processRequest();
function processRequest()
{
    $req_method = $_SERVER["REQUEST_METHOD"];

    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    // $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $ssm_id = "";
    switch ($req_method) {
        case 'GET':
            if (!empty($_GET['ssm_id'])) {
                $response = selectDataByssmId($_GET['ssm_id']);
            } else {
                $response = selectData("");
            }
            break;
        case 'POST':
            $response =  insertData($input);
            break;
        case 'PUT':
            $response = updateDate();
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

function selectData($inputData)
{

    // $limit = $inputData["limit"];
    // $limit = empty($inputData['limit']) ? '' : "limit $limit";

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT m1.* FROM ssm m1 LEFT JOIN ssm m2 ON
    (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) WHERE m2.auto_id IS NULL order by m1.auto_id desc";

    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        for ($i = 0; $i < sizeof($res); $i++) {
            $res[$i]->power_bank_details = select_power_Bank_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gms_details = select_Gsm_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_wifi_details =  select_near_Wifi_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gnss_location_details = select_Gsm_Location_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_cellular_operator_details = select_near_Cellular_Operator_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->device_runtime = select_device_runtime_By_ssmId($res[$i]->ssm_id);
        }

        // $response['body']['country'] = selectCountryData("");
        // $response['body']['project'] = selectProjectData("");
        // $response['body']['project_manager'] = selectProject_managerData("");
        // $response['body']['device'] = selectDeviceData("");
        $response['body']['res'] = $res;
        $response['body']['success'] = 1;
        // $response['body']['total_device'] = count($res);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';

    return $response;
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
    // SSM-TES00000111
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;
    // $sql = "select ifnull(max(cast(subString(ssm_id,locate('-TES',ssm_id)+1,
    // length(ssm_id)-locate('-',ssm_id)) as UNSIGNED)),0)+1 as id from ssm order by auto_id";
    //////////////////////////////////////////
    $sql = "select ifnull(max(cast(subString(ssm_id, 8,  LENGTH(ssm_id) - 7 - 8) as UNSIGNED)),0)+1 as id from ssm order by auto_id";
    try {

        $query =  $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    // return "ssm-" . $res['id']; SSM-TES00000111
    return "SSM-TES" . $res['id'].date("dmY", strtotime("today"));
}
function insertData($data)
{

    if(!validateSecretKey($data['s_k'])){
        return unprocessableEntityResponse('unwanted attempts! try using a valid token.');
    }


    // if (!array_key_exists("ssm_id", $data)) {
    //     return unprocessableEntityResponse('ssm_id is required');
    // }
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
    // if (!array_key_exists("emei", $data)) {
    //     return unprocessableEntityResponse('emei is required');
    // }
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
    $data['emei'] = '';

    // b_s: battery status:
    // 0 = standby
    // 1 = charging
    // 2 = giving output
    // 3 = notConnected
    // 4 = shutdown

    // if($data['b_sta']==0){
    //     $data['b_sta'] = "standby";
    // }
    // if($data['b_sta']==1){
    //     $data['b_sta'] = "charging";
    // }
    // if($data['b_sta']==2){
    //     $data['b_sta'] = "giving output";
    // }
    // if($data['b_sta']==3){
    //     $data['b_sta'] = "notConnected";
    // }
    // if($data['b_sta']==3){
    //     $data['b_sta'] = "shutdown";
    // }

    if (!($data['b_sta'] >= 0 && $data['b_sta'] <= 3)) {
        return unprocessableEntityResponse('b_sta not valid');
    }
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


    // p_s: Power source

    // 0 = system is off 
    // 1 = battery
    // 2 = solar
    // 3 = adapter/grid


    if (!($data['p_s'] >= 0 && $data['p_s'] <= 3)) {
        return unprocessableEntityResponse('p_s not valid');
    }

    if($data['p_s']==0){
        $data['p_s'] = "System is off";
    }
    if($data['p_s']==1){
        $data['p_s'] = "Battery";
    }
    if($data['p_s']==2){
        $data['p_s'] = "Solar";
    }
    if($data['p_s']==3){
        $data['p_s'] = "Adapter/Grid";
    }

//     PowerSourceStatus:

// 0 = disconnected
// 1 = connected
// 2 = charging
// 3 = discharging
// 4 = giving output
// 5 = charging and giving output


    if (!($data['p_s_sta'] >= 0 && $data['p_s_sta'] <= 5)) {
        return unprocessableEntityResponse('p_s_sta not valid');
    }
    if($data['p_s_sta']==0){
        $data['p_s_sta'] = "Disconnected";
    }
    if($data['p_s_sta']==1){
        $data['p_s_sta'] = "Connected";
    }
    if($data['p_s_sta']==2){
        $data['p_s_sta'] = "Charging";
    }
    if($data['p_s_sta']==3){
        $data['p_s_sta'] = "Discharging";
    }
    if($data['p_s_sta']==4){
        $data['p_s_sta'] = "Giving Output";
    }
    if($data['p_s_sta']==5){
        $data['p_s_sta'] = "Charging and Giving output";
    }

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $ssm_id = "";
    
    // if ((!array_key_exists("ssm_id", $data))) {
    //     // $ssm_id =  autoID();
    //     $data['ssm_id'] = autoID();
    // } else {
    //     $res_ssm_id = ssmIsExist($data['ssm_id']);
    //     $res_ssm_id = json_decode($res_ssm_id, true);
    //     if ($res_ssm_id['ssm_id'] != 1) {
    //         return unprocessableEntityResponse('ssm_id not valid');
    //     }
    //     $ssm_id = $data['id'];
    // }
    if((!array_key_exists("ssm_id", $data))){
        return unprocessableEntityResponse('ssm_id not provided or not valid');
    }


    $res_ssm_id = ssmIsExist($data['ssm_id']);
    $res_ssm_id = json_decode($res_ssm_id, true);
    if ($res_ssm_id['ssm_id'] != 1) {
        return unprocessableEntityResponse('ssm_id not valid');
    }
    $ssm_id = $data['id'];
    
    if((!array_key_exists("ssm_id", $data))){
        return unprocessableEntityResponse('ssm_id not provided or not valid');
    }

    $res = null;
    $sql = "INSERT INTO ssm(ssm_id, signal_strength, network_id, last_seen_time, total_session, 
     imei, emei, power_source_type, power_source_status, total_charge, sos_activated, created_at,
    updated_at, battery_status, temperature, device_total_runtime, device_activity, user_activity, device_error, input_source, output_source, input_voltage, input_current, input_power, output_voltage, output_current, output_power, gnss) VALUES( :ssm_id,  :signal_strength, :network_id, now(), :total_session,
    :imei, :emei, :power_source_type, :power_source_status, :total_charge, :sos_activated,
    NOW(), NOW(), :battery_status, :temperature, :device_total_runtime, :device_activity, :user_activity, :device_error, :input_source, :output_source, :input_voltage, :input_current, :input_power, :output_voltage, :output_current, :output_power, :gnss)";
    try {
        $sth = $conn->prepare($sql);
        $status = $sth->execute(array(
            'ssm_id' => trim($data['ssm_id']),
            'signal_strength'  => trim($data['s_s']),
            'network_id' => trim($data['op']),
            'total_session' => trim($data['t_sn']),
            'imei' => trim($data['imei']),
            'emei' => trim($data['emei']),
            'power_source_type' => trim($data['p_s']),
            'power_source_status' => trim($data['p_s_sta']),
            'total_charge' => trim($data['t_ch']),
            'sos_activated' => trim($data['sos']),
            'battery_status' => trim($data['b_sta']),
            'temperature' => trim($data['temp']),
            'device_total_runtime' => trim($data['lifetime']),
            'device_activity' => trim($data['d_activity']),
            'user_activity' => trim($data['u_activity']),
            'device_error' => trim($data['err']),
            'input_source' => trim($data['Si']),
            'output_source' => trim($data['Bs']),
            'input_voltage' => trim($data['Vi']),
            'input_current' => trim($data['Ii']),
            'input_power' => trim($data['Pi']),
            'output_voltage' => trim($data['Vo']),
            'output_current' => trim($data['Io']),
            'output_power' => trim($data['Po']),
            'gnss' => trim($data['gnss'])
        ));
        $res = "all data inserted successfully";
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }

    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = [
        "post" => $res,
        "ssm_id" => $data['ssm_id']
    ];
    return $response;
}
function updateDate()
{
    return "update Data";
}
function selectDataByssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    // $sql = "SELECT * FROM ssm WHERE ssm_id  = ?";
    $sql = "SELECT * FROM ssm WHERE ssm_id  = ? order by created_at desc";

    $res = null;

    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($ssm_id));
        // $query->setFetchMode(PDO::FETCH_OBJ);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
        $res['power_bank_details'] = select_power_Bank_Data_By_ssmId($ssm_id);
        $res['gms_details'] = select_Gsm_Data_By_ssmId($ssm_id);
        $res['near_wifi_details'] =  select_near_Wifi_Data_By_ssmId($ssm_id);
        $res['gnss_location_details'] = select_Gsm_Location_Data_By_ssmId($ssm_id);
        $res['near_cellular_operator_details'] = select_near_Cellular_Operator_Data_By_ssmId($ssm_id);
        $res['device_runtime'] = select_device_runtime_By_ssmId($ssm_id);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $res;
    // var_dump($response);
    return $response;
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
    $sql = "SELECT * FROM power_bank WHERE ssm_id = ? order by created_at desc limit 6";
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
    $sql = "SELECT  EXISTS (select ssm_id from ssm_serial where ssm_id = ?  )as  ssm_id";
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


function validateSecretKey($string) {
    $db_connection = new Database();
    if(md5($db_connection->secretKey) == $string){
        return true;
    }else{
        return false;
    }
}