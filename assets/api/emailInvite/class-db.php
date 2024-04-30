<?php
class DB {
    /*private $dbHost = '/cloudsql/tespack-smb-map-services:europe-north1:plan-platform';
    private $dbName;
    private $dbPassword;
    private $dbUsername;*/
    // private $dbHost     = "localhost";
    // private $dbUsername = "tespack";
    // private $dbPassword = "password";
    // private $dbName     = "plan_tespack";
    // public function __construct() {
    //     //$this->dbHost = getenv('CLOUDSQL_DSN');
    //     //$this->dbName = getenv('CLOUDSQL_DB');
    //     //$this->dbPassword = getenv('CLOUDSQL_PASSWORD');
    //     //$this->dbUsername = getenv('CLOUDSQL_USER');

    //     if(!isset($this->db)){
    //         // Connect to the database
    //         //$conn = new mysqli(null, $this->dbUsername, $this->dbPassword, $this->dbName, null, $this->dbHost);
    //         $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
    //         if($conn->connect_error){
    //             die("Failed to connect with MySQL: " . $conn->connect_error);
    //         }else{
    //             $this->db = $conn;
    //         }
    //     }
    // }
    private $db_host = 'localhost';
    //private $db_name = 'smd';
    private $db_name = 'plan_tespack';
    private $db_username = 'tespack';
    private $db_password = 'adminxp123';
    public $secretKey = 'Xcad0T1dD04aEa25poASjs';
    private $schema_name = 'tespack_plan';
    private $db;
    public function __construct(){
        $conn = null;
        try{
            $conn = new PDO('pgsql:host='.$this->db_host.';dbname='.$this->db_name.';options=\'--search_path='.$this->schema_name.'\'',$this->db_username,$this->db_password);
            // $conn = new PDO('pgsql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);

            //$conn = new PDO($this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(\PDO::ATTR_PERSISTENT, true);
            //return $conn;
            $this->db = $conn;
        }
        catch(PDOException $e){
            echo "Connection error ".$e->getMessage(); 
            exit;
        }
          
    }
  
    public function is_token_empty() {
        //$result = $this->db->query("SELECT id FROM google_oauth WHERE provider = 'google'");
        $google = 'google';
        $sql = "SELECT id FROM google_oauth WHERE provider=:google";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':google', $google);
        $stmt->execute();
        //$user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount()) {
            return false;
        }
  
        return true;
    }
  
    public function get_access_token() {
        //$sql = $this->db->query("SELECT provider_value FROM google_oauth WHERE provider='google'");
        //$result = $sql->fetch_assoc();
        $google = 'google';
        $sql = "SELECT provider_value FROM google_oauth WHERE provider=:google";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':google', $google);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return json_decode($result['provider_value']);
    }
  
    public function get_refersh_token() {
        $result = $this->get_access_token();
        return $result->refresh_token;
    }
  
    public function update_access_token($token) {
        $google = 'google';
        if($this->is_token_empty()) {
            //$this->db->query("INSERT INTO google_oauth(provider, provider_value) VALUES('google', '$token')");
            $sql = "INSERT INTO google_oauth(provider, provider_value) VALUES(:google, :token)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':google', $google);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
        } else {
            //$this->db->query("UPDATE google_oauth SET provider_value = '$token' WHERE provider = 'google'");
            $sql = "UPDATE google_oauth SET provider_value=:token WHERE provider=:google";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':google', $google);
            $stmt->execute();
        }
    }
}