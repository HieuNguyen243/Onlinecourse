<?php
require_once './models/CourseModel.php';
require_once './models/LessonModel.php';
require_once './models/CategoryModel.php';
require_once './models/EnrollmentModel.php';

class CourseController {
    
    private $courseModel;
    private $lessonModel;
    private $categoryModel;
    public $pdo; // Public để truy cập từ bên ngoài nếu cần (như trong detail)

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->courseModel = new CourseModel($pdo);
        $this->lessonModel = new LessonModel($pdo);
        $this->categoryModel = new CategoryModel($pdo);
        $this->enrollmentModel = new EnrollmentModel($pdo);
    }

    public function listAllCourses() {
        $categories = $this->categoryModel->getAllCategories();
        $allcourses = $this->courseModel->getAllCourses();
        require './views/courses/index.php';
    }

    public function searchCourses() {
        $categories = $this->categoryModel->getAllCategories();
        $allcourses = []; 

        if(isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
            $allcourses = $this->courseModel->searchCourses($keyword);
        } else {
            $allcourses = $this->courseModel->getAllCourses();
        }
        require './views/courses/index.php';
    }

    public function listCoursesByCategory() {
        $categories = $this->categoryModel->getAllCategories();
        $allcourses = [];

        if(isset($_POST['category_id'])) {
            $category_id = $_POST['category_id'];
            $allcourses = $this->courseModel->getCourseByCategory($category_id);
        } else {
            $allcourses = $this->courseModel->getAllCourses();
        }
        require './views/courses/index.php';
    }

    public function listEnrolledCourses() {
        if(isset($_SESSION['user_id'])) {
            $student_id = $_SESSION['user_id'];
            // Gọi hàm từ model đã được sửa (lấy đủ thông tin progress, image...)
            $courses = $this->courseModel->getEnrolledCourses($student_id);
            require './views/student/my_courses.php'; 
        }
        else {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    public function detail() {
        // Kiểm tra xem có ID khóa học không
        if (!isset($_GET['course_id'])) {
            header("Location: index.php");
            exit();
        }

        $course_id = $_GET['course_id'];

        // 4. LẤY THÔNG TIN KHÓA HỌC (Biến $course mà view cần)
        $course = $this->courseModel->getCourseById($course_id);

        // Nếu không tìm thấy khóa học -> về trang chủ
        if (!$course) {
            header("Location: index.php");
            exit();
        }

        // Lấy danh sách bài học
        $lessons = $this->lessonModel->getLessonsByCourse($course_id);
        
        // Mặc định chưa đăng ký
        $isEnrolled = false; 

        // Nếu đã đăng nhập, kiểm tra trạng thái đăng ký và tiến độ
        if(isset($_SESSION['user_id'])) {
            $student_id = $_SESSION['user_id'];
            
            // 5. TẠO BIẾN $isEnrolled (View rất cần biến này)
            $isEnrolled = $this->enrollmentModel->checkEnrollment($student_id, $course_id);

            foreach ($lessons as &$lesson) {
                $lesson['is_completed'] = $this->lessonModel->isLessonCompleted($student_id, $lesson['id']);
            }
            unset($lesson); // Hủy tham chiếu
        }

        // 6. Sửa đường dẫn View cho đúng (thêm 's' vào courses)
        require './views/courses/detail.php';
    }
}
?>