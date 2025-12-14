<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/CourseModel.php'; 
require_once __DIR__ . '/../models/EnrollmentModel.php'; 

class AdminController {
    private $db;
    private $userModel;
    private $courseModel;
    private $enrollmentModel; 

   public function __construct($pdo) { 
        $this->db = $pdo;
        $this->userModel = new UserModel($this->db);
        $this->courseModel = new CourseModel($this->db);
        $this->enrollmentModel = new EnrollmentModel($this->db); 

        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    public function dashboard() {
        $countStudent = $this->userModel->countByRole(0);
        $countInstructor = $this->userModel->countByRole(1);
        $countAdmin = $this->userModel->countByRole(2);
        $countCourse = $this->courseModel->countAll();

        require_once 'views/admin/dashboard.php';
    }

   public function manageStudent() {
        $students = $this->userModel->getUsersByRole(0);
        
        foreach ($students as &$st) {
            $st['course_count'] = $this->enrollmentModel->countByStudentId($st['id']);
        }
        unset($st); // Hủy tham chiếu

        require_once 'views/admin/manageStudent.php';
    }

    public function manageInstructor() {
        $instructors = $this->userModel->getUsersByRole(1); // Role 1 là giảng viên
        
        foreach ($instructors as &$inst) {
            $inst['courses'] = $this->courseModel->getCoursesByInstructorId($inst['id']);
        }
        unset($inst);

        require_once 'views/admin/manageInstructor.php';
    }

    public function createInstructor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];
            $role = 1; 

            if ($this->userModel->create($username, $email, $password, $fullname, $role)) {
                echo "<script>alert('Thêm giảng viên thành công!'); window.location.href='index.php?controller=admin&action=manageInstructor';</script>";
            } else {
                echo "<script>alert('Lỗi: Username hoặc Email đã tồn tại!'); window.history.back();</script>";
            }
        }
    }

    public function manageCourse() {
        $approvedCourses = $this->courseModel->getCoursesByStatus('approved');
        $pendingCourses = $this->courseModel->getCoursesByStatus('pending');
        
        require_once 'views/admin/manageCourse.php';
    }

    public function setCourseStatus() {
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $id = $_GET['id'];
            $status = $_GET['status']; 
            
            $this->courseModel->updateStatus($id, $status);
            header("Location: index.php?controller=admin&action=manageCourse");
        }
    }

    public function manageAdmin() {
        $admins = $this->userModel->getUsersByRole(2);
        require_once 'views/admin/manageAdmin.php'; 
    }

    public function deleteUser() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $type = isset($_GET['type']) ? $_GET['type'] : 'student'; 

            $user = $this->userModel->getById($id);
            if ($user && $user['role'] == 1) {
                if ($this->userModel->hasCourses($id)) {
                    echo "<script>alert('Không thể xóa giảng viên đang có khóa học!'); window.location.href='index.php?controller=admin&action=manageInstructor';</script>";
                    return; 
                }
            }

            if ($this->userModel->delete($id)) {
                $redirectAction = ($type == 'instructor') ? 'manageInstructor' : 'manageStudent';
                header("Location: index.php?controller=admin&action=$redirectAction");
            } else {
                echo "Lỗi xóa người dùng!";
            }
        }
    }


}
?>