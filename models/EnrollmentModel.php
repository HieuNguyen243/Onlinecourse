<?php
class EnrollmentModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function checkEnrollment($student_id, $course_id) {
        $sql = "SELECT COUNT(*) FROM enrollments WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id, $course_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function register($student_id, $course_id) {
        $sql = "INSERT INTO enrollments (student_id, course_id, enrolled_date, status, progress) VALUES (?, ?, NOW(), 'active', 0)";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute([$student_id, $course_id])) {
            return true;
        } else {
            return false;
        }
    }

    public function updateStatus($student_id, $course_id, $status) {
        $sql = "UPDATE enrollments SET status = ? WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $student_id, $course_id]);
    }
    // Giang vien
    public function getCourseProgress($course_id) {
        $sql = "SELECT 
                    u.id,
                    u.fullname, 
                    u.email, 
                    e.enrolled_date, 
                    e.progress, 
                    e.status 
                FROM enrollments e 
                JOIN users u ON e.student_id = u.id 
                WHERE e.course_id = ? ORDER BY e.progress DESC";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Gv: Lấy danh sách học viên đã đăng ký
    public function getEnrolledStudents($course_id) {
        $sql = "SELECT u.id, u.fullname, u.email, e.enrolled_date, e.status, e.progress 
                FROM enrollments e 
                JOIN users u ON e.student_id = u.id 
                WHERE e.course_id = ? ORDER BY e.enrolled_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Gv: Theo dõi tiến độ từng học viên
    public function getStudentProgress($student_id, $course_id) {
        $sql = "SELECT e.*, u.fullname, u.email 
                FROM enrollments e 
                JOIN users u ON e.student_id = u.id 
                WHERE e.student_id = ? AND e.course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id, $course_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Gv: Cập nhật tiến độ học viên
    public function updateProgress($student_id, $course_id, $progress) {
        $sql = "UPDATE enrollments SET progress = ? WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$progress, $student_id, $course_id]);
    }
}
?>