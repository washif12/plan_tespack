<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

require __DIR__.'/classes/database.php';
//require __DIR__.'/classes/JwtHandler.php';

$db_connection = new Database();
$conn = $db_connection->dbConnection();
$returnData = [];
$testArray = [];

// IF REQUEST METHOD IS NOT EQUAL TO GET
if($_SERVER["REQUEST_METHOD"] != "GET"):
    $returnData = msg(0,404,'Data Not Received, Please Send GET Request.');

// IF Method is GET
elseif($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['str'])):
    /*$returnData = msg(1,201,'Request is GET');
    $gps_data = explode(",",$_GET['gps_data']);
    $data_array =  array(
        "smb_id" => $_GET['smb_id'],
        "key" => $_GET['key'],
        "lat" => $gps_data[0],
        "lng" => $gps_data[1],
        "alt" => $gps_data[2],
        "speed" => $gps_data[3], 
        "course" => $gps_data[4]   
      );*/
    if($_GET['str']==0):
        $ref = $_GET['s_id'];
        $imsi = $_GET['imsi'];
        $iemi = $_GET['iemi'];
        try{
            $check = "SELECT * FROM `devices` WHERE `ref`=:ref";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)),PDO::PARAM_STR);
            $check_stmt->execute();
    
            if($check_stmt->rowCount()):
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                $smb_id = $data['id'];
                $check_info = "SELECT * FROM `device_info` WHERE `smb_id`=:smb";
                $check_info_stmt = $conn->prepare($check_info);
                $check_info_stmt->bindValue(':smb', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
                $check_info_stmt->execute();
                if($check_info_stmt->rowCount()):
                    $returnData = msg(0,422, 'This SMB Info is already added');
                else:
                    $insert_query = "INSERT INTO `device_info`(`imsi`,`iemi`,`smb_id`) VALUES(:imsi,:iemi,:smb)";
    
                    $insert_stmt = $conn->prepare($insert_query);
                    // DATA BINDING
                    $insert_stmt->bindValue(':imsi', htmlspecialchars(strip_tags($imsi)),PDO::PARAM_STR);
                    $insert_stmt->bindValue(':iemi', htmlspecialchars(strip_tags($iemi)),PDO::PARAM_STR);
                    $insert_stmt->bindValue(':smb', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
        
                    $insert_stmt->execute();
        
                    $returnData = msg(1,201,'Primary Info for this SMB is Stored');
                endif;
            
            else:
                $returnData = msg(0,422, 'Sorry! This SMB is not added in the database.');
    
            endif;
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
        //$returnData = msg(1,201,'First String Received.');

    elseif($_GET['str'] == 1):
        $ref = $_GET['s_id'];
        $network = $_GET['gsm'];
        $signal = $_GET['sig'];
        try{
            $check = "SELECT * FROM `devices` WHERE `ref`=:ref";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)),PDO::PARAM_STR);
            $check_stmt->execute();
    
            if($check_stmt->rowCount()):
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                $smb_id = $data['id'];
                $check_info = "SELECT * FROM `device_info` WHERE `smb_id`=:smb";
                $check_info_stmt = $conn->prepare($check_info);
                $check_info_stmt->bindValue(':smb', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
                $check_info_stmt->execute();
                if($check_info_stmt->rowCount()):
                    $update_query = "UPDATE `device_info` SET `network`=:network,`smb_signal`=:signal WHERE `smb_id`=:id";
    
                    $update_stmt = $conn->prepare($update_query);
                    // DATA BINDING
                    $update_stmt->bindValue(':network', htmlspecialchars(strip_tags($network)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':signal', htmlspecialchars(strip_tags($signal)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':id', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
        
                    $update_stmt->execute();
        
                    $returnData = msg(1,201,'Network & Signal Info Updated');
                else:
                    $returnData = msg(0,422, 'This SMB Primary Info is not Stored.');
                endif;
            
            else:
                $returnData = msg(0,422, 'Sorry! This SMB is not added in the database.');
    
            endif;
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }

    elseif($_GET['str']==2):
        $ref = $_GET['s_id'];
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        try{
            $check = "SELECT * FROM `devices` WHERE `ref`=:ref";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)),PDO::PARAM_STR);
            $check_stmt->execute();
    
            if($check_stmt->rowCount()):
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                $smb_id = $data['id'];
                $check_info = "SELECT * FROM `device_info` WHERE `smb_id`=:smb";
                $check_info_stmt = $conn->prepare($check_info);
                $check_info_stmt->bindValue(':smb', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
                $check_info_stmt->execute();
                if($check_info_stmt->rowCount()):
                    $update_query = "UPDATE `device_info` SET `lat`=:lat,`lng`=:lng WHERE `smb_id`=:id";
    
                    $update_stmt = $conn->prepare($update_query);
                    // DATA BINDING
                    $update_stmt->bindValue(':lat', htmlspecialchars(strip_tags($lat)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':lng', htmlspecialchars(strip_tags($lng)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':id', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
        
                    $update_stmt->execute();
        
                    $returnData = msg(1,201,'Latitude & Longitude Info Updated');
                else:
                    $returnData = msg(0,422, 'This SMB Primary Info is not Stored.');
                endif;
            
            else:
                $returnData = msg(0,422, 'Sorry! This SMB is not added in the database.');
    
            endif;
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }

    elseif($_GET['str']==3):
        //$returnData = msg(1,201,'Fourth String Received.');   
        $ref = $_GET['s_id'];
        $level = $_GET['level'];
        $mode = $_GET['mode'];
        $p_stat = $_GET['p_stat'];
        $pwr = $_GET['pwr'];
        $grid = $_GET['grid'];
        $gpwr = $_GET['gpwr'];
        $gvolt = $_GET['gvolt'];
        $panel = $_GET['panel'];
        $ppwr = $_GET['ppwr'];
        $pvolt = $_GET['pvolt'];
        try{
            $check = "SELECT * FROM `devices` WHERE `ref`=:ref";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)),PDO::PARAM_STR);
            $check_stmt->execute();
    
            if($check_stmt->rowCount()):
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                $smb_id = $data['id'];
                $check_info = "SELECT * FROM `device_info` WHERE `smb_id`=:smb";
                $check_info_stmt = $conn->prepare($check_info);
                $check_info_stmt->bindValue(':smb', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
                $check_info_stmt->execute();
                if($check_info_stmt->rowCount()):
                    $update_query = "UPDATE `device_info` SET `lat`=:lat,`lng`=:lng WHERE `smb_id`=:id";
    
                    $update_stmt = $conn->prepare($update_query);
                    // DATA BINDING
                    $update_stmt->bindValue(':lat', htmlspecialchars(strip_tags($lat)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':lng', htmlspecialchars(strip_tags($lng)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':id', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
        
                    $update_stmt->execute();
        
                    $returnData = msg(1,201,'Latitude & Longitude Info Updated');
                else:
                    $returnData = msg(0,422, 'This SMB Primary Info is not Stored.');
                endif;
            
            else:
                $returnData = msg(0,422, 'Sorry! This SMB is not added in the database.');
    
            endif;
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    elseif($_GET['str']==4):
        $ref = $_GET['s_id'];
        $battery =  array($_GET['bt1'], $_GET['bt2'], $_GET['bt3'], $_GET['bt4'], $_GET['bt5'], $_GET['bt6']);
        try{
            $check = "SELECT * FROM `devices` WHERE `ref`=:ref";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)),PDO::PARAM_STR);
            $check_stmt->execute();
    
            if($check_stmt->rowCount()):
                $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
                $smb_id = $data['id'];
                $check_info = "SELECT * FROM `power_banks` WHERE `smb_id`=:smb";
                $check_info_stmt = $conn->prepare($check_info);
                $check_info_stmt->bindValue(':smb', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
                $check_info_stmt->execute();
                if($check_info_stmt->rowCount()):
                    foreach($battery as $index=>$item){
                        $bt_data = explode(",",$item);
                        $serial = $bt_data[0];
                        $level = $bt_data[1];
                        $status = $bt_data[2];
                        $capacity = $bt_data[3];
                        $cycle = $bt_data[4];
                        $pos = $index+1;
                    }
                    /*$update_query = "UPDATE `device_info` SET `lat`=:lat,`lng`=:lng WHERE `smb_id`=:id";
    
                    $update_stmt = $conn->prepare($update_query);
                    // DATA BINDING
                    $update_stmt->bindValue(':lat', htmlspecialchars(strip_tags($lat)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':lng', htmlspecialchars(strip_tags($lng)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':id', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
        
                    $update_stmt->execute();*/
        
                    $returnData = msg(1,201,'Battery Info Updated');
                else:
                    foreach($battery as $index=>$item){
                        $bt_data = explode(",",$item);
                        /*$serial = $bt_data[0];
                        $level = $bt_data[1];
                        $status = $bt_data[2];
                        $capacity = $bt_data[3];
                        $cycle = $bt_data[4];*/
                        $data_array =  array(
                            "lat" => $bt_data[0],
                            "lng" => $bt_data[1],
                            "alt" => $bt_data[2],
                            "speed" => $bt_data[3], 
                            "course" => $bt_data[4],
                            'pos' => $index +1  
                        );
                        array_push($testArray,$data_array);
                    }
                    /*$update_query = "UPDATE `device_info` SET `lat`=:lat,`lng`=:lng WHERE `smb_id`=:id";
    
                    $update_stmt = $conn->prepare($update_query);
                    // DATA BINDING
                    $update_stmt->bindValue(':lat', htmlspecialchars(strip_tags($lat)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':lng', htmlspecialchars(strip_tags($lng)),PDO::PARAM_STR);
                    $update_stmt->bindValue(':id', htmlspecialchars(strip_tags($smb_id)),PDO::PARAM_STR);
        
                    $update_stmt->execute();*/
                    $returnData = msg(1,201, 'New Battery Info Stored.',$testArray);
                endif;
            
            else:
                $returnData = msg(0,422, 'Sorry! This SMB is not added in the database.');
    
            endif;
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    else:
        $returnData = msg(0,404,'Variable str is missing');
    endif;
else:
    $returnData = msg(0,404,'Please check the data format');
endif;

echo json_encode($returnData);
?>