<?php 
require_once './controllers/CourseController.php';
require_once './controllers/CategoryController.php';

class HomeController {
    private $courseController;
    private $categoryController;

    public function __construct($pdo) {
        $this->courseController = new CourseController($pdo);
        $this->categoryController = new CategoryController($pdo);
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        } else {
            header("Location: index.php?controller=Instructor&action=index");
            exit();
        }
    }
}