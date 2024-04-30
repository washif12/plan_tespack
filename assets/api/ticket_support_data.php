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
    $res_user_id =  userIsExist($_GET['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    if ($res_user_id['user_id'] != 1 || empty($_GET['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {
        switch ($req_method) {
            case 'GET':
                $response = select_ticket_support_data($_GET['user_id'], $_GET['limit'], $_GET['offset']);
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
function insertData($data)
{
}
function updateDate()
{
    return "update Data";
}

function select_ticket_support_data($user_id, $limit, $offset)
{


    try {
        $object = new stdClass();
  
        // Added property to the object
        $object->user_id = $user_id;
        $object->limit =  $limit;
        $object->offset =  $offset;
        $out = Database::executeRoutedFn('ticket_support__paginate_by_user', $object);
    
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

    // $query = $conn->prepare("SELECT role, email FROM users where id = ?");
    // $query->execute(array($user_id));
    // $query->setFetchMode(PDO::FETCH_OBJ);
    // $res = $query->fetch();

    // // $limit = $data["limit"];
    // $limit = empty($limit) ? "limit 10" : "limit $limit";
    // $offset = empty($offset) ? "" : "and ts.id < $offset";
    // if($res->role == 0 && $res->role == 1){
    //     $sql = $conn->prepare("SELECT * FROM ticket_support ts $offset order by ts.id desc $limit;");
    //     $sql->execute();
    // }
    // else if($res->role == 3) {
    //     $sql = $conn->prepare("SELECT id, replacement, quantity, ref, country, project, responsible, email, phone, image_path FROM ticket_support ts  where replacement !='' and country = (select country from users where id = ? limit 1) $offset order by ts.id desc $limit;");
    //     $sql->execute(array($user_id));
    // }
    // else{
    //     $sql = $conn->prepare("SELECT id, replacement, quantity, ref, country, project, responsible, email, phone, image_path FROM ticket_support ts  where replacement !='' and email = ? $offset order by ts.id desc $limit;");
    //     $sql->execute(array($res->email));
    // }
    // $sql->setFetchMode(PDO::FETCH_OBJ);
    // $res = $sql->fetchAll();
    // $response['header_status_code'] = 'HTTP/1.1 200 OK';
    // $response['body']['ret_data'] = $res;

    // return  $response;
}

