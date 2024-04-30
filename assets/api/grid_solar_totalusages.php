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

    $res_user_id =  userIsExist($input['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    if ($res_user_id['user_id'] != 1 || empty($input['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {
        switch ($req_method) {
            case 'POST':
                $response = select_grid_solar_total_use_data($input);
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
    // if (!array_key_exists("user_id", $data)) {
    //     return unprocessableEntityResponse('user_id is required ');
    // }

    // $db_connection = new Database();
    // $conn = $db_connection->dbConnection();

    // $res = null;


    // $res_user_id =  userIsExist($data['user_id']);
    // $res_user_id = json_decode($res_user_id, true);
    // if ($res_user_id['user_id'] != 1) {
    //     $res['err_msg'] = "user_id not valid";
    // } else {
    //     try {
    //         $sql = "INSERT INTO activity_log( user_id, section, command, description, ip, time, date, created_at)
    //         VALUES(:user_id, :section, :command, :description, :user_ip, now(), CURRENT_DATE(), NOW())";
    //         $sth = $conn->prepare($sql);
    //         $status = $sth->execute(array(
    //             'user_id' => trim($data['user_id']),
    //             'section'  => trim($data['section']),
    //             'command' => trim($data['command']),
    //             'description' => trim($data['description']),
    //             'user_ip' => trim($data['user_trc_details']),
    //         ));
    //         $res['success'] = "all data inserted successfully";
    //     } catch (\PDOException $e) {
    //         exit($e->getMessage());
    //     }
    // }

    // $conn = null;

    // $response['header_status_code'] = 'HTTP/1.1 201 Created';
    // $response['body'] = $res;
    // return $response;
}
function updateDate()
{
    return "update Data";
}
function summarizedData($add, $c_m, $ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $ssm_id = empty($ssm_id) ? '' : " where ssm_id  = '$ssm_id'";


    $sql = "select sum(from_grid) as total_grid, sum(from_solar) as total_solar, sum(from_battery) as total_battery,  sum(user_usage) total_user_usages,(select count(ssm_id) from  devices $ssm_id) as total_device from grid_solar_totaluse $add";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();

        // $query = $conn->prepare("select (sum(gst.from_solar)*constant)/ count(ssm_id) as total_foot_print
        // from footprint_constant fc, grid_solar_totaluse gst where
        // fc.country = (select country from devices where ssm_id = gst.ssm_id) $c_m
        // group by gst.ssm_id, fc.country
        // ");

        $query = $conn->prepare("select (sum(gst.from_solar)*constant)/ 1 as total_foot_print
        from footprint_constant fc, grid_solar_totaluse gst where
        fc.country = (select country from devices where ssm_id = gst.ssm_id) $c_m
        group by gst.ssm_id, fc.country
        ");
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res_c = $query->fetchAll();
        $team = $i = 0;

        foreach ($res_c as $value) {
            $i++;
            $team += $value->total_foot_print;
        }

        // $team = $team >0 ? $team/$i : 0;
        $res['total_footprint'] = $team;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function select_grid_solar_total_use_data($input)
{
    $from_date = $input['from_date'];
    $to_date = $input['to_date'];
    $from_time = $input['from_time'];
    $to_time = $input['to_time'];
    $ssm_id = $input['ssm_id'];
    $a = 0;
    $d = 0;
    $t = 0;

    $add_where =  (empty($from_date) ?
        (empty($to_date) ?
            (empty($from_time) ?
                (empty($to_time) ?
                    (empty($ssm_id) ?
                        '' :
                        "Where") :
                    'Where') :
                'Where') :
            'Where') :
        'Where');

    if (!empty($from_date)) {
        if (empty($to_date)) {
            $to_date = date("Y-m-d");
        }
        $d = 1;
        $from_date = "(date between '$from_date' and '$to_date' )";
    } else {
        $from_date = '';
    }

    if ((!empty($to_date)) && (empty($from_date))) {
        $d = 1;
        $from_date = "(date between (SELECT  MIN(date) as from_date from grid_solar_totaluse) and '$to_date')";
    }

    if (!empty($from_time)) {
        if (empty($to_time)) {
            $to_time = date("h:i:s");
        }
        $t = 1;
        $from_time = " (time between '$from_time' and '$to_time' )";
        if ($a == 1 || $d == 1) {
            $from_time = 'and ' . $from_time;
        }
    } else {
        $from_time = '';
    }
    if ((!empty($to_time)) && (empty($from_time))) {
        $t = 1;
        $from_time = "(time between (SELECT  MIN(time) as from_time from grid_solar_totaluse) and '$to_date')";
        if ($a == 1 || $d == 1) {
            $from_time = 'and ' . $from_time;
        }
    }
    if (!empty($ssm_id)) {
        $a = 1;
        $ssm_id = "ssm_id = '$ssm_id'";
        if ($t == 1 || $d == 1) {
            $ssm_id = 'and ' . $ssm_id;
        }
    } else {
        $ssm_id = '';
    }
    $add_where = empty($add_where) ? " WHERE DATE(date) >=  (select max(date) 
    from grid_solar_totaluse) - INTERVAL 30 DAY " : $add_where;

    $sql = "Select date as y, sum(from_solar) as a, sum(from_grid) as b, sum(user_usage) as d, sum(from_battery) as c from grid_solar_totaluse $add_where $from_date  $ssm_id GROUP BY date order by date";
    $summ =  "$add_where $from_date  $ssm_id";

    $c_m = empty($from_date) && empty($ssm_id) ? '' : "and $from_date  $ssm_id";
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';

        $response['body'] = summarizedData($summ, $c_m, $input['ssm_id']);
        $response['body']['res'] = $res;
        $response['body']['carbon_emission'] = carmonEimissionData($c_m);
        // $response['body']['sql'] = $sql;

        // var_dump($response);
        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function carmonEimissionData($add)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $add = empty($add) ? " and DATE(date) >=  (select max(date) 
    from grid_solar_totaluse) - INTERVAL 30 DAY " : $add;
    $sql = "select (sum(gst.from_solar)*constant)/ 1 as total_foot_print,  date
    from footprint_constant fc, grid_solar_totaluse gst where
    fc.country = (select country from devices where ssm_id = gst.ssm_id) $add
    group by gst.date, fc.country";

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
    return $res;
}
