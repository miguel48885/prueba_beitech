<?php
class Database{
 
    // specify your own database credentials

    private $host = "beitech-sas.ccnlcdeiv1f1.us-east-1.rds.amazonaws.com";
    private $db_name = "test";
    private $username = "beitech_test";
    private $password = "K#j~t33@M}";
    private $portbd = "3306";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=3306".";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}