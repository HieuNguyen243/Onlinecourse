<?php 
class CourseModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // [PUBLIC] Chỉ lấy khóa học ĐÃ DUYỆT để hiện thị cho người dùng
    public function getAllCourses() {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.status = 'approved' 
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function searchCourses($keyword) {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.title LIKE ? AND c.status = 'approved'"; // Chỉ tìm khóa đã duyệt
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseByCategory($category_id) {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE category_id = ? AND c.status = 'approved'"; // Chỉ lấy khóa đã duyệt
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [STUDENT] Lấy khóa học đã đăng ký (Không cần check status vì đã mua rồi thì phải học được)
    public function getEnrolledCourses($student_id) {
        $sql = "SELECT c.*, e.progress, e.status as enrollment_status, e.enrolled_date, u.fullname as instructor_name 
                FROM courses c 
                JOIN enrollments e ON c.id = e.course_id 
                LEFT JOIN users u ON c.instructor_id = u.id
                WHERE e.student_id = ?
                ORDER BY e.enrolled_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [INSTRUCTOR] Lấy danh sách khóa học của giảng viên (Lấy tất cả trạng thái để họ xem)
    public function getCoursesByInstructor($instructor_id) {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.instructor_id = ?
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [CREATE] Tạo khóa học mới -> Status mặc định là 'pending'
    public function createCourse($title, $description, $instructor_id, $category_id = null, $price = 0, $duration_weeks = 0, $level = 'Beginner', $image = null) {
        $sql = "INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, status, created_at) 
                VALUES (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image, 'pending', NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':instructor_id', $instructor_id);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':duration_weeks', $duration_weeks); // Mới
        $stmt->bindParam(':level', $level);                   // Mới
        $stmt->bindParam(':image', $image);
        
        if ($stmt->execute()) {
            return $this->pdo->lastInsertId(); // [THAY ĐỔI] Trả về ID khóa học mới
        }
        return false;
    }

    public function updateCourse($id, $title, $description, $category_id, $price, $duration_weeks, $level, $image = null) {
        // SQL cơ bản cập nhật các thông tin văn bản
        $sql = "UPDATE courses SET 
                    title = :title, 
                    description = :description, 
                    category_id = :category_id, 
                    price = :price, 
                    duration_weeks = :duration_weeks, 
                    level = :level";
        
        // Nếu có ảnh mới ($image không null), nối thêm câu lệnh update ảnh
        if ($image) {
            $sql .= ", image = :image";
        }

        $sql .= ", updated_at = NOW() WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':duration_weeks', $duration_weeks);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':id', $id);
        
        // Chỉ bind param image nếu có ảnh mới
        if ($image) {
            $stmt->bindParam(':image', $image);
        }

        return $stmt->execute();
    }

    public function deleteCourse($id) {
        $sql = "DELETE FROM courses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function isTeacherOwnsCourse($course_id, $instructor_id) {
        $sql = "SELECT COUNT(*) FROM courses WHERE id = ? AND instructor_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id, $instructor_id]);
        return $stmt->fetchColumn() > 0;
    }

    // --- [ADMIN FUNCTIONS] ---

    // Lấy danh sách khóa học đang chờ duyệt
    public function getPendingCourses() {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.status = 'pending'
                ORDER BY c.created_at ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Duyệt khóa học
    public function approveCourse($course_id) {
        $sql = "UPDATE courses SET status = 'approved' WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$course_id]);
    }

    // Từ chối khóa học
    public function rejectCourse($course_id) {
        $sql = "UPDATE courses SET status = 'rejected' WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$course_id]);
    }
}
?>