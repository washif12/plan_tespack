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
if(isset($_POST['id']) && isset($_POST['type'])):
    $id = $_POST['id'];
    $type = $_POST['type'];
    $curDate = date("Y-m-d H:i:s");
    if($type==0):
        try{
            $check = "UPDATE users SET verified=0, updated_at=:curDate WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $check_stmt->bindValue(':curDate', htmlspecialchars(strip_tags($curDate)),PDO::PARAM_STR);
            //$check_stmt->execute();
            if($check_stmt->execute()):
                $select = "SELECT * FROM users where id=:id";
                $select_stmt = $conn->prepare($select);
                $select_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $select_stmt->execute();
                if($select_stmt->rowCount()):
                    $data = $select_stmt->fetch(PDO::FETCH_ASSOC);
                    $role = $data['role'];
                    $fullName = $data['fname'].' '.$data['lname'];
                    try {
                        if($role == '1'): 
                            $user_insert = "DELETE FROM global_admins WHERE reg_id=:id";
                        elseif($role == '2'): 
                            $user_insert = "DELETE FROM project_managers WHERE reg_id=:id";
                        elseif($role == '3'): 
                            $user_insert = "DELETE FROM country_managers WHERE reg_id=:id";
                        elseif($role == '4'): 
                            $user_insert = "DELETE FROM team_members WHERE reg_id=:id";
                        endif;

                        $user_insert_stmt = $conn->prepare($user_insert);
                        $user_insert_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                        $user_insert_stmt->execute();
                        $returnData = msg(1,201,'You have successfully deactivated this user!');
                    }
                    catch(PDOException $e){
                        $returnData = msg(0,500,$e->getMessage());
                    }
                else:
                    $returnData = msg(0,422,'Sorry! There is an issue removing, Please try again letter');
                endif;
            else:
                $returnData = msg(0,422,'Sorry! There is an issue deactivating, Please try again letter');
            endif;
            
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    elseif($type==1):
        try{
            $check = "UPDATE users SET verified=1, updated_at=:curDate WHERE id=:id";
            $check_stmt = $conn->prepare($check);
            $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $check_stmt->bindValue(':curDate', htmlspecialchars(strip_tags($curDate)),PDO::PARAM_STR);
            //$check_stmt->execute();
            if($check_stmt->execute()):
                $select = "SELECT * FROM users where id=:id";
                $select_stmt = $conn->prepare($select);
                $select_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                $select_stmt->execute();
                if($select_stmt->rowCount()):
                    $data = $select_stmt->fetch(PDO::FETCH_ASSOC);
                    $role = $data['role'];
                    $fullName = $data['fname'].' '.$data['lname'];
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
                        $user_insert_stmt->bindValue(':fullName', htmlspecialchars(strip_tags($fullName)),PDO::PARAM_STR);
                        $user_insert_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
                        $user_insert_stmt->execute();
                        $returnData = msg(1,201,'You have successfully activated this user!');
                    }
                    catch(PDOException $e){
                        $returnData = msg(0,500,$e->getMessage());
                    }
                else:
                    $returnData = msg(0,422,'Sorry! There is an issue reinserting, Please try again letter');
                endif;
            else:
                $returnData = msg(0,422,'Sorry! There is an issue, Please try again letter');
            endif;
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
        
    endif;
else:
    $returnData = msg(0,422,'Sorry! There was an error');
endif;
echo json_encode($returnData);
?>