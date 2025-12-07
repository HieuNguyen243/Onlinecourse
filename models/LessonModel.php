<?php
class LessonModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getLessonsByCourse($course_id) {
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY lesson_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Gv: Tạo bài học
    public function createLesson($course_id, $title, $content, $video_url, $lesson_order) {
        $sql = "INSERT INTO lessons (course_id, title, content, video_url, lesson_order, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$course_id, $title, $content, $video_url, $lesson_order]);
    }

    // Gv: Cập nhật bài học
    public function updateLesson($lesson_id, $title, $content, $video_url, $lesson_order) {
        $sql = "UPDATE lessons SET title = ?, content = ?, video_url = ?, lesson_order = ?, updated_at = NOW() 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $content, $video_url, $lesson_order, $lesson_id]);
    }

    // Gv: Xóa bài học
    public function deleteLesson($lesson_id) {
        $sql = "DELETE FROM lessons WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$lesson_id]);
    }

    // Gv: Lấy chi tiết bài học
    public function getLessonById($lesson_id) {
        $sql = "SELECT * FROM lessons WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>