<?php
require_once './models/LessonModel.php';
require_once './models/EnrollmentModel.php';
require_once './models/MaterialModel.php'; 

class LessonController { 
    private $lessonModel;
    private $enrollmentModel;
    private $materialModel;

    public function __construct($pdo){
        $this->lessonModel = new LessonModel($pdo);
        $this->enrollmentModel = new EnrollmentModel($pdo);
        $this->materialModel = new MaterialModel($pdo);
    }


    public function detail() {
        if (isset($_GET['lesson_id']) && isset($_SESSION['user_id'])) {
            $lesson_id = $_GET['lesson_id'];
            $course_id = $_GET['course_id']; 
            $student_id = $_SESSION['user_id'];

            
            $material = $this->materialModel->getMaterialsByLesson($lesson_id);
            
            $currentLesson = $this->lessonModel->getLessonById($lesson_id);
            $listLessons = $this->lessonModel->getLessonsByCourse($course_id);
            
            foreach ($listLessons as &$l) {
                $l['completed'] = $this->lessonModel->isLessonCompleted($student_id, $l['id']);
                $l['is_current'] = ($l['id'] == $lesson_id);
            }
            unset($l);

            require './views/lesson/detail.php';
        } else {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    public function complete() {
        if (isset($_POST['lesson_id']) && isset($_POST['course_id']) && isset($_SESSION['user_id'])) {
            $lesson_id = $_POST['lesson_id'];
            $course_id = $_POST['course_id'];
            $student_id = $_SESSION['user_id'];

            $this->lessonModel->markAsDone($student_id, $course_id, $lesson_id);

            $total = $this->lessonModel->countLessons($course_id);
            $done = $this->lessonModel->countCompleted($student_id, $course_id);
            
            $percent = ($total > 0) ? ($done / $total) * 100 : 0;
            $this->enrollmentModel->updateProgressDirect($student_id, $course_id, $percent);

            header("Location: index.php?controller=lesson&action=detail&course_id=$course_id");
            exit();
        }    
    }
}
?>