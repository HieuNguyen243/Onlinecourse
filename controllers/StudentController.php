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

    public function dashboard() {
    if(isset($_SESSION['user_id']) && $_SESSION['role'] == 0) {
        $student_id = $_SESSION['user_id'];
        
        // Xử lý tìm kiếm và lọc category ngay tại Dashboard nếu cần
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : '';

        if($keyword) {
            $allCourses = $this->courseModel->searchCourses($keyword);
        } elseif($categoryId) {
            $allCourses = $this->courseModel->getCourseByCategory($categoryId);
        } else {
            $allCourses = $this->courseModel->getAllCourses();
        }

        $categories = $this->categoryModel->getAllCategories();
        
        
        $enrolledCourses = $this->courseModel->getEnrolledCourses($student_id);
        
        $enrolledData = [];
        foreach ($enrolledCourses as $ec) {
            $enrolledData[$ec['id']] = [
                'progress' => $ec['progress'],
                'status' => $ec['enrollment_status']
            ];
        }

        require './views/student/dashboard.php';
    } else {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
    }
}