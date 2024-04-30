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
elseif(!isset($_POST['country']) 
    || !isset($_POST['ref'])
    || !isset($_POST['note'])
    || !isset($_POST['id'])
    || !isset($_POST['contact'])
    || !isset($_POST['date'])
    || !isset($_POST['model'])
    || empty(trim($_POST['country']))
    || empty(trim($_POST['ref']))
    || empty(trim($_POST['note']))
    || empty(trim($_POST['id']))
    || empty(trim($_POST['model']))
    || empty(trim($_POST['date']))
    || empty(trim($_POST['contact']))
    ):

    $fields = ['fields' => ['email','name','role']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!',$fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $country = trim($_POST['country']);
    $ref = trim($_POST['ref']);
    $note = trim($_POST['note']);
    $model = trim($_POST['model']);
    $date = trim($_POST['date']);
    $contact = trim($_POST['contact']);
    $id = trim($_POST['id']);
    try{
        $check = "UPDATE devices SET country=:country,ref=:ref, ssm_id=:ssm_id, note=:note, model=:model,contact=:contact,date=:date_new, updated_at = now() WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
        $check_stmt->bindValue(':ref', htmlspecialchars(strip_tags(strtoupper($ref))),PDO::PARAM_STR);
        $check_stmt->bindValue(':ssm_id', htmlspecialchars(strip_tags(strtoupper($ref))),PDO::PARAM_STR);
        $check_stmt->bindValue(':note', htmlspecialchars(strip_tags($note)),PDO::PARAM_STR);
        $check_stmt->bindValue(':model', htmlspecialchars(strip_tags($model)),PDO::PARAM_STR);
        $check_stmt->bindValue(':contact', htmlspecialchars(strip_tags($contact)),PDO::PARAM_STR);
        $check_stmt->bindValue(':date_new', htmlspecialchars(strip_tags($date)),PDO::PARAM_STR);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        $check_stmt->execute();
        $returnData = msg(1,201,'You have successfully added a new Country!');
        
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }

endif;

echo json_encode($returnData);
?>