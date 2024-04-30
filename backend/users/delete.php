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
if(isset($_POST['id'])):
    $id = $_POST['id'];
    try{
        $check = "DELETE FROM users WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        if($check_stmt->execute()):
            $select = "SELECT * FROM users where id=:id";
            $select_stmt = $conn->prepare($select);
            $select_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
            $select_stmt->execute();
            if($select_stmt->rowCount()):
                $data = $select_stmt->fetch(PDO::FETCH_ASSOC);
                $role = $data['role'];
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
            $returnData = msg(0,422,'Sorry! There is an issue deleting, Please try again letter');
        endif;
        
    }
    catch(PDOException $e){
        //echo "There is a problem in server, please try again a few moments later.";
        //echo $e->getMessage();
        $returnData = msg(0,500,$e->getMessage());
    }
endif;
?>