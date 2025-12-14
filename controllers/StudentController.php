<?php
require_once './models/LessonModel.php';
require_once './models/EnrollmentModel.php';
require_once './models/CourseModel.php';
require_once './models/CategoryModel.php';

class StudentController {
    private $courseModel;
    private $enrollmentModel;
    private $categoryModel;

    public function __construct($pdo){
        $this->courseModel = new CourseModel($pdo);
        $this->enrollmentModel = new EnrollmentModel($pdo);
        $this->categoryModel = new CategoryModel($pdo);
    }

// Trong file controllers/StudentController.php
    public function dashboard() {
        if(isset($_SESSION['user_id']) && $_SESSION['role'] == 0) {
            $student_id = $_SESSION['user_id'];
            
            // --- LOGIC LỌC KHÓA HỌC ---
            $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : '';

            // 1. Lấy tất cả khóa học cơ sở (dựa trên search/category)
            if($keyword) {
                $allCourses = $this->courseModel->searchCourses($keyword);
            } elseif($categoryId) {
                $allCourses = $this->courseModel->getCourseByCategory($categoryId);
            } else {
                $allCourses = $this->courseModel->getAllCourses();
            }

            // 2. Lấy thông tin đăng ký
            $enrolledCoursesRaw = $this->courseModel->getEnrolledCourses($student_id);
            $enrolledData = [];
            $enrolledIds = []; // Mảng chứa ID các khóa đã đăng ký
            foreach ($enrolledCoursesRaw as $ec) {
                $enrolledIds[] = $ec['id'];
                $enrolledData[$ec['id']] = [
                    'progress' => $ec['progress'],
                    'status' => $ec['enrollment_status']
                ];
            }

            // 3. Nếu đang lọc "Khóa học của tôi", loại bỏ các khóa chưa đăng ký khỏi danh sách
            if ($filter === 'enrolled') {
                $allCourses = array_filter($allCourses, function($course) use ($enrolledIds) {
                    return in_array($course['id'], $enrolledIds);
                });
            }

            $categories = $this->categoryModel->getAllCategories();
            
            require './views/student/dashboard.php';
        } else {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    public function myCourses() {
        if(isset($_SESSION['user_id'])) {
            $student_id = $_SESSION['user_id'];
            $enrolledCourses = $this->courseModel->getEnrolledCourses($student_id);
            require './views/student/my_courses.php';
        } else {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }
}