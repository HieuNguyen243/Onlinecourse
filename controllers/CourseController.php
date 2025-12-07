<?php
require_once './models/CourseModel.php';
require_once './models/LessonModel.php';
require_once './models/MaterialModel.php';

class CourseController {
    private $courseModel;
    private $lessonModel;
    private $materialModel;

    public function __construct($pdo) {
        $this->courseModel = new CourseModel($pdo);
        $this->lessonModel = new LessonModel($pdo);
        $this->materialModel = new MaterialModel($pdo);
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
// CRUD KHGV
// Lưu khóa học mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $teacher_id = $_SESSION['user']['id']; // Lấy từ session login
            
            $image = "";
            if (isset($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
            }
            
            $this->courseModel->createCourse($name, $desc, $price, $image, $teacher_id);
            header("Location: index.php?act=list_course");
        }
    }

    // Xóa khóa học
    public function delete() {
        if (isset($_GET['id'])) {
            $this->courseModel->deleteCourse($_GET['id']);
            header("Location: index.php?act=list_course");
        }
    }
    public function edit() {
        if (isset($_GET['id'])) {
            $course = $this->courseModel->getCourseById($_GET['id']);
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $desc = $_POST['description'];
                $price = $_POST['price'];
                $image = $course['image'];
                if (!empty($_FILES['image']['name'])) {
                    $image = $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
                }
                
                $this->courseModel->updateCourse($_GET['id'], $name, $desc, $price, $image);
                header("Location: index.php?act=list_course");
            } 
            require_once './views/courses/edit.php'; 
        }
    }

    // Gv: Danh sách khóa học của giảng viên
    public function listCourses() {
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'teacher') {
            $teacher_id = $_SESSION['user']['id'];
            $allcourses = $this->courseModel->getCoursesByTeacher($teacher_id);
            require './views/course/teacher_courses.php';
        } else {
            header("Location: index.php?act=login");
        }
    }

    // Gv: Quản lý bài học
    public function manageLessons() {
        if (isset($_GET['course_id']) && isset($_SESSION['user']) && $_SESSION['user']['role'] == 'teacher') {
            $course_id = $_GET['course_id'];
            if ($this->courseModel->isTeacherOwnsCourse($course_id, $_SESSION['user']['id'])) {
                $lessons = $this->lessonModel->getLessonsByCourse($course_id);
                require './views/course/manage_lessons.php';
            }
        }
    }

    // Gv: Tạo bài học
    public function createLesson() {
        if (isset($_GET['course_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $course_id = $_GET['course_id'];
            if ($this->courseModel->isTeacherOwnsCourse($course_id, $_SESSION['user']['id'])) {
                $this->lessonModel->createLesson(
                    $course_id,
                    $_POST['title'],
                    $_POST['content'],
                    $_POST['video_url'] ?? '',
                    $_POST['lesson_order'] ?? 1
                );
                header("Location: index.php?act=manage_lessons&course_id=$course_id");
            }
        }
    }

    // Gv: Chỉnh sửa bài học
    public function editLesson() {
        if (isset($_GET['lesson_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->lessonModel->updateLesson(
                $_GET['lesson_id'],
                $_POST['title'],
                $_POST['content'],
                $_POST['video_url'] ?? '',
                $_POST['lesson_order'] ?? 1
            );
            $lesson = $this->lessonModel->getLessonById($_GET['lesson_id']);
            header("Location: index.php?act=manage_lessons&course_id=" . $lesson['course_id']);
        }
    }

    // Gv: Xóa bài học
    public function deleteLesson() {
        if (isset($_GET['lesson_id'])) {
            $lesson = $this->lessonModel->getLessonById($_GET['lesson_id']);
            $this->lessonModel->deleteLesson($_GET['lesson_id']);
            header("Location: index.php?act=manage_lessons&course_id=" . $lesson['course_id']);
        }
    }

    // Gv: Đăng tải tài liệu
    public function uploadMaterial() {
        if (isset($_GET['lesson_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $lesson_id = $_GET['lesson_id'];
            if (isset($_FILES['material'])) {
                $file = $_FILES['material'];
                $file_name = $file['name'];
                $file_path = "uploads/materials/" . basename($file_name);
                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    $this->materialModel->uploadMaterial($lesson_id, $file_name, $file_path, $file['type']);
                }
            }
            header("Location: index.php?act=manage_lessons&course_id=" . $_GET['course_id']);
        }
    }

    // Gv: Xóa tài liệu
    public function deleteMaterial() {
        if (isset($_GET['material_id'])) {
            $material = $this->materialModel->getMaterialById($_GET['material_id']);
            $this->materialModel->deleteMaterial($_GET['material_id']);
            header("Location: index.php?act=manage_lessons&course_id=" . $_GET['course_id']);
        }
    }
}
?>