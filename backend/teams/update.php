<?php

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

require __DIR__.'/../../assets/api/classes/database.php';
//require __DIR__.'/classes/JwtHandler.php';

$db_connection = new Database();
$conn = $db_connection->dbConnection();

//$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT EQUAL TO POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($_POST['manager']) 
    || !isset($_POST['member'])
    || !isset($_POST['smb_ref'])
    || !isset($_POST['smb_resp'])
    || !isset($_POST['team'])
    || !isset($_POST['contact'])
    || empty($_POST['manager'])
    || empty($_POST['member'])
    || empty($_POST['smb_ref'])
    || empty($_POST['smb_resp'])
    || empty($_POST['team'])
    || empty($_POST['contact'])
    ):

    //$fields = ['fields' => ['manager','member','smb_info','team','contact']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $managers = $_POST['manager'];
    $members = $_POST['member'];
    $devices = $_POST['smb_ref'];
    $smb_resp = $_POST['smb_resp'];
    $team = $_POST['team'];
    $contact = $_POST['contact'];
    $id = $_POST['team_id'];
    $total_managers = count($managers);
    $total_members = count($members);
    $total_devices = count($devices);
    $total_resp = count($smb_resp);
    //$returnData = msg(1,201,'Success!');
    try{
        $conn->beginTransaction();
        try {
            $insert_query = "UPDATE teams SET name=:team, contact=:contact, updated_at = now() WHERE id=:id";
            $insert_stmt = $conn->prepare($insert_query);
            // DATA BINDING
            $insert_stmt->bindValue(':team', htmlspecialchars(strip_tags($team)),PDO::PARAM_STR);
            $insert_stmt->bindValue(':contact', htmlspecialchars(strip_tags($contact)),PDO::PARAM_STR);
            $insert_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $insert_stmt->execute();
    
            $check = "SELECT * FROM devices WHERE team_id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $check_stmt->execute();
            $data = $check_stmt->fetchAll(PDO::FETCH_ASSOC);
            //$check_stmt->rowCount()
            foreach($data as $item) {
                $delete_resp_query = "DELETE FROM smb_resp WHERE smb_id=:id";
                $delete_resp_stmt = $conn->prepare($delete_resp_query);
                $delete_resp_stmt->bindValue(':id', htmlspecialchars(strip_tags($item['id'])),PDO::PARAM_STR);
                $delete_resp_stmt->execute();
            }
            $reset_query = "UPDATE devices SET team_id= NULL, updated_at = now() WHERE team_id=:id";
            $reset_stmt = $conn->prepare($reset_query);
            $reset_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $reset_stmt->execute();
            $reset_pm_query = "UPDATE project_managers SET team_id= NULL, updated_at = now() WHERE team_id=:id";
            $reset_pm_stmt = $conn->prepare($reset_pm_query);
            $reset_pm_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $reset_pm_stmt->execute();
            $reset_tm_query = "UPDATE team_members SET team_id= NULL, updated_at = now() WHERE team_id=:id";
            $reset_tm_stmt = $conn->prepare($reset_tm_query);
            $reset_tm_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $reset_tm_stmt->execute();
            for($i=0; $i<$total_devices; $i++) {
                $devices_query = "UPDATE devices SET team_id=:id, updated_at = now() WHERE id=$devices[$i]";
                $devices_stmt = $conn->prepare($devices_query);
                $devices_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $devices_stmt->execute();
                $resp_query = "INSERT INTO smb_resp (smb_id, pm_id, created_at) VALUES ($devices[$i], $smb_resp[$i], now())";
                $resp_stmt = $conn->prepare($resp_query);
                $resp_stmt->execute();
            }
            for($j=0; $j<$total_managers; $j++) {
                $managers_query = "UPDATE project_managers SET team_id=:id, updated_at = now() WHERE reg_id=$managers[$j]";
                $managers_stmt = $conn->prepare($managers_query);
                $managers_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $managers_stmt->execute();
            }
            for($k=0; $k<$total_members; $k++) {
                $members_query = "UPDATE team_members SET team_id=:id, updated_at = now() WHERE reg_id=$members[$k]";
                $members_stmt = $conn->prepare($members_query);
                $members_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $members_stmt->execute();
            }
            /*$delete_managers_query = "DELETE FROM team_pm WHERE team_id = :id";
            $delete_managers_stmt = $conn->prepare($delete_managers_query);
            $delete_managers_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $delete_managers_stmt->execute();
            for($j=0; $j<$total_managers; $j++) {
                $managers_query = "INSERT INTO team_pm (team_id, pm_id) VALUES (:id, (SELECT id FROM project_managers WHERE reg_id=$managers[$j]))";
                $managers_stmt = $conn->prepare($managers_query);
                $managers_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $managers_stmt->execute();
            }
            $delete_members_query = "DELETE FROM team_tm WHERE team_id = :id";
            $delete_members_stmt = $conn->prepare($delete_members_query);
            $delete_members_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $delete_members_stmt->execute();
            for($k=0; $k<$total_members; $k++) {
                $members_query = "INSERT INTO team_tm (team_id, tm_id) VALUES (:id, (SELECT id FROM team_members WHERE reg_id=$members[$k]))";
                $members_stmt = $conn->prepare($members_query);
                $members_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $members_stmt->execute();
            }*/
            $conn->commit();
            $returnData = msg(1,201,'You have successfully Updated!');
        }
        catch(PDOException $m){
            $conn->rollback();
            $returnData = msg(0,500,$m->getMessage());
        }
        
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }

endif;

echo json_encode($returnData);
?>