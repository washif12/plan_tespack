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

require __DIR__.'/classes/database.php';
require __DIR__.'/classes/JwtHandler.php';

$db_connection = new Database();
$conn = $db_connection->dbConnection();

$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT EQUAL TO POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');
// CHECKING EMPTY FIELDS
elseif(!isset($data->id)
    || empty(trim($data->id))
    ):
    $returnData = msg(0,422,'Please Fill in all Required Fields!');
// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $id = trim($data->id);
    $query = "UPDATE users SET token=:token WHERE id=:id";
    $stmt = $conn->prepare($query);
    // DATA BINDING
    $stmt->bindValue(':token', NULL);
    $stmt->bindValue(':id', $id,PDO::PARAM_STR);
    $stmt->execute();
    $returnData = msg(1,200,'Thank You!');

endif;

echo json_encode($returnData);