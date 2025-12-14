<?php

class Database {
    private $pdo;
    function connect() {
        $host = '127.0.0.1';
        $dbname = 'onlinecourse';
        $username = 'root';
        $password = '';
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        try {
            $options = [
                
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];
            
         
            $this->pdo = new PDO($dsn, $username, $password, $options);
            
            return $this->pdo;
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }
}
?>