<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

require __DIR__ . '/classes/database.php';
require __DIR__ . '/classes/JwtHandler.php';

$db_connection = new Database();
$conn = $db_connection->dbConnection();

$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT EQUAL TO POST
if ($_SERVER["REQUEST_METHOD"] != "POST") :
    $returnData = msg(0, 404, 'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif (
    !isset($data->email)
    || !isset($data->password)
    || empty(trim($data->email))
    || empty(trim($data->password))
) :
    $returnData = msg(0, 422, 'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else :
    $email = trim($data->email);
    $password = trim($data->password);

    // CHECKING THE EMAIL FORMAT (IF INVALID FORMAT)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        $returnData = msg(0, 422, 'Invalid Email Address!');

    // IF PASSWORD IS LESS THAN 8 THE SHOW THE ERROR
    elseif (strlen($password) < 6) :
        $returnData = msg(0, 422, 'Your password must be at least 6 characters long!');

    // THE USER IS ABLE TO PERFORM THE LOGIN ACTION
    else :
        try {

            $fetch_user_by_email = "SELECT * FROM users WHERE email=:email";
            $query_stmt = $conn->prepare($fetch_user_by_email);
            $query_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $query_stmt->execute();

            // IF THE USER IS FOUNDED BY EMAIL
            if ($query_stmt->rowCount()) :
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                $check_password = password_verify($password, $row['password']);
                $stored_token = $row['token'];
                //Check if email is verified
                if ($row['verified'] == 1) :
                    // VERIFYING THE PASSWORD (IS CORRECT OR NOT?)
                    // IF PASSWORD IS CORRECT THEN SEND THE LOGIN TOKEN
                    if ($check_password) :
                        /*$returnData = [
                            'success' => 1,
                            'message' => 'You have successfully logged in.',
                            'id' => $row['id']
                        ];*/
                        if (is_null($stored_token)||empty($stored_token)) :
                            $jwt = new JwtHandler();
                            $token = $jwt->jwtEncodeData(
                                'https://tespack-smb-map-services.appspot.com/',
                                array("user_id" => $row['id'], "role" => $row['role'], "name" => $row['fname'])
                            );
                            $insert_query = "UPDATE users SET token=:token WHERE email=:email";
                            $insert_stmt = $conn->prepare($insert_query);
                            // DATA BINDING
                            $insert_stmt->bindValue(':token', $token);
                            $insert_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                            $insert_stmt->execute();

                            $returnData = [
                                'success' => 1,
                                'message' => 'You have successfully logged in.',
                                'token' => $token
                            ];
                        //$_SESSION['login'] = $row['role'];
                        elseif (!is_null($stored_token)) :
                            $jwt = new JwtHandler();
                            $token = $jwt->jwtDecodeData($stored_token);
                            //date_default_timezone_set('Europe/Helsinki');
                            //$current_time = time();
                            //$token_expires = $token->exp-$current_time;
                            //$token_expires = $token['auth'];
                            /*$returnData = [
                                'success' => 1,
                                'message' => 'You have  logged in.',
                                'token' => $token
                            ];*/
                            if ($token == 'Expired token') {
                                $jwt = new JwtHandler();
                                $token = $jwt->jwtEncodeData(
                                    'https://tespack-smb-map-services.appspot.com/',
                                    array("user_id" => $row['id'], "role" => $row['role'], "name" => $row['fname'])
                                );
                                $query = "UPDATE users SET token=:token WHERE email=:email";
                                $stmt = $conn->prepare($query);
                                // DATA BINDING
                                $stmt->bindValue(':token', $token);
                                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                                $stmt->execute();
                                //$returnData = msg(0,404,'Login session expired. Please log in again.');
                                //$token_test = $jwt->jwtDecodeData($token);
                                $returnData = [
                                    'success' => 1,
                                    'message' => 'You have successfully logged in.',
                                    'token' => $token
                                ];
                                //$_SESSION['login'] = $row['role'];
                            } else {
                                //$returnData = msg(0,404,'You are already logged in.');
                                $returnData = [
                                    'success' => 1,
                                    'message' => 'You are already logged in.',
                                    'token' => $stored_token
                                ];
                            }

                        endif;
                    // IF INVALID PASSWORD
                    else :
                        $returnData = msg(0, 422, 'Invalid Password!');
                    endif;
                else :
                    $returnData = msg(0, 422, 'Please Verify your Email.');
                endif;

            // IF THE USER IS NOT FOUNDED BY EMAIL THEN SHOW THE FOLLOWING ERROR
            else :
                $returnData = msg(0, 422, 'Invalid Email Address!');
            endif;
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }

    endif;

endif;

echo json_encode($returnData);
