<?php
//include('sendVerifyEmail.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

function sendPasswordResetLink($resetToken, $userName, $userEmail) 
{
  require_once './../../../vendor/autoload.php';
  //$transport = Transport::fromDsn('gmail+smtp://'.urlencode('washif.hossain@tespack.com').':'.urlencode($arr_token['access_token']).'@default');
  $transport = Transport::fromDsn('smtp://platform@tespack.com:yimzqmgjihabhxqx@smtp.gmail.com:587');
  $mailer = new Mailer($transport);

  $message = (new Email())
      ->from('platform@tespack.com')
      ->to($userEmail)
      ->subject('Password Reset Link')
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
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="background-image: url(https://tesinsight.com/assets/images/emails/password.png);background-size: cover;background-repeat: no-repeat;margin: auto;">
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
                              <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td class="text-header" style="color:#475c77; font-family:"Muli", Arial,sans-serif; font-size:12px; line-height:16px; text-align:center;"><img src="https://tesinsight.com/assets/images/emails/plan-logo.png" width="300"/></td>
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
                                    <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:26px; text-align:left; padding-bottom:10px;">We have received a request to reset your password for your account.</b>.</td>
                                    
                                  </tr>
                                  <tr>
                                    <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:26px; text-align:left; padding-bottom:20px;">Please click the button below to reset your password for the Smart Solar Media System Platform.</td>
                                  </tr>
                                  <!-- Button -->
                                  <tr>
                                    <td align="left" style="padding-bottom: 20px;">
                                      <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td class="pb-20" style="background:#ffcc09; color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:18px; padding:12px 30px; text-align:center; border-radius:0px 22px 22px 22px; font-weight:bold;"><a href="https://tesinsight.com/setPassword.php?token='.$resetToken.'" target="_blank" class="link-white" style="color:#000000; text-decoration:none;"><span class="link-white" style="color:#000000; text-decoration:none;">Reset Password</span></a></td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="text pb10" style="color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:26px; text-align:left; padding-bottom:10px;">Or copy & paste the link in the browser:</td>
                                  </tr>
                                  <tr>
                                    <td class="text pb20" style="color:#000000; font-family:Arial,sans-serif; font-size:14px; line-height:26px; text-align:left; padding-bottom:20px;"><text>https://tesinsight.com/setPassword.php?token='.$resetToken.'</text></td>
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
                              <td class="pb10" style="color:#ffffff; font-family:Arial,sans-serif; font-size:16px; line-height:20px; text-align:right; padding-bottom:10px;">Copyright© '.date("Y").' Tespack. All rights reserved</td>
                              <td class="text-header" style="color:#475c77; font-family:Arial,sans-serif; font-size:12px; line-height:16px; text-align:right;"><img src="https://tesinsight.com/assets/images/emails/powered.png" width="200"/></td>
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
    try {
      $mailer->send($message);
      return true;
    } catch (Exception $e) {
          return false;
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
require __DIR__.'/../classes/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT POST
if($_SERVER["REQUEST_METHOD"] != "POST"):
    $returnData = msg(0,404,'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif(!isset($data->email)
|| empty(trim($data->email))
):

    //$fields = ['fields' => ['name','email','password']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!');

// IF THERE ARE NO EMPTY FIELDS THEN-
else:
    $email = trim($data->email);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        $returnData = msg(0,422,'Invalid Email Address!');

    else:
        try{
            $fetch_user_by_email = "SELECT * FROM users WHERE email=:email";
            $query_stmt = $conn->prepare($fetch_user_by_email);
            $query_stmt->bindValue(':email', $email,PDO::PARAM_STR);
            $query_stmt->execute();

            // IF THE USER IS FOUNDED BY EMAIL
            if($query_stmt->rowCount()):
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                $token = bin2hex(random_bytes(50));
                $curDate = date("Y-m-d H:i:s");
                if(sendPasswordResetLink($token, $row['fname'], $email)):
                  $insert_query = "INSERT INTO password_reset(email,token,created_at) VALUES(:email,:token,:created_at)";

                  $insert_stmt = $conn->prepare($insert_query);

                  // DATA BINDING

                  $insert_stmt->bindValue(':email', $email,PDO::PARAM_STR);
                  $insert_stmt->bindValue(':token', $token);
                  $insert_stmt->bindValue(':created_at', $curDate);

                  $insert_stmt->execute();
                  
                  $returnData = msg(1,201,"Sign into your email account and click on the link we just emailed you at ".$email);
                else:
                  $returnData = msg(0,422,'Sorry there is an issue, please try again later.');
                endif;
            // IF THE USER IS NOT FOUNDED BY EMAIL THEN SHOW THE FOLLOWING ERROR
            else:
                $returnData = msg(0,422,'This email is not registered in the platform!');
            endif;
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }
    endif;
    
endif;

echo json_encode($returnData);