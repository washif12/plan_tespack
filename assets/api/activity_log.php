<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE, PATCH");
// header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require __DIR__ . '/classes/database.php';


processRequest();
function processRequest()
{
    $req_method = $_SERVER["REQUEST_METHOD"];
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    if($req_method != "POST"){
        require __DIR__ . '/classes/JwtHandler.php';
        // require __DIR__ . '/middleware.php';
    }
    switch ($req_method) {
        case 'GET':
            if (!empty($_GET['user_id'])) {
                $response = selectDataByUserId($_GET['user_id']);
            } else {
                $response = unprocessableEntityResponse("user_id not provided");
            }
            break;
        case 'POST':
            $response =  insertData($input);
            break;
        case 'PUT':
            $response = updateDate();
            break;
        case 'PATCH':
            $response = selectDataByUserId($input);
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
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function get_mac_address(){
    $MAC = exec('getmac');

    // Storing 'getmac' value in $MAC
    $MAC = strtok($MAC, ' ');
    return $MAC;
}
function insertData($data)
{
    if (!array_key_exists("user_id", $data)) {
        return unprocessableEntityResponse('user_id is required ');
    }
   
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;


    $res_user_id =  userIsExist($data['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    if ($res_user_id['user_id'] != 1) {
        $res['err_msg'] = "user_id not valid";
    } else {
        try {
            $sql = "INSERT INTO activity_log( user_id, section, command, description, ip, time, date, created_at)
            VALUES(:user_id, :section, :command, :description, :user_ip, now(), now(), NOW())";
            $sth = $conn->prepare($sql);
            $status = $sth->execute(array(
                'user_id' => trim($data['user_id']),
                'section'  => trim($data['section']),
                'command' => trim($data['command']),
                'description' => trim($data['description']),
                'user_ip' => trim($data['user_trc_details']),
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
function selectDataByUserId($data)
{
    if (!array_key_exists("user_id", $data)) {
        return unprocessableEntityResponse('user_id is required');
    }
    if (!array_key_exists("role", $data)) {
        return unprocessableEntityResponse('role is required');
    }
    if (!array_key_exists("country", $data)) {
        return unprocessableEntityResponse('country is required');
    }

    try {
        $out = Database::executeRoutedFn('activity_log__paginate_by_user_and_role', $data);
    
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

    // $limit = $data["limit"];
    // $limit = empty($data['limit']) ? "limit 50" : "limit $limit";

    // $offset = $data["offset"];
    // $offset = empty($data['offset']) ? "" : "and n1.notification_id < $offset";  //buggy
    // $out = [];
    // if($data['role'] == 1 || $data['role'] == 0){
    //     $sql = "SELECT al.*, u.fname, u.lname, u.email, (SELECT CONCAT(u.fname, ' ',u.lname))AS full_name FROM activity_log al INNER JOIN users u ON al.user_id = u.id $offset order by al.id desc $limit";
    //     $query = $conn->prepare($sql);
    //     $query->execute();
    // }
    // if($data['role'] == 2){

    //     $sql = "SELECT al.*, u.fname, u.lname, u.email, (SELECT CONCAT(u.fname, ' ',u.lname))AS full_name 
    //     FROM activity_log al  INNER JOIN users u ON al.user_id = u.id inner join team_members m on m.reg_id = u.id inner join project_managers pm on pm.team_id = m.team_id  where pm.team_id = (select team_id from project_managers where reg_id = :user_id limit 1) $offset order by al.id desc $limit";



    //     $query = $conn->prepare($sql);
    //     $query->execute(array('user_id' => trim($data['user_id'])));
    // }
    // if($data['role'] == 3){
    //     $sql = "SELECT al.*, u.fname, u.lname, u.email, (SELECT CONCAT(u.fname, ' ',u.lname))AS full_name FROM activity_log al INNER JOIN users u ON al.user_id = u.id where u.country = :country $offset order by al.id desc $limit";
    //     $query = $conn->prepare($sql);
    //     $query->execute(array('country' => trim($data['country'])));
    // }
    // if($data['role'] == 4){
    //     $sql = "SELECT al.*, u.fname, u.lname, u.email, (SELECT CONCAT(u.fname, ' ',u.lname))AS full_name FROM activity_log al INNER JOIN users u ON al.user_id = u.id WHERE u.id  = :user_id $offset order by al.id desc $limit";
    //     $query = $conn->prepare($sql);
    //     $query->execute(array('user_id' => trim($data['user_id'])));
    // }
    // $res = null;
    // try {

    //     $query->setFetchMode(PDO::FETCH_OBJ);
    //     $res = $query->fetchAll();
    //     if(count($res)==0){
    //         $res['res'] = [];
    //     }
    //     $response['header_status_code'] = 'HTTP/1.1 200 OK';
    //     $response['body'] = $res;
       
    //     return $response;
    // } catch (\PDOException $e) {
    //     exit($e->getMessage());
    // }
    // $conn = null;
    // return $res;
}
function deleteData()
{
    return "delete Data";
}
 

function operateQuery($sql, $param)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $res = [];
    try {
        $query =  $conn->prepare($sql);
        $query->execute($param);
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    return $res;
}