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
        if $stmt->execute([$student_id, $course_id]) {
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

    
}