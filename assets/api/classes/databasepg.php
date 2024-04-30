<?php
require __DIR__ . '/user_track_info.php';

class Database{
    public function __construct() {}
    private $db_host = 'localhost';
    //private $db_name = 'smd';
    private $db_name = 'plan_tespack';
    private $db_username = 'tespack';
    private $db_password = 'adminxp123';
    public $secretKey = 'Xcad0T1dD04aEa25poASjs';
    private $schema_name = 'xti';
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
			$_out = json_encode([ "error_msg" =>$dbconnection->extract_error_message($th->getMessage())]);
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


// var_dump(userIsExist(1));
?>