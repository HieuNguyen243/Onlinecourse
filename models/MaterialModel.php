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

    public function addMaterial($lesson_id, $file_name, $file_path, $file_type) {
        $sql = "INSERT INTO materials (lesson_id, file_name, file_path, file_type) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$lesson_id, $file_name, $file_path, $file_type]);
    }

    public function deleteMaterial($id) {
        $sqlGet = "SELECT file_path FROM materials WHERE id = ?";
        
        $stmtGet = $this->pdo->prepare($sqlGet);
        $stmtGet->execute([$id]);
        $material = $stmtGet->fetch(PDO::FETCH_ASSOC); 
        
        if ($material && file_exists($material['file_path'])) {
            unlink($material['file_path']); 
        }
        $sqlDel = "DELETE FROM materials WHERE id = ?";
        $stmtDel = $this->pdo->prepare($sqlDel);
        return $stmtDel->execute([$id]);
    }
}
?>