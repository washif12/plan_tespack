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
            $select = "SELECT a.* FROM projects as a left join teams as b on b.id=a.team_id left join project_managers as c on c.team_id=b.id left join users as d on d.id=c.reg_id where d.id=:reg_id";
            $select_stmt = $conn->prepare($select);
            $select_stmt->bindValue(':reg_id', htmlspecialchars(strip_tags($data["id"])),PDO::PARAM_STR);
            $select_stmt->execute();

            if($select_stmt->rowCount()):
                $assigned=1;
            else:
                $assigned=0;
            endif;
            $values = ['fields' => [$data["fname"],$data["email"],$data["phone"],$data["country"],$data["address"],$data["lname"],$data["id"],$data["role"], $assigned, $data["image_path"]]];
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