<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3>Tạo khóa học mới</h3>
        <form action="index.php?controller=Instructor&action=storeCourse" method="post" class="mt-3">
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề khóa học</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <input type="number" class="form-control" id="category_id" name="category_id" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá (VND)</label>
                <input type="number" class="form-control" id="price" name="price" min="0" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Tạo khóa học</button>
                <a href="index.php?controller=Instructor&action=index" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
