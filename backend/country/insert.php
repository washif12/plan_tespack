<?php

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

require __DIR__.'/../../assets/api/classes/database.php';
//require __DIR__.'/classes/JwtHandler.php';

$db_connection = new Database();
$conn = $db_connection->dbConnection();

//$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT EQUAL TO POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($_POST['country']) 
    || !isset($_POST['region'])
    || !isset($_POST['note'])
    || empty(trim($_POST['country']))
    || empty(trim($_POST['region']))
    || empty(trim($_POST['note']))
    ):

    $fields = ['fields' => ['email','name','role']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!',$fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $country = trim($_POST['country']);
    $region = trim($_POST['region']);
    $note = trim($_POST['note']);
    try{
        $check = "SELECT country FROM countries WHERE country=:country AND region=:region";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $check_stmt->bindValue(':region', htmlspecialchars(strip_tags($region)),PDO::PARAM_STR);
        $check_stmt->execute();

        if($check_stmt->rowCount()):
            $returnData = msg(0,422, 'This Country & Region already exists!');
        
        else:
            $insert_query = "INSERT INTO countries(region,note,country, created_at) VALUES(:region,:note,:country, now())";

            $insert_stmt = $conn->prepare($insert_query);

            // DATA BINDING
            $insert_stmt->bindValue(':region', htmlspecialchars(strip_tags($region)),PDO::PARAM_STR);
            $insert_stmt->bindValue(':note', htmlspecialchars(strip_tags($note)),PDO::PARAM_STR);
            $insert_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);

            $insert_stmt->execute();

            $returnData = msg(1,201,'You have successfully added a new Country!');

        endif;
        
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }

endif;

echo json_encode($returnData);
?>