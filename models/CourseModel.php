<?php 
class CourseModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCourses() {
        $sql = "SELECT * FROM courses";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function searchCourses($keyword) {
        $sql = "SELECT * FROM courses WHERE title LIKE ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseByCategory($category_id) {
        $sql = "SELECT * FROM courses WHERE category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEnrolledCourses($student_id) {
        $sql = "SELECT c.* FROM courses c 
                JOIN enrollments e ON c.id = e.course_id 
                WHERE e.student_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // CRUD khoa hoc GV
    public function createCourse($name, $desc, $price, $image, $teacher_id) {
        $sql = "INSERT INTO courses (name, description, price, image, teacher_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $desc, $price, $image, $teacher_id]);
    }

    public function updateCourse($id, $name, $desc, $price, $image) {
        $sql = "UPDATE courses SET name=?, description=?, price=?, image=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $desc, $price, $image, $id]);
    }

    public function deleteCourse($id) {
        $sql = "DELETE FROM courses WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function getCourseById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Gv: Lấy khóa học theo giảng viên
    public function getCoursesByTeacher($teacher_id) {
        $sql = "SELECT * FROM courses WHERE teacher_id = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$teacher_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Gv: Kiểm tra sở hữu khóa học
    public function isTeacherOwnsCourse($course_id, $teacher_id) {
        $sql = "SELECT id FROM courses WHERE id = ? AND teacher_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id, $teacher_id]);
        return $stmt->fetch() !== false;
    }

    // Gv: Cập nhật trạng thái khóa học
    public function updateCourseStatus($course_id, $status) {
        $sql = "UPDATE courses SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $course_id]);
    }
}
?>