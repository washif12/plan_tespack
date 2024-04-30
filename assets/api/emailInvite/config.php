<?php
// require_once '../../../vendor/autoload.php';
// require_once 'class-db.php';
require_once __DIR__. '/../../../vendor/autoload.php';
require_once __DIR__. '/class-db.php';
//require_once __DIR__. '/../classes/database.php';
  
define('GOOGLE_CLIENT_ID', '232094940781-u8fv99bp2v8kqdutqd6sha7vrbaio2u4.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
  
$config = [
    //'callback' => 'https://tespack-smb-map-services.appspot.com/email/callback.php',
    //'callback' => 'http://5.161.107.4/assets/api/emailInvite/callback.php',
    'callback' => 'https://tesinsight.com/assets/api/emailInvite/callback.php',
    'keys'     => [
                    'id' => GOOGLE_CLIENT_ID,
                    'secret' => GOOGLE_CLIENT_SECRET
                ],
    'scope'    => 'https://mail.google.com',
    'authorize_url_parameters' => [
            'prompt' => 'consent', // to pass only when you need to acquire a new refresh token.
            'access_type' => 'offline'
    ]
];
   
$adapter = new Hybridauth\Provider\Google( $config );
//$hybridauth = new Hybrid_Auth( $config );
 
//$adapter = $hybridauth->authenticate( "Google" );
?>