<?php
/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__.'/classes/Database.php';

$allHeaders = getallheaders();
$db_connection = new Database();
$conn = $db_connection->dbConnection();

$returnData = [];

$fetch_user_by_email = "SELECT * FROM `test`";
$query_stmt = $conn->prepare($fetch_user_by_email);
$query_stmt->execute();
if($query_stmt->rowCount()) {
    $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
    $returnData = [
        'success' => 1,
        'message' => 'You have successfully logged in.',
        'token' => $row['name']
    ];
}

echo json_encode($returnData);*/

session_start();

if(isset($_SESSION["message"])) {
    echo $_SESSION['message'];
}
else if(isset($_SESSION["error"])) {
    echo $_SESSION['error'];
}

?>