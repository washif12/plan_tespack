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

$country = $_POST['country'];
$project = $_POST['project'];

if(!empty($country) && empty($project)):
    try{
        $check = "SELECT * FROM projects WHERE country=:country";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            foreach($data_pro = $check_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($projects,$row);
            }
        else:
            $projects = [];
    
        endif;

        $values = ['projects' => $projects];
        $returnData = msg(1,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(empty($country) && !empty($project)):
    try{
        $check = "SELECT * FROM projects WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $team_id = $data["team_id"];
            array_push($countries,$data);
        else:
            $countries = [];
        endif;

        $values = ['countries' => $countries];
        $returnData = msg(2,201,'Data Received',$values);
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }

endif;

echo json_encode($returnData);
?>