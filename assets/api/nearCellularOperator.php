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
    if (!array_key_exists("ssm_id", $data)) {
        return unprocessableEntityResponse('ssm_id is required');
    }
    if (!array_key_exists("mcc", $data)) {
        return unprocessableEntityResponse('mcc is required');
    }
    if (!array_key_exists("mnc", $data)) {
        return unprocessableEntityResponse('mnc is required');
    }
    if (!array_key_exists("rxlev", $data)) {
        return unprocessableEntityResponse('rxlev is required');
    }
    if (!array_key_exists("cell_id", $data)) {
        return unprocessableEntityResponse('cell_id is required');
    }
    if (!array_key_exists("arfcn", $data)) {
        return unprocessableEntityResponse('arfcn is required');
    }
    if (!array_key_exists("lac", $data)) {
        return unprocessableEntityResponse('lac is required');
    }
    if (!array_key_exists("bsic", $data)) {
        return unprocessableEntityResponse('bsic is required');
    }
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;

    $res_ssm_id =  ssmIsExist($data['ssm_id']);
    $res_ssm_id = json_decode($res_ssm_id, true);
    if ($res_ssm_id['ssm_id'] != 1) {
        $res['err_msg'] = "ssm_id not valid";
    } else {
        try {
            $sql = "INSERT INTO near_cellular_operator(ssm_id, mcc, mnc, rxlev, cell_id, arfcn, lac, bsic, created_at, updated_at)
            VALUES(:ssm_id, :mcc, :mnc, :rxlev, :cell_id, :arfcn, :lac, :bsic, NOW(), NOW())";
            $sth = $conn->prepare($sql);
            $status = $sth->execute(array(
                'ssm_id' => trim(strtoupper($data['ssm_id'])),
                'mcc'  => trim($data['mcc']),
                'mnc' => trim($data['mnc']),
                'rxlev' => trim($data['rxlev']),
                'cell_id' => trim($data['cell_id']),
                'arfcn' => trim($data['arfcn']),
                'lac' => trim($data['lac']),
                'bsic' => trim($data['bsic']),
            ));
            $res['success'] = "all data inserted successfully";
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
 