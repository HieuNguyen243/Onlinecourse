<?php require __DIR__ . '/../layouts/header.php'; ?>

<?php
$course_id = isset($course_id) ? $course_id : (isset($_GET['course_id']) ? $_GET['course_id'] : '');
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <h2>Thêm bài học mới</h2>

        <form action="index.php?controller=Lesson&action=store" method="post" enctype="multipart/form-data" class="mt-3">
            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
            
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea class="form-control" id="content" name="content" rows="6"></textarea>
            </div>

            <div class="mb-3">
                <label for="video_url" class="form-label">Video URL</label>
                <input type="text" class="form-control" id="video_url" name="video_url">
            </div>

            <div class="mb-3">
                <label for="order" class="form-label">Thứ tự</label>
                <input type="number" class="form-control" id="order" name="order" value="0">
            </div>

            <div class="mb-3">
                <label for="material" class="form-label">Tải lên tài liệu (PDF)</label>
                <input type="file" class="form-control" id="material" name="material" accept="application/pdf">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="index.php?controller=Lesson&action=manage&course_id=<?php echo htmlspecialchars($course_id); ?>" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
