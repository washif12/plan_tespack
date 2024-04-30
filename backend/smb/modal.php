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
$project_info = [];
$resp_info=[];
if(isset($_POST['id'])):
    $id = $_POST['id'];
    try{
        $check = "SELECT * FROM devices WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $team_id = $data['team_id'];
            if($team_id == NULL):
                $values = ['ref'=>$data["ref"],'model'=>$data["model"],'contact'=>$data["contact"],'deliver_date'=>$data["date"],'country'=>$data["country"],'note'=>$data["note"],'main_id'=>$data["id"], 'pro_assigned'=>[], 'resp'=>[]];
            else:
                $project = "SELECT * FROM projects where team_id=:team_id";
                $project_stmt = $conn->prepare($project);
                $project_stmt->bindValue(':team_id', htmlspecialchars(strip_tags($team_id)),PDO::PARAM_STR);
                $project_stmt->execute();
                if($project_stmt->rowCount()):
                    foreach($data_project = $project_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        array_push($project_info,$row['name']);
                    }
                else:
                    $project_info=[];
                endif;
                $resp = "SELECT a.* FROM project_managers as a left join smb_resp as b on a.id=b.pm_id where b.smb_id=:id";
                $resp_stmt = $conn->prepare($resp);
                $resp_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $resp_stmt->execute();
                if($resp_stmt->rowCount()):
                    foreach($data_resp = $resp_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        array_push($resp_info,$row['name']);
                    }
                else:
                    $resp_info=[];
                endif;
                $values = ['ref'=>$data["ref"],'model'=>$data["model"],'contact'=>$data["contact"],'deliver_date'=>$data["date"],'country'=>$data["country"],'note'=>$data["note"],'main_id'=>$data["id"], 'pro_assigned'=>$project_info, 'resp'=>$resp_info];
            endif;
            $returnData = msg(1,201,'Data Received',$values);
        else:
            $returnData = msg(0,422, 'No data found!');
    
        endif;
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
endif;

echo json_encode($returnData);
?>