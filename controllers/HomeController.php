<?php 
require_once './controllers/CourseController.php';
require_once './controllers/AuthController.php';
require_once './controllers/EnrollmentController.php';
require_once './controllers/LessonController.php';
require_once './models/CategoryModel.php';
require_once './models/CourseModel.php';

class HomeController {
    private $courseModel;
    private $categoryModel;

    public function __construct($pdo) {
        $this->courseModel = new CourseModel($pdo);
        $this->categoryModel = new CategoryModel($pdo);
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        $allcourses = $this->courseModel->getAllCourses();

        $userrole = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
        if ($userrole === 2) {
            header("Location: index.php?controller=admin&action=dashboard");
        } elseif ($userrole === 1) {
            header("Location: index.php?controller=instructor&action=dashboard");
        }elseif ($userrole === 0) {
            header("Location: index.php?controller=student&action=dashboard");
        } else {
            require './views/home/index.php';
        }
    }
}