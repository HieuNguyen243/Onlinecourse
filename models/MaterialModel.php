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

    // NN
    public function addMaterial($lesson_id, $file_name, $file_path, $file_type) {
        $sql = "INSERT INTO materials (lesson_id, file_name, file_path, file_type) VALUES (?, ?, ?, ?)";
        return $this->execute($sql, [$lesson_id, $file_name, $file_path, $file_type]);
    }

    // Xóa tài liệu 
    public function deleteMaterial($id) {
        $sqlGet = "SELECT file_path FROM materials WHERE id = ?";
        $material = $this->selectOne($sqlGet, [$id]); 
        if ($material && file_exists($material['file_path'])) {
            unlink($material['file_path']); 
        }
        $sqlDel = "DELETE FROM materials WHERE id = ?";
        return $this->execute($sqlDel, [$id]);
    }
}