<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

// INCLUDING DATABASE AND MAKING OBJECT
require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
$returnData = [];

// IF REQUEST METHOD IS NOT POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($_POST['id'])
|| !isset($_POST['pass'])
|| !isset($_POST['checkPass'])
|| empty(trim($_POST['id']))
|| empty(trim($_POST['pass']))
|| empty(trim($_POST['checkPass']))
):
    $returnData = msg(0,422,'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    
    $id = $_POST['id'];
    $pass = $_POST['pass'];
    $checkPass = $_POST['checkPass'];
    
    if(strlen($pass) < 6):
        $returnData = msg(0,422,'Your password must be at least 6 characters long!');

    elseif($pass != $checkPass):
        $returnData = msg(0,422,'Your passwords do not match! Please confirm properly.');

    else:
        try{

            $check_email = "SELECT * FROM users WHERE id=:id";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':id', $id,PDO::PARAM_STR);
            $check_email_stmt->execute();

            if($check_email_stmt->rowCount()):
                $insert_query = "UPDATE users SET password=:newPassword WHERE id=:id";
                $insert_stmt = $conn->prepare($insert_query);
                // DATA BINDING
                $insert_stmt->bindValue(':newPassword', password_hash($pass, PASSWORD_DEFAULT));
                $insert_stmt->bindValue(':id', $id);
                $insert_stmt->execute();
                $returnData = msg(1,422, 'Your password has been updated successfully');
            
            else:

                $returnData = msg(0,201,'Could not find the User.!');

            endif;

        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
    
endif;

echo json_encode($returnData);