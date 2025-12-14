<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Tạo Khóa Học Mới</h3>
        
        <?php if(isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=Instructor&action=storeCourse" method="post" enctype="multipart/form-data" class="space-y-6">
            
            <div class="space-y-4">
                <h4 class="font-bold text-gray-700 uppercase text-sm tracking-wider border-l-4 border-purple-500 pl-2">Thông tin chung</h4>
                
                <div class="input-group">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề khóa học <span class="text-red-500">*</span></label>
                    <input type="text" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" 
                           id="title" name="title" required placeholder="Ví dụ: Lập trình PHP với mô hình MVC">
                </div>
                
                <div class="input-group">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả chi tiết <span class="text-red-500">*</span></label>
                    <textarea class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" 
                              id="description" name="description" rows="5" required placeholder="Giới thiệu về nội dung, mục tiêu và đối tượng của khóa học..."></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="input-group">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục <span class="text-red-500">*</span></label>
                    <select class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" id="category_id" name="category_id" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['id']); ?>">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Học phí (VND)</label>
                    <input type="number" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" 
                           id="price" name="price" min="0" value="0" placeholder="Nhập 0 để miễn phí">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="input-group">
                    <label for="duration_weeks" class="block text-sm font-medium text-gray-700 mb-1">Thời lượng (Tuần)</label>
                    <input type="number" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" 
                           id="duration_weeks" name="duration_weeks" min="1" value="4">
                </div>
                <div class="input-group">
                    <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Trình độ</label>
                    <select class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" id="level" name="level">
                        <option value="Beginner">Cơ bản (Beginner)</option>
                        <option value="Intermediate">Trung cấp (Intermediate)</option>
                        <option value="Advanced">Nâng cao (Advanced)</option>
                    </select>
                </div>
                 <div class="input-group">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Ảnh bìa khóa học</label>
                    <input type="file" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition bg-white" 
                           id="image" name="image" accept="image/*">
                </div>
            </div>

            <div class="border-t-2 border-dashed border-gray-200 pt-6 mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="flex items-center text-lg font-bold text-gray-800">
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2 text-purple-600">
                            <i class="fas fa-list-ol"></i>
                        </div>
                        Nội dung bài học
                    </h4>
                    <button type="button" onclick="addLesson()" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-4 py-2 rounded-lg text-sm font-bold transition">
                        <i class="fas fa-plus mr-1"></i> Thêm bài học
                    </button>
                </div>
                
                <div id="lessons-container" class="space-y-4">
                    </div>
            </div>
            
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="index.php?controller=Instructor&action=index" class="btn bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 px-6 py-3 rounded-lg font-medium transition">
                    Hủy bỏ
                </a>
                <button type="submit" class="btn bg-purple-600 text-white hover:bg-purple-700 px-8 py-3 rounded-lg font-bold transition shadow-lg shadow-purple-200 flex items-center">
                    <i class="fas fa-save mr-2"></i> Lưu Khóa Học
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let lessonCount = 0;

function addLesson() {
    lessonCount++;
    const container = document.getElementById('lessons-container');
    
    const html = `
    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 relative lesson-item group transition hover:border-purple-300">
        <span class="absolute top-4 right-4 text-xs font-bold text-gray-400 bg-white px-2 py-1 rounded border">Bài ${lessonCount}</span>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Tiêu đề bài học</label>
                <input type="text" name="lessons[${lessonCount}][title]" class="w-full p-2 border border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500 text-sm" placeholder="Nhập tên bài học" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Video URL (Embed)</label>
                <input type="text" name="lessons[${lessonCount}][video_url]" class="w-full p-2 border border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500 text-sm" placeholder="Link nhúng Youtube...">
            </div>
        </div>
        
        <div>
            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Nội dung / Mô tả</label>
            <textarea name="lessons[${lessonCount}][content]" rows="2" class="w-full p-2 border border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500 text-sm" placeholder="Tóm tắt nội dung bài học..."></textarea>
        </div>
        
        <button type="button" onclick="this.parentElement.remove()" class="mt-3 text-red-500 text-xs hover:text-red-700 font-medium">
            <i class="fas fa-trash-alt mr-1"></i> Xóa bài này
        </button>
    </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
}

// Tự động thêm 1 bài học trống khi load trang
document.addEventListener('DOMContentLoaded', () => {
    addLesson();
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>