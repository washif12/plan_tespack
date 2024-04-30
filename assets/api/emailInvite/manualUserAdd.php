<?php
//include('sendVerifyEmail.php');

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
require __DIR__.'/../classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
//$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($_POST['fname']) 
    || !isset($_POST['lname']) 
    || !isset($_POST['email'])
    || !isset($_POST['phone']) 
    || !isset($_POST['country'])
    || !isset($_POST['address'])
    || !isset($_POST['pass'])
    || !isset($_POST['checkPass'])
    || !isset($_POST['role'])
    || empty(trim($_POST['fname']))
    || empty(trim($_POST['lname']))
    || empty(trim($_POST['email']))
    || empty(trim($_POST['phone']))
    || empty(trim($_POST['address']))
    || empty(trim($_POST['country']))
    || empty(trim($_POST['pass']))
    || empty(trim($_POST['checkPass']))
    || empty(trim($_POST['role']))
    ):

    //$fields = ['fields' => ['name','email','password']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $role_name = $_POST['role'];
    if($role_name=='Global Admin'): $role = '1';
    elseif($role_name=='Project Admin'): $role = '2';
    elseif($role_name=='Country Admin'): $role = '3';
    elseif($role_name=='Team Member'): $role = '4';
    endif;

    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $country = trim($_POST['country']);
    $pass = trim($_POST['pass']);
    $checkPass = trim($_POST['checkPass']);
    $fullName = $fname.' '.$lname;

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Invalid Email Address!');
    
    elseif(strlen($pass) < 6):
        $returnData = msg(0,422,'Your password must be at least 6 characters long!');

    elseif($pass != $checkPass):
        $returnData = msg(0,422,'Your passwords do not match! Please confirm properly.');

    elseif(strlen($fname) < 3):
        $returnData = msg(0,422,'Your first name must be at least 3 characters long!');

    else:
        try{
            $check_email = "SELECT email FROM users WHERE email=:email";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':email', $email,PDO::PARAM_STR);
            $check_email_stmt->execute();

            if($check_email_stmt->rowCount()):
                $returnData = msg(0,422, 'This E-mail already in use!');
            
            else:
                $token = bin2hex(random_bytes(50));
                //$curDate = date("Y-m-d");
                $curDate = date("Y-m-d H:i:s");
                $insert_query = "INSERT INTO users(fname,lname,email,phone,address,country,password,created_at,reg_token,verified,role) VALUES(:fname,:lname,:email,:phone,:address,:country,:password,:curDate,:token, :verified, :role_id)";

                $insert_stmt = $conn->prepare($insert_query);

                // DATA BINDING
                $insert_stmt->bindValue(':fname', htmlspecialchars(strip_tags($fname)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':lname', htmlspecialchars(strip_tags($lname)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':email', $email,PDO::PARAM_STR);
                $insert_stmt->bindValue(':phone', htmlspecialchars(strip_tags($phone)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':address', htmlspecialchars(strip_tags($address)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':password', password_hash($pass, PASSWORD_DEFAULT),PDO::PARAM_STR);
                $insert_stmt->bindValue(':curDate', $curDate);
                $insert_stmt->bindValue(':token', $token);
                $insert_stmt->bindValue(':verified', '1');
                $insert_stmt->bindValue(':role_id', $role);

                if($insert_stmt->execute()):
                    //sendVerificationEmail($token, $fname, $role_name, $email);
                    $last_id = $conn->lastInsertId();
                    try {
                        if($role == '1'): 
                            $user_insert = "INSERT INTO global_admins(name,reg_id) VALUES(:fullName,:id)";
                        elseif($role == '2'): 
                            $user_insert = "INSERT INTO project_managers(name,reg_id) VALUES(:fullName,:id)";
                        elseif($role == '3'): 
                            $user_insert = "INSERT INTO country_managers(name,reg_id) VALUES(:fullName,:id)";
                        elseif($role == '4'): 
                            $user_insert = "INSERT INTO team_members(name,reg_id) VALUES(:fullName,:id)";
                        endif;

                        $user_insert_stmt = $conn->prepare($user_insert);
                        // DATA BINDING
                        $user_insert_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                        $user_insert_stmt->bindValue(':id', htmlspecialchars(strip_tags($last_id)),PDO::PARAM_STR);
                        $user_insert_stmt->execute();
                        $returnData = msg(1,201,'A new User is Successfully Added');
                    }
                    catch(PDOException $e){
                        $returnData = msg(0,500,$e->getMessage());
                    }
                else:
                    $returnData = msg(0,422,'Sorry! There is an issue, Please try again letter');
                endif;

            endif;

        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
    
endif;

echo json_encode($returnData);