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
    // $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $ssm_id = "";
    $res_user_id =  userIsExist($input['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    if ($res_user_id['user_id'] != 1 || empty($input['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {
        switch ($req_method) {
            case 'POST':
                // if (empty(trim($input['country'])) && empty(trim($input['project'])) && empty(trim($input['pro_manager'])) && empty(trim($input['ssm']))) {
                //     $response = selectData($input);
                // }
                // if ((!empty(trim($input['country']))) && empty(trim($input['project'])) && empty(trim($input['pro_manager']))  && empty(trim($input['ssm']))) {
                //     $response = selectDataByCountry($input);
                // }
                // if (empty(trim($input['country'])) && (!empty(trim($input['project']))) && empty(trim($input['pro_manager']))  && empty(trim($input['ssm']))) {
                //     $response = selectDataByProject($input);
                // }
                // if (empty(trim($input['country'])) && empty(trim($input['project'])) && (!empty(trim($input['pro_manager'])))  && empty(trim($input['ssm']))) {
                //     $response = selectDataByProjecManager($input);
                // }
                // if (empty(trim($input['country'])) && empty(trim($input['project'])) && empty(trim($input['pro_manager']))  && (!empty(trim($input['ssm'])))) {
                //     $response = selectDataByDevice($input);
                // }
                $response= selectDataPg($input);
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

function selectDataPg($data)
{
    try {
        $out = Database::executeRoutedFn('ssm__select_for_map', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['status'] = 1;
    return $response;

}
function selectData($inputData)
{
    $limit = $inputData["limit"];
    $limit = empty($inputData['limit']) ? '' : "limit $limit";

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT (SELECT name from projects where team_id =
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name,(select array_to_json(ARRAY_AGG(name)) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id)  inner join devices ds on ds.ssm_id = m1.ssm_id WHERE m2.auto_id IS NULL $limit";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        for ($i = 0; $i < sizeof($res); $i++) {
            $res[$i]->power_bank_details = select_power_Bank_Data_By_ssmId($res[$i]->ssm_id);
            // $res[$i]->gms_details = select_Gsm_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_wifi_details =  select_near_Wifi_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gnss_location_details = select_Gsm_Location_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_cellular_operator_details = select_near_Cellular_Operator_Data_By_ssmId($res[$i]->ssm_id);
        }
        $response['body']['country'] = selectCountryData("");
        $response['body']['project'] = selectProjectData("");
        $response['body']['project_manager'] = selectProject_managerData("");
        $response['body']['device'] = selectDeviceData("");
        $response['body']['res'] = $res;  
        $response['body']['success'] = 0;
        $response['body']['total_device'] = count($res);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';

    return $response;
}

function selectDataByCountry($inputData)
{
    $limit = $inputData["limit"];
    $limit = empty($inputData['limit']) ? '' : "limit $limit";
    $country = $inputData['country'];

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT (SELECT name from projects where team_id =
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name,(select array_to_json(ARRAY_AGG(name)) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) inner join devices d ON (m1.ssm_id = d.ssm_id) WHERE m2.auto_id IS NULL and d.country = ? $limit";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($country));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();

        for ($i = 0; $i < sizeof($res); $i++) {
            $res[$i]->power_bank_details = select_power_Bank_Data_By_ssmId($res[$i]->ssm_id);
            // $res[$i]->gms_details = select_Gsm_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_wifi_details =  select_near_Wifi_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gnss_location_details = select_Gsm_Location_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_cellular_operator_details = select_near_Cellular_Operator_Data_By_ssmId($res[$i]->ssm_id);
        }
        // $response['body']['country'] = selectCountryData("");
        $response['body']['project'] = selectProjectData("select * from projects where country = '$country'");
        $response['body']['project_manager'] = selectProject_managerData("SELECT distinct pm.* FROM project_managers pm inner join projects
        p on pm.team_id = p.team_id where p.country= '$country'");
        $response['body']['device'] = selectDeviceData("select * from devices where country = '$country'");
        $response['body']['res'] = $res;
        $response['body']['success'] = 1;
        $response['body']['total_device'] = count($res);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';

    return $response;
}
function selectDataByProject($inputData)
{
    $limit = $inputData["limit"];
    $limit = empty($inputData['limit']) ? '' : "limit $limit";
    $project = $inputData['project'];

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT (SELECT name from projects where team_id =
                (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name, (select array_to_json(ARRAY_AGG(name)) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.*,d.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) inner join devices d ON (m1.ssm_id = d.ssm_id) inner join projects p ON (p.team_id = d.team_id) WHERE m2.auto_id IS NULL and p.id = ?";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($project));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();

        for ($i = 0; $i < sizeof($res); $i++) {
            $res[$i]->power_bank_details = select_power_Bank_Data_By_ssmId($res[$i]->ssm_id);
            // $res[$i]->gms_details = select_Gsm_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_wifi_details =  select_near_Wifi_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gnss_location_details = select_Gsm_Location_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_cellular_operator_details = select_near_Cellular_Operator_Data_By_ssmId($res[$i]->ssm_id);
        }
        $response['body']['country'] = selectCountryData("select distinct country from projects where id = ' $project'");

        // $response['body']['project'] = selectProjectData("select * from projects where team_id = '$project'");

        $response['body']['project_manager'] = selectProject_managerData("SELECT distinct pm.* FROM project_managers pm inner join projects p on pm.team_id = p.team_id where p.id= '$project'");

        $response['body']['device'] = selectDeviceData("select * from devices d inner join projects
        p on d.team_id = p.team_id where p.id= '$project'");
        $response['body']['res'] = $res;
        $response['body']['success'] = 2;
        $response['body']['total_device'] = count($res);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';

    return $response;
}
function selectDataByProjecManager($inputData)
{
    $limit = $inputData["limit"];
    $limit = empty($inputData['limit']) ? '' : "limit $limit";
    $project_manager = $inputData['pro_manager'];

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT (SELECT name from projects where team_id =
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name, (select array_to_json(ARRAY_AGG(name)) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) inner join devices d ON (m1.ssm_id = d.ssm_id) WHERE m2.auto_id IS NULL and d.team_id = ? $limit";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($project_manager));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();

        for ($i = 0; $i < sizeof($res); $i++) {
            $res[$i]->power_bank_details = select_power_Bank_Data_By_ssmId($res[$i]->ssm_id);
            // $res[$i]->gms_details = select_Gsm_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_wifi_details =  select_near_Wifi_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gnss_location_details = select_Gsm_Location_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_cellular_operator_details = select_near_Cellular_Operator_Data_By_ssmId($res[$i]->ssm_id);
        }
        $response['body']['country'] = selectCountryData("select distinct country from projects where team_id = '$project_manager'");
        $response['body']['project'] = selectProjectData("select * from projects where team_id = '$project_manager'");

        $response['body']['device'] = selectDeviceData("select * from devices  where team_id= '$project_manager'");

        $response['body']['res'] = $res;
        $response['body']['success'] = 3;
        $response['body']['total_device'] = count($res);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';

    return $response;
}
function selectDataByDevice($inputData){
    $limit = $inputData["limit"];
    $limit = empty($inputData['limit']) ? '' : "limit $limit";
    $ssm_id = $inputData['ssm'];

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT (SELECT name from projects where team_id =
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name, (select array_to_json(ARRAY_AGG(name)) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) inner join devices d ON (m1.ssm_id = d.ssm_id) WHERE m2.auto_id IS NULL and d.ssm_id = ? $limit";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();

        for ($i = 0; $i < sizeof($res); $i++) {
            $res[$i]->power_bank_details = select_power_Bank_Data_By_ssmId($res[$i]->ssm_id);
            // $res[$i]->gms_details = select_Gsm_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_wifi_details =  select_near_Wifi_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gnss_location_details = select_Gsm_Location_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_cellular_operator_details = select_near_Cellular_Operator_Data_By_ssmId($res[$i]->ssm_id);
        }
        $response['body']['country'] = selectCountryData("select distinct country from devices where ssm_id = '$ssm_id'");
        $response['body']['project'] = selectProjectData("select p.* from devices d inner join projects
        p on d.team_id = p.team_id where d.ssm_id = '$ssm_id'");
        $response['body']['project_manager'] = selectProject_managerData("select p.* from devices d inner join project_managers p on d.team_id = p.team_id where d.ssm_id = '$ssm_id'");
        // $response['body']['device'] = selectDeviceData("select * from devices  where team_id= '$ssm_id'");

        $response['body']['res'] = $res;
        $response['body']['success'] = 4;
        $response['body']['total_device'] = count($res);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';

    return $response;
}
function selectCountryData($sql)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    if (empty($sql)) {
        $sql = "SELECT * FROM countries";
    }
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body'] = $res;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function selectProjectData($sql)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    if (empty($sql)) {
        $sql = "SELECT * FROM projects";
    }
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
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $res;
    return $res;
}
function selectDeviceData($sql)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    if (empty($sql)) {
        $sql = "SELECT * FROM devices";
    }
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
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $res;
    return $res;
}
function selectProject_managerData($sql)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    if (empty($sql)) {
        $sql = "SELECT * FROM project_managers";
    }
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
function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
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
    $sql = "SELECT * FROM ssm WHERE ssm_id  = ? order by updated_at desc";
    $res = null;

    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($ssm_id));
        // $query->setFetchMode(PDO::FETCH_OBJ);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
        $res['power_bank_details'] = select_power_Bank_Data_By_ssmId($ssm_id);
        // $res['gms_details'] = select_Gsm_Data_By_ssmId($ssm_id);
        $res['near_wifi_details'] =  select_near_Wifi_Data_By_ssmId($ssm_id);
        $res['gnss_loaction_details'] = select_Gsm_Location_Data_By_ssmId($ssm_id);
        $res['near_cellular_operator_details'] = select_near_Cellular_Operator_Data_By_ssmId($ssm_id);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $res;
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
    $sql = "SELECT * FROM gms WHERE ssm_id  = ? order by created_at limit 1";

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
    $sql = "SELECT * FROM gnss_loaction WHERE ssm_id = ? order by created_at desc limit 1";
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
    $sql = "SELECT * FROM near_wifi WHERE ssm_id = ? order by created_at limit 6";
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
    $sql = "SELECT * FROM near_cellular_operator WHERE ssm_id = ? order by created_at limit 1";
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
    $sql = "SELECT * FROM power_bank WHERE ssm_id = ? order by created_at limit 6";
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

function getTotalDevices()
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    // $sql = "SELECT  EXISTS (select ssm_id from ssm where ssm_id = ?  )as  ssm_id";
    $sql = "SELECT count(distinct(ssm_id)) as total_device FROM devices;";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
}
// SELECT *, (select array_to_json(ARRAY_AGG(name)) from project_managers  where id = 
// (select pm_id from smb_resp where smb_id = d.id )) as device_responsible, (select name 
// from projects where team_id = d.team_id limit 1) as project_name
// FROM devices d