<?php
class LessonModel {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function getLessonsByCourse($course_id) {
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY `order` ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function isLessonCompleted($student_id, $lesson_id) {
        $sql = "SELECT count(*) FROM lesson_completions lc
                JOIN enrollments e ON lc.enrollment_id = e.id
                WHERE e.student_id = ? AND lc.lesson_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id, $lesson_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function markAsDone($student_id, $course_id, $lesson_id){
        
        $sqlId = "SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?";
        $stmtId = $this->pdo->prepare($sqlId);
        $stmtId->execute([$student_id, $course_id]);
        $enrollment = $stmtId->fetch(PDO::FETCH_ASSOC);

        if ($enrollment) {
            $sql = "INSERT IGNORE INTO lesson_completions (enrollment_id, lesson_id) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$enrollment['id'], $lesson_id]);
        }
        return false;
    }
    
    
    public function countLessons($course_id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM lessons WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetchColumn();
    }
    
    
    public function countCompleted($student_id, $course_id) {
        $sql = "SELECT COUNT(*) FROM lesson_completions lc 
                JOIN enrollments e ON lc.enrollment_id = e.id 
                WHERE e.student_id = ? AND e.course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id, $course_id]);
        return $stmt->fetchColumn();
    }
}
?>