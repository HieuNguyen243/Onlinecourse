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
            $currentLesson['completed'] = $this->lessonModel->isLessonCompleted($student_id, $lesson_id);
            foreach ($listLessons as &$l) {
                $l['completed'] = $this->lessonModel->isLessonCompleted($student_id, $l['id']);
                $l['is_current'] = ($l['id'] == $lesson_id);
            }
            unset($l);
            $next_lesson_id = null;
            $foundCurrent = false;
            foreach ($listLessons as $item) {
                if ($foundCurrent) {
                    $next_lesson_id = $item['id'];
                    break;
                }
                if ($item['id'] == $lesson_id) {
                    $foundCurrent = true;
                }
            }

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

            header("Location: index.php?controller=lesson&action=detail&course_id=$course_id&lesson_id=$lesson_id");            exit();
        }    
    }

    // Đã sửa: Sử dụng Model đã có PDO và xử lý logic POST/FILE
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
            $course_id = $_POST['course_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $video_url = $_POST['video_url'];
            $order = $_POST['order'];

            $lesson_id = $this->lessonModel->addLesson($course_id, $title, $content, $video_url, $order);
            
            if ($lesson_id && isset($_FILES['material']) && $_FILES['material']['error'] === 0) {
                $fileName = $_FILES['material']['name'];
                $fileTmp = $_FILES['material']['tmp_name'];
                $targetDir = "uploads/materials/";
                // Tạo thư mục nếu chưa tồn tại
                if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
                $targetFile = $targetDir . basename($fileName);

                if (move_uploaded_file($fileTmp, $targetFile)) {
                    $this->materialModel->addMaterial($lesson_id, $fileName, $targetFile, 'pdf');
                }
            }
            
            header("Location: index.php?controller=Lesson&action=manage&course_id=" . urlencode($course_id));
            exit();
        }
    }
    
    // Đã thêm: Phương thức hiển thị form tạo bài học mới
    public function create() {
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        if (!$course_id) {
            header("Location: index.php?controller=instructor&action=index");
            exit();
        }
        require_once 'views/instructor/add_lesson.php';
    }

    // Đã sửa: Sử dụng Model đã có PDO và lấy course_id
    public function manage() {
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        if (!$course_id) { 
            // Nếu không có course_id, chuyển hướng về dashboard giảng viên
            header("Location: index.php?controller=Instructor&action=index");
            exit();
        }
        $lessons = $this->lessonModel->getLessonsByCourse($course_id);
        
        // Lấy tài liệu cho từng bài học để hiển thị trong view manage_lessons.php
        foreach ($lessons as &$lesson) {
            $lesson['materials'] = $this->materialModel->getMaterialsByLesson($lesson['id']);
        }
        unset($lesson); 
        
        require_once 'views/instructor/manage_lessons.php';
    }

    // Đã thêm action edit để hiển thị form chỉnh sửa
    public function edit() {
        if (isset($_GET['id']) && isset($_GET['course_id'])) {
            $lesson = $this->lessonModel->getLessonById($_GET['id']);
            $course_id = $_GET['course_id'];
            if (!$lesson) {
                // Có thể chuyển hướng về trang quản lý nếu bài học không tồn tại
                header("Location: index.php?controller=Lesson&action=manage&course_id=" . urlencode($course_id));
                exit();
            }
            require_once 'views/instructor/edit_lesson.php';
        } else {
            header("Location: index.php?controller=instructor&action=index");
            exit();
        }
    }

    // Đã sửa: Sử dụng Model đã có PDO và xử lý logic POST/GET
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $course_id = $_POST['course_id'] ?? null;
            if (!$course_id) {
                 header("Location: index.php?controller=instructor&action=index");
                 exit();
            }
            $this->lessonModel->updateLesson(
                $_POST['id'], 
                $_POST['title'], 
                $_POST['content'], 
                $_POST['video_url'], 
                $_POST['order']
            );
            
            // Xử lý upload tài liệu mới (nếu có)
            if (isset($_FILES['material']) && $_FILES['material']['error'] === 0) {
                 $lesson_id = $_POST['id'];
                 $fileName = $_FILES['material']['name'];
                 $fileTmp = $_FILES['material']['tmp_name'];
                 $targetDir = "uploads/materials/";
                 if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
                 $targetFile = $targetDir . basename($fileName);

                 if (move_uploaded_file($fileTmp, $targetFile)) {
                     $this->materialModel->addMaterial($lesson_id, $fileName, $targetFile, 'pdf');
                 }
            }
            
            header("Location: index.php?controller=Lesson&action=manage&course_id=" . urlencode($course_id));
            exit();
        }
        // Nếu là GET request đến action=update mà không có id, chuyển hướng về index
        header("Location: index.php?controller=instructor&action=index");
        exit();
    }
    
    // Đã sửa: Sử dụng Model đã có PDO và lấy course_id
    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        if ($id && $course_id) {
            $this->lessonModel->deleteLesson($id);
            header("Location: index.php?controller=Lesson&action=manage&course_id=" . urlencode($course_id));
            exit();
        }
        header("Location: index.php?controller=instructor&action=index");
        exit();
    }
    
    // Đã sửa: Sử dụng Model đã có PDO và lấy course_id
    public function deleteMaterial() {
        $material_id = isset($_GET['material_id']) ? $_GET['material_id'] : null;
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        if ($material_id && $course_id) {
            $this->materialModel->deleteMaterial($material_id);
            header("Location: index.php?controller=Lesson&action=manage&course_id=" . urlencode($course_id));
            exit();
        }
        header("Location: index.php?controller=instructor&action=index");
        exit();
    }
}
?>