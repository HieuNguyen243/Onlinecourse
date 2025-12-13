<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct($pdo) {
        $this->db = $pdo;
        $this->userModel = new UserModel($this->db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];

              if ($user['role'] == 2) {
            header("Location: index.php?controller=admin&action=dashboard");
            exit();
        } 
        elseif ($user['role'] == 1) {
            header("Location: index.php?controller=instructor&action=dashboard");
            exit();
        } 
        else {
            header("Location: index.php?controller=home&action=index");
            exit();
        }
                
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
                require_once 'views/auth/login.php';
            }
        } else {
            require_once 'views/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];

            if ($this->userModel->create($username, $email, $password, $fullname)) {
                header("Location: index.php?controller=auth&action=login");
            } else {
                $error = "Đăng ký thất bại (Username hoặc Email có thể đã tồn tại)";
                require_once 'views/auth/register.php';
            }
        } else {
            require_once 'views/auth/register.php';
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit();
    }


}

?> 