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
elseif(!isset($_POST['fname']) 
    || !isset($_POST['lname'])
    || !isset($_POST['email'])
    || !isset($_POST['phone'])
    || !isset($_POST['country'])
    || !isset($_POST['address'])
    || !isset($_POST['id'])
    || !isset($_POST['role'])
    || empty(trim($_POST['fname']))
    || empty(trim($_POST['lname']))
    || empty(trim($_POST['email']))
    || empty(trim($_POST['id']))
    || empty(trim($_POST['phone']))
    || empty(trim($_POST['country']))
    || empty(trim($_POST['address']))
    || empty(trim($_POST['role']))
    ):

    $fields = ['fields' => ['email','name','role']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!',$fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $fullName = $fname.' '.$lname;
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $country = trim($_POST['country']);
    $address = trim($_POST['address']);
    $id = trim($_POST['id']);
    $role = trim($_POST['role']);
    $newRole = trim($_POST['newRole']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Invalid Email Address');
    else:
        try{
            $check = "UPDATE users SET fname=:fname,lname=:lname,email=:email, phone=:phone,country=:country,address=:userAddress,role=:newRole, updated_at=now() WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':fname', htmlspecialchars(strip_tags($fname)),PDO::PARAM_STR);
            $check_stmt->bindValue(':lname', htmlspecialchars(strip_tags($lname)),PDO::PARAM_STR);
            $check_stmt->bindValue(':email', htmlspecialchars(strip_tags($email)),PDO::PARAM_STR);
            $check_stmt->bindValue(':phone', htmlspecialchars(strip_tags($phone)),PDO::PARAM_STR);
            $check_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
            $check_stmt->bindValue(':userAddress', htmlspecialchars(strip_tags($address)),PDO::PARAM_STR);
            $check_stmt->bindValue(':newRole', htmlspecialchars(strip_tags($newRole)),PDO::PARAM_STR);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $check_stmt->execute();
            if($role==$newRole):
                if($role=='1'):
                    $user = "UPDATE global_admins SET name=:fullName WHERE reg_id=:id";
                    $user_stmt = $conn->prepare($user);
                    $user_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                    $user_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $user_stmt->execute();
                elseif($role=='2'):
                    $user = "UPDATE project_managers SET name=:fullName WHERE reg_id=:id";
                    $user_stmt = $conn->prepare($user);
                    $user_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                    $user_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $user_stmt->execute();
                elseif($role=='3'):
                    $user = "UPDATE country_managers SET name=:fullName WHERE reg_id=:id";
                    $user_stmt = $conn->prepare($user);
                    $user_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                    $user_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $user_stmt->execute();
                elseif($role=='4'):
                    $user = "UPDATE team_members SET name=:fullName WHERE reg_id=:id";
                    $user_stmt = $conn->prepare($user);
                    $user_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                    $user_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $user_stmt->execute();
                endif;
            elseif($role!=$newRole):
                if($role=='1'):
                    $delete = "DELETE FROM global_admins WHERE reg_id=:id";
                    $delete_stmt = $conn->prepare($delete);
                    $delete_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $delete_stmt->execute();
                elseif($role=='2'):
                    $delete = "DELETE FROM project_managers WHERE reg_id=:id";
                    $delete_stmt = $conn->prepare($delete);
                    $delete_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $delete_stmt->execute();
                elseif($role=='3'):
                    $delete = "DELETE FROM country_managers WHERE reg_id=:id";
                    $delete_stmt = $conn->prepare($delete);
                    $delete_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $delete_stmt->execute();
                elseif($role=='4'):
                    $delete = "DELETE FROM team_members WHERE reg_id=:id";
                    $delete_stmt = $conn->prepare($delete);
                    $delete_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $delete_stmt->execute();
                endif;
                if($newRole=='1'):
                    $user = "INSERT INTO global_admins(name,reg_id) VALUES(:fullName,:id)";
                    $user_stmt = $conn->prepare($user);
                    $user_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                    $user_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $user_stmt->execute();
                elseif($newRole=='2'):
                    $user = "INSERT INTO project_managers(name,reg_id) VALUES(:fullName,:id)";
                    $user_stmt = $conn->prepare($user);
                    $user_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                    $user_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $user_stmt->execute();
                elseif($newRole=='3'):
                    $user = "INSERT INTO country_managers(name,reg_id) VALUES(:fullName,:id)";
                    $user_stmt = $conn->prepare($user);
                    $user_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                    $user_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $user_stmt->execute();
                elseif($newRole=='4'):
                    $user = "INSERT INTO team_members(name,reg_id) VALUES(:fullName,:id)";
                    $user_stmt = $conn->prepare($user);
                    $user_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                    $user_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                    $user_stmt->execute();
                endif;
            endif;
            $returnData = msg(1,201,'You have successfully updated this record!');
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;

endif;

echo json_encode($returnData);
?>