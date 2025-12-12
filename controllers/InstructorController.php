
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

    public function index() {
        $courses = [];
        if ($this->pdo && isset($_SESSION['user_id'])) {
            $courseModel = new CourseModel($this->pdo);
            $courses = $courseModel->getCoursesByInstructor($_SESSION['user_id']);
        }
        require_once __DIR__ . '/../views/instructor/dashboard.php';
    }
    
    public function dashboard() {
        $this->index(); 
    }

    public function createCourse() {
        require_once __DIR__ . '/../views/instructor/create_course.php';
    }

    public function storeCourse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
            $courseModel = new CourseModel($this->pdo);
            
            // Xử lý dữ liệu POST an toàn hơn
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $price = $_POST['price'] ?? 0;
            $instructor_id = $_SESSION['user_id'] ?? null;
            
            if (!$instructor_id) {
                // Xử lý trường hợp không có user_id (không đăng nhập)
                header("Location: index.php?controller=auth&action=login");
                exit();
            }

            if ($courseModel->createCourse(
                $title, 
                $description, 
                $instructor_id, 
                $category_id, 
                $price
            )) {
                header("Location: index.php?controller=instructor&action=index");
                exit();
            } else {
                // Xử lý lỗi khi tạo khóa học thất bại (ví dụ: category_id không tồn tại)
                $error = "Lỗi: Không thể tạo khóa học. Kiểm tra Category ID.";
                require_once __DIR__ . '/../views/instructor/create_course.php';
            }
        }
        require_once __DIR__ . '/../views/instructor/create_course.php';
    }

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

    public function editCourse() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) { die("Thiếu ID khóa học"); }

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
                $_POST['category_id'] ?? null, 
                $_POST['price'] ?? 0
            );
            header('Location: index.php?controller=Instructor&action=index');
            exit();
        }
        
        // Nếu là GET request, gọi lại editCourse để hiển thị form
        $this->editCourse();
    }

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