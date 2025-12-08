<?php 
require_once './controllers/CourseController.php';
require_once './controllers/AuthController.php';
require_once './controllers/EnrollmentController.php';
require_once './controllers/LessonController.php';
require_once './controllers/CategoryController.php';

class HomeController {
    private $courseController;
    private $categoryController;

    public function __construct($pdo) {
        $this->courseController = new CourseController($pdo);
        $this->categoryController = new CategoryController($pdo);
    }

    public function index() {
        $categories = $this->categoryController->getAllCategories();
        $allcourses = $this->courseController->getAllCourses();

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