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

    public function getCoursesByInstructor($instructor_id) {
        $sql = "SELECT * FROM courses WHERE instructor_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCourse($title, $desc, $instructor_id, $cat_id, $price) {
        $sql = "INSERT INTO courses (title, description, instructor_id, category_id, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $desc, $instructor_id, $cat_id, $price]);
    }

    public function updateCourse($id, $title, $desc, $cat_id, $price) {
        $sql = "UPDATE courses SET title=?, description=?, category_id=?, price=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $desc, $cat_id, $price, $id]);
    }

    public function deleteCourse($id) {
        $sql = "DELETE FROM courses WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getCourseById($id) {
        $sql = "SELECT * FROM courses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}