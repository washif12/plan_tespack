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
require __DIR__.'/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($_POST['email'])
|| !isset($_POST['pass'])
|| !isset($_POST['checkPass'])
|| empty(trim($_POST['email']))
|| empty(trim($_POST['pass']))
|| empty(trim($_POST['checkPass']))
):
    $returnData = msg(0,422,'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
    $pass = trim($_POST['checkPass']);
    
    if(strlen($password) < 6):
        $returnData = msg(0,422,'Your password must be at least 6 characters long!');

    elseif($pass != $password):
        $returnData = msg(0,422,'Your passwords do not match! Please confirm properly.');

    else:
        try{

            $check_email = "SELECT email FROM users WHERE email=:email";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':email', $email,PDO::PARAM_STR);
            $check_email_stmt->execute();

            if($check_email_stmt->rowCount()):
                $insert_query = "UPDATE users SET password=:password WHERE email=:email";
                $insert_stmt = $conn->prepare($insert_query);
                // DATA BINDING
                $insert_stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
                $insert_stmt->bindValue(':email', $email);
                $insert_stmt->execute();
                $returnData = msg(1,422, 'Your password has been updated successfully');
            
            else:

                $returnData = msg(0,201,'Could not find the Email Address.!');

            endif;

        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
    
endif;

echo json_encode($returnData);