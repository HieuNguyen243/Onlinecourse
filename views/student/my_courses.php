<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Khóa học của tôi</h2>
    <?php if (!empty($enrolledCourses)): ?>
        <div class="row">
            <?php foreach ($enrolledCourses as $course): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                            <p class="text-muted">Tiến độ: <?php echo htmlspecialchars($course['progress']); ?>%</p>
                            <a href="#" class="btn btn-primary">Tiếp tục học</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Bạn chưa có khóa học nào.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
