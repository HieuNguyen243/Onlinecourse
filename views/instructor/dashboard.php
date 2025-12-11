<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <h2>Trang giảng viên</h2>
        <p>Chọn chức năng để quản lý khóa học và học viên.</p>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <div class="list-group">
            <a href="index.php?controller=Instructor&action=index" class="list-group-item list-group-item-action active">Dashboard</a>
            <a href="index.php?controller=Instructor&action=createCourse" class="list-group-item list-group-item-action">Tạo khóa học</a>
            <a href="index.php?controller=Instructor&action=index" class="list-group-item list-group-item-action">Chỉnh sửa / Xóa khóa học</a>
            <a href="index.php?controller=Lesson&action=manage" class="list-group-item list-group-item-action">Quản lý bài học</a>
            <a href="index.php?controller=Lesson&action=create" class="list-group-item list-group-item-action">Đăng tải tài liệu</a>
            <a href="index.php?controller=Instructor&action=index" class="list-group-item list-group-item-action">Xem danh sách học viên</a>
            <a href="index.php?controller=Instructor&action=progress" class="list-group-item list-group-item-action">Theo dõi tiến độ học viên</a>
        </div>
    </div>

    <div class="col-md-8">
        <h4>Khóa học của bạn</h4>
        <?php if (!empty($courses)): ?>
            <div class="row">
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-12 mb-2">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title"><?php echo htmlspecialchars($course['title'] ?? $course['name'] ?? 'Không tên'); ?></h5>
                                    <p class="mb-0 text-muted">ID: <?php echo htmlspecialchars($course['id'] ?? ''); ?></p>
                                </div>
                                <div>
                                    <a class="btn btn-sm btn-primary" href="index.php?controller=Instructor&action=editCourse&id=<?php echo urlencode($course['id']); ?>">Sửa</a>
                                    <a class="btn btn-sm btn-danger" href="index.php?controller=Instructor&action=deleteCourse&id=<?php echo urlencode($course['id']); ?>" onclick="return confirm('Xóa khóa học này?')">Xóa</a>
                                    <a class="btn btn-sm btn-secondary" href="index.php?controller=Lesson&action=manage&course_id=<?php echo urlencode($course['id']); ?>">Quản lý bài học</a>
                                    <a class="btn btn-sm btn-info" href="index.php?controller=Instructor&action=viewStudents&course_id=<?php echo urlencode($course['id']); ?>">Học viên</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Bạn chưa có khóa học nào.</p>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
