<?php
require_once 'models/UserModel.php';
require_once 'config/database.php'; // File kết nối CSDL

class ManageProfileController {
    private $db;
    private $userModel;

   public function __construct($pdo) {
        $this->db = $pdo;
        $this->userModel = new UserModel($this->db);
    }

    public function editProfile() {
    
        
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=home&action=index");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $message = "";
        $error = "";

        // 2. Xử lý khi có POST request (Người dùng bấm nút Lưu)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validate đơn giản
            if (empty($fullname) || empty($email)) {
                $error = "Vui lòng nhập đủ họ tên và email!";
            } else {
                // Gọi Model để update thông tin
                if ($this->userModel->updateProfile($userId, $fullname, $email)) {
                    $_SESSION['user_fullname'] = $fullname; // Cập nhật lại session
                    $message = "Cập nhật thông tin thành công!";
                    
                    // Logic đổi mật khẩu
                    if (!empty($newPassword)) {
                        if ($newPassword === $confirmPassword) {
                            $this->userModel->updatePassword($userId, $newPassword);
                            $message .= " Mật khẩu đã được đổi.";
                        } else {
                            $error = "Mật khẩu xác nhận không khớp.";
                        }
                    }
                } else {
                    $error = "Lỗi hệ thống, vui lòng thử lại.";
                }
            }
        }

        // 3. Lấy dữ liệu user mới nhất để đẩy ra View
        $currentUser = $this->userModel->getById($userId);

        // 4. Gọi View để hiển thị (Truyền biến sang view)
        require_once 'views/layouts/header.php';
        require_once 'views/profile/manageprofile.php'; 
    }
}
?>