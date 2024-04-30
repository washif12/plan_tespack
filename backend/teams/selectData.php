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

if(isset($_POST['id'])):
    $id = $_POST['id'];
    try{
        $check = "SELECT * FROM users WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $values = ['fields' => [$data["email"],$data["phone"],$data["country"]]];
            $returnData = msg(1,201,'Data Received',$values);
        else:
            $returnData = msg(0,422, 'No data found!');
    
        endif;
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(isset($_POST['devID'])):
    $devID = $_POST['devID'];
    try{
        $check = "SELECT * FROM devices WHERE id=:devID";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':devID', htmlspecialchars(strip_tags($devID)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $values = ['fields' => [$data["model"]]];
            $returnData = msg(1,201,'Data Received',$values);
        else:
            $returnData = msg(0,422, 'No data found!');
    
        endif;
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(isset($_POST['respId'])):
    $respId = $_POST['respId'];
    try{
        $check = "SELECT * FROM project_managers WHERE reg_id=:respId";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':respId', htmlspecialchars(strip_tags($respId)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $values = ['fields' => [$data["id"],$data["name"]]];
            $returnData = msg(1,201,'Data Received',$values);
        else:
            $returnData = msg(0,422, 'No data found!');
    
        endif;
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }
elseif(isset($_POST['userId'])):
    $userId = $_POST['userId'];
    try{
        $check = "SELECT * FROM users WHERE id=:userId";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':userId', htmlspecialchars(strip_tags($userId)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $values = ['fields' => [$data["email"],$data["phone"],$data["country"]]];
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