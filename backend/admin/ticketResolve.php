<?php
function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
if(isset($_POST['id'])):
    $id = $_POST['id'];
    try{
        $check = "UPDATE ticket_support SET resolved='1' WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        if($check_stmt->execute()):
            $returnData = msg(1,201,'You have successfully updated the resolve status!');
        else:
            $returnData = msg(0,422,'Sorry! There is an issue updating, Please try again letter');
        endif;
        
    }
    catch(PDOException $e){
        //echo "There is a problem in server, please try again a few moments later.";
        //echo $e->getMessage();
        $returnData = msg(0,500,$e->getMessage());
    }
else:
    $returnData = msg(0,422,'There is an issue updating, Please try again letter');
endif;
echo json_encode($returnData);
?>