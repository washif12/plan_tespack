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
        // case 'GET':
        //     $response = $input;
        //     // $response = selectData();
        //     break;
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
    if (!array_key_exists("lat", $data)) {
        return unprocessableEntityResponse('lat is required');
    }
    if (!array_key_exists("lon", $data)) {
        return unprocessableEntityResponse('lon is required');
    }
    // if (!array_key_exists("lon", $data)) {
    //     return unprocessableEntityResponse('lon is required');
    // }
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;

    $res_ssm_id =  ssmIsExist($data['ssm_id']);
    $res_ssm_id = json_decode($res_ssm_id, true);
    if ($res_ssm_id['ssm_id'] != 1) {
        $res['err_msg'] = "ssm_id not valid";
    } else {
        try {
            $sql = "INSERT INTO gnss_loaction (latitude, longitude, ssm_id, altitude, created_at, updated_at) 
            VALUES (:lat, :lon, :ssm_id, :altitude, NOW(), NOW())";
            $sth = $conn->prepare($sql);
            $status = $sth->execute(array(
                'lat' => trim(convLat($data['lat'])),
                'lon'  => trim(convLong($data['lon'])),
                'ssm_id' => trim(strtoupper($data['ssm_id'])),
                'altitude' => trim($data['alt'])
            ));
            $res['success'] = "all data inserted successfully";
            $res['ssm_id'] = $res_ssm_id['ssm_id'];
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
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
function deleteData()
{
    return "delete Data";
}

function convLat($txt_lat)
{
    $latFirst = substr($txt_lat, 0, 2);

    $getLatMinSec = substr($txt_lat, 2, 9) . str_split(',')[0];

    $getLatDirection = substr($txt_lat, 10, 11);

    $latSecond = $getLatMinSec / 60;

    $finalLat = floatval($latFirst) + floatval($latSecond);

    if ($getLatDirection == "S") {

        $finalLat = "-" . $finalLat;
    }
    return $finalLat;
}
function convLong($txt_long)
{

    $longFirst = substr($txt_long,0,3);

    $getLongMinSecL = substr($txt_long,3,11).str_split(',')[0];
    
    $getLongDirection = substr($txt_long,11,12);
    
    $longSecond = $getLongMinSecL/60;
    
    $finalLong = floatval($longFirst) + floatval($longSecond);
    
    if($getLongDirection == "W"){
    
    $finalLong = "-".$finalLong;
    }
    return $finalLong;
}

function validateSecretKey($string) {
    $db_connection = new Database();
    if(md5($db_connection->secretKey) == $string){
        return true;
    }else{
        return false;
    }
}
