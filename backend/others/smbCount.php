<?php
require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}
$returnData = [];
$projects = [];
$managers = [];
$countries = [];

if(isset($_POST['role']) && isset($_POST['country'])):
    $role = $_POST['role'];
    $country = $_POST['country'];
    if($role == '1'):
        try{
            $count_smb = "SELECT count(id) as total_smb FROM devices";
            $count_smb_stmt = $conn->prepare($count_smb);
            $count_smb_stmt->execute();
            $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
            $values = ['smb' => $smb_data['total_smb']];
            $returnData = msg(1,201,'Data Received',$values);
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    elseif($role == '3'):
        try{
            $count_smb = "SELECT count(id) as total_smb FROM devices where country=:country";
            $count_smb_stmt = $conn->prepare($count_smb);
            $count_smb_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
            $count_smb_stmt->execute();
            $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
            $values = ['smb' => $smb_data['total_smb']];
            $returnData = msg(1,201,'Data Received',$values);
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    else:
        try{
            $count_smb = "SELECT count(id) as total_smb FROM devices";
            $count_smb_stmt = $conn->prepare($count_smb);
            $count_smb_stmt->execute();
            $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
            $values = ['smb' => $smb_data['total_smb']];
            $returnData = msg(1,201,'Data Received',$values);
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
else:
    try{
        $count_smb = "SELECT count(id) as total_smb FROM devices";
        $count_smb_stmt = $conn->prepare($count_smb);
        $count_smb_stmt->execute();
        $smb_data = $count_smb_stmt->fetch(PDO::FETCH_ASSOC);
        $values = ['smb' => $smb_data['total_smb']];
        $returnData = msg(1,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
endif;

echo json_encode($returnData);
?>