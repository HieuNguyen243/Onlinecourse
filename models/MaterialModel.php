<?php
class MaterialModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getMaterialsByLesson($lesson_id) {
        $sql = "SELECT * FROM materials WHERE lesson_id = ? ORDER BY uploaded_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Gv: Đăng tải tài liệu
    public function uploadMaterial($lesson_id, $file_name, $file_path, $file_type) {
        $sql = "INSERT INTO materials (lesson_id, file_name, file_path, file_type, uploaded_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$lesson_id, $file_name, $file_path, $file_type]);
    }

    // Gv: Xóa tài liệu
    public function deleteMaterial($material_id) {
        $sql = "DELETE FROM materials WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$material_id]);
    }

    // Gv: Lấy chi tiết tài liệu
    public function getMaterialById($material_id) {
        $sql = "SELECT * FROM materials WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$material_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>