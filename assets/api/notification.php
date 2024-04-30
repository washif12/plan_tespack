<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE");
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
    // $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $ssm_id = "";
    $res_user_id =  userIsExist($input['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    if ($res_user_id['user_id'] == 0  || empty($input['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {

        switch ($req_method) {
            case 'POST':
                $response = insertData($input);
                break;
            case 'PATCH':
                if ((array_key_exists("notify", $input))) {
                    $response =  selectDataByUser($input);
                } else {
                    $response =  selectData($input);
                }
                break;
            case 'PUT':
                $response = updateData($input);
                break;
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
function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
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
    if (!array_key_exists("foreign_id", $data)) {
        return unprocessableEntityResponse('foreign_id is required');
    }
    if (!array_key_exists("foreign_st", $data)) {
        return unprocessableEntityResponse('foreign_st is required');
    }
    if (!array_key_exists("title", $data)) {
        return unprocessableEntityResponse('title is required');
    }
    if (!array_key_exists("content", $data)) {
        return unprocessableEntityResponse('content is required');
    }
    // if (!array_key_exists("des1", $data)) {
    //     return unprocessableEntityResponse('des1 is required');
    // }
    // if (!array_key_exists("des2", $data)) {
    //     return unprocessableEntityResponse('des2 is required');
    // }
    // if (!array_key_exists("des3", $data)) {
    //     return unprocessableEntityResponse('des3 is required');
    // }

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;

    $res_ssm_id =  foreignIDIsExist($data['foreign_id'], $data['foreign_st']);
    $res_ssm_id = json_decode($res_ssm_id, true);
    if ($res_ssm_id['foreign_id'] != 1) {
        $res['error_msg'] = "Invalid foreign details provided";
    } else {
        try {
            $sql = "insert into notification (foreign_id, foreign_st, title, content, des1, des2, des3, created_at, updated_at,created_by, user_date) values(:foreign_id, :foreign_st, :title, :content, :des1, :des2, :des3, now(), now(), :user_id, :user_date)";
            $sth = $conn->prepare($sql);
            $status = $sth->execute(array(
                'foreign_id' => trim(strtolower($data['foreign_id'])),
                'foreign_st'  => trim($data['foreign_st']),
                'title' => trim($data['title']),
                'content' => trim($data['content']),
                'des1' => trim($data['des1']),
                'des2' => trim($data['des2']),
                'des3' => trim($data['des3']),
                'user_date' => trim($data['user_date']),
                'user_id' => trim($data['user_id'])
            ));
            $res['success'] = "all data inserted successfully";
            $res['notification_id'] = $conn->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    $conn = null;

    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = $res;
    return $response;
}
function updateData($data)
{
    if (!array_key_exists("notification_id", $data)) {
        return unprocessableEntityResponse('notification_id is required');
    }
    if (!array_key_exists("user_id", $data)) {
        return unprocessableEntityResponse('user_id is required');
    }

    $seen = "";
    $remove = "";
    if ((array_key_exists("remove", $data)) || (!empty($data['remove']))) {
        $remove = ", remove = 1";
    }
    if ((array_key_exists("seen", $data)) || (!empty($data['seen']))) {
        $seen = ", seen = 1";
    }
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $res_ssm_id =  notificationIsExist($data['notification_id'], $data['user_id']);
    $res_ssm_id = json_decode($res_ssm_id, true);
    if ($res_ssm_id['notify'] != 1) {
        return unprocessableEntityResponse('Invalid data provided');
    } else {
        $sql = "update notification set updated_at = now() $seen $remove where notification_id  =?";

        $res = null;
        try {
            $query =  $conn->prepare($sql);
            $res = $query->execute(array($data['notification_id']));
            if ($res == 1) {
                $res = "all data updated successfully";
            }
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 ok';

    $response['body']['status'] = 1;
    $response['body']['res'] = $res;
    return $response;
}
function selectData($data)
{
    if (!array_key_exists("ssm_id", $data)) {
        return unprocessableEntityResponse('ssm_id is required');
    }
    // if (!array_key_exists("foreign_st", $data)) {
    //     return unprocessableEntityResponse('foreign_st is required');
    // }
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "select * from tespack_plan.notification where des2 = ? order by notification_id desc limit 1";
    // $sql = "Select * from notification where foreign_id = ? AND foreign_st = ? order by notification_id desc limit 1";
    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($data['ssm_id']));
        // $query->execute(array($data['foreign_id'], $data['foreign_st']));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 201 ok';

    $response['body']['status'] = 1;
    $response['body']['res'] = $res;
    return $response;
}
function selectDataByUser($data)
{
    // if (!array_key_exists("foreign_id", $data)) {
    //     return unprocessableEntityResponse('foreign_id is required');
    // }
    // if (!array_key_exists("foreign_st", $data)) {
    //     return unprocessableEntityResponse('foreign_st is required');
    // }


         // new comment
    // $limit = $data["limit"];
    // $limit = empty($data['limit']) ? "limit 10" : "limit $limit";

    // $offset = $data["offset"];
    // $offset = empty($data['offset']) ? "" : "and n1.notification_id < $offset";
  
    // $db_connection = new Database();
    // $conn = $db_connection->dbConnection();
    // $sql = "SELECT n1.* FROM notification n1 WHERE n1.created_by = ? and n1.remove = 0 and n1.des1 = 'outside' $offset  order by n1.notification_id desc $limit";
    // // $sql = "SELECT n1.* FROM notification n1 LEFT JOIN notification n2 ON
    // // (n1.foreign_id = n2.foreign_id AND n1.notification_id < n2.notification_id)
    // // WHERE n2.notification_id IS NULL and  n1.created_by = ? $offset  order by n1.created_at desc $limit";
    
    // $res = null;
    // try {
    //     $query =  $conn->prepare($sql);
    //     $query->execute(array($data['user_id']));
    //     $query->setFetchMode(PDO::FETCH_OBJ);
    //     $res = $query->fetchAll();
    // } catch (\PDOException $e) {
    //     exit($e->getMessage());
    // }
    // $conn = null;

    ////end comment


    try {
        $out = Database::executeRoutedFn('notification__paginate', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    
    $response['header_status_code'] = 'HTTP/1.1 201 ok';

    $response['body']['status'] = 1;
    $response['body'] = $out;
    return $response;
}
function deleteData()
{
    return "delete Data";
}

function foreignIDIsExist($id, $foreign_st)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT  EXISTS (SELECT * FROM $foreign_st WHERE id = ?  )as  foreign_id";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($id));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return json_encode($res, JSON_FORCE_OBJECT);
}

function notificationIsExist($id, $user_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT  EXISTS (SELECT * FROM notification WHERE notification_id = ? and created_by = ? )as  notify";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($id, $user_id));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return json_encode($res, JSON_FORCE_OBJECT);
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
