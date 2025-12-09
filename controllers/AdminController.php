<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';


class AdminController {
    private $db;
    private $userModel;


    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new UserModel($this->db);


        if (session_status() === PHP_SESSION_NONE) session_start();


        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }


    public function index() {
        $users = $this->userModel->getAll();
        require_once 'views/admin/users/manage.php';
    }


   
    public function createUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];
            $role = $_POST['role'];


            if ($this->userModel->create($username, $email, $password, $fullname, $role)) {
                header("Location: index.php?controller=admin&action=index");
            } else {
                $error = "Có lỗi xảy ra!";
                require_once 'views/admin/users/create.php';
            }
        } else {
            require_once 'views/admin/users/create.php';
        }
    }


   
    public function deleteUser() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $user = $this->userModel->getById($id);

            if ($user) {
                if ($user['role'] == 1) {
                    if ($this->userModel->hasCourses($id)) {
                        echo "<script>alert('CẢNH BÁO: Không thể xóa giáo viên này vì họ đang có khóa học trên hệ thống! Hãy xóa khóa học trước.'); window.location.href='index.php?controller=admin&action=index';</script>";
                        return; 
                    }
                }
                
                if ($this->userModel->delete($id)) {
                    header("Location: index.php?controller=admin&action=index");
                } else {
                    echo "Lỗi xóa người dùng!";
                }
            }
        }
    }

}
?>
