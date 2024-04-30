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

    $sql = "SELECT  EXISTS (select ssm_id from ssm where ssm_id = ?  )as ssm_id";

    // $sql = "SELECT  EXISTS (select ssm_id from ssm where ssm_id = ? AND (SELECT COUNT(pw.ssm_id) < 6 FROM power_bank pw WHERE pw.ssm_id = ?) )as ssm_id";

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
    if(!validateSecretKey($data['s_k'])){
        return unprocessableEntityResponse('unwanted attempts! try using a valid token.');
    }
    
    if (!array_key_exists("ssm_id", $data)) {
        return unprocessableEntityResponse('ssm_id is required');
    }
    if ((empty($data['capacity'])) || (!array_key_exists("capacity", $data))) {
        $data['capacity'] = "20000 mah";
        // return unprocessableEntityResponse('name is required');
    }
    if (!array_key_exists("cycle", $data)) {
        return unprocessableEntityResponse('cycle is required');
    }
    if ((empty($data['type'])) || (!array_key_exists("type", $data))) {
        $data['type'] = "Li-Ion";
        // return unprocessableEntityResponse('name is required');
    }
    // if (!array_key_exists("battery_status", $data)) {
    //     return unprocessableEntityResponse('battery_status is required');
    // }
    if (!array_key_exists("poc", $data)) {
        return unprocessableEntityResponse('poc is required');
    }

    if (!array_key_exists("b_s", $data)) {
        return unprocessableEntityResponse('b_s is required');
    }

    try {
        // $battery_list = separateBatteryIDFromString($data['battery_id']);
        $battery_list = [];
        foreach ($data['battery_id'] as $item) {

            array_push($battery_list,  convertStringtoHex($item));
        }
        // $poc = separateDataFromString($data['poc']);
        // $cycle = separateDataFromString($data['cycle']);
        // $battery_status = separateDataFromString($data['b_s']);
        $data['poc'] = separateDataFromString($data['poc']);
        $data['cycle'] = separateDataFromString($data['cycle']);
        $data['b_s'] = separateDataFromString($data['b_s']);
        $data['battery_id'] = $battery_list;

        $data['temp'] = separateDataFromString($data['temp']);
        $data['Ei'] = separateDataFromString($data['Ei']);
        $data['Eo'] = separateDataFromString($data['Eo']);
       

    } catch (\Throwable $th) {
        //throw $th;
        return unprocessableEntityResponse($th->getMessage());
    }

    // if (count($battery_list) != 6) :
    //     return unprocessableEntityResponse('battery_id not in valid format or battery_id less than 6');
    // endif;
    // if (count($poc) != 6) :
    //     return unprocessableEntityResponse('poc not in valid format or poc less than 6');
    // endif;
    // if (count($cycle) != 6) :
    //     return unprocessableEntityResponse('cycle not in valid format or cycle less than 6');
    // endif;
    // if (count($battery_status) != 6) :
    //     return unprocessableEntityResponse('battery_status not in valid format or battery_status less than 6');
    // endif;

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    $res = null;

    // $res_ssm_id =  ssmIsExist($data['ssm_id']);
    // $res_ssm_id = json_decode($res_ssm_id, true);
    // if ($res_ssm_id['ssm_id'] != 1) {
    //     $res['error_msg'] = "ssm_id not valid ";
    // } else {
    //     try {
    //         // for ($i = 0; $i <= 5; $i++) {
    //         //     // 0=disconnected, 1=connected, 2=charging,3=damaged

    //         //     // b_s: battery status:
    //         //     // 0 = standby
    //         //     // 1 = charging
    //         //     // 2 = giving output
    //         //     // 3 = notConnected
    //         //     // 4 = shutdown

    //         //     ///////////////////////////
    //         //     $b_status = "";
    //         //     if ($battery_status[$i] == 0) {
    //         //         $b_status = "Standby";
    //         //     }
    //         //     if ($battery_status[$i] == 1) {
    //         //         $b_status = "Charging";
    //         //     }
    //         //     if ($battery_status[$i] == 2) {
    //         //         // $b_status = "Giving Output";
    //         //         $b_status = "In Use";
    //         //     }
    //         //     if ($battery_status[$i] == 3) {
    //         //         $b_status = "Not Connected";
    //         //     }
    //         //     if ($battery_status[$i] == 4) {
    //         //         $b_status = "Shutdown";
    //         //     }
   


    //         //     // switch ($poc[$i]) {
    //         //     //     case 1:
    //         //     //       echo "Your favorite color is red!";
    //         //     //       break;
    //         //     //     case 2:
    //         //     //       echo "Your favorite color is blue!";
    //         //     //       break;
    //         //     //     case 3:
    //         //     //       echo "Your favorite color is green!";
    //         //     //       break;
    //         //     //     default:
    //         //     //       
    //         //     //   }

    //         //     $sql = "INSERT INTO power_bank(ssm_id, capacity, cycle, type, poc, created_at, updated_at, battery_id, battery_status)
    //         //     VALUES(:ssm_id, :capacity, :cycle, :type,  :poc, NOW(), NOW(), :battery_id, :battery_status)";

    //         //     $sth = $conn->prepare($sql);
    //         //     $status = $sth->execute(array(
    //         //         'ssm_id' => trim(strtoupper($data['ssm_id'])),
    //         //         'capacity'  => trim($data['capacity']),
    //         //         'cycle' => trim($cycle[$i]),
    //         //         'type'  => trim($data['type']),
    //         //         'battery_status'  => trim($b_status),
    //         //         'poc' => trim($poc[$i]),
    //         //         'battery_id' => trim($battery_list[$i])

    //         //     ));
    //         // }

    //         // $res['success'] = "all data inserted successfully";
    //         $data['b_s'] = 

    //         try {
    //             $out = Database::executeRoutedFn('power_bank__upsert', $data);
    //         } catch (\PDOException $e) {
    //             exit($e->getMessage());
    //         }

    //     } catch (\PDOException $e) {
    //         exit($e->getMessage());
    //     }
    // }

    try {
        $out = Database::executeRoutedFn('power_bank__upsert', $data);
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }
  
    $conn = null;

    $response['header_status_code'] = 'HTTP/1.1 201 Created';
    $response['body'] = $out;
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

function separateDataFromString($data)
{
    $out = [];
    $out = explode(',', $data);
    return $out;
}

function convertStringtoHex($string)
{
    $numbers = explode(',', str_replace(' ', '', $string));

    $packed = pack('C*', ...$numbers);

    $result = bin2hex($packed);

    // $string = substr($result, 8);

    // $string = substr($string, 0, -2);

    return strval($result);
}

function IDIsExist($battery_id)
{
    if (empty($battery_id)) {
        return unprocessableEntityResponse('battery_id is required');
    }

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $sql = "SELECT  EXISTS (SELECT * FROM tbm_battery_info WHERE battery_id = ?  )as  res";
    // $sql = "SELECT *, (select EXISTS (SELECT * FROM tbm_battery_info WHERE battery_id = ? ))as  res FROM tbm_battery_info WHERE battery_id = ?";
    $res = null;
    try {
        $query =  $conn->prepare($sql);
        $query->execute(array(trim($battery_id)));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $res = $query->fetch();
    } catch (\PDOException $e) {
        exit($e->getMessage());
    }

    return $res;
}


function validateSecretKey($string) {
    $db_connection = new Database();
    if(md5($db_connection->secretKey) == $string){
        return true;
    }else{
        return false;
    }
}