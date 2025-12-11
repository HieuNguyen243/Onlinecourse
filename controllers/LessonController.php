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
            $material = $this->materialModel->getMaterialByLesson($lesson_id);
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
        }    
    }

 
    public function store() {
        $lessonModel = new LessonModel();
        $lesson_id = $lessonModel->addLesson(...);
        if (isset($_FILES['material'])) {
            $fileName = $_FILES['material']['name'];
            $fileTmp = $_FILES['material']['tmp_name'];
            $targetDir = "uploads/materials/";
            $targetFile = $targetDir . basename($fileName);
            if (move_uploaded_file($fileTmp, $targetFile)) {
                $materialModel = new MaterialModel(); 
                $materialModel->addMaterial($lesson_id, $fileName, $targetFile, 'pdf');
            }
        }
    }
    public function manage($course_id) {
        $lessonModel = new LessonModel();
        $lessons = $lessonModel->getLessonsByCourse($course_id);
        require_once 'views/instructor/manage_lessons.php';
    }
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lessonModel = new LessonModel();
            $lessonModel->updateLesson(
                $_POST['id'], 
                $_POST['title'], 
                $_POST['content'], 
                $_POST['video_url'], 
                $_POST['order']
            );
            header("Location: index.php?controller=Lesson&action=manage&course_id=" . $course_id);
            exit();
        }
    }
    public function delete($id, $course_id) {
        $lessonModel = new LessonModel();
        $lessonModel->deleteLesson($id);
        header("Location: index.php?controller=Lesson&action=manage&course_id=" . $course_id);
            exit();
    }
    public function deleteMaterial($material_id, $course_id) {
        $materialModel = new MaterialModel();
        $materialModel->deleteMaterial($material_id);
       header("Location: index.php?controller=Lesson&action=manage&course_id=" . $course_id);
            exit();
    }
    
    
   }

?>