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
        if(isset($_SESSION['user_id'])) {
            $student_id = $_SESSION['user_id'];
            $allCourses = $this->courseModel->getAllCourses();
            $categories = $this->categoryModel->getAllCategories();
            require './views/student/dashboard.php';
        } else {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }
}