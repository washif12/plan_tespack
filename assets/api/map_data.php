<?php


use GuzzleHttp\Psr7\Response;

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

    $res_user_id =  userIsExist($input['user_id']);
    $res_user_id = json_decode($res_user_id, true);
    if ($res_user_id['user_id'] != 1 || empty($input['user_id'])) {
        $response = unprocessableEntityResponse("user_id not provided or not valid");
        $response['body']['success'] = 0;
    } else {
        switch ($req_method) {
            case 'POST':
                if (empty(trim($input['country'])) && empty(trim($input['project'])) && empty(trim($input['pro_manager'])) && empty(trim($input['device_id']))  && empty(trim($input['from_date'])) && empty(trim($input['to_date']))) {
                    $response = countryData();
                }
                if (empty(trim($input['country'])) &&  empty(trim($input['project']))  && (!empty(trim($input['pro_manager']))) && empty(trim($input['device_id'])) && empty(trim($input['from_date'])) && empty(trim($input['to_date']))) {
                    $response = selectDataByProjectManager(trim($input['pro_manager']));
                }
                if ((!empty(trim($input['country']))) && empty(trim($input['project'])) && empty(trim($input['pro_manager'])) && empty(trim($input['device_id'])) && empty(trim($input['from_date'])) && empty(trim($input['to_date']))) {
                    $response = selectDataByCountry(trim($input['country']));
                }
                if (empty(trim($input['country'])) && (!empty(trim($input['project']))) && empty(trim($input['pro_manager'])) && empty(trim($input['device_id'])) && empty(trim($input['from_date'])) && empty(trim($input['to_date']))) {
                    $response = selectDataByProject(trim($input['project']));
                }
                if (empty(trim($input['country'])) && empty(trim($input['project'])) && empty(trim($input['pro_manager'])) && (!empty(trim($input['ssm']))) && empty(trim($input['from_date'])) && empty(trim($input['to_date']))) {
                    $response = selectDataByDevice(trim($input['ssm']));
                }

                if (((!empty(trim($input['country']))) && (!empty(trim($input['from_date'])))) || ((!empty(trim($input['country']))) && (!empty(trim($input['to_date']))))) {
                    $response = selectDataByCountryandDate(trim($input['country']), trim($input['from_date']), trim($input['to_date']));
                }
                if (!empty(trim($input['project'])) && ((!empty(trim($input['from_date']))) || (!empty(trim($input['to_date']))))) {
                    $response = selectDataByProjectandDate(trim($input['project']), trim($input['from_date']), trim($input['to_date']));
                }
                if (!empty(trim($input['pro_manager'])) && ((!empty(trim($input['from_date']))) || (!empty(trim($input['to_date']))))) {
                    $response = selectDataByProjectManagerandDate(trim($input['pro_manager']), trim($input['from_date']), trim($input['to_date']));
                }
                if (!empty(trim($input['ssm'])) && ((!empty(trim($input['from_date']))) || (!empty(trim($input['to_date']))))) {
                    $response = selectDataByDeviceandDate(trim($input['ssm']), trim($input['from_date']), trim($input['to_date']));
                }
                if (empty(trim($input['country'])) && empty(trim($input['project'])) && empty(trim($input['pro_manager'])) && empty(trim($input['ssm'])) && ((!empty(trim($input['from_date']))) || (!empty(trim($input['to_date']))))) {
                    $response = selectDataByDate(trim($input['from_date']), trim($input['to_date']));
                }
                break;

                // if ((!empty(trim($_GET['project']))) && (!empty(trim($_GET['country'])))) {
                //     $response = selectProjectManagerDataByCountryAndProject(trim($_GET['country']), trim($_GET['project']));
                // }

                // if ((!empty(trim($_GET['project']))) && (!empty(trim($_GET['country']))) && (!empty(trim($_GET['pro_manager'])))) {
                //     $response = selectdeviceDataByCountryAndProjectAndPM(trim($_GET['country']), trim($_GET['project']), trim($_GET['project_manager_team_id']));
                // }

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
function selectDataByDate($from_date, $to_date){
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();


    if (!empty($from_date)) {
        if (empty($to_date)) {
            $to_date = date("Y-m-d");
        }

        $from_date = " (gst.date between '$from_date' and '$to_date' )";
    } else {
        $from_date = '';
    }

    if ((!empty($to_date)) && (empty($from_date))) {

        $from_date = " (gst.date between (SELECT  MIN(date) as from_date from grid_solar_totaluse) and '$to_date')";
    }

    $sql = "select * from projects";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array());
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['project'] = $res;
        $response['body']['success'] = 1;

        $query = $conn->prepare("SELECT * FROM countries");
        $query->execute(array());
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['country'] = $res;

        $query = $conn->prepare("SELECT distinct pm.* FROM project_managers pm inner join projects p on pm.team_id = p.team_id ");
        $query->execute(array());
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project_manager'] = $res;


        $query = $conn->prepare("SELECT * FROM devices");
        $query->execute(array());
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['device'] = $res;

        $response['body']['total_report'] = summaryData("gst inner join devices d on gst.ssm_id=d.ssm_id where  $from_date", "and  $from_date");
        $response['body']['total_report']['total_device'] = count($res);

        $response['body']['energy_data'] = energyData("gst inner join devices d on gst.ssm_id=d.ssm_id where  $from_date");
        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print,  date
        from footprint_constant fc, grid_solar_totaluse gst where
        fc.country = (select country from devices where ssm_id = gst.ssm_id) and $from_date
        group by gst.date, fc.country");
        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    return $res;
}
function selectDataByCountryandDate($country, $from_date, $to_date)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();


    if (!empty($from_date)) {
        if (empty($to_date)) {
            $to_date = date("Y-m-d");
        }

        $from_date = " and (gst.date between '$from_date' and '$to_date' )";
    } else {
        $from_date = '';
    }

    if ((!empty($to_date)) && (empty($from_date))) {

        $from_date = "and (gst.date between (SELECT  MIN(date) as from_date from grid_solar_totaluse) and '$to_date')";
    }

    $sql = "select * from projects where country = ?";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($country));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['project'] = $res;
        $response['body']['success'] = 1;
        $query = $conn->prepare("SELECT distinct pm.* FROM project_managers pm inner join projects p on pm.team_id = p.team_id where p.country= ?");
        $query->execute(array($country));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project_manager'] = $res;


        $query = $conn->prepare("SELECT * FROM devices where country = ?");
        $query->execute(array($country));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['device'] = $res;

        $response['body']['total_report'] = summaryData("gst inner join devices d on gst.ssm_id=d.ssm_id where country = '$country' $from_date", "and fc.country = '$country' $from_date");
        $response['body']['total_report']['total_device'] = count($res);

        $response['body']['energy_data'] = energyData("gst inner join devices d on gst.ssm_id=d.ssm_id where d.country = '$country' $from_date");
        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND(sum(from_solar)*(select constant from footprint_constant where country = '$country' limit 1)/1, 2) as total_foot_print,  gst.date from devices d inner join grid_solar_totaluse gst on gst.ssm_id = d.ssm_id where country = '$country' $from_date group by gst.date");
        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    return $res;
}
function selectDataByDeviceandDate($ssm_id, $from_date, $to_date){
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    
    if (!empty($from_date)) {
        if (empty($to_date)) {
            $to_date = date("Y-m-d");
        }

        $from_date = " and (gst.date between '$from_date' and '$to_date' )";
    } else {
        $from_date = '';
    }

    if ((!empty($to_date)) && (empty($from_date))) {

        $from_date = "and (gst.date between (SELECT  MIN(date) as from_date from grid_solar_totaluse) and '$to_date')";
    }

    $sql = "select country from projects where team_id = (select team_id from devices where ssm_id = ?)";

    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['country'] = $res;
        $response['body']['success'] = 4;

        $query = $conn->prepare("select * from projects where team_id = 
        (select team_id from devices where ssm_id = ?)");
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project'] = $res;

        $query = $conn->prepare("select * from project_managers where team_id = (select team_id from devices where ssm_id = ?)");
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project_manager'] = $res;

        $response['body']['total_report'] = summaryData("gst where gst.ssm_id = '$ssm_id' $from_date", "and ssm_id = '$ssm_id' $from_date");
        $response['body']['total_report']['total_device'] = count($response['body']['project']) >= 1 ? 1 : 0;

        $response['body']['energy_data'] = energyData("gst where ssm_id = '$ssm_id' $from_date");
        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print, date from footprint_constant fc, grid_solar_totaluse gst where
        gst.ssm_id= '$ssm_id' and fc.country = (select country from devices where ssm_id = '$ssm_id' ) $from_date group by gst.date, fc.country
        ");

        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function selectDataByProjectManagerandDate($project_manager_team_id, $from_date, $to_date)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    if (!empty($from_date)) {
        if (empty($to_date)) {
            $to_date = date("Y-m-d");
        }

        $from_date = " and (gst.date between '$from_date' and '$to_date' )";
    } else {
        $from_date = '';
    }

    if ((!empty($to_date)) && (empty($from_date))) {

        $from_date = "and (gst.date between (SELECT  MIN(date) as from_date from grid_solar_totaluse) and '$to_date')";
    }

    $sql = "SELECT distinct country FROM projects where team_id =  ?";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($project_manager_team_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['country'] = $res;
        $response['body']['success'] = 3;
        $query = $conn->prepare("SELECT * FROM projects where team_id =  ?");
        $query->execute(array($project_manager_team_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project'] = $res;

        $query = $conn->prepare("SELECT * FROM devices where team_id = ?");
        $query->execute(array($project_manager_team_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['device'] = $res;

        $response['body']['total_report'] = summaryData("gst inner join devices d on gst.ssm_id = d.ssm_id inner join projects p on p.team_id = d.team_id where p.team_id ='$project_manager_team_id' $from_date", "");

        $response['body']['total_report']['total_device'] = count($res);

        $query = $conn->prepare("select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print from footprint_constant fc, grid_solar_totaluse gst inner join devices d on gst.ssm_id = d.ssm_id where fc.country = d.country and d.team_id = '$project_manager_team_id' $from_date group by gst.ssm_id, fc.country");
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $ress = $query->fetch();

        $response['body']['total_report']['total_footprint'] = $ress == false ? 0 : $ress['total_foot_print'];

        $response['body']['energy_data'] = energyData("gst inner join devices d on gst.ssm_id = d.ssm_id inner join projects p on p.team_id = d.team_id where p.team_id ='$project_manager_team_id' $from_date");

        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print,  gst.date from footprint_constant fc, grid_solar_totaluse gst inner join devices d on gst.ssm_id = d.ssm_id where fc.country = d.country and d.team_id = $project_manager_team_id $from_date group by gst.date, fc.country");

        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    return $res;
}
function selectDataByProjectandDate($project, $from_date, $to_date)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();



    if (!empty($from_date)) {
        if (empty($to_date)) {
            $to_date = date("Y-m-d");
        }

        $from_date = " and (gst.date between '$from_date' and '$to_date' )";
    } else {
        $from_date = '';
    }

    if ((!empty($to_date)) && (empty($from_date))) {

        $from_date = "and (gst.date between (SELECT  MIN(date) as from_date from grid_solar_totaluse) and '$to_date')";
    }

    $sql = "SELECT country FROM projects  where id = ?";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($project));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['country'] = $res;
        $response['body']['success'] = 2;

        $query = $conn->prepare("SELECT distinct pm.* FROM project_managers pm inner join projects p on pm.team_id = p.team_id where p.id= ?");
        $query->execute(array($project));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project_manager'] = $res;


        $query = $conn->prepare("SELECT * FROM devices where team_id = (select team_id from projects where id = ? )");
        $query->execute(array($project));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['device'] = $res;

        $response['body']['total_report'] = summaryData("gst inner join devices d  on gst.ssm_id = d.ssm_id inner join projects p on p.team_id = d.team_id where p.id = '$project' $from_date", "");

        $query = $conn->prepare("select ROUND(sum(from_solar)*(select constant from footprint_constant where country = (select country from projects where id = '$project') limit 1)/1, 1)
        as total_foot_print from devices d inner join grid_solar_totaluse gst on gst.ssm_id = d.ssm_id  where d.team_id  = (select team_id from projects where id = '$project') $from_date group by gst.ssm_id");
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $ress = $query->fetch();
        $response['body']['total_report']['total_footprint'] = $ress == false ? 0 : $ress['total_foot_print'];

        $response['body']['total_report']['total_device'] = count($res);
        $response['body']['energy_data'] = energyData("gst inner join devices d  on gst.ssm_id = d.ssm_id inner join projects p on p.team_id = d.team_id where p.id = '$project' $from_date ");


        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND(sum(from_solar)*(select constant from footprint_constant where country =
        (select country from projects where id = '$project') limit 1)/1, 2)
        as total_foot_print,  gst.date from devices d
        inner join grid_solar_totaluse gst on gst.ssm_id = d.ssm_id
        where d.team_id  = (select team_id from projects where id = '$project') $from_date  group by gst.date");

        return $response;
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
function selectdeviceDataByCountryAndProjectAndPM($country, $project, $project_manager)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "select * from devices  where   country = ? and team_id= (select team_id from projects where team_id = (select team_id from project_managers where name= ?)and name= ?);
    ";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($country, $project_manager, $project));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['device'] = $res;
        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    return $res;
}
function selectProjectManagerDataByCountryAndProject($country, $project)
{

    // if(cou)
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "select * from project_managers where team_id= (select team_id from projects where name = ? and country = ?)";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($project, $country));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['project'] = $res;
        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    return $res;
}

function selectDataByDevice($ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "select country from projects where team_id = (select team_id from devices where ssm_id = ?)";

    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['country'] = $res;
        $response['body']['success'] = 4;

        $query = $conn->prepare("select * from projects where team_id = 
        (select team_id from devices where ssm_id = ?)");
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project'] = $res;

        $query = $conn->prepare("select * from project_managers where team_id = (select team_id from devices where ssm_id = ?)");
        $query->execute(array($ssm_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project_manager'] = $res;

        $response['body']['total_report'] = summaryData(" where ssm_id = '$ssm_id'", "and ssm_id = '$ssm_id'");
        $response['body']['total_report']['total_device'] = count($response['body']['project']) >= 1 ? 1 : 0;

        $response['body']['energy_data'] = energyData("gst where ssm_id = '$ssm_id'");
        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print, date from footprint_constant fc, grid_solar_totaluse gst where
        gst.ssm_id= '$ssm_id' and fc.country = (select country from devices where ssm_id = '$ssm_id') group by gst.date, fc.country
        ");

        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function selectDataByCountry($country)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "select * from projects where country = ?";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($country));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['project'] = $res;
        $response['body']['success'] = 1;
        $query = $conn->prepare("SELECT distinct pm.* FROM project_managers pm inner join projects p on pm.team_id = p.team_id where p.country= ?");
        $query->execute(array($country));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project_manager'] = $res;


        $query = $conn->prepare("SELECT * FROM devices where country = ?");
        $query->execute(array($country));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['device'] = $res;

        $response['body']['total_report'] = summaryData("gst inner join devices d on gst.ssm_id=d.ssm_id where country = '$country'", "and fc.country = '$country'");
        $response['body']['total_report']['total_device'] = count($res);

        $response['body']['energy_data'] = energyData("gst inner join devices d on gst.ssm_id=d.ssm_id where d.country = '$country'");
        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND(sum(from_solar)*(select constant from footprint_constant where country = '$country' limit 1)/1, 2) as total_foot_print,  gst.date from devices d inner join grid_solar_totaluse gst on gst.ssm_id = d.ssm_id where country = '$country' group by gst.date");
        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    return $res;
}
function selectDataByProject($project)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT country FROM projects  where id = ?";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($project));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['country'] = $res;
        $response['body']['success'] = 2;


        $query = $conn->prepare("SELECT distinct pm.* FROM project_managers pm inner join projects p on pm.team_id = p.team_id where p.id= ?");
        $query->execute(array($project));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project_manager'] = $res;

        $query = $conn->prepare("SELECT * FROM devices where team_id = (select team_id from projects where id = ? )");
        $query->execute(array($project));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['device'] = $res;

        $response['body']['total_report'] = summaryData("gst inner join devices d  on gst.ssm_id = d.ssm_id inner join projects p on p.team_id = d.team_id where p.id = '$project'", "");

        $query = $conn->prepare("select ROUND(sum(from_solar)*(select constant from footprint_constant where country = (select country from projects where id = '$project') limit 1)/1, 2)
        as total_foot_print from devices d inner join grid_solar_totaluse gst on gst.ssm_id = d.ssm_id  where d.team_id  = (select team_id from projects where id = '$project') group by gst.ssm_id");
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $ress = $query->fetch();
        $response['body']['total_report']['total_footprint'] = $ress == false ? 0 : $ress['total_foot_print'];

        $response['body']['total_report']['total_device'] = count($res);
        $response['body']['energy_data'] = energyData("gst inner join devices d  on gst.ssm_id = d.ssm_id inner join projects p on p.team_id = d.team_id where p.id = '$project'");

        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND(sum(from_solar)*(select constant from footprint_constant where country =
        (select country from projects where id = '$project') limit 1)/1, 2)
        as total_foot_print,  gst.date from devices d
        inner join grid_solar_totaluse gst on gst.ssm_id = d.ssm_id
        where d.team_id  = (select team_id from projects where id = '$project') group by gst.date");

        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function selectDataByProjectManager($project_manager_team_id)
{

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT distinct country FROM projects where team_id =  ?";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute(array($project_manager_team_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['country'] = $res;
        $response['body']['success'] = 3;
        $query = $conn->prepare("SELECT * FROM projects where team_id =  ?");
        $query->execute(array($project_manager_team_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['project'] = $res;

        $query = $conn->prepare("SELECT * FROM devices where team_id = ?");
        $query->execute(array($project_manager_team_id));
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['body']['device'] = $res;

        $response['body']['total_report'] = summaryData("gst inner join devices d on gst.ssm_id = d.ssm_id inner join projects p on p.team_id = d.team_id where p.team_id ='$project_manager_team_id'", "");
        $response['body']['total_report']['total_device'] = count($res);

        $query = $conn->prepare("select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print from footprint_constant fc, grid_solar_totaluse gst inner join devices d on gst.ssm_id = d.ssm_id where fc.country = d.country and d.team_id = $project_manager_team_id group by gst.ssm_id, fc.country");
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $ress = $query->fetch();

        $response['body']['total_report']['total_footprint'] = $ress == false ? 0 : $ress['total_foot_print'];

        $response['body']['energy_data'] = energyData("gst inner join devices d on gst.ssm_id = d.ssm_id inner join projects p on p.team_id = d.team_id where p.team_id ='$project_manager_team_id'");

        $response['body']['carbon_emission'] = carmonEimissionData("select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print,  gst.date from footprint_constant fc, grid_solar_totaluse gst inner join devices d on gst.ssm_id = d.ssm_id where fc.country = d.country and d.team_id = $project_manager_team_id group by gst.date, fc.country");

        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;

    return $res;
}
function countryData()
{

    // if(cou)
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM countries";
    $res = null;

    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_OBJ);
        $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        // $response['body']['total_device'] =  count(ssmData());

        $response['body']['total_report'] = summaryData("", "");
        $response['body']['country'] = $res;
        $response['body']['total_report']['total_device'] = count(ssmData());
        $response['body']['project'] = projectData();
        $response['body']['project_manager'] = projectManagerData();
        $response['body']['device'] = ssmData();
        $response['body']['energy_data'] = energyData("");
        $response['body']['carbon_emission'] = carmonEimissionData("");


        return $response;
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
    $conn = null;
    return $res;
}
function projectData()
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM projects";
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
function summaryData($sql, $f_c)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    if (empty($sql)) {
        $sql = "Select  ROUND(sum(from_solar), 2) as total_solar_energy , ROUND(sum(from_grid), 2) as total_grid_energy, ROUND(sum(user_usage), 2) as total_user_usages, ROUND(sum(from_battery), 2) as total_battery from grid_solar_totaluse ";
        // $sql = "Select  from_solar as total_solar_energy , from_grid as total_grid_energy, user_usage as total_user_usages, from_battery as total_battery from grid_solar_totaluse ";
    } else {
        $sql = "Select  ROUND(sum(from_solar), 2) as total_solar_energy ,ROUND(sum(from_grid), 2) as total_grid_energy, ROUND(sum(user_usage), 2) as total_user_usages, ROUND(sum(from_battery), 2)  as total_battery from grid_solar_totaluse $sql";
    }
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();

        $query = $conn->prepare("select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print
        from footprint_constant fc, grid_solar_totaluse gst where
        fc.country = (select country from devices where ssm_id = gst.ssm_id) $f_c group by gst.ssm_id, fc.country");
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
function energyData($sql)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    // if (empty($sql)) {
    //     $sql = "Select date as y, ROUND(sum(from_solar), 2) as a, ROUND(sum(from_grid), 2) as b, ROUND(sum(user_usage), 2) as d, ROUND(sum(from_battery), 2) as c from grid_solar_totaluse WHERE DATE(date) >=  (select max(date) 
    //     from grid_solar_totaluse) - INTERVAL 120 DAY  group by date order by date";
    // } else {
    //     $sql = "Select gst.date as y, ROUND(sum(from_solar), 2) as a, ROUND(sum(from_grid), 2) as b, ROUND(sum(user_usage), 2) as d, ROUND(sum(from_battery), 2) as c from grid_solar_totaluse $sql group by gst.date order by gst.date";
    // }
    if (empty($sql)) {
        $sql = "Select id, created_at as y, from_solar as a, from_grid as b, user_usage as d, from_battery as c from grid_solar_totaluse WHERE DATE(date) >=  (select max(date) 
        from grid_solar_totaluse) - INTERVAL 7 DAY  order by date ";
    } else {
        $sql = "Select id, gst.created_at as y, from_solar as a, from_grid as b, user_usage as d, from_battery as c from grid_solar_totaluse $sql order by gst.date ";
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
function projectManagerData()
{

    // if(cou)
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM project_managers";
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
function ssmData()
{

    // if(cou)
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT * FROM devices";
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
function select_data_by_country_and_project($input)
{
    $response = null;
    $country = $input['country'];
    $project  = $input['project'];
    $team_leader = $input['team_leader'];
    $ssm_id = $input['ssm_id'];

    if (empty($country) && empty($project) && empty($team_leader) && empty($ssm_id)) {
        $response['body']['country'] = countryData();
        $response['body']['project'] = projectData();
        $response['body']['project_manage'] = projectManagerData();
        $response['body']['device'] = ssmData();
    }
    if ((!empty($country)) && (!empty($project)) && (!empty($team_leader)) && (!empty($ssm_id))) {
        $sql = "";
    }


    $sql = "";
    $res = null;
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    try {
        // $query = $conn->prepare($sql);
        // $query->execute();
        // $query->setFetchMode(PDO::FETCH_OBJ);
        // $res = $query->fetchAll();
        $response['header_status_code'] = 'HTTP/1.1 200 OK';
        $response['body']['res'] = $res;
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
    $sql = empty($add) ? "select ROUND((sum(gst.from_solar)*constant)/ 1, 2) as total_foot_print,  date
    from footprint_constant fc, grid_solar_totaluse gst where
    fc.country =  (select country from devices where ssm_id = gst.ssm_id) and DATE(date) >= (select max(date) from grid_solar_totaluse) - INTERVAL 120 DAY
    group by gst.date, fc.country" : $add;


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
function summarizedData($add, $c_m, $ssm_id)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $ssm_id = empty($ssm_id) ? '' : " where ssm_id  = '$ssm_id'";

    $sql = "select ROUND(sum(from_grid), 2) as total_grid, ROUND(sum(from_solar), 2) as total_solar, ROUND(sum(user_usage), 2) total_user_usages,(select count(distinct ssm_id) from grid_solar_totaluse $ssm_id) as total_device from grid_solar_totaluse $add";
    $res = null;
    try {
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();

        $query = $conn->prepare("select ROUND((sum(gst.from_solar)*constant)/ count(ssm_id), 2) as total_foot_print
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

function deleteData()
{
    return "delete Data";
}
