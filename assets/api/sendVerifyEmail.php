<?php
require_once './../../vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
    ->setUsername('orcko.ruet@gmail.com')
    ->setPassword('');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail($userEmail, $token) 
{
    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Test mail</title>
      <style>
        .wrapper {
          padding: 20px;
          color: #444;
          font-size: 1.3em;
          text-align: center;
        }
        a {
          background: #28a745;
          text-decoration: none;
          padding: 8px 15px;
          border-radius: 5px;        }
      </style>
    </head>

    <body>
      <div class="wrapper">
        <p>Thank you for signing up. Please click on the link below to verify your account:.</p>
        <a href="http://localhost/Plan_Int_New/backend/verify_email.php?token=' . $token . '" target="_blank">Verify Email!</a>
      </div>
    </body>

    </html>';

    // Create a message
    $message = (new Swift_Message('Verify your email'))
        ->setFrom('orcko.ruet@gmail.com')
        ->setTo($userEmail)
        ->setBody($body, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}