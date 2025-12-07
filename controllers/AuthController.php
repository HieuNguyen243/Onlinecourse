<?php

require_once './models/UserModel.php';
// gv
class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = $this->userModel->checkLogin($email, $password);
            
            if ($user) {
                $_SESSION['user'] = $user;
                if ($user['role'] == 'teacher') {
                    header("Location: index.php?act=list_course");
                } else {
                    header("Location: index.php");
                }
            } else {
                echo "Sai email hoặc mật khẩu!";
            }
        }
        require_once './views/auth/login.php'; 
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?act=login");
    }
}

?>