<?php
require __DIR__.'/../../assets/api/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
if(isset($_POST['id'])):
    $id = $_POST['id'];
    try{
        $check = "DELETE FROM projects WHERE id=:id";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':id', htmlspecialchars(strip_tags($id)),PDO::PARAM_STR);
        $check_stmt->execute();
        
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
endif;
?>