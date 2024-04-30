<?php
// session_start();
// /*$servername = "/cloudsql/tespack-smb-map-services:europe-north1:plan-platform";
// $username = "root";
// $password = "tespack@plan.2021";
// $dbname = "plan_tespack";
// $servername = "localhost:3307";
// $username = "root";
// $password = "";
// $dbname = "plan_tespack";*/
// $servername = "localhost";
// $username = "tespack";
// $password = "password";
// $dbname = "plan_tespack";
// // Create connection
// //$conn = new mysqli(null, $username, $password, $dbname, null, $servername);
// $conn = new mysqli($servername, $username, $password, $dbname);


// if (isset($_GET['token'])) {
//     $token = $_GET['token'];
//     $sql = "SELECT * FROM users WHERE reg_token='$token' LIMIT 1";
//     $result = mysqli_query($conn, $sql);
//     $user = mysqli_fetch_assoc($result);
//     $now = time();
//     $verify_date = strtotime($user['created_at']);
//     //$expired = ceil(abs($now - $verify_date) / 86400);
//     $expired = $now - $verify_date;

//     if (mysqli_num_rows($result) > 0 && $expired<=7200 && $user['verified']=='0') {
//         $curDate = date("Y-m-d H:i:s");
//         $fullName = $user['fname'].' '.$user['lname'];
//         $id = $user['id'];
//         $query = "UPDATE users SET verified=1, verified_at=$curDate WHERE reg_token=$token";

//         if (mysqli_query($conn, $query)) {
//             if($user['role']=='1'):
//                 $insert = "INSERT INTO global_admins(name,reg_id) VALUES('$fullName','$id')";
//             elseif($user['role']=='2'):
//                 $insert = "INSERT INTO project_managers(name,reg_id) VALUES('$fullName','$id')";
//             elseif($user['role']=='3'):
//                 $insert = "INSERT INTO country_managers(name,reg_id) VALUES('$fullName','$id')";
//             elseif($user['role']=='4'):
//                 $insert = "INSERT INTO team_members(name,reg_id) VALUES('$fullName','$id')";
//             endif;
//             if (mysqli_query($conn, $insert)) {

//                 $data_arr =  array(
//                   "user_id" =>  $user['id'],
//                   "section" => "User",
//                   "command" => "Joined",
//                   "description" => $fullName. " joined in the platform"
        
//               );
//               $data = json_encode($data_arr);
//                 //$url = 'http://5.161.107.4/assets/api/activity_log.php';
//                 $url = 'https://tesinsight.com/assets/api/activity_log.php';
//                 $ch = curl_init($url);
//                 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//                 curl_setopt($ch, CURLOPT_POST, 1);
//                 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//                 $res = curl_exec($ch);
//                 curl_close($ch);
//                 $resp = json_decode($res);
//                 $_SESSION['message'] = "Your email address has been verified successfully. You can login now.";
//                 header('location: ../login.php');
//                 exit(0);
//             }
//         }
//     }
//     else if (mysqli_num_rows($result) > 0 && $expired<=7200 && $user['verified']=='1') {

//         $_SESSION['message'] = "Your email is already verified. You can login.";
//         header('location: ../login.php');
//     }
//     else if (mysqli_num_rows($result) > 0 && $expired > 7200) {
//         $query_Overwrite = "DELETE FROM users WHERE token='$token'";
//         if(mysqli_query($conn,$query_Overwrite)) {
//             $_SESSION['error'] = "Your verification link has expired!";
//             header('location: ../login.php');
//         }
//     }

//     else if (mysqli_num_rows($result) == 0){
//         $_SESSION['error'] = "No token provided! Please Register again.";
//         header('location: ../login.php');
//     }
// } 
// else {
//     $_SESSION['error'] = "No token provided!";
//     header('location: ../login.php');
// }




///////update code  



session_start();
require __DIR__.'/../assets/api/classes/database.php';
try {

    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $sql = "SELECT * FROM users WHERE reg_token=:token LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $now = time();
        $verify_date = strtotime($user['created_at']);
        $expired = $now - $verify_date;

        if ($stmt->rowCount() > 0 && $expired <= 7200 && $user['verified'] == '0') {
            $curDate = date("Y-m-d H:i:s");
            $fullName = $user['fname'] . ' ' . $user['lname'];
            $id = $user['id'];
            $query = "UPDATE users SET verified=1, verified_at=:curDate WHERE reg_token=:token";
            $updateStmt = $conn->prepare($query);
            $updateStmt->bindParam(':curDate', $curDate);
            $updateStmt->bindParam(':token', $token);
            $updateStmt->execute();

            if ($user['role'] == '1') {
                $insert = "INSERT INTO global_admins(name,reg_id) VALUES(:fullName, :id)";
            } elseif ($user['role'] == '2') {
                $insert = "INSERT INTO project_managers(name,reg_id) VALUES(:fullName, :id)";
            } elseif ($user['role'] == '3') {
                $insert = "INSERT INTO country_managers(name,reg_id) VALUES(:fullName, :id)";
            } elseif ($user['role'] == '4') {
                $insert = "INSERT INTO team_members(name,reg_id) VALUES(:fullName, :id)";
            }
            $insertStmt = $conn->prepare($insert);
            $insertStmt->bindParam(':fullName', $fullName);
            $insertStmt->bindParam(':id', $id);
            $insertStmt->execute();

            $data_arr = array(
                "user_id" => $user['id'],
                "section" => "User",
                "command" => "Joined",
                "description" => $fullName . " joined in the platform"
            );
            $data = json_encode($data_arr);
            $url = 'https://tesinsight.com/assets/api/activity_log.php';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $res = curl_exec($ch);
            curl_close($ch);
            $resp = json_decode($res);

            $_SESSION['message'] = "Your email address has been verified successfully. You can login now.";
            header('location: ../login.php');
            exit(0);
        } else if ($stmt->rowCount() > 0 && $expired <= 7200 && $user['verified'] == '1') {
            $_SESSION['message'] = "Your email is already verified. You can login.";
            header('location: ../login.php');
        } else if ($stmt->rowCount() > 0 && $expired > 7200) {
            $query_Overwrite = "DELETE FROM users WHERE token=:token";
            $deleteStmt = $conn->prepare($query_Overwrite);
            $deleteStmt->bindParam(':token', $token);
            if ($deleteStmt->execute()) {
                $_SESSION['error'] = "Your verification link has expired!";
                header('location: ../login.php');
            }
        } else if ($stmt->rowCount() == 0) {
            $_SESSION['error'] = "No token provided! Please Register again.";
            header('location: ../login.php');
        }
    } else {
        $_SESSION['error'] = "No token provided!";
        header('location: ../login.php');
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>