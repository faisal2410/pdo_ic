<?php


class Database
{
    private $host = 'localhost';
    private $db = 'testdb';
    private $user = 'root';
    private $pass = '';
    public $pdo;
    
    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
            echo "Connected successfully";
            // $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}



// $db=new Database();

