
<?php
require_once __DIR__ . '/../models/CourseModel.php';
require_once __DIR__ . '/../models/EnrollmentModel.php';
require_once __DIR__ . '/../models/LessonModel.php';
require_once __DIR__ . '/../models/MaterialModel.php';

class InstructorController {
    protected $pdo;

    public function __construct($pdo = null) {
        $this->pdo = $pdo;
    }

    // Trang dashboard hiển thị các chức năng của giảng viên
    public function index() {
        $courses = [];
        if ($this->pdo && isset($_SESSION['user_id'])) {
            $courseModel = new CourseModel($this->pdo);
            $courses = $courseModel->getCoursesByInstructor($_SESSION['user_id']);
        }
        require_once __DIR__ . '/../views/instructor/dashboard.php';
    }

    // Hiển thị form tạo khóa học
    public function createCourse() {
        require_once __DIR__ . '/../views/instructor/create_course.php';
    }

    // Xử lý tạo khóa học
    public function storeCourse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
            $courseModel = new CourseModel($this->pdo);
            $courseModel->createCourse(
                $_POST['title'], 
                $_POST['description'], 
                $_SESSION['user_id'], 
                $_POST['category_id'], 
                $_POST['price']
            );
            header("Location: index.php?controller=instructor&action=index");
            exit();
        }
        require_once __DIR__ . '/../views/instructor/create_course.php';
    }

    // Xem danh sách học viên của khóa học
    public function viewStudents() {
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        if (!$course_id) {
            header("Location: index.php?controller=instructor&action=index");
            exit();
        }
        $enrollmentModel = new EnrollmentModel($this->pdo);
        $students = $enrollmentModel->getStudentsByCourse($course_id);
        require_once __DIR__ . '/../views/instructor/student_list.php';
    }

    public function editCourse($id) {
        $courseModel = new CourseModel($this->pdo);
        $course = $courseModel->getCourseById($id);
        if (!$course) { die("Khóa học không tồn tại"); }
        require_once __DIR__ . '/../views/instructor/edit_course.php';
    }

    public function updateCourse() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $courseModel = new CourseModel($this->pdo);
            $courseModel->updateCourse(
                $_POST['id'], 
                $_POST['title'], 
                $_POST['description'], 
                $_POST['category_id'], 
                $_POST['price']
            );
            header('Location: index.php?controller=Instructor&action=index');
            exit();
        }
        if (isset($_GET['id'])) {
            $courseModel = new CourseModel($this->pdo);
            $course = $courseModel->getCourseById($_GET['id']);
            if (!$course) { die("Khóa học không tồn tại"); }
            require_once __DIR__ . '/../views/instructor/edit_course.php';
        }
    }

    // Xem tiến độ học viên
    public function progress() {
        $courses = [];
        $students = [];
        
        if ($this->pdo && isset($_SESSION['user_id'])) {
            $courseModel = new CourseModel($this->pdo);
            $courses = $courseModel->getCoursesByInstructor($_SESSION['user_id']);
            
            if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
                $enrollmentModel = new EnrollmentModel($this->pdo);
                $students = $enrollmentModel->getStudentsByCourse($_GET['course_id']);
            }
        }
        require_once __DIR__ . '/../views/instructor/progress.php';
    }

    public function deleteCourse() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            header('Location: index.php?controller=Instructor&action=index');
            exit();
        }
        $courseModel = new CourseModel($this->pdo);
        $courseModel->deleteCourse($id);
        header('Location: index.php?controller=Instructor&action=index');
        exit();
    }
}

?>