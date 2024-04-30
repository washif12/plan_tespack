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
    if ($res_user_id['user_id'] <= 0 || empty($input['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {
        
        switch ($req_method) {
            case 'POST':
                    $response = locationPaginateByDevice($input);
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

function locationPaginateByDevice($data)
{

    if ((!array_key_exists("from_date", $data)) || (empty($data['from_date']))) {
        return unprocessableEntityResponse('from_date not provided or empty');
    }
    if ((!array_key_exists("to_date", $data)) || (empty($data['to_date']))) {
        return unprocessableEntityResponse('to_date not provided or empty');
    }

    if ((!array_key_exists("ssm_id", $data)) || (empty($data['ssm_id']))) {
        return unprocessableEntityResponse('ssm_id not provided or empty');
    }

    $res_ssm_id =  ssmIsExist($data['ssm_id']);
    $res_ssm_id = json_decode($res_ssm_id, true);

    if ($res_ssm_id['ssm_id'] != 1) {
        return unprocessableEntityResponse('ssm_id not valid');
    }

    $limit = $data["limit"];
    $limit = empty($data['limit']) ? "limit 10" : "limit $limit";

    $offset = $data["offset"];
    $offset = empty($data['offset']) ? "" : "and gnss_location_id < $offset";

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "select * from gnss_loaction  where created_at  between :from_date and :to_date and ssm_id = :ssm_id $offset  order by gnss_location_id desc $limit";

    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array(
            'from_date' => trim($data['from_date']),
            'to_date'  => trim($data['to_date']),
            'ssm_id'  => trim($data['ssm_id'])
        ));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();

        $response['body']['res'] = $res;
        $response['body']['success'] = 1;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';

    return $response;
}
function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
        'success' => 0
    ];
    return $response;
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
function checkIDFormat($string)
{
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
