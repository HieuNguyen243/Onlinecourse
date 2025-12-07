<?php
class MaterialModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getMaterialsByLesson($lesson_id) {
        $sql = "SELECT * FROM materials WHERE lesson_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}