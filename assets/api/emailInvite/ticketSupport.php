<?php
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

function sendSupportRequest($subject, $html, $cc, $bcc, $target_file)
{
    require_once './../../../vendor/autoload.php';
    //$transport = Transport::fromDsn('gmail+smtp://'.urlencode('washif.hossain@tespack.com').':'.urlencode($arr_token['access_token']).'@default');
    $transport = Transport::fromDsn('smtp://platform@tespack.com:yimzqmgjihabhxqx@smtp.gmail.com:587');
    $mailer = new Mailer($transport);

    if (!empty($target_file)) :
        $message = (new Email())
            ->from('platform@tespack.com')
            ->to('platform@tespack.com')
            ->subject($subject)
            ->cc($cc)
            ->bcc($bcc)
            //->attachFromPath($target_file)
            ->attach(fopen($target_file, 'r'), basename($target_file))
            ->html($html);
    else:
        $message = (new Email())
            ->from('platform@tespack.com')
            ->to('platform@tespack.com')
            ->subject($subject)
            ->cc($cc)
            ->bcc($bcc)
            ->html($html);
    endif;
    try {
        // Send the message
        $mailer->send($message);
        return true;
        // if ($result > 0) {
        //     return true;
        // } else {
        //     return false;
        // }

        //echo 'Email sent successfully.';
    } catch (TransportExceptionInterface $e) {
        echo $e->getMessage();
        return false;
    }
}

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}
function fileUpload($uploaded, $id) {
    $user_id= $id;
    if(!empty($uploaded)):
        $target_dir = "../../uploads/ticket_support/".$user_id."/" ;
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755);
        }
        $file = $uploaded['file']['name'];
        $time = rand();
        $target_file = $target_dir .basename($uploaded["file"]["name"]);
        // Select file type
        $image_path = "/assets/uploads/ticket_support/".$user_id."/".basename($uploaded['file']['name']);
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Valid file extensions
        $extensions_arr = array("jpg", "jpeg", "png", "pdf", "docx");
        if (in_array($imageFileType, $extensions_arr)) :
            try {
                move_uploaded_file($uploaded['file']['tmp_name'], $target_dir . $file);
                $result = '1';
                return array($result, $image_path, $target_file);
            } catch (Exception $e) {
                $result = '0';
                $image_path = '';
                $target_file = '';
                //return $e->getMessage();
                return array($result, $image_path, $target_file);
            }
        endif;
    else:
        $result = '2';
        $image_path = '';
        $target_file = '';
        return array($result, $image_path, $target_file);
    endif;
}

// INCLUDING DATABASE AND MAKING OBJECT
require __DIR__ . '/../classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
//$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT POST
if ($_SERVER["REQUEST_METHOD"] != "POST") :
    $returnData = msg(0, 404, 'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif (!isset($_POST['sub'])|| empty(trim($_POST['sub']))):
    $returnData = msg(0, 422, 'Please Fill in Subject Field!');
elseif (!isset($_POST['msg'])|| empty(trim($_POST['msg']))):
    $returnData = msg(0, 422, 'Please Fill in Message Field!');
elseif (!isset($_POST['project'])|| empty(trim($_POST['project']))):
    $returnData = msg(0, 422, 'Please Select a Project!');
elseif (!isset($_POST['country'])|| empty(trim($_POST['country']))):
    $returnData = msg(0, 422, 'Please Select a Country!');
elseif (!isset($_POST['ref'])|| empty(trim($_POST['ref']))):
    $returnData = msg(0, 422, 'Please Select a SSM!');
elseif (!isset($_POST['cc'])|| empty(trim($_POST['cc']))):
    $returnData = msg(0, 422, 'Please Fill in CC Field!');
elseif (!isset($_POST['bcc']) || empty(trim($_POST['bcc']))):
    $returnData = msg(0, 422, 'Please Fill in BCC Field!');
elseif (!isset($_POST['replace'])|| empty(trim($_POST['replace']))):
    $returnData = msg(0, 422, 'Please Fill in Replace Field!');
    //$file = [$_POST['sub'],$_POST['replace'],$_POST['msg'],$_POST['project'],$_POST['country'],$_POST['ref']];
    //$fields = ['fields' => ['name','email','password']];
    //$returnData = msg(0, 422, 'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else :
    //$returnData = msg(1,201,'Thank you! We have received you support request. We will get back to you soon.');
    $subject = trim($_POST['sub']);
    $cc = trim($_POST['cc']);
    $bcc = trim($_POST['bcc']);
    $replace = trim($_POST['replace']);
    $message = trim($_POST['msg']);
    $country = trim($_POST['country']);
    $ref = trim($_POST['ref']);
    $user_id = trim($_POST['user_id']);
    $target_file = '';
    $image_path = '';

    if(!filter_var($cc, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Invalid Email Address in CC');
    elseif(!filter_var($bcc, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Invalid Email Address in BCC');
    else:
        $project_id = trim($_POST['project']);
        $select = "SELECT * FROM projects where id=:id";
        $select_stmt = $conn->prepare($select);
        $select_stmt->bindValue(':id', htmlspecialchars(strip_tags($project_id)), PDO::PARAM_STR);
        $select_stmt->execute();
        $project_data = $select_stmt->fetch(PDO::FETCH_ASSOC);
        $project = $project_data["name"];

        if ($replace == '2') : // No Replacement asked
            $product = '';
            $quantity = '';
            $html = '<!DOCTYPE html>
                <html>
                <head>
                <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
                <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,700,700i" rel="stylesheet" />
                <title>Email Template</title>
                    <style>
                        table {
                        font-family: arial, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                        }

                        td, th {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                        }

                        tr:nth-child(even) {
                        background-color: #dddddd;
                        }
                    </style>
                </head>
                <body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; -webkit-text-size-adjust:none;">
                    <h4>' . $message . '</h4>
                    <h3 style="text-align:center;">Support Requested SSM Information</h3>
                    <table style="text-align:center;">
                        <thead>
                        <tr>
                            <th>SSM Reference Number</th>
                            <th>Country</th>
                            <th>Project</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>' . $ref . '</td>
                            <td>' . $country . '</td>
                            <td>' . $project . '</td>
                        </tr>
                        </tbody>
                    </table>
                </body>
                </html>';
            $pm = "SELECT a.fname,a.lname,a.email,a.phone FROM users as a left join project_managers as b on b.reg_id=a.id left join smb_resp as c on c.pm_id=b.id left join devices as d on c.smb_id=d.id where d.ref=:ref";
            $pm_stmt = $conn->prepare($pm);
            $pm_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)), PDO::PARAM_STR);
            $pm_stmt->execute();
            $values = [];
            // $image_path = "";
            // if (!empty($_FILES)) :
            //     //$target_dir = "../../uploads/ticket_support/".$user_id."/" ;
            //     $target_dir = "https://tesinsight.com/assets/uploads/ticket_support/".$user_id."/" ;
            //     if (!is_dir($target_dir)) {
            //         mkdir($target_dir, 0755);
            //     }
            //     $file = $_FILES['file']['name'];
            //     $time = rand();
            //     $target_file = $target_dir .basename($_FILES["file"]["name"]);
            //     // Select file type
            //     $image_path = "/assets/uploads/ticket_support/".$user_id."/".basename($_FILES['file']['name']);
                
            //     $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            //     // Valid file extensions
            //     $extensions_arr = array("jpg", "jpeg", "png", "pdf", "docx");
            //     if (in_array($imageFileType, $extensions_arr)) :
            //         try {
            //             move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $file);
            //             // echo $image_path;
            //         } catch (Exception $e) {
            //             //echo $e->getMessage();
            //             $returnData = msg(0, 500, $e->getMessage());
            //         }
            //     endif;
            // else :
            //     $target_file = '';
            // endif;
            if ($pm_stmt->rowCount()) :
                $row = $pm_stmt->fetch(PDO::FETCH_ASSOC);
                list($result, $image_path, $target_file)=fileUpload($_FILES, $user_id);
                if ($result=='2'||$result=='1') :
                    $resp = $row['fname'] . ' ' . $row['lname'];
                    $phone = $row['phone'];
                    $email = $row['email'];
                    try {
                        $insert_query = "INSERT INTO ticket_support(replacement,quantity,ref,country,project,responsible,email,phone,message,image_path, created_at,subject,resolved) VALUES(:replacement,:quantity,:ref,:country,:project,:resp,:email,:phone,:msg, :image_path, now(), :sub, '0')";
                        $insert_stmt = $conn->prepare($insert_query);

                        // DATA BINDING
                        $insert_stmt->bindValue(':replacement', htmlspecialchars(strip_tags($product)), PDO::PARAM_STR);
                        $insert_stmt->bindValue(':quantity', htmlspecialchars(strip_tags($quantity)), PDO::PARAM_STR);
                        $insert_stmt->bindValue(':msg', htmlspecialchars(strip_tags($message)), PDO::PARAM_STR);
                        $insert_stmt->bindValue(':project', htmlspecialchars(strip_tags($project)), PDO::PARAM_STR);
                        $insert_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)), PDO::PARAM_STR);
                        $insert_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)), PDO::PARAM_STR);
                        $insert_stmt->bindValue(':phone', $phone);
                        $insert_stmt->bindValue(':email', $email);
                        $insert_stmt->bindValue(':resp', $resp);
                        $insert_stmt->bindValue(':image_path', $image_path);
                        $insert_stmt->bindValue(':sub', htmlspecialchars(strip_tags($subject)), PDO::PARAM_STR);

                        if($insert_stmt->execute()):
                            sendSupportRequest($subject, $html, $cc, $bcc, $target_file);
                            $returnData = msg(1, 201, 'Thank you! We have received you support request. We will get back to you soon.');
                        else:
                            $returnData = msg(0, 422, 'Sorry there is an issue, please try again later.');
                        endif;
                    } catch (PDOException $e) {
                        $returnData = msg(0, 500, $e->getMessage());
                    }
                    
                else:
                    $returnData = msg(0, 422, 'Sorry the file couldnt be uploaded, please try again later.');
                endif;
                
            else :
                $returnData = msg(0, 422, 'Invalid SSM Reference Number');
            endif;
        elseif ($replace == '1') :
            if (
                !isset($_POST['product'])
                || !isset($_POST['quantity'])
                || empty(trim($_POST['product']))
                || empty(trim($_POST['quantity']))
            ) :
                $returnData = msg(0, 422, 'Please Fill in all Required Fields!');
            else :
                $product = trim($_POST['product']);
                $quantity = trim($_POST['quantity']);
                $html = '<!DOCTYPE html>
                <html>
                <head>
                <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
                <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,700,700i" rel="stylesheet" />
                <title>Email Template</title>
                    <style>
                        table {
                        font-family: arial, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                        }

                        td, th {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                        }

                        tr:nth-child(even) {
                        background-color: #dddddd;
                        }
                    </style>
                </head>
                <body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; -webkit-text-size-adjust:none;">
                    <h4>' . $message . '</h4>
                    <h3 style="text-align:center;">SSM Item Replacment Details</h3>
                    <table style="text-align:center;">
                        <thead>
                        <tr>
                            <th>SSM Reference Number</th>
                            <th>Country</th>
                            <th>Project</th>
                            <th>Replacement Item</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>' . $ref . '</td>
                            <td>' . $country . '</td>
                            <td>' . $project . '</td>
                            <td>' . $product . '</td>
                            <td>' . $quantity . '</td>
                        </tr>
                        </tbody>
                    </table>
                </body>
                </html>';
                try {
                    $pm = "SELECT a.fname,a.lname,a.email,a.phone FROM users as a left join project_managers as b on b.reg_id=a.id left join smb_resp as c on c.pm_id=b.id left join devices as d on c.smb_id=d.id where d.ref=:ref";
                    $pm_stmt = $conn->prepare($pm);
                    $pm_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)), PDO::PARAM_STR);
                    $pm_stmt->execute();
                } catch (PDOException $e) {
                    $returnData = msg(0, 500, $e->getMessage());
                }
                
                // if (!empty($_FILES)) :
                //     $target_dir = "../../uploads/ticket_support/".$user_id."/" ;
                //     //$target_dir = "https://tesinsight.com/assets/uploads/ticket_support/".$user_id."/" ;
                //     if (!is_dir($target_dir)) {
                //         mkdir($target_dir, 0755);
                //     }
                //     $file = $_FILES['file']['name'];
                //     $time = rand();
                //     $target_file = $target_dir .basename($_FILES["file"]["name"]);
                //     // Select file type
                //     $image_path = "/assets/uploads/ticket_support/".$user_id."/".basename($_FILES['file']['name']);
                    
                //     $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                //     // Valid file extensions
                //     $extensions_arr = array("jpg", "jpeg", "png", "pdf", "docx");
                //     if (in_array($imageFileType, $extensions_arr)) :
                //         try {
                //             move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $file);
                //             // echo $image_path;
                //         } catch (Exception $e) {
                //             echo $e->getMessage();
                //         }
                //     endif;
                // else :
                //     $target_file = '';
                // endif;
                if ($pm_stmt->rowCount()) :
                    $row = $pm_stmt->fetch(PDO::FETCH_ASSOC);
                    list($result, $image_path, $target_file)=fileUpload($_FILES, $user_id);
                    if ($result=='2'||$result=='1') :
                        $resp = $row['fname'] . ' ' . $row['lname'];
                        $phone = $row['phone'];
                        $email = $row['email'];
                        try {
                            $insert_query = "INSERT INTO ticket_support(replacement,quantity,ref,country,project,responsible,email,phone,message,image_path, created_at,subject,resolved) VALUES(:replacement,:quantity,:ref,:country,:project,:resp,:email,:phone,:msg, :image_path, now(), :sub, '0')";
                            $insert_stmt = $conn->prepare($insert_query);
        
                            // DATA BINDING
                            $insert_stmt->bindValue(':replacement', htmlspecialchars(strip_tags($product)), PDO::PARAM_STR);
                            $insert_stmt->bindValue(':quantity', htmlspecialchars(strip_tags($quantity)), PDO::PARAM_STR);
                            $insert_stmt->bindValue(':msg', htmlspecialchars(strip_tags($message)), PDO::PARAM_STR);
                            $insert_stmt->bindValue(':project', htmlspecialchars(strip_tags($project)), PDO::PARAM_STR);
                            $insert_stmt->bindValue(':ref', htmlspecialchars(strip_tags($ref)), PDO::PARAM_STR);
                            $insert_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)), PDO::PARAM_STR);
                            $insert_stmt->bindValue(':phone', $phone);
                            $insert_stmt->bindValue(':email', $email);
                            $insert_stmt->bindValue(':resp', $resp);
                            $insert_stmt->bindValue(':image_path', $image_path);
                            $insert_stmt->bindValue(':sub', htmlspecialchars(strip_tags($subject)), PDO::PARAM_STR);
        
                            if($insert_stmt->execute()):
                                sendSupportRequest($subject, $html, $cc, $bcc, $target_file);
                                $returnData = msg(1, 201, 'Thank you! We have received you support request. We will get back to you soon.');
                            else:
                                $returnData = msg(0, 422, 'Sorry there is an issue, please try again later.');
                            endif;
                        } catch (PDOException $e) {
                            $returnData = msg(0, 500, $e->getMessage());
                        }
                        
                    else:
                        $returnData = msg(0, 422, 'Sorry the file couldnt be uploaded, please try again later.');
                    endif;
                    
                else :
                    $returnData = msg(0, 422, 'Invalid SSM Reference Number');
                endif;
            endif;
        endif;
    endif;
endif;

echo json_encode($returnData);
