<?php
require_once './models/EnrollmentModel.php';
require_once './models/CourseModel.php';

class EnrollmentController {
    private $enrollmentModel;
    private $courseModel;

    public function __construct($pdo) {
        $this->enrollmentModel = new EnrollmentModel($pdo);
        $this->courseModel = new CourseModel($pdo);
    }

    // Gv: Xem danh sách học viên
    public function viewStudents() {
        if (isset($_GET['course_id']) && isset($_SESSION['user']) && $_SESSION['user']['role'] == 'teacher') {
            $course_id = $_GET['course_id'];
            if ($this->courseModel->isTeacherOwnsCourse($course_id, $_SESSION['user']['id'])) {
                $students = $this->enrollmentModel->getEnrolledStudents($course_id);
                require './views/enrollment/view_students.php';
            }
        }
    }

    // Gv: Theo dõi tiến độ học viên
    public function trackProgress() {
        if (isset($_GET['course_id']) && isset($_SESSION['user']) && $_SESSION['user']['role'] == 'teacher') {
            $course_id = $_GET['course_id'];
            if ($this->courseModel->isTeacherOwnsCourse($course_id, $_SESSION['user']['id'])) {
                $progress = $this->enrollmentModel->getCourseProgress($course_id);
                require './views/enrollment/track_progress.php';
            }
        }
    }

    // Gv: Xem tiến độ chi tiết của một học viên
    public function studentDetail() {
        if (isset($_GET['course_id']) && isset($_GET['student_id']) && isset($_SESSION['user']) && $_SESSION['user']['role'] == 'teacher') {
            $course_id = $_GET['course_id'];
            if ($this->courseModel->isTeacherOwnsCourse($course_id, $_SESSION['user']['id'])) {
                $studentProgress = $this->enrollmentModel->getStudentProgress($_GET['student_id'], $course_id);
                require './views/enrollment/student_detail.php';
            }
        }
    }
}
?>
