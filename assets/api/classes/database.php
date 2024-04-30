<?php
// require __DIR__ . '/user_track_info.php';
// class Database{
//     /*private $db_host;
//     private $db_name;
//     private $db_password;
//     private $db_username;
//     public function __construct() {
//         $this->db_host = getenv('CLOUDSQL_DSN');
//         $this->db_name = getenv('CLOUDSQL_DB');
//         $this->db_password = getenv('CLOUDSQL_PASSWORD');
//         $this->db_username = getenv('CLOUDSQL_USER');
//     }
//     private $db_host = '34.88.125.255';
//     private $db_name = 'plan_tespack';
//     private $db_username = 'root';
//     private $db_password = 'tespack@plan.2021';*/
//     private $db_host = 'localhost';
//     //private $db_name = 'smd';
//     private $db_name = 'plan_tespack';
//     private $db_username = 'tespack';
//     private $db_password = 'password';
//     public $secretKey = 'Xcad0T1dD04aEa25poASjs';
//     public function dbConnection(){
        
//         try{
//             $conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
//             //$conn = new PDO($this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
//             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//             return $conn;
//         }
//         catch(PDOException $e){
//             echo "Connection error ".$e->getMessage(); 
//             exit;
//         }
          
//     }

//     public static function get_user_track_details(){
//         $user_details = "IP : " . UserInfo::get_ip() . "<br> Device Type : " . UserInfo::get_device() . "<br> OS: " . UserInfo::get_os() . "<br> Browser: " . UserInfo::get_browser()."<br>".UserInfo::get_country_and_city(UserInfo::get_ip());
//         return $user_details;
//     }
// }

////////////postgres connection

require __DIR__ . '/user_track_info.php';

class Database{
    public function __construct() {}
    private $db_host = 'localhost';
    //private $db_name = 'smd';
    private $db_name = 'plan_tespack';
    private $db_username = 'tespack';
    private $db_password = 'adminxp123';
    public $secretKey = 'Xcad0T1dD04aEa25poASjs';
    private $schema_name = 'tespack_plan';
    public function dbConnection(){
        $conn = null;
        try{
            $conn = new PDO('pgsql:host='.$this->db_host.';dbname='.$this->db_name.';options=\'--search_path='.$this->schema_name.'\'',$this->db_username,$this->db_password);
            // $conn = new PDO('pgsql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);

            //$conn = new PDO($this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(\PDO::ATTR_PERSISTENT, true);
            return $conn;
        }
        catch(PDOException $e){
            echo "Connection error ".$e->getMessage(); 
            exit;
        }
          
    }

    public static function get_user_track_details(){
        $user_details = "IP : " . UserInfo::get_ip() . "<br> Device Type : " . UserInfo::get_device() . "<br> OS: " . UserInfo::get_os() . "<br> Browser: " . UserInfo::get_browser()."<br>".UserInfo::get_country_and_city(UserInfo::get_ip());
        return $user_details;
    }
    public static function executeRoutedFn($storedFunctionName, $payload) {
       
        $dbconnection = new Database();
        $pdo = $dbconnection->dbConnection();
        
		$isErr = false;
		//var_dump(json_decode($payload));

		$_out = null;

		try {
			$stmt = $pdo->prepare("SELECT $storedFunctionName(:x)");
			$stmt->setFetchMode(\PDO::FETCH_ASSOC);
			$stmt->execute([
				':x' => json_encode($payload),
			]);
            $_out = $stmt->fetchColumn(0);
		} 
		catch (\Throwable $th) {
			$isErr = true;
			// var_dump($th);
			$_out = json_encode([ "error_msg" => $th->getMessage()]);
		}

		$pdo = null;
		return json_decode($_out, true); //decode json to php object
		//return $_out;
		
	}


    public function extract_error_message($input_string) {
        // Use regular expressions to find the error message between the single quotes
        preg_match("/'([^']+)'/", $input_string, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return null;
        }
    }
}
?>