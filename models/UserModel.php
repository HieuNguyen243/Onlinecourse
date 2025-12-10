<?php

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function addUser($name, $email, $password, $fullname, $role, $created_at){
        $sql = "insert into users (name, email, password, fullname, role, created_at) values (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $email, $password, $fullname, $role, $created_at]);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    
}