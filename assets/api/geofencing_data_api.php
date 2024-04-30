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

    $ssm_id = "";
    $res_user_id =  userIsExist($input['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    if ($res_user_id['user_id'] != 1 || empty($input['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {
        switch ($req_method) {
            case 'POST':
                if (empty(trim($input['country'])) && empty(trim($input['project'])) && empty(trim($input['pro_manager']))) {
                    $response = selectData($input);
                }
                if ((!empty(trim($input['country']))) && empty(trim($input['project'])) && empty(trim($input['pro_manager']))  && empty(trim($input['ssm']))) {
                    $response = selectDataByCountry($input);
                }
                if (empty(trim($input['country'])) && (!empty(trim($input['project']))) && empty(trim($input['pro_manager']))  && empty(trim($input['ssm']))) {
                    $response = selectDataByProject($input);
                }
                if (empty(trim($input['country'])) && empty(trim($input['project'])) && (!empty(trim($input['pro_manager'])))  && empty(trim($input['ssm']))) {
                    $response = selectDataByProjecManager($input);
                }
                // if (empty(trim($input['country'])) && empty(trim($input['project'])) && empty(trim($input['pro_manager']))  && (!empty(trim($input['ssm'])))) {
                //     $response = selectDataByDevice($input);
                // }
                break;
            case 'PATCH':
                $response =  insertData($input);
                break;
            case 'PUT':
                $response = updateDate($input);
                break;
            case 'DELETE':
                $response = deleteData($input);
                break;
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
function beforeInsert($data)
{
    if (!array_key_exists("ssm", $data)) {
        return unprocessableEntityResponse('ssm is required');
    }
    $devicelist = $data['ssm'];
    $count = 0;
    $res = false;
    foreach ($devicelist as $item) {
        $data['ssm_id'] = $item;
        // $res = insertData($data);
        $sql = "SELECT  EXISTS (select ssm_id from geofence_device where ssm_id = ?  )as  ssm_id";
        $res_ssm_id =  ssmIsExist($item, $sql);
        $res_ssm_id = json_decode($res_ssm_id, true);
        if ($res_ssm_id['ssm_id'] == 1) {
            $count = 1;
            break;
        }
    }
    if ($count == 1) {
        $res =  true;
    }

    return $res;
}
function insertData($data)
{

    if ((!array_key_exists("ssm", $data)) || (empty($data['ssm']))) {
        return unprocessableEntityResponse('ssm is required');
    }
    if (!array_key_exists("shape_type", $data)) {
        return unprocessableEntityResponse('shape_type is required');
    }
    if (!array_key_exists("shape_details", $data)) {
        return unprocessableEntityResponse('shape_details is required');
    }
    if (!array_key_exists("user_id", $data)) {
        return unprocessableEntityResponse('user_id is required');
    }

    $jwt = new JwtHandler();
    $token_data = $jwt->jwtDecodeData($_SESSION['token']);
    if($token_data->data->role == 4){
        return unprocessableEntityResponse("you've no permission to create");
    }
    $jwt = null;


    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;
    $from_date = $data['from_date'];
    $to_date = $data['to_date'];
    $shape_type = $data['shape_type'];
    $shape_details = $data['shape_details'];
    $des1 = $data['des1'];
    $des2 = $data['des2'];
    $des3 = $data['des3'];
    $created_by = $data['user_id'];
    try {
        $sql = "insert into geofencing( from_date, to_date, shape_type, shape_details,
            des1, des2, des3, created_at, updated_at, created_by) values( :from_date,  :to_date,  :shape_type, :shape_details, :des1, :des2, :des3, now(), now(), :created_by)";
        $sth = $conn->prepare($sql);
        $status = $sth->execute(array(
            'from_date' => trim($from_date),
            'to_date'  => trim($to_date),
            'shape_type'  => trim($shape_type),
            'shape_details'  => trim($shape_details),
            'des1'  => trim($des1),
            'des2'  => trim($des2),
            'des3'  => trim($des3),
            'created_by'  => trim($created_by)
        ));
        $geofence_id  = $conn->lastInsertId();
        $data['geofence_id'] = $geofence_id;
        foreach ($data['ssm'] as $item) {
            $res_ssm_id =  ssmIsExist($item, "");
            $res_ssm_id = json_decode($res_ssm_id, true);
            if ($res_ssm_id['ssm_id'] != 1) {

                // deleteData($data);
                return unprocessableEntityResponse($item . " not valid");
                break;
            } else {
                $sql1 = "insert into geofence_device(ssm_id, geofence_id, created_at, updated_at, created_by) values (:ssm_id, :geofence_id, now(), now(), :created_by)";
                $sth1 = $conn->prepare($sql1);
                $status = $sth1->execute(array(
                    'ssm_id' => trim(strtoupper($item)),
                    'geofence_id' => trim($geofence_id),
                    'created_by' => trim($data['user_id'])
                ));
            }
        }
        $res['success'] = "1";
        $response['header_status_code'] = 'HTTP/1.1 201 Created';
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }

    $conn = null;
    $response['body'] = $res;
    return $response;
}
function selectData($inputData)
{

    $limit = $inputData["limit"];
    $limit = empty($inputData['limit']) ? '' : "limit $limit";

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT (SELECT name from projects where team_id =
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name,(select json_arrayagg( name) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) WHERE m2.auto_id IS NULL $limit";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['country'] = selectCountryData("");
        $response['body']['project'] = selectProjectData("");
        $response['body']['project_manager'] = selectProject_managerData("");
        $response['body']['success'] = 0;
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
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name,(select json_arrayagg( name) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) inner join devices d ON (m1.ssm_id = d.ssm_id) WHERE m2.auto_id IS NULL and d.country = ? $limit";
    $res = null;
    try {

        $response['body']['project'] = selectProjectData("select * from projects where country = '$country'");
        $response['body']['project_manager'] = selectProject_managerData("SELECT distinct pm.* FROM project_managers pm inner join projects
        p on pm.team_id = p.team_id where p.country= '$country'");
        $response['body']['device'] = selectDeviceData("select * from devices where country = '$country'");
        $response['body']['success'] = 1;
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
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name, (select json_arrayagg( name) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.*,d.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) inner join devices d ON (m1.ssm_id = d.ssm_id) inner join projects p ON (p.team_id = d.team_id) WHERE m2.auto_id IS NULL and p.id = ?";
    $res = null;
    try {
        $response['body']['country'] = selectCountryData("select distinct country from projects where id = ' $project'");
        $response['body']['project_manager'] = selectProject_managerData("SELECT distinct pm.* FROM project_managers pm inner join projects p on pm.team_id = p.team_id where p.id= '$project'");
        $response['body']['device'] = selectDeviceData("select * from devices d inner join projects p on d.team_id = p.team_id where p.id= '$project'");
        $response['body']['success'] = 2;
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
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name, (select json_arrayagg( name) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) inner join devices d ON (m1.ssm_id = d.ssm_id) WHERE m2.auto_id IS NULL and d.team_id = ? $limit";
    $res = null;
    try {

        $response['body']['country'] = selectCountryData("select distinct country from projects where team_id = '$project_manager'");
        $response['body']['project'] = selectProjectData("select * from projects where team_id = '$project_manager'");

        $response['body']['device'] = selectDeviceData("select * from devices  where team_id= '$project_manager'");

        $response['body']['success'] = 3;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';

    return $response;
}
function selectDataByDevice($inputData)
{

    $limit = $inputData["limit"];
    $limit = empty($inputData['limit']) ? '' : "limit $limit";
    $ssm_id = $inputData['ssm'];

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "SELECT (SELECT name from projects where team_id =
    (select team_id from devices where ssm_id = m1.ssm_id limit 1) limit 1)as team_name, (select json_arrayagg( name) from project_managers  where id = (select pm_id from smb_resp where smb_id = (select id from devices where ssm_id = m1.ssm_id) )) as device_responsible, m1.* FROM ssm m1 LEFT JOIN ssm m2 ON (m1.ssm_id = m2.ssm_id AND m1.auto_id < m2.auto_id) inner join devices d ON (m1.ssm_id = d.ssm_id) WHERE m2.auto_id IS NULL and d.ssm_id = ? ";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();

        for ($i = 0; $i < sizeof($res); $i++) {
            $res[$i]->power_bank_details = select_power_Bank_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gms_details = select_Gsm_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_wifi_details =  select_near_Wifi_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->gnss_location_details = select_Gsm_Location_Data_By_ssmId($res[$i]->ssm_id);
            $res[$i]->near_cellular_operator_details = select_near_Cellular_Operator_Data_By_ssmId($res[$i]->ssm_id);
        }
        // $response['body']['country'] = selectCountryData("select distinct country from devices where ssm_id = '$ssm_id'");
        // $response['body']['project'] = selectProjectData("select p.* from devices d inner join projects
        // p on d.team_id = p.team_id where d.ssm_id = '$ssm_id'");
        // $response['body']['project_manager'] = selectProject_managerData("select p.* from devices d inner join project_managers p on d.team_id = p.team_id where d.ssm_id = '$ssm_id'");
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
function selectGeofenceData($sql, $data)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    if (empty($sql)) {
        $sql = "select ssm_id, ge.* from geofence_device gd inner join geofencing ge on gd.geofence_id = ge.id where created_by = :created_by";
    }
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute(array(
            'created_by' => $data['user_id']
        ));
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
    $response['header_status_code'] = 'HTTP/1.1 201 Unprocessable Entity';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
    ];
    $response['body']['success'] = 0;
    return $response;
}
function updateDate($data)
{
    if ((!array_key_exists("ssm", $data)) || (count($data['ssm']) == 0)) {
        return unprocessableEntityResponse('ssm is required or Invalid ssm formet');
    }
    if (!array_key_exists("geofence_id", $data)) {
        return unprocessableEntityResponse('geofence_id is required');
    }
    // if (!array_key_exists("shape_type", $data)) {
    //     return unprocessableEntityResponse('shape_type is required');
    // }
    // if (!array_key_exists("shape_details", $data)) {
    //     return unprocessableEntityResponse('shape_details is required');
    // }
    if (!array_key_exists("user_id", $data)) {
        return unprocessableEntityResponse('user_id is required');
    }
    $jwt = new JwtHandler();
    $token_data = $jwt->jwtDecodeData($_SESSION['token']);
    if($token_data->data->role == 4){
        return unprocessableEntityResponse("you've no permission to update");
    }
    $jwt = null;


    $data["shape_details"] = empty($data['shape_details']) ?  '' :  $data["shape_details"];
    $data['shape_type'] = empty($data['shape_type']) ?  '' :  $data["shape_type"];
    $data['from_date'] = empty($data['from_date']) ?  '' :  $data["from_date"];
    $data['to_date'] = empty($data['to_date']) ?  '' :  $data["to_date"];
    $data['des1'] = empty($data['des1']) ? $data['des1'] = '' :  $data["des1"];
    $data['des2'] = empty($data['des2']) ? $data['des2'] = '' :  $data["des2"];
    $data['des3'] = empty($data['des3']) ? $data['des3'] = '' :  $data["des3"];

    $res_geo_id =  geofenceIdIsExist($data['geofence_id'], $data['user_id']);
    $res_geo_id = json_decode($res_geo_id, true);
    if ($res_geo_id['geo_id'] != 1) {
        return unprocessableEntityResponse("geofence_id not valid or user_id not match");
    }
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $sql = "update geofencing set  created_by = :user_id, shape_details = :shape_details, shape_type = :shape_type, from_date = :from_date, to_date =:to_date, des1 = :des1,  des2 = :des2, des3 = :des3, updated_at = now() where id  = :geofence_id";

    $res = null;

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':shape_details', $data['shape_details']);
        $stmt->bindParam(':shape_type', $data['shape_type']);
        $stmt->bindParam(':from_date', $data['from_date']);
        $stmt->bindParam(':to_date', $data['to_date']);
        $stmt->bindParam(':des1', $data['des1']);
        $stmt->bindParam(':des2', $data['des2']);
        $stmt->bindParam(':des3', $data['des3']);
        $stmt->bindParam(':geofence_id', $data['geofence_id']);
        $res = $stmt->execute();

        if ($res == true) {
            $stmt = $conn->prepare("DELETE FROM geofence_device WHERE geofence_id = :geofence_id ");
            $stmt->bindParam(':geofence_id', $data['geofence_id']);
            $res = $stmt->execute();

            foreach ($data['ssm'] as $item) {
                $res_ssm_id =  ssmIsExist($item, "");
                $res_ssm_id = json_decode($res_ssm_id, true);
                if ($res_ssm_id['ssm_id'] != 1) {
                    return unprocessableEntityResponse($item . " not valid");
                    break;
                } else {
                    $sql1 = "insert into geofence_device(ssm_id, geofence_id, created_at, updated_at, created_by) values (:ssm_id, :geofence_id, now(), now(), :created_by)";
                    $sth1 = $conn->prepare($sql1);
                    $status = $sth1->execute(array(
                        'ssm_id' => trim(strtoupper($item)),
                        'geofence_id' => trim($data['geofence_id']),
                        'created_by' => trim($data['user_id']),
                    ));
                }
            }

            $res = "data updated successfully";
            $response['body']['success'] = 1;
        } else {
            $res = "Something went wrong";
            $response['body']['success'] = 0;
        }
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body']['res'] = $res;

    // var_dump($response);
    return $response;
}
function selectDataByssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM ssm WHERE ssm_id  = ? order by updated_at desc";
    $res = null;

    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
        $res['power_bank_details'] = select_power_Bank_Data_By_ssmId($ssm_id);
        $res['gms_details'] = select_Gsm_Data_By_ssmId($ssm_id);
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

    $sql = "SELECT s.*, (SELECT COUNT(p.ssm_id) FROM power_bank p WHERE p.ssm_id = s.ssm_id) as total_power_bank,
    (SELECT COUNT(n.ssm_id) FROM near_wifi n WHERE n.ssm_id = s.ssm_id) as total_near_wifi,
    (SELECT COUNT(c.ssm_id) FROM near_cellular_operator c WHERE c.ssm_id = s.ssm_id) as total_near_cellular_operator FROM  ssm s WHERE s.ssm_id = ? ORDER BY updated_at DESC LIMIT 1";

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
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $res;
    // var_dump($response);
    return $response;
}
function select_Gsm_Data_By_ssmId($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM gms WHERE ssm_id  = ?";

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
    $sql = "SELECT * FROM gnss_loaction WHERE ssm_id = ?";
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
    $sql = "SELECT * FROM near_wifi WHERE ssm_id = ?";
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
    $sql = "SELECT * FROM near_cellular_operator WHERE ssm_id = ?";
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
    $sql = "SELECT * FROM power_bank WHERE ssm_id = ?";
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
function deleteData($data)
{
    try {
        $out = Database::executeRoutedFn('geofence_delete', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    $response['header_status_code'] = 'HTTP/1.1 200 OK';
    $response['body'] = $out;
    $response['body']['status'] = 1;
    return $response;

    // if (!array_key_exists("ssm", $data)) {
    //     return unprocessableEntityResponse('ssm is required');
    // }
    // if (!array_key_exists("geofence_id", $data)) {
    //     return unprocessableEntityResponse('geofence_id is required');
    // }

    // if (!array_key_exists("fore", $data)) {
    //     return unprocessableEntityResponse('geofence_id is required');
    // }



    // $jwt = new JwtHandler();
    // $token_data = $jwt->jwtDecodeData($_SESSION['token']);
    // if($token_data->data->role == 4){
    //     return unprocessableEntityResponse("you've no permission to delete");
    // }
    // $jwt = null;


    // $res_geo_id =  geofenceIdIsExist($data['geofence_id'], $data['user_id']);
    // $res_geo_id = json_decode($res_geo_id, true);
    // if ($res_geo_id['geo_id'] != 1) {
    //     return unprocessableEntityResponse("geofence_id not valid or user_id not match");
    // }
    // $db_connection = new Database();
    // $conn = $db_connection->dbConnection();

    // $sql = "DELETE FROM geofencing WHERE id = :id";

    // $res = null;

    // try {
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':id', $data['geofence_id']);
    //     $stmt->bindParam(':userid', $data['user_id']);
    //     $res = $stmt->execute();

    //     if ($res == true) {
    //         $stmt = $conn->prepare("DELETE FROM geofence_device WHERE geofence_id = :geofence_id");
    //         $stmt->bindParam(':geofence_id', $data['geofence_id']);
    //         $res = $stmt->execute();


    //         $stmt1 = $conn->prepare("update notification set remove = 1 where foreign_id = :geofence_id and foreign_st = 'geofencing'");
    //         $stmt1->bindParam(':geofence_id', $data['geofence_id']);
    //         $res = $stmt1->execute();

    //         $res = "data deleted successfully";
    //         $response['body']['success'] = 1;
    //     } else {
    //         $res = "Something went wrong";
    //     }
    // } catch (\PDOException $e) {
    //     exit($e->getMessage());
    // }
    // $conn = null;
    // $response['header_status_code'] = 'HTTP/1.1 200 OK';
    // $response['body']['res'] = $res;

    // // var_dump($response);
    // return $response;
}
function ssmIsExist($ssm_id, $sql)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    if (empty($sql)) {

        $sql = "SELECT  EXISTS (select ssm_id from ssm where ssm_id = ?  )as  ssm_id";
    }
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
function geofenceIdIsExist($ssm_id, $user_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();


    // $sql = "SELECT  EXISTS (select id from geofencing where id = ? and created_by =? )as  geo_id";
    $sql = "SELECT  EXISTS (select id from geofencing where id = ? )as  geo_id";

    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array($ssm_id));
        // $query->execute(array($ssm_id, $user_id));
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

// SELECT *, (select json_arrayagg( name) from project_managers  where id = 
// (select pm_id from smb_resp where smb_id = d.id )) as device_responsible, (select name 
// from projects where team_id = d.team_id limit 1) as project_name
// FROM devices d