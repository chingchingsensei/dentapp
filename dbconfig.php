<?php
class Database
{   
    /* $DB_HOST = 'localhost';
    $DB_USER = 'u655308956_tutor';
    $DB_PASS = 'www.g2ix.com';
    $DB_NAME = 'u655308956_dent';
    */
    private $host = "localhost";
    private $db_name = "u655308956_dent";
    private $username = "u655308956_tutor";
    private $password = "www.g2ix.com";
    public $conn;
     
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
}
?>