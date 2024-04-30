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
    || !isset($_POST['ref_no'])
    || !isset($_POST['note'])
    || !isset($_POST['model'])
    || !isset($_POST['contact'])
    || !isset($_POST['date'])
    || empty(trim($_POST['ref_no']))
    || empty(trim($_POST['country']))
    || empty(trim($_POST['note']))
    || empty(trim($_POST['model']))
    || empty(trim($_POST['date']))
    || empty(trim($_POST['contact']))
    ):

    $returnData = msg(0,422,'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $country = trim($_POST['country']);
    $ref = trim($_POST['ref_no']);
    $note = trim($_POST['note']);
    $model = trim($_POST['model']);
    $date = trim($_POST['date']);
    $contact = trim($_POST['contact']);

    $select = "SELECT * FROM ssm_serial WHERE ssm_id=:ref";
    $select_stmt = $conn->prepare($select);
    $select_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)),PDO::PARAM_STR);
    $select_stmt->execute();
    if($select_stmt->rowCount()):
        try{
            $check = "SELECT ref FROM devices WHERE ref=:ref";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)),PDO::PARAM_STR);
            $check_stmt->execute();

            if($check_stmt->rowCount()):
                $returnData = msg(0,422, 'This SSM with reference no '.$ref.' already exists!');
            
            else:
                $insert_query = "INSERT INTO devices(ref,ssm_id,note,country,model,date,contact, created_at) VALUES(:ref,:ssm_id, :note,:country,:model,:date_added,:contact, now())";

                $insert_stmt = $conn->prepare($insert_query);

                // DATA BINDING
                $insert_stmt->bindValue(':ref', htmlspecialchars(strip_tags(strtoupper($ref))),PDO::PARAM_STR);
                $insert_stmt->bindValue(':ssm_id', htmlspecialchars(strip_tags(strtoupper($ref))),PDO::PARAM_STR);
                $insert_stmt->bindValue(':note', htmlspecialchars(strip_tags($note)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':model', htmlspecialchars(strip_tags($model)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':date_added', htmlspecialchars(strip_tags($date)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':contact', htmlspecialchars(strip_tags($contact)),PDO::PARAM_STR);

                $insert_stmt->execute();

                $returnData = msg(1,201,'You have successfully added a new SSM!');

            endif;
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    else:
        $returnData = msg(0,422, 'This SSM with reference no '.$ref.' does not exist!');
    endif;
endif;

echo json_encode($returnData);
?>