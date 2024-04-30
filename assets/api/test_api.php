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
            // $response = $input;
            $response = selectData();
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

    $sql = "SELECT  EXISTS (select ssm_id from ssm where ssm_id = ? AND (SELECT COUNT(pw.ssm_id) < 6 FROM power_bank pw WHERE pw.ssm_id = ?) )as ssm_id";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($ssm_id, $ssm_id));
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
    if ((empty($data['name'])) || (!array_key_exists("name", $data))) {
        $data['name'] = "empty";
        // return unprocessableEntityResponse('name is required');
    }
    if ((empty($data['field1'])) || (!array_key_exists("field1", $data))) {
        $data['field1'] = "empty";
        // return unprocessableEntityResponse('name is required');
    }
    if ((empty($data['field2'])) || (!array_key_exists("field2", $data))) {
        $data['field2'] = "empty";
        // return unprocessableEntityResponse('name is required');
    }
    if ((empty($data['field3'])) || (!array_key_exists("field3", $data))) {
        $data['field3'] = "empty";
        // return unprocessableEntityResponse('name is required');
    }
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $res = null;
    try {
        $sql = "
        START TRANSACTION;
          INSERT INTO test_table (name, created_at, updated_at, field1, field2, field3) 
           VALUES (:name, NOW(), NOW(), :field1, :field2, :field3);
          SELECT * FROM test_table WHERE id = LAST_INSERT_ID();
        COMMIT;
        ";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
            'name'  => trim($data['name']),
            'field1'  => trim($data['field1']),
            'field2'  => trim($data['field2']),
            'field3'  => trim($data['field3']),
        ));
        $sth->setFetchMode(PDO::FETCH_OBJ);
        $res = $sth->fetchAll();
        // $res['out'] =  $res;
        $res['success'] = "all data inserted successfully";
    } catch (\PDOException $e) {
        exit($e->getMessage());
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
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM test_table order by id desc limit 100";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = $res;
    return $response;
}
function deleteData()
{
    return "delete Data";
}
