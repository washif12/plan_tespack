<?php
require_once __DIR__. '/../../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler
{
    protected $jwt_secrect;
    protected $token;
    protected $issuedAt;
    protected $expire;
    protected $jwt;

    public function __construct()
    {
        // set your default time-zone
        //date_default_timezone_set('Europe/Helsinki');
        $this->issuedAt = time();

        // Token Validity (3600 second = 1hr)
        $this->expire = $this->issuedAt + 36000;

        // Set your secret or signature
        $this->jwt_secrect = "this_is_my_secrect";
    }

    public function jwtEncodeData($iss, $data)
    {
        $this->token = array(
            //Adding the identifier to the token (who issue the token)
            "iss" => $iss,
            "aud" => $iss,
            // Adding the current timestamp to the token, for identifying that when the token was issued.
            "iat" => $this->issuedAt,
            // Token expiration
            "exp" => $this->expire,
            // Payload
            "data" => $data
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secrect, 'HS256');
        return $this->jwt;
    }

    public function jwtDecodeData($jwt_token)
    {
        try {
            //$decode = JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
            $decode = JWT::decode($jwt_token, new Key($this->jwt_secrect, 'HS256'));
            //return $decode->data;
            //return (array)$decode;
            return $decode;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}