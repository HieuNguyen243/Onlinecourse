<?php
require_once './models/EnrollmentModel.php';

class EnrollmentController {
    private $enrollmentModel;

    public function __construct($pdo){
        $this->enrollmentModel = new EnrollmentModel($pdo);
    }

    public function register(){
        // Kiểm tra login
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if (isset($_POST['course_id'])) {
            $student_id = $_SESSION['user_id'];
            $course_id = $_POST['course_id'];

            if (!$this->enrollmentModel->checkEnrollment($student_id, $course_id)) {
                $this->enrollmentModel->register($student_id, $course_id);
                header("Location: index.php?controller=course&action=my_courses");
            } else {
                echo "<script>alert('Bạn đã đăng ký khóa này rồi!'); history.back();</script>";
            }
        }    
    }
}
?>