<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="mb-4">
                    <span class="badge bg-light text-primary mb-3">
                        <i class="fas fa-rocket"></i> Khởi động tương lai của bạn
                    </span>
                </div>
                <h1>
                    Học kỹ năng mới,<br>
                    <strong class="text-primary">Mở lối thành công</strong>
                </h1>
                <p class="lead mt-4">
                    Truy cập hơn 5,000 khóa học từ lập trình, thiết kế đến kinh doanh. Học mọi lúc, mọi nơi với các chuyên gia hàng đầu.
                </p>
                
                <div class="search-section mt-5">
                    <div class="input-group" style="max-width: 500px;">
                        <input type="text" class="form-control search-input" placeholder="Bạn muốn học gì hôm nay?" aria-label="Search courses">
                        <button class="btn search-btn" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="mt-4">
                    <span class="me-3">
                        <i class="fas fa-check-circle text-success"></i> Học trọn đời
                    </span>
                    <span>
                        <i class="fas fa-check-circle text-success"></i> Cấp chức chỉ
                    </span>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/svgs/laptop.svg" alt="Learning" style="width: 100%; max-width: 400px;">
            </div>
        </div>
    </div>
</section>

<section class="course-section">
    <div class="container">
        <h3 class="mb-4">Khóa học có sẵn</h3>
        
        <?php if (!empty($allcourses)): ?>
            <div class="row">
                <?php foreach ($allcourses as $course): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($course['title'] ?? $course['name'] ?? 'Không tên'); ?>
                                </h5>
                                <p class="card-text text-muted small">
                                    <?php echo htmlspecialchars(substr($course['description'] ?? '', 0, 80)); ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="badge bg-info">
                                        <?php echo number_format($course['price'] ?? 0, 0, ',', '.'); ?> VND
                                    </span>
                                    <a href="index.php?controller=Course&action=detail&id=<?php echo $course['id']; ?>" class="btn btn-sm btn-primary">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Chưa có khóa học nào được tạo.
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

