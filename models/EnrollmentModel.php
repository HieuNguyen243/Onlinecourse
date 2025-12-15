<?php
class EnrollmentModel {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

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
        }
        return false;
    }

    public function updateProgressDirect($student_id, $course_id, $percent) {
        $status = ($percent == 100) ? 'completed' : 'active';
        $sql = "UPDATE enrollments SET progress = ?, status = ? WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$percent, $status, $student_id, $course_id]);
    }
    
    public function getStudentsByCourse($course_id) {
        $sql = "SELECT u.fullname, u.email, e.enrolled_date, e.progress, e.status
                FROM enrollments e
                JOIN users u ON e.student_id = u.id
                WHERE e.course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
   

    public function countByStudentId($student_id) {
        $sql = "SELECT COUNT(*) FROM enrollments WHERE student_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchColumn();
    }
}
?>