<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require __DIR__ . '/classes/database.php';
require __DIR__ . '/classes/JwtHandler.php';
// require __DIR__ . '/middleware.php';

processRequest();
function processRequest()
{
    $req_method = $_SERVER["REQUEST_METHOD"];
    // $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $input = file_get_contents('php://input');
    // $get_frm = gettype($input);
    // $file = $_FILES['json_file'];
    switch ($req_method) {
        case 'POST':
            // var_dump($input);
            $response =  bult_data_insert($input);
            // echo $response['header_status_code'];
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
function bult_data_insert($data)
{
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();
    $out  = "";
    // echo $out;
    $response['body']['status'] = 1;
    // $filename = '../uploads/data.txt';
    $filename = fopen("../uploads/data.txt", "a");

    // Write the content to the file


    try {

        $fileContent = rtrim($data, '|');
        $json_objects = explode('|', $fileContent);
        // file_put_contents($filename, $json_objects, LOCK_EX);
        // file_put_contents($filename, $json_objects);
        // return unprocessableEntityResponse(count($json_objects));
       
        fwrite($filename, $fileContent);

        // Close the file
        // fclose($filename);
    } catch (\Throwable $th) {
        return unprocessableEntityResponse("Something Went wrong");
    }


    //////////////////////////ex code 
    $response['header_status_code'] = 'HTTP/1.1 201 OK';
    $response['body']['reply_msg'] = strlen($data) . ' ' . count($json_objects);
    // return $response; 
    // return unprocessableEntityResponse(strlen($data) . ' ' . count($json_objects));

    // $fileContent = rtrim($data, '|');
    // $json_objects = explode('|', $fileContent);
    // return unprocessableEntityResponse(json_decode($json_objects[0]));

    // if (!isset($_FILES['file'])) {
    //     return unprocessableEntityResponse("invalid request");
    // }
    // $file_type = $_FILES['file']['type'];

    // if ($file_type == 'text/plain') {
    //     return unprocessableEntityResponse("File found!!!!!");
    //     $fileContent = file_get_contents($_FILES['file']['tmp_name']);

    //     $fileContent = rtrim($fileContent, '|');
    //     $json_objects = explode('|', $fileContent);

    //     // $folder_name = date("Y_m_d_h_i_sa");
    //     // try {
    //     //     $target_dir = "../uploads/offline_device_data/".$folder_name."/" ;
    //     //     if (!is_dir($target_dir)) {
    //     //         mkdir($target_dir, 0755);
    //     //     }else{
    //     //         return unprocessableEntityResponse("cannot create");
    //     //     }
    //     //     $file = $_FILES['file']['name'];

    //     //     move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $file);
    //     // } catch (\Throwable $th) {
    //     //    return unprocessableEntityResponse($th->getMessage());
    //     // }


    // } else {
    //     return unprocessableEntityResponse("Invalid file request");
    // }
   
   
    $insertQueries = [];

    $insertQueries['ssm'] = "INSERT INTO tespack_plan.ssm(ssm_id, signal_strength, network_id, last_seen_time, total_session, imei, emei, power_source_type, power_source_status, total_charge, sos_activated, created_at, updated_at, battery_status, temperature, device_total_runtime, gnss, device_activity, user_activity, device_error, input_source, output_source, input_voltage, input_current, input_power, output_voltage, output_current, output_power) VALUES ";

    $insertQueries['power_bank'] = [];
    $insertQueries['run_time'] = [];
    $insertQueries['gnss_location'] = "INSERT INTO tespack_plan.gnss_loaction (latitude, longitude, ssm_id, altitude, created_at, updated_at) VALUES ";
    $insertQueries['event_log'] = "insert into tespack_plan.event_log(device_activity, user_activity, ssm_id, faults, created_at, updated_at) values";
   
    // $json_objects=array_slice($json_objects,0,count($json_objects)-1);
    try {
        foreach ($json_objects as $ele) {
            $ele = json_decode($ele, true);
         
            $insertQueries['ssm'] .= parseSSMJsonToInsertSQL($ele['sys_status'], $ele['ssm_id'], $ele['d&t']);
            
            // $insertQueries['gnss_location'] .= parseLoactionJsonToInsertSQL($ele['gnss_loaction_log'], $ele['ssm_id'], $ele['date_time']);
            // $insertQueries['event_log'] .= parsEventLogJsonToInsertSQL($ele['event_log'], $ele['ssm_id'], $ele['date_time']);
            array_push($insertQueries['power_bank'], parsePowerBankJsonToInsertSQL($ele['pb_log'], $ele['ssm_id'], $ele['d&t']));
          
            array_push($insertQueries['run_time'], parseRunTimeJsonToInsertSQL($ele['Uses'], $ele['ssm_id'], $ele['d&t']));
            // print_r($insertQueries['run_time']);
         
        }
    } catch (\Throwable $th) {
        $response['body']['reply_msg'] = "Something went wrong!";
        $response['body']['error_msg'] = $th->getMessage();
        return $response;
    }




    // print(rtrim($insertQueries['ssm'], ','));
    $insertQueries['ssm'] = rtrim($insertQueries['ssm'], ',');
    // $ssm_sqli['sqli']  = preg_replace('/\s+/', ' ', trim( $insertQueries['ssm']));

    fwrite($filename,  $insertQueries['ssm']);
    fwrite($filename,  json_encode($insertQueries['power_bank']));
    fwrite($filename,  json_encode($insertQueries['run_time']));
    // print_r($insertQueries['power_bank']);
    // fwrite($filename,  $insertQueries['power_bank']);

    // file_put_contents($filename,  "tst");
    // Close the file
    fclose($filename);

    // print(rtrim($insertQueries['gnss_location'], ','));
    // print_r(json_encode($insertQueries['power_bank']));
    
    $out = [];
    try {
        
       
        // print_r(json_encode($insertQueries['ssm']));
        // $w = $json_objects.' /n'.$insertQueries;
        // file_put_contents($filename, $insertQueries);
      
        $out['power_res'] = Database::executeRoutedFn('power_bank__upsert_for_offline', $insertQueries);
        //  print_r(json_encode($insertQueries['run_time']));
        $out['use_res'] = Database::executeRoutedFn('grid_solar_totaluse__upsert_for_offline', $insertQueries);
        // $out = Database::executeRoutedFn('offline_data__upsert', $insertQueries);
        //$out = Database::executeRoutedFn('offline_data__upsert', $insertQueries);
        $sth = $conn->prepare($insertQueries['ssm']);
        $out['ssm_res'] = $sth->execute();
        // $out = Database::executeRoutedFn('offline_data__upsert', $ssm_sqli);
        $response['body']['status'] = 1;
    } catch (\PDOException $e) {
         $response['body']['reply_msg'] = "Something went wrong!";
         $response['body']['error_msg'] = $e->getMessage();
         return $response;
        // exit($e->getMessage());
    }
    $response['header_status_code'] = 'HTTP/1.1 201 OK';
    $response['body']['out'] = $out;
  
    return $response;
}
function unprocessableEntityResponse($msg)
{
    $response['header_status_code'] = 'HTTP/1.1 200 Unprocessable Entity';
    $response['body'] = $msg;
    $response['body'] = [
        'error_msg' => $msg,
    ];
    return $response;
}

function parseSSMJsonToInsertSQL($data, $ssm_id, $date_time)
{



    $ssm_id = trim($ssm_id);
    $signal_strength = trim($data[0]['signal']);
    $network_id = trim($data[0]['operator']);
    $total_session = trim($data[0]['cSession']);
    $imei = trim($data[0]['imei']);
    $emei = trim($data[0]['emei']);
    $power_source_type = trim($data[0]['p_source']);
    $power_source_status = trim($data[0]['p_s_sta']);
    $total_charge = trim($data[0]['t_ch']);
    $sos_activated = trim($data[0]['sos']);
    $battery_status = trim($data[0]['bat_sta']);
    $temperature = trim($data[0]['temp']);
    // new added
    $gnss = trim($data[0]['gnss']);
    $device_activity = trim($data[0]['d_activity']);
    $user_activity = trim($data[0]['u_activity']);
    $device_error = trim($data[0]['err']);

    $input_source = trim($data[0]['Si']);
    $output_source = trim($data[0]['Bs']);
    $input_voltage = trim($data[0]['Vi']);
    $input_current = trim($data[0]['Ii']);
    $input_power = trim($data[0]['Pi']);
    $output_voltage = trim($data[0]['Vo']);
    $output_current = trim($data[0]['Io']);
    $output_power = trim($data[0]['Po']);

    $device_total_runtime = trim($data[0]['lifetime']);

   

    try {
        $date_time = convertDeviceTimeToDBTime($date_time);
    } catch (\Throwable $th) {
        throw $th;
    }

   // $insertQueries['ssm'] = "INSERT INTO tespack_plan.ssm(ssm_id, signal_strength, network_id, last_seen_time, total_session, imei, emei, power_source_type, power_source_status, total_charge, sos_activated, created_at, updated_at, battery_status, temperature, device_total_runtime, gnss, device_activity, user_activity, device_error, input_source, output_source, input_voltage, input_current, input_power, output_voltage, output_current, output_power) VALUES ";

    // $query = "(''$ssm_id'',''$signal_strength'',''$network_id'',''$date_time'',''$total_session'',''$imei'',''$emei'',''$power_source_type'',''$power_source_status'', ''$total_charge'', ''$sos_activated'', ''$date_time'', now(), ''$battery_status'', ''$temperature'', ''$total_session'',''$gnss'', ''$device_activity'',''$user_activity'', ''$device_error'', ''$input_source'', ''$output_source'', ''$input_voltage'', ''$input_current'', ''$input_power'',''$output_voltage'',''$output_current'', ''$output_power''),";
    $query = "('$ssm_id','$signal_strength','$network_id','$date_time','$total_session','$imei','$emei','$power_source_type','$power_source_status', '$total_charge', '$sos_activated', '$date_time', now(), '$battery_status', '$temperature', '$total_session','$gnss', '$device_activity','$user_activity', '$device_error', '$input_source', '$output_source', '$input_voltage', '$input_current', '$input_power','$output_voltage','$output_current', '$output_power'),";
    
    return $query;
}

function parseLoactionJsonToInsertSQL($data, $ssm_id, $date_time)
{

    $lat = trim(convLat($data[0]['lat']));
    $lon = trim(convLong($data[0]['lon']));
    $altitude = trim($data[0]['alt']);
    try {
        $date_time = convertDeviceTimeToDBTime($date_time);
    } catch (\Throwable $th) {
        throw $th;
    }


    $query = "(''$lat'', ''$lon'', ''$ssm_id'', ''$altitude'', ''$date_time'', now()),";

    return $query;
}

function parseRunTimeJsonToInsertSQL($data, $ssm_id, $date_time)
{

    // _user_usage numeric := coalesce((_in->>'totalUses')::numeric, 0.0);
    // _from_battery numeric := coalesce((_in->>'f_battery')::numeric, 0.0);
    // _from_grid numeric := coalesce((_in->>'f_grid')::numeric, 0.0);
    // _from_solar numeric := coalesce((_in->>'f_solar')::numeric, 0.0);
    // _ssm_id varchar := coalesce((_in->>'ssm_id')::varchar, '');
    // _total_session numeric := coalesce((_in->>'t_sn')::numeric, 0.0);


    $data['totalUses'] = $data[0]['userUses'];
    // $data['totalUses'] = $data[0]['t_uses'];
    $data['f_battery'] = $data[0]['f_bat'];
    $data['f_grid'] = $data[0]['f_grid'];
    $data['f_solar'] = $data[0]['f_solar'];
    $data['ssm_id'] = $ssm_id;
    $data['t_sn'] = $data[0]['total_sn'];


    $data['eFgrid'] = $data[0]['eFgrid'];
    $data['eFsolar'] = $data[0]['eFsolar'];
    $data['eFBat'] = $data[0]['eFBat'];
    $data['tEnergy'] = $data[0]['tEnergy'];
    $data['lifetime'] = $data[0]['lifetime'];
    
    try {
        $data['dated'] = convertDeviceTimeToDBTime($date_time);
        $data['created_at'] =  $data['dated'];
    } catch (\Throwable $th) {
        throw $th;
    }
    $data[0] = [];


    return $data;
}

function parsEventLogJsonToInsertSQL($data, $ssm_id, $date_time)
{

    $device_activity = $data[0]['device_activity'];
    $user_activity = $data[0]['user_activity'];
    $faults = $data[0]['faults'];
    $date_time = convertDeviceTimeToDBTime($date_time);

    $query = "(''$device_activity'', ''$user_activity'', ''$ssm_id'', ''$faults'', ''$date_time'', now()),";

    return $query;
}

function parsePowerBankJsonToInsertSQL($data, $ssm_id, $date_time)
{

    $battery_list = [];
    $cell_capacity_list = [];

    foreach ($data[0]['bat_ids'] as $item) {
        array_push($battery_list,  convertStringtoHex($item));
    }

    foreach ($data[0]['cell_cap'] as $item) {
        array_push($cell_capacity_list,  $item);
    }
    // $poc = separateDataFromString($data['poc']);
    // $cycle = separateDataFromString($data['cycle']);
    // $battery_status = separateDataFromString($data['b_s']);
    $data['poc'] = separateDataFromString($data[0]['poc']);
    $data['cycle'] = separateDataFromString($data[0]['cycle']);
    $data['capacity'] = "20000 mah";
    $data['b_s'] = separateDataFromString($data[0]['batSta']);
    $data['cell_capacity'] = $cell_capacity_list;
    $data['temp'] = separateDataFromString($data[0]['temp']);
    $data['energy_in'] = separateDataFromString($data[0]['Ei']);
    $data['energy_out'] = separateDataFromString($data[0]['Eo']);
    $data['altitude'] = $data[0]['altitude'];
    $data[0] = [];
    $data['battery_id'] = $battery_list;
    $data['ssm_id'] = $ssm_id;
    $data['type'] = "Li-Ion";
    try {
        $data['created_at'] = convertDeviceTimeToDBTime($date_time);
    } catch (\Throwable $th) {
        throw $th;
    }
    // $data['created_at'] = convertDeviceTimeToDBTime($date_time);


    return $data;



    // $battery_list = [];
    // $cell_capacity_list = [];

    // foreach ($data[0]['battery_id'] as $item) {
    //     array_push($battery_list,  convertStringtoHex($item));
    // }

    // foreach ($data[0]['battery_cell_capacity'] as $item) {
    //     array_push($cell_capacity_list,  $item);
    // }
    // // $poc = separateDataFromString($data['poc']);
    // // $cycle = separateDataFromString($data['cycle']);
    // // $battery_status = separateDataFromString($data['b_s']);
    // $data['poc'] = separateDataFromString($data[0]['poc']);
    // $data['cycle'] = separateDataFromString($data[0]['cycle']);
    // $data['capacity'] = "20000 mah";
    // $data['b_s'] = separateDataFromString($data[0]['b_s']);
    // $data['cell_capacity'] = $cell_capacity_list;
    // $data['temp'] = separateDataFromString($data[0]['temp']);
    // $data['energy_in'] = separateDataFromString($data[0]['energy_in']);
    // $data['energy_out'] = separateDataFromString($data[0]['energy_out']);
    // $data[0] = [];
    // $data['battery_id'] = $battery_list;
    // $data['ssm_id'] = $ssm_id;
    // $data['type'] = "Li-Ion";
    // $data['created_at'] = convertDeviceTimeToDBTime($date_time);
    // return $data;
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
function separateDataFromString($data)
{
    $out = [];
    $out = explode(',', $data);
    return $out;
}

function convertDeviceTimeToDBTime($input_datetime)
{

    // $date_part = substr($input_datetime, 0, 8);
    // $time_part = substr($input_datetime, 9);

    // $day = substr($date_part, 0, 2);
    // $month = substr($date_part, 2, 2);
    // $year = substr($date_part, 4, 4);

    // $hours = substr($time_part, 0, 2);
    // $minutes = substr($time_part, 2, 2);
    // $seconds = substr($time_part, 4, 2);

    // $postgres_timestamp_format = "{$year}-{$month}-{$day}  {$hours}:{$minutes}:{$seconds}";



    // Using str_replace() function
    $inputDate = str_replace(',', '', $input_datetime);

    $dateTime = DateTime::createFromFormat('dmYHis', $inputDate);

    $postgres_timestamp_format = $dateTime->format('Y-m-d H:i:s.u');
    
    return $postgres_timestamp_format;
}


function convLat($txt_lat)
{
    $latFirst = substr($txt_lat, 0, 2);

    $getLatMinSec = substr($txt_lat, 2, 9) . str_split(',')[0];

    $getLatDirection = substr($txt_lat, 10, 11);

    $latSecond = $getLatMinSec / 60;

    $finalLat = floatval($latFirst) + floatval($latSecond);

    if ($getLatDirection == "S") {

        $finalLat = "-" . $finalLat;
    }
    return $finalLat;
}
function convLong($txt_long)
{

    $longFirst = substr($txt_long, 0, 3);

    $getLongMinSecL = substr($txt_long, 3, 11) . str_split(',')[0];

    $getLongDirection = substr($txt_long, 11, 12);

    $longSecond = $getLongMinSecL / 60;

    $finalLong = floatval($longFirst) + floatval($longSecond);

    if ($getLongDirection == "W") {

        $finalLong = "-" . $finalLong;
    }
    return $finalLong;
}
// function bult_data_insert($data)
// {
//     $out  = "";
//     // echo $out;
//     $fileContent = rtrim($data, '|');
//     $json_objects = explode('|', $fileContent);
//     return unprocessableEntityResponse(json_decode($json_objects[0]));

//     if (!isset($_FILES['file'])) {
//         return unprocessableEntityResponse("invalid request");
//     }
//     $file_type = $_FILES['file']['type'];
//     return unprocessableEntityResponse("File found!!!!!");
//     if ($file_type == 'text/plain') {
//         $fileContent = file_get_contents($_FILES['file']['tmp_name']);
       
//         $fileContent = rtrim($fileContent, '|');
//         $json_objects = explode('|', $fileContent);
       
//         // $folder_name = date("Y_m_d_h_i_sa");
//         // try {
//         //     $target_dir = "../uploads/offline_device_data/".$folder_name."/" ;
//         //     if (!is_dir($target_dir)) {
//         //         mkdir($target_dir, 0755);
//         //     }else{
//         //         return unprocessableEntityResponse("cannot create");
//         //     }
//         //     $file = $_FILES['file']['name'];

//         //     move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $file);
//         // } catch (\Throwable $th) {
//         //    return unprocessableEntityResponse($th->getMessage());
//         // }

//         $insertQueries = [];

//         $insertQueries['ssm'] = "INSERT INTO tespack_plan.ssm(ssm_id, signal_strength, network_id, last_seen_time, total_session, 
//         imei, emei, power_source_type, power_source_status, total_charge, sos_activated, created_at, updated_at, battery_status, temperature) VALUES ";

//         $insertQueries['power_bank'] = [];
//         $insertQueries['run_time'] = [];
//         $insertQueries['gnss_location'] = "INSERT INTO tespack_plan.gnss_loaction (latitude, longitude, ssm_id, altitude, created_at, updated_at) VALUES ";
//         $insertQueries['event_log'] = "insert into tespack_plan.event_log(device_activity, user_activity, ssm_id, faults, created_at, updated_at) values";
//         foreach ($json_objects as $ele) {
//             $ele = json_decode($ele, true);
          
//             $insertQueries['ssm'] .= parseSSMJsonToInsertSQL($ele['system_status'], $ele['ssm_id'], $ele['date_time']);
//             // $insertQueries['gnss_location'] .= parseLoactionJsonToInsertSQL($ele['gnss_loaction_log'], $ele['ssm_id'], $ele['date_time']);
//             // $insertQueries['event_log'] .= parsEventLogJsonToInsertSQL($ele['event_log'], $ele['ssm_id'], $ele['date_time']);
//             // array_push($insertQueries['power_bank'], parsePowerBankJsonToInsertSQL($ele['power_banks_log'], $ele['ssm_id'], $ele['date_time']));
//             // array_push($insertQueries['run_time'], parseRunTimeJsonToInsertSQL($ele['device_total_uses_log'], $ele['ssm_id'], $ele['date_time']));
           
//         }
//         // print(rtrim($insertQueries['ssm'], ','));
//         // print(rtrim($insertQueries['gnss_location'], ','));
//         // print_r(json_encode($insertQueries['power_bank']));
//         try {
//             print_r(json_encode($insertQueries['ssm']));
//         // $out = Database::executeRoutedFn('power_bank__upsert_for_offline', $insertQueries);
//         //  print_r(json_encode($insertQueries['run_time']));
//         // $out = Database::executeRoutedFn('grid_solar_totaluse__upsert_for_offline', $insertQueries);
//         // $out = Database::executeRoutedFn('offline_data__upsert', $insertQueries);
//         //$out = Database::executeRoutedFn('offline_data__upsert', $insertQueries);
//         } catch (\PDOException $e) {
//             exit($e->getMessage());
//         }
//     } else {
//         return unprocessableEntityResponse("Invalid file request");
//     }
//     $response['header_status_code'] = 'HTTP/1.1 201 OK';
//     $response['body']['out'] = $out;
//     $response['body']['status'] = 1;
//     return $response;
// }