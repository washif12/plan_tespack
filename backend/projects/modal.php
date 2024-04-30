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
$values = [];
$pm_info = [];
$tm_info = [];
$smb_info = [];
$regions = [];

if(isset($_POST['id'])):
    $id = $_POST['id'];
    try{
        $check = "SELECT * FROM projects where id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            //$values = ['name' => $data["name"],'contact'=>$data["contact"]];
            $team_id = $data['team_id'];
            if($team_id == NULL):
                $values = ['team'=>'0','name' => $data["name"],'country'=>$data["country"],'region'=>$data["region"],'description'=>$data["description"]];
            else:
                $pm = "SELECT a.fname,a.lname,a.email,a.phone,a.country FROM users as a left join project_managers as b on b.reg_id=a.id left join teams as c on c.id=b.team_id where c.id=$team_id";
                $pm_stmt = $conn->prepare($pm);
                $pm_stmt->execute();
                foreach($data_pm = $pm_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    array_push($pm_info,$row);
                    //$values = ['pm'=>$row];
                }
                $tm = "SELECT a.fname,a.lname,a.email,a.phone,a.country FROM users as a left join team_members as b on b.reg_id=a.id left join teams as c on c.id=b.team_id where c.id=$team_id";
                $tm_stmt = $conn->prepare($tm);
                $tm_stmt->execute();
                foreach($data_tm = $tm_stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
                    array_push($tm_info,$item);
                }
                $smb = "SELECT a.id,a.ref,a.model,c.name FROM devices as a left join smb_resp as d on a.id=d.smb_id left join project_managers as c on d.pm_id=c.id left join teams as b on a.team_id=b.id WHERE b.id=$team_id";
                $smb_stmt = $conn->prepare($smb);
                $smb_stmt->execute();
                foreach($data_smb = $smb_stmt->fetchAll(PDO::FETCH_ASSOC) as $items) {
                    array_push($smb_info,$items);
                }
                $teamName = "SELECT * FROM teams where id=$team_id";
                $teamName_stmt = $conn->prepare($teamName);
                $teamName_stmt->execute();
                $data_team = $teamName_stmt->fetch(PDO::FETCH_ASSOC);

                $values = ['team'=>'1','pm'=>$pm_info,'tm'=>$tm_info,'smb'=>$smb_info,'name' => $data["name"],'country'=>$data["country"],'region'=>$data["region"],'description'=>$data["description"],'teamName'=>$data_team["name"],'idTeam'=>$data_team["id"]];
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