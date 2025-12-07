<?php
class CourseController {
    require_once './models/CourseModel.php';
    private $courseModel;

    public function __construct($pdo) {
        $this->courseModel = new CourseModel($pdo);
    }

    public function listALlCourses() {
        $allcourses = $this->courseModel->getAllCourses();
        require './views/course/index.php';
    }

    public function searchCourses() {
        if(isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
            $result = $this->courseModel->searchCourses($keyword);
        }else {
            $result = $this->courseModel->getAllCourses();
        }
        require './views/course/search.php';
    }

    public function listCoursesByCategory($category_id) {
        if(isset($_POST['category_id'])) {
            $category_id = $_POST['category_id'];
            $result = $this->courseModel->getCourseByCategory($category_id);
        }

        require './views/course/index.php';
    }

    public function listEnrolledCourses() {
        if(isset($_SESSION['user_id'])) {
            $student_id = $_SESSION['user_id'];
            $result = $this->courseModel->getEnrolledCourses($student_id);
            require './views/course/index.php';
        }
        else {
            header("Location: ./views/auth/login.php");
            exit();
        }
        
    }
}

?>