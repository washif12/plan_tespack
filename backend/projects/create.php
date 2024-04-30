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
elseif(!isset($_POST['project']) 
    || !isset($_POST['country'])
    || !isset($_POST['region'])
    || !isset($_POST['desc'])
    || !isset($_POST['team'])
    || empty($_POST['project'])
    || empty($_POST['country'])
    || empty($_POST['region'])
    || empty($_POST['desc'])
    || empty($_POST['team'])
    ):

    //$fields = ['fields' => ['manager','member','smb_info','team','contact']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $project = $_POST['project'];
    $country = $_POST['country'];
    $region = $_POST['region'];
    $desc = $_POST['desc'];
    $team = $_POST['team'];
    try{
        $check = "SELECT * FROM projects WHERE name=:project";
        $check_stmt = $conn->prepare($check);
        $check_stmt->bindValue(':project', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
        $check_stmt->execute();
        if($check_stmt->rowCount()):
            $returnData = msg(0,422, 'This Project Name already exists!');
        else:
            try {
                $insert_query = "INSERT INTO projects(name,country,region,description,team_id, created_at) VALUES(:project,:country,:region,:descrip,:team, now())";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bindValue(':team', htmlspecialchars(strip_tags($team)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':descrip', htmlspecialchars(strip_tags($desc)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':project', htmlspecialchars(strip_tags($project)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':region', htmlspecialchars(strip_tags($region)),PDO::PARAM_STR);
                $insert_stmt->execute();
                $returnData = msg(1,201,'You have successfully created a new Project!');
            }
            catch(PDOException $m){
                $returnData = msg(0,500,$m->getMessage());
            }

        endif;
        
    }
    catch(PDOException $e){
        $returnData = msg(0,500,$e->getMessage());
    }

endif;

echo json_encode($returnData);
?>