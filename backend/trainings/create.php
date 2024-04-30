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
    || empty(trim($_POST['title']))
    || empty(trim($_POST['link']))
    || empty(trim($_POST['desc']))
    ):

    $fields = ['fields' => ['email','name','role']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!',$fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $title = trim($_POST['title']);
    $link = trim($_POST['link']);
    $desc = trim($_POST['desc']);
    try{
        $check = "SELECT * FROM ssm_tutorials WHERE title=:title";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':title', htmlspecialchars(strip_tags($title)),PDO::PARAM_STR);
        $check_stmt->execute();

        if($check_stmt->rowCount()):
            $returnData = msg(0,422, 'Please try a different title!');
        
        else:
            $insert_query = "INSERT INTO ssm_tutorials(title,link,description, created_at) VALUES(:title,:link,:note, now())";

            $insert_stmt = $conn->prepare($insert_query);

            // DATA BINDING
            $insert_stmt->bindValue(':title', htmlspecialchars(strip_tags($title)),PDO::PARAM_STR);
            $insert_stmt->bindValue(':link', htmlspecialchars(strip_tags($link)),PDO::PARAM_STR);
            $insert_stmt->bindValue(':note', htmlspecialchars(strip_tags($desc)),PDO::PARAM_STR);

            $insert_stmt->execute();

            $returnData = msg(1,201,'You have successfully added a new Tutorial!');

        endif;
        
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }

endif;

echo json_encode($returnData);
?>