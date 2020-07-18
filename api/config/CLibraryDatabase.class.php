<?php
class CLibraryDatabase{
    
    private $host 		= "localhost";
    private $db_name 	= "library_api";
    private $username 	= "root";
    private $password 	= "root";

    public $conn;

    const WRITE_TO_LOG_FILE = 3;
  
    public function getDbConnection() {
  
        $this->connection = null;
  
        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

            $this->connection->exec("set names utf8");

        } catch(PDOException $exception) {
        	error_log('Error connecting database : ' . $exception->getMessage(), WRITE_TO_LOG_FILE, '/DatabaseLog.log');
        }
  
        return $this->connection;
    }
}
?>