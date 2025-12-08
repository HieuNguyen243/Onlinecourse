<?php
require_once './models/CourseModel.php';
require_once './models/LessonModel.php';
class CourseController {
    
    private $courseModel;
    private $lessonModel;

    public function __construct($pdo) {
        $this->courseModel = new CourseModel($pdo);
        $this->lessonModel = new LessonModel($pdo);
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
            require './views/student/my_courses.php'; 
        }
        else {
            header("Location: index.php?controller=Auth&action=Login");
            exit();
        }
        
    }

    public function detail() {
        $course_id = $_GET['course_id'];
        $lessons = $this->lessonModel->getLessonsByCourse($course_id);
        //nếu đã đăng nhập mới hiển thị trạng thái đã học
        if(isset($_SESSION['user_id'])) {
            $student_id = $_SESSION['user_id'];
            foreach ($lessons as &$lesson) {
                $lesson['is_completed'] = $this->lessonModel->isLessonCompleted($student_id, $lesson['id']);
            }
        
        unset($lesson);
        require './views/course/detail.php';
    }
}
?>