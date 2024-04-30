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
        $check = "SELECT * FROM countries WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $data = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $values = ['fields' => [$data["country"],$data["region"],$data["note"],$data["id"]]];
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