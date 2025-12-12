<?php
require_once './models/CourseModel.php';
require_once './models/LessonModel.php';
require_once './models/CategoryModel.php';
require_once './models/EnrollmentModel.php';

class CourseController {
    
    private $courseModel;
    private $lessonModel;
    private $categoryModel;

    public function __construct($pdo) {
        $this->courseModel = new CourseModel($pdo);
        $this->lessonModel = new LessonModel($pdo);
        $this->categoryModel = new CategoryModel($pdo);
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
            $result = $this->courseModel->getEnrolledCourses($student_id);
            require './views/student/my_courses.php'; 
        }
        else {
            header("Location: index.php?controller=Auth&action=Login");
            exit();
        }
        
    }

    public function detail() {
        $course_id = $_GET['course_id'];
        $course = $this->courseModel->getCourseById($course_id);
        
        $isEnrolled = false;
        $lessons = $this->lessonModel->getLessonsByCourse($course_id);
        
        if(isset($_SESSION['user_id'])) {
            $student_id = $_SESSION['user_id'];
            
            $enrollmentModel = new EnrollmentModel($this->courseModel->pdo);
            $isEnrolled = $enrollmentModel->checkEnrollment($student_id, $course_id); 
            
            foreach ($lessons as &$lesson) {
                $lesson['is_completed'] = $this->lessonModel->isLessonCompleted($student_id, $lesson['id']);
            }
        }
        unset($lesson);
        require './views/courses/detail.php';
    }
}
?>