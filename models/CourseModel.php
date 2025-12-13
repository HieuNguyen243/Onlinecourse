<?php 
class CourseModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCourses() {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                ORDER BY c.created_at DESC";
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
        $sql = "SELECT c.*, e.progress, e.status as enrollment_status 
                FROM courses c 
                JOIN enrollments e ON c.id = e.course_id 
                WHERE e.student_id = ?";
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

    public function countAll() {
        $query = "SELECT COUNT(*) FROM courses";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getCoursesByStatus($status) {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name,
                (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.id) as student_count
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.status = ?
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($courseId, $status) {
        $sql = "UPDATE courses SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $courseId]);
    }

    public function getCoursesByInstructorId($instructorId) {
        $sql = "SELECT * FROM courses WHERE instructor_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$instructorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}