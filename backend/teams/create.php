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
    $total_managers = count($managers);
    $total_members = count($members);
    $total_devices = count($devices);
    $total_resp = count($smb_resp);
    //$returnData = msg(1,201,'Success!');
    try{
        $check = "SELECT * FROM teams WHERE name=:team";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':team', htmlspecialchars(strip_tags($team)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $returnData = msg(0,422, 'This Team Name already exists!');
        /*for($i=0; $i<$total_devices; $i++) {
            $check_smb = "SELECT * FROM devices WHERE id=:id_smb AND team_id is null";
            $check_smb_stmt = $conn->prepare($check_smb);
            $check_smb_stmt->bindValue(':id_smb', htmlspecialchars(strip_tags($devices[$i])),PDO::PARAM_STR);
            $check_smb_stmt->execute();
        }
        elseif($check_smb_stmt->rowCount()):
            $returnData = msg(0,422, 'Sorry! This Device is already assigned to another team.');*/
        else:
            $conn->beginTransaction();
            try {
                $insert_query = "INSERT INTO teams(name,contact, created_at) VALUES(:team,:contact, now())";
                $insert_stmt = $conn->prepare($insert_query);
                // DATA BINDING
                $insert_stmt->bindValue(':team', htmlspecialchars(strip_tags($team)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':contact', htmlspecialchars(strip_tags($contact)),PDO::PARAM_STR);
                $insert_stmt->execute();
                for($i=0; $i<$total_devices; $i++) {
                    $devices_query = "UPDATE devices SET team_id=(SELECT id FROM teams WHERE name=:team), updated_at = now() WHERE id=$devices[$i]";
                    $devices_stmt = $conn->prepare($devices_query);
                    $devices_stmt->bindValue(':team', htmlspecialchars(strip_tags($team)),PDO::PARAM_STR);
                    $devices_stmt->execute();
                    $resp_query = "INSERT INTO smb_resp (smb_id, pm_id) VALUES ($devices[$i], $smb_resp[$i])";
                    $resp_stmt = $conn->prepare($resp_query);
                    $resp_stmt->execute();
                }
                for($j=0; $j<$total_managers; $j++) {
                    $managers_query = "UPDATE project_managers SET team_id=(SELECT id FROM teams WHERE name=:team), updated_at = now() WHERE reg_id=$managers[$j]";
                    $managers_stmt = $conn->prepare($managers_query);
                    $managers_stmt->bindValue(':team', htmlspecialchars(strip_tags($team)),PDO::PARAM_STR);
                    $managers_stmt->execute();
                }
                for($k=0; $k<$total_members; $k++) {
                    $members_query = "UPDATE team_members SET team_id=(SELECT id FROM teams WHERE name=:team), updated_at = now() WHERE reg_id=$members[$k]";
                    $members_stmt = $conn->prepare($members_query);
                    $members_stmt->bindValue(':team', htmlspecialchars(strip_tags($team)),PDO::PARAM_STR);
                    $members_stmt->execute();
                }
                $conn->commit();
                $returnData = msg(1,201,'You have successfully added a new Team!');
            }
            catch(PDOException $m){
                $conn->rollback();
                $returnData = msg(0,500,$m->getMessage());
            }

        endif;
        
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }

endif;

echo json_encode($returnData);
?>