<?php require __DIR__ . '/../layouts/header.php'; ?>

<?php
$lesson = isset($lesson) ? $lesson : [];
$course_id = isset($course_id) ? $course_id : (isset($_GET['course_id']) ? $_GET['course_id'] : '');
?>

<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Sửa Bài Học (ID: <?php echo htmlspecialchars($lesson['id'] ?? 'N/A'); ?>)</h2>

        <form action="index.php?controller=Lesson&action=update" method="post" enctype="multipart/form-data" class="space-y-5">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($lesson['id'] ?? ''); ?>">
            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
            
            <div class="input-group">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề bài học</label>
                <input type="text" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="title" name="title" value="<?php echo htmlspecialchars($lesson['title'] ?? ''); ?>" required>
            </div>

            <div class="input-group">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung (Text/HTML)</label>
                <textarea class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="content" name="content" rows="6"><?php echo htmlspecialchars($lesson['content'] ?? ''); ?></textarea>
            </div>

            <div class="input-group">
                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1">Video URL (Embed Code)</label>
                <input type="text" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="video_url" name="video_url" value="<?php echo htmlspecialchars($lesson['video_url'] ?? ''); ?>">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="input-group">
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Thứ tự bài học</label>
                    <input type="number" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="order" name="order" value="<?php echo htmlspecialchars($lesson['order'] ?? 0); ?>" min="0">
                </div>
                <div class="input-group">
                    <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Tải lên tài liệu mới (nếu muốn thay thế)</label>
                    <input type="file" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="material" name="material" accept="application/pdf">
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-4">
                <a href="index.php?controller=Lesson&action=manage&course_id=<?php echo htmlspecialchars($course_id); ?>" class="btn bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-lg font-medium transition">
                    <i class="fas fa-arrow-left mr-2"></i> Hủy
                </a>
                <button type="submit" class="btn bg-blue-600 text-white hover:bg-blue-700 px-6 py-2 rounded-lg font-bold transition shadow-lg shadow-blue-200">
                    <i class="fas fa-sync-alt mr-2"></i> Cập Nhật
                </button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>