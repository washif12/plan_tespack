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
$returnData = [];

// IF REQUEST METHOD IS NOT EQUAL TO POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($_POST['region'])
    || !isset($_POST['note'])
    || !isset($_POST['id'])
    ||  empty(trim($_POST['region']))
    || empty(trim($_POST['note']))
    || empty(trim($_POST['id']))
    ):

    $fields = ['fields' => ['email','name','role']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!',$fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    //$country = trim($_POST['country']);
    $region = trim($_POST['region']);
    $note = trim($_POST['note']);
    $id = trim($_POST['id']);
    try{
        $select = "SELECT * FROM countries WHERE id=:id";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        $select_stmt->execute();

        if($select_stmt->rowCount()):
            $check = "UPDATE countries SET region=:region,note=:note, updated_at = now() WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            //$check_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
            $check_stmt->bindValue(':region', htmlspecialchars(strip_tags($region)),PDO::PARAM_STR);
            $check_stmt->bindValue(':note', htmlspecialchars(strip_tags($note)),PDO::PARAM_STR);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $check_stmt->execute();
            $returnData = msg(1,201,'You have successfully updated the Country!');
        else:
            $returnData = msg(0,422, 'This Country & Region does not exist!'); 
        endif;
        
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }

endif;

echo json_encode($returnData);
?>