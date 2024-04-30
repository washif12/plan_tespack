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
elseif(!isset($_POST['title']) 
    || !isset($_POST['link'])
    || !isset($_POST['desc'])
    || !isset($_POST['id'])
    || empty(trim($_POST['title']))
    || empty(trim($_POST['link']))
    || empty(trim($_POST['desc']))
    || empty(trim($_POST['id']))
    ):

    $fields = ['fields' => ['email','name','role']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!',$fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $title = trim($_POST['title']);
    $link = trim($_POST['link']);
    $desc = trim($_POST['desc']);
    $id = trim($_POST['id']);
    $select = "SELECT * FROM ssm_tutorials WHERE title=:title AND id!=:id";
    $select_stmt = $conn->prepare($select);
    $select_stmt->bindValue(':title', htmlspecialchars(strip_tags($title)),PDO::PARAM_STR);
    $select_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
    $select_stmt->execute();

    if($select_stmt->rowCount()):
        $returnData = msg(0,422, 'Please try a different title!');
    
    else:
        try{
            $check = "UPDATE ssm_tutorials SET title=:title,link=:link,description=:note, updated_at = now() WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':title', htmlspecialchars(strip_tags($title)),PDO::PARAM_STR);
            $check_stmt->bindValue(':note', htmlspecialchars(strip_tags($desc)),PDO::PARAM_STR);
            $check_stmt->bindValue(':link', htmlspecialchars(strip_tags($link)),PDO::PARAM_STR);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $check_stmt->execute();
            $returnData = msg(1,201,'You have successfully updated the Country!');
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;

endif;

echo json_encode($returnData);
?>