
<?php
require_once __DIR__ . '/../models/CourseModel.php';
require_once __DIR__ . '/../models/EnrollmentModel.php';
require_once __DIR__ . '/../models/LessonModel.php';
require_once __DIR__ . '/../models/MaterialModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
class InstructorController {
    protected $pdo;

    public function __construct($pdo = null) {
        $this->pdo = $pdo;
    }

    public function index() {
        $courses = [];
        if ($this->pdo && isset($_SESSION['user_id'])) {
            $courseModel = new CourseModel($this->pdo);
            $courses = $courseModel->getCoursesByInstructor($_SESSION['user_id']);
        }
        require_once __DIR__ . '/../views/instructor/dashboard.php';
    }
    
    public function dashboard() {
        $this->index(); 
    }

    public function createCourse() {
        $categoryModel = new CategoryModel($this->pdo);
        $categories = $categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/instructor/create_course.php';
    }

    public function storeCourse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
            $courseModel = new CourseModel($this->pdo);
            
            // 1. Lấy dữ liệu khóa học
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $price = $_POST['price'] ?? 0;
            $duration_weeks = $_POST['duration_weeks'] ?? 0;
            $level = $_POST['level'] ?? 'Beginner';
            $instructor_id = $_SESSION['user_id'] ?? null;
            
            if (!$instructor_id) {
                header("Location: index.php?controller=auth&action=login");
                exit();
            }

            // Xử lý ảnh khóa học
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "uploads/courses/";
                if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            // 2. Tạo khóa học & lấy ID
            $newCourseId = $courseModel->createCourse(
                $title, $description, $instructor_id, $category_id, 
                $price, $duration_weeks, $level, $imagePath
            );

            if ($newCourseId) {
                // 3. [MỚI] Xử lý mảng các bài học
                if (isset($_POST['lessons']) && is_array($_POST['lessons'])) {
                    $lessonModel = new LessonModel($this->pdo);
                    $orderCounter = 1; // Biến đếm để set thứ tự bài học
                    
                    foreach ($_POST['lessons'] as $lesson) {
                        // Lấy dữ liệu từ từng item trong mảng
                        $l_title = $lesson['title'] ?? '';
                        $l_video = $lesson['video_url'] ?? '';
                        $l_content = $lesson['content'] ?? '';
                        
                        // Chỉ thêm nếu có tiêu đề
                        if (!empty($l_title)) {
                            $lessonModel->addLesson(
                                $newCourseId,       // ID khóa học
                                $l_title, 
                                $l_content, 
                                $l_video, 
                                $orderCounter++     // Tự động tăng thứ tự: 1, 2, 3...
                            );
                        }
                    }
                }

                // Chuyển hướng về trang quản lý bài học
                header("Location: index.php?controller=Lesson&action=manage&course_id=" . $newCourseId);
                exit();
            } else {
                $error = "Lỗi: Không thể tạo khóa học.";
                $categoryModel = new CategoryModel($this->pdo);
                $categories = $categoryModel->getAllCategories();
                require_once __DIR__ . '/../views/instructor/create_course.php';
            }
        }
        
        // Load view (GET request)
        $categoryModel = new CategoryModel($this->pdo);
        $categories = $categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/instructor/create_course.php';
    }
    


    public function viewStudents() {
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        if (!$course_id) {
            header("Location: index.php?controller=instructor&action=index");
            exit();
        }
        $enrollmentModel = new EnrollmentModel($this->pdo);
        $students = $enrollmentModel->getStudentsByCourse($course_id);
        require_once __DIR__ . '/../views/instructor/student_list.php';
    }

    public function editCourse() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) { die("Thiếu ID khóa học"); }

        $courseModel = new CourseModel($this->pdo);
        $course = $courseModel->getCourseById($id);
        
        // Kiểm tra quyền sở hữu
        if (!$course || $course['instructor_id'] != $_SESSION['user_id']) {
            die("Bạn không có quyền sửa khóa học này hoặc khóa học không tồn tại");
        }

        // Lấy danh mục
        $categoryModel = new CategoryModel($this->pdo);
        $categories = $categoryModel->getAllCategories();

        // [MỚI] Lấy danh sách bài học hiện tại để hiển thị
        $lessonModel = new LessonModel($this->pdo);
        $lessons = $lessonModel->getLessonsByCourse($id);

        require_once __DIR__ . '/../views/instructor/edit_course.php';
    }

    public function updateCourse() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $courseModel = new CourseModel($this->pdo);
            $lessonModel = new LessonModel($this->pdo);

            // 1. CẬP NHẬT THÔNG TIN KHÓA HỌC
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $duration_weeks = $_POST['duration_weeks'];
            $level = $_POST['level'];

            $imagePath = null;
            // Giữ lại ảnh cũ nếu không up ảnh mới
            // Logic: Nếu model updateCourse nhận null thì nó không update cột image
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "uploads/courses/";
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            $courseModel->updateCourse($id, $title, $description, $category_id, $price, $duration_weeks, $level, $imagePath);

            // 2. XỬ LÝ BÀI HỌC (Logic Đồng bộ hóa)
            // Lấy danh sách ID bài học hiện có trong DB
            $currentLessons = $lessonModel->getLessonsByCourse($id);
            $currentIds = array_column($currentLessons, 'id');
            
            $submittedLessons = isset($_POST['lessons']) ? $_POST['lessons'] : [];
            $submittedIds = [];

            $orderCounter = 1;

            if (!empty($submittedLessons)) {
                foreach ($submittedLessons as $l) {
                    $l_title = $l['title'];
                    $l_video = $l['video_url'];
                    $l_content = $l['content'];
                    $l_id = isset($l['id']) ? $l['id'] : null;

                    if ($l_id && in_array($l_id, $currentIds)) {
                        // A. Cập nhật bài học cũ
                        $lessonModel->updateLesson($l_id, $l_title, $l_content, $l_video, $orderCounter++);
                        $submittedIds[] = $l_id; // Đánh dấu là đã được xử lý (không bị xóa)
                    } else {
                        // B. Thêm bài học mới (nếu không có ID)
                        $lessonModel->addLesson($id, $l_title, $l_content, $l_video, $orderCounter++);
                    }
                }
            }

            // C. Xóa các bài học đã bị loại bỏ khỏi giao diện
            // Những ID có trong DB ($currentIds) nhưng không có trong form gửi lên ($submittedIds) sẽ bị xóa
            $idsToDelete = array_diff($currentIds, $submittedIds);
            foreach ($idsToDelete as $delId) {
                $lessonModel->deleteLesson($delId);
            }

            header('Location: index.php?controller=Instructor&action=index');
            exit();
        }
        
        // Nếu không phải POST, quay về trang edit
        $this->editCourse();
    }

    public function progress() {
        $courses = [];
        $students = [];
        
        if ($this->pdo && isset($_SESSION['user_id'])) {
            $courseModel = new CourseModel($this->pdo);
            $courses = $courseModel->getCoursesByInstructor($_SESSION['user_id']);
            
            if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
                $enrollmentModel = new EnrollmentModel($this->pdo);
                $students = $enrollmentModel->getStudentsByCourse($_GET['course_id']);
            }
        }
        require_once __DIR__ . '/../views/instructor/progress.php';
    }

    public function deleteCourse() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            header('Location: index.php?controller=Instructor&action=index');
            exit();
        }
        $courseModel = new CourseModel($this->pdo);
        $courseModel->deleteCourse($id);
        header('Location: index.php?controller=Instructor&action=index');
        exit();
    }
}