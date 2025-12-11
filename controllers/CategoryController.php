<?php
class CategoryController {
	protected $db;
	public function __construct($db = null) {
		$this->db = $db; // nếu HomeController truyền PDO thì sẽ nhận vào
	}
	// Thêm các method thật sau này. Hiện tại để tránh lỗi "class not found"

	// Trả về mảng categories. Hàm tĩnh để khớp với gọi CategoryController::getAllCategories()
	public static function getAllCategories() {
		// cố gắng nạp model nếu tồn tại
		$modelPath = __DIR__ . '/../models/CategoryModel.php';
		if (file_exists($modelPath)) {
			require_once $modelPath;
		}

		// nếu model tồn tại và có method phù hợp thì gọi
		if (class_exists('CategoryModel')) {
			$model = new CategoryModel();

			if (method_exists($model, 'getAllCategories')) {
				return $model->getAllCategories();
			}
			if (method_exists($model, 'getAll')) {
				return $model->getAll();
			}
			if (method_exists($model, 'all')) {
				return $model->all();
			}
			if (method_exists($model, 'fetchAll')) {
				return $model->fetchAll();
			}
		}

		// fallback: trả mảng rỗng nếu không tìm được
		return [];
	}
}