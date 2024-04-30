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

if(isset($_POST['id'])):
    $id = $_POST['id'];
    try{
        $check = "SELECT * FROM devices WHERE team_id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetchAll(PDO::FETCH_ASSOC);
            //$smb_id = $data['id'];
            $conn->beginTransaction();
            try {
                foreach($data as $item) {
                    /*$devices_query = "UPDATE devices SET team_id=NULL WHERE id=:id";
                    $devices_stmt = $conn->prepare($devices_query);
                    $devices_stmt->bindValue(':id', htmlspecialchars(strip_tags($item['id'])),PDO::PARAM_STR);
                    $devices_stmt->execute();*/
                    
                    $resp_query = "DELETE FROM smb_resp WHERE smb_id=:id";
                    $resp_stmt = $conn->prepare($resp_query);
                    $resp_stmt->bindValue(':id', htmlspecialchars(strip_tags($item['id'])),PDO::PARAM_STR);
                    $resp_stmt->execute();
                }

                /*$check_project = "SELECT * FROM projects WHERE team_id=:id";
                $check_project_stmt = $conn->prepare($check_project);
                $check_project_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $check_project_stmt->execute();
                if($check_project_stmt->rowCount()):
                    $projects_query = "UPDATE projects SET team_id=NULL WHERE team_id=:id";
                    $projects_stmt = $conn->prepare($projects_query);
                    $projects_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $projects_stmt->execute();
                endif;*/
                
                //$members_query = "DELETE team_pm,team_tm,teams FROM teams LEFT JOIN team_pm ON team_pm.team_id = teams.id LEFT JOIN team_tm ON team_tm.team_id = teams.id WHERE teams.id = :id";
                $members_query = "DELETE FROM teams WHERE id = :id";
                $members_stmt = $conn->prepare($members_query);
                $members_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $members_stmt->execute();
                
                $conn->commit();
                $returnData = msg(1,201,'You have successfully deleted the Team');
            }
            catch(PDOException $m){
                $conn->rollback();
                $returnData = msg(0,500,$m->getMessage());
            }
        else:
            $returnData = msg(0,422, 'No data found!');
    
        endif;
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
endif;

echo json_encode($returnData);
?>