<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="hero bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4">Nền tảng khóa học trực tuyến</h1>
                <p class="lead">Chia sẻ kiến thức và tạo khóa học của riêng bạn</p>
                <a href="index.php?controller=Instructor&action=index" class="btn btn-primary btn-lg">Đi tới bảng điều khiển giảng viên</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h3 class="mb-4">Khóa học có sẵn</h3>
        
        <?php if (!empty($allcourses)): ?>
            <div class="row">
                <?php foreach ($allcourses as $course): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($course['title'] ?? $course['name'] ?? 'Không tên'); ?>
                                </h5>
                                <p class="card-text text-muted small">
                                    <?php echo htmlspecialchars(substr($course['description'] ?? '', 0, 80)); ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info">
                                        <?php echo number_format($course['price'] ?? 0, 0, ',', '.'); ?> VND
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Chưa có khóa học nào được tạo.
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

