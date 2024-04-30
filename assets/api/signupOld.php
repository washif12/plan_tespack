<?php
//include('sendVerifyEmail.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

function sendVerificationEmail($verifyToken, $userName, $userRole, $userEmail) 
{
  require_once './emailInvite/config.php';
  //require __DIR__.'/emailInvite/config.php';
 
  $db = new DB();
  $arr_token = (array) $db->get_access_token();

  try {
    $transport = Transport::fromDsn('gmail+smtp://'.urlencode('washif.hossain@tespack.com').':'.urlencode($arr_token['access_token']).'@default');

    $mailer = new Mailer($transport);

    $message = (new Email())
        ->from('washif.hossain@tespack.com')
        ->to($userEmail)
        ->subject('Verify Your Email')
        ->html('<!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
          <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,700,700i" rel="stylesheet" />
          <title>Email Template</title>
          
        
          <style type="text/css" media="screen">
            /* Linked Styles */
            body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; -webkit-text-size-adjust:none }
            a { color:#66c7ff; text-decoration:none }
            p { padding:0 !important; margin:0 !important } 
            img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */ }
            .mcnPreviewText { display: none !important; }
        
                
            /* Mobile styles */
            @media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
              .mobile-shell { width: 100% !important; min-width: 100% !important; }
              .bg { background-size: 100% auto !important; -webkit-background-size: 100% auto !important; }
              
              .text-header,
              .m-center { text-align: center !important; }
              
              .center { margin: 0 auto !important; }
              .container { padding: 20px 10px !important }
              
              .td { width: 100% !important; min-width: 100% !important; }
        
              .m-br-15 { height: 15px !important; }
              .p30-15 { padding: 30px 15px !important; }
        
              .m-td,
              .m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }
        
              .m-block { display: block !important; }
        
              .fluid-img img { width: 100% !important; max-width: 100% !important; height: auto !important; }
        
              .column,
              .column-top,
              .column-empty,
              .column-empty2,
              .column-dir-top { float: left !important; width: 100% !important; display: block !important; }
        
              .column-empty { padding-bottom: 10px !important; }
              .column-empty2 { padding-bottom: 30px !important; }
        
              .content-spacing { width: 15px !important; }
            }
          </style>
        </head>
        <body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; -webkit-text-size-adjust:none;">
          <table width="90%" border="0" cellspacing="0" cellpadding="0" style="background-image: url(http://localhost/Plan_Int_New/assets/images/emails/verify_bg.png);background-size: cover;background-repeat: no-repeat;margin: auto;">
            <tr>
              <td align="center" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                  <tr>
                    <td class="td container" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; margin:0; font-weight:normal; padding:25px 0px;">
                      <!-- Header -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="p30-15" style="padding: 0px 10px 10px 10px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td class="img m-center" style="font-size:0pt; line-height:0pt; text-align:left;"><img src="http://localhost/Plan_Int_New/assets/images/emails/smb_tick.png" width="200"/></td>
                                    </tr>
                                  </table>
                                </th>
                                <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:middle;">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td class="h3 pb20" style="color:#ffffff; font-family:Arial,sans-serif; font-size:25px; line-height:32px; text-align:center; padding-bottom:20px;">WELCOME TO THE SSM SYSTEM PLATFORM!</td>
                                    </tr>
                                  </table>
                                </th>
                                <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td class="text-header" style="color:#475c77; font-family:"Muli", Arial,sans-serif; font-size:12px; line-height:16px; text-align:right;"><img src="http://localhost/Plan_Int_New/assets/images/emails/plan-logo.png" width="150"/></td>
                                    </tr>
                                  </table>
                                </th>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <!-- END Header -->
        
                      <!-- Article / Full Width Image + Title + Copy + Button -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding-bottom: 10px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                              <tr>
                                <td class="p30-15" style="padding: 30px 30px;">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:20px; line-height:32px; text-align:left; padding-bottom:20px;">Hello '.$userName.',</td>
                                    </tr>
                                    <tr>
                                      <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:26px; text-align:left; padding-bottom:10px;">You have successfully registered to the SSM system platform as <b>'.$userRole.'</b>.</td>
                                      
                                    </tr>
                                    <tr>
                                      <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:26px; text-align:left; padding-bottom:20px;">Please click the button below to verify your email and have access to the Smart Solar Media System Platform.</td>
                                    </tr>
                                    <!-- Button -->
                                    <tr>
                                      <td align="left" style="padding-bottom: 20px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td class="pb-20" style="background:#ffcc09; color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:18px; padding:12px 30px; text-align:center; border-radius:0px 22px 22px 22px; font-weight:bold;"><a href="http://localhost/Plan_Int_New/verify_email.php?token='.$verifyToken.'" target="_blank" class="link-white" style="color:#000000; text-decoration:none;"><span class="link-white" style="color:#000000; text-decoration:none;">Verify Email</span></a></td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="text pb10" style="color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:26px; text-align:left; padding-bottom:10px;">Or copy & paste the link in the browser:</td>
                                    </tr>
                                    <tr>
                                      <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:26px; text-align:left; padding-bottom:20px;"><text>http://localhost/Plan_Int_New/verify_email.php?token='.$verifyToken.'</text></td>
                                    </tr>
                                    <tr>
                                      <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:20px; line-height:32px; text-align:left; padding-bottom:10px;">Best Regards,</td>
                                    </tr>
                                    <tr>
                                      <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:20px; line-height:32px; text-align:left; padding-bottom:10px;">The Tespack Team</td>
                                    </tr>
                                    <!-- END Button -->
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <!-- END Article / Full Width Image + Title + Copy + Button -->
        
                      <!-- Footer -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="p30-15 bbrr" style="padding: 30px 10px; border-radius:0px 0px 26px 26px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td class="pb10" style="color:#ffffff; font-family:Arial,sans-serif; font-size:16px; line-height:20px; text-align:right; padding-bottom:10px;">Copyright© 2022 Tespack. All rights reserved</td>
                                <td class="text-header" style="color:#475c77; font-family:Arial,sans-serif; font-size:12px; line-height:16px; text-align:right;"><img src="http://localhost/Plan_Int_New/assets/images/emails/powered.png" width="200"/></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <!-- END Footer -->
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>
        ');

    // Send the message
    //$mailer->send($message);
    $result = $mailer->send($message);

    if ($result > 0) {
        return true;
    } else {
        return false;
    }

    //echo 'Email sent successfully.';
      } catch (Exception $e) {
          if( !$e->getCode() ) {
              $refresh_token = $db->get_refersh_token();

              $response = $adapter->refreshAccessToken([
                  "grant_type" => "refresh_token",
                  "refresh_token" => $refresh_token,
                  "client_id" => GOOGLE_CLIENT_ID,
                  "client_secret" => GOOGLE_CLIENT_SECRET,
              ]);
              
              $data = (array) json_decode($response);
              $data['refresh_token'] = $refresh_token;

              $db->update_access_token(json_encode($data));
              sendVerificationEmail($verifyToken, $userName, $userRole, $userEmail);
              //send_email_to_user($userEmail);
          } else {
              echo $e->getMessage(); //print the error
          }
      }
}

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

// INCLUDING DATABASE AND MAKING OBJECT
require __DIR__.'/classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
//$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($_POST['fname']) 
    || !isset($_POST['lname']) 
    || !isset($_POST['email'])
    || !isset($_POST['phone']) 
    || !isset($_POST['country'])
    || !isset($_POST['address'])
    || !isset($_POST['pass'])
    || !isset($_POST['checkPass'])
    || !isset($_POST['role'])
    || empty(trim($_POST['fname']))
    || empty(trim($_POST['lname']))
    || empty(trim($_POST['email']))
    || empty(trim($_POST['phone']))
    || empty(trim($_POST['address']))
    || empty(trim($_POST['country']))
    || empty(trim($_POST['pass']))
    || empty(trim($_POST['checkPass']))
    || empty(trim($_POST['role']))
    ):

    //$fields = ['fields' => ['name','email','password']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $role_name = $_POST['role'];
    if($role_name=='Global Admin'): $role = '1';
    elseif($role_name=='Project Admin'): $role = '2';
    elseif($role_name=='Country Admin'): $role = '3';
    elseif($role_name=='Team Member'): $role = '4';
    endif;

    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $country = trim($_POST['country']);
    $pass = trim($_POST['pass']);
    $checkPass = trim($_POST['checkPass']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Invalid Email Address!');
    
    elseif(strlen($pass) < 6):
        $returnData = msg(0,422,'Your password must be at least 6 characters long!');

    elseif($pass != $checkPass):
        $returnData = msg(0,422,'Your passwords do not match! Please confirm properly.');

    elseif(strlen($fname) < 3):
        $returnData = msg(0,422,'Your first name must be at least 3 characters long!');

    else:
        try{
            $check_email = "SELECT `email` FROM `users` WHERE `email`=:email";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':email', $email,PDO::PARAM_STR);
            $check_email_stmt->execute();

            if($check_email_stmt->rowCount()):
                $returnData = msg(0,422, 'This E-mail already in use!');
            
            else:
                $token = bin2hex(random_bytes(50));
                //$curDate = date("Y-m-d");
                $curDate = date("Y-m-d H:i:s");
                $insert_query = "INSERT INTO `users`(`fname`,`lname`,`email`,`phone`,`address`,`country`,`password`,`created_at`,`reg_token`,`verified`,`role`) VALUES(:fname,:lname,:email,:phone,:address,:country,:password,:curDate,:token, :verified, :role_id)";

                $insert_stmt = $conn->prepare($insert_query);

                // DATA BINDING
                $insert_stmt->bindValue(':fname', htmlspecialchars(strip_tags($fname)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':lname', htmlspecialchars(strip_tags($lname)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':email', $email,PDO::PARAM_STR);
                $insert_stmt->bindValue(':phone', htmlspecialchars(strip_tags($phone)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':address', htmlspecialchars(strip_tags($address)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':country', htmlspecialchars(strip_tags($country)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':password', password_hash($pass, PASSWORD_DEFAULT),PDO::PARAM_STR);
                $insert_stmt->bindValue(':curDate', $curDate);
                $insert_stmt->bindValue(':token', $token);
                $insert_stmt->bindValue(':verified', '0');
                $insert_stmt->bindValue(':role_id', $role);

                if($insert_stmt->execute()):
                    sendVerificationEmail($token, $fname, $role_name, $email);
                    $returnData = msg(1,201,'You have successfully registered. Please verify your email to continue.');
                else:
                    $returnData = msg(0,422,'Sorry! There is an issue, Please try again letter');
                endif;

            endif;

        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
    
endif;

echo json_encode($returnData);