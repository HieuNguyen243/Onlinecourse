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
        $categories = $this->categoryController->getAllCategories();
        $allcourses = $this->courseController->getAllCourses();

        // Chỉ dành cho giảng viên - hiển thị trang chủ
        require './views/home/index.php';
    }
}