<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Khóa học có sẵn</h2>
    <div class="row">
        <?php if (!empty($allCourses)): ?>
            <?php foreach ($allCourses as $course): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                            <p class="text-muted">Giảng viên: <?php echo htmlspecialchars($course['instructor_name']); ?></p>
                            <p class="text-muted">Danh mục: <?php echo htmlspecialchars($course['category_name']); ?></p>
                            <p class="text-primary">Giá: <?php echo number_format($course['price']); ?> VND</p>
                            <a href="#" class="btn btn-primary">Đăng ký</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có khóa học nào.</p>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
