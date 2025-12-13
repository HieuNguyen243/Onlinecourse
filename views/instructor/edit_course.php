<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        <div class="flex justify-between items-center mb-6 border-b pb-3">
            <h3 class="text-2xl font-bold text-gray-900">Sửa Khóa Học</h3>
            <a href="index.php?controller=Instructor&action=index" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i> Đóng
            </a>
        </div>

        <form action="index.php?controller=Instructor&action=updateCourse" method="post" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($course['id']); ?>">

            <div class="space-y-4">
                <h4 class="font-bold text-gray-700 uppercase text-sm tracking-wider border-l-4 border-purple-500 pl-2">Thông tin chung</h4>
                
                <div class="input-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề khóa học</label>
                    <input type="text" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" 
                           name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
                </div>
                
                <div class="input-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả chi tiết</label>
                    <textarea class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" 
                              name="description" rows="5" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="input-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                    <select class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" name="category_id" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $course['category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Học phí (VND)</label>
                    <input type="number" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" 
                           name="price" min="0" value="<?php echo htmlspecialchars($course['price']); ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="input-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thời lượng (Tuần)</label>
                    <input type="number" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" 
                           name="duration_weeks" min="1" value="<?php echo htmlspecialchars($course['duration_weeks']); ?>">
                </div>
                <div class="input-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trình độ</label>
                    <select class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition" name="level">
                        <?php 
                            $levels = ['Beginner' => 'Cơ bản', 'Intermediate' => 'Trung cấp', 'Advanced' => 'Nâng cao'];
                            foreach($levels as $val => $label):
                        ?>
                            <option value="<?php echo $val; ?>" <?php echo ($course['level'] == $val) ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                 <div class="input-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh bìa (Tải lên để thay đổi)</label>
                    <?php if (!empty($course['image'])): ?>
                        <div class="mb-2"><img src="<?php echo htmlspecialchars($course['image']); ?>" class="h-16 w-24 object-cover rounded"></div>
                    <?php endif; ?>
                    <input type="file" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 transition bg-white" 
                           name="image" accept="image/*">
                </div>
            </div>

            <div class="border-t-2 border-dashed border-gray-200 pt-6 mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="flex items-center text-lg font-bold text-gray-800">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-2 text-blue-600">
                            <i class="fas fa-edit"></i>
                        </div>
                        Chỉnh sửa nội dung bài học
                    </h4>
                    <button type="button" onclick="addLesson()" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-4 py-2 rounded-lg text-sm font-bold transition">
                        <i class="fas fa-plus mr-1"></i> Thêm bài học mới
                    </button>
                </div>
                
                <div id="lessons-container" class="space-y-4">
                    <?php 
                    // Hiển thị các bài học ĐANG CÓ
                    if (!empty($lessons)): 
                        foreach($lessons as $index => $l):
                            $idx = $index + 1; // Index dùng cho Javascript
                    ?>
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 relative lesson-item group transition hover:border-blue-300">
                            <input type="hidden" name="lessons[<?php echo $idx; ?>][id]" value="<?php echo $l['id']; ?>">
                            
                            <span class="absolute top-4 right-4 text-xs font-bold text-gray-400 bg-white px-2 py-1 rounded border">Bài cũ #<?php echo $l['id']; ?></span>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Tiêu đề</label>
                                    <input type="text" name="lessons[<?php echo $idx; ?>][title]" value="<?php echo htmlspecialchars($l['title']); ?>" 
                                           class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Video URL</label>
                                    <input type="text" name="lessons[<?php echo $idx; ?>][video_url]" value="<?php echo htmlspecialchars($l['video_url']); ?>" 
                                           class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Nội dung</label>
                                <textarea name="lessons[<?php echo $idx; ?>][content]" rows="2" 
                                          class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 text-sm"><?php echo htmlspecialchars($l['content']); ?></textarea>
                            </div>
                            
                            <button type="button" onclick="this.parentElement.remove()" class="mt-3 text-red-500 text-xs hover:text-red-700 font-medium border border-red-200 bg-white px-3 py-1 rounded">
                                <i class="fas fa-trash-alt mr-1"></i> Xóa bài này (Sẽ mất vĩnh viễn sau khi Lưu)
                            </button>
                        </div>
                    <?php 
                        endforeach; 
                    endif; 
                    ?>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="index.php?controller=Instructor&action=index" class="btn bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 px-6 py-3 rounded-lg font-medium transition">
                    Hủy bỏ
                </a>
                <button type="submit" class="btn bg-blue-600 text-white hover:bg-blue-700 px-8 py-3 rounded-lg font-bold transition shadow-lg shadow-blue-200 flex items-center">
                    <i class="fas fa-save mr-2"></i> Lưu Cập Nhật
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Đếm số lượng bài hiện có để tạo index tiếp theo tránh trùng lặp
let lessonIndex = <?php echo !empty($lessons) ? count($lessons) + 1 : 1; ?>;

function addLesson() {
    lessonIndex++;
    const container = document.getElementById('lessons-container');
    
    // Template bài học mới (Không có input hidden ID)
    const html = `
    <div class="bg-green-50 p-5 rounded-xl border border-green-200 relative lesson-item group transition hover:border-green-400 mt-4">
        <span class="absolute top-4 right-4 text-xs font-bold text-green-600 bg-white px-2 py-1 rounded border border-green-200">Mới</span>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Tiêu đề bài học</label>
                <input type="text" name="lessons[${lessonIndex}][title]" class="w-full p-2 border border-gray-300 rounded focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Nhập tên bài học" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Video URL</label>
                <input type="text" name="lessons[${lessonIndex}][video_url]" class="w-full p-2 border border-gray-300 rounded focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Link video...">
            </div>
        </div>
        
        <div>
            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Nội dung / Mô tả</label>
            <textarea name="lessons[${lessonIndex}][content]" rows="2" class="w-full p-2 border border-gray-300 rounded focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Tóm tắt..."></textarea>
        </div>
        
        <button type="button" onclick="this.parentElement.remove()" class="mt-3 text-red-500 text-xs hover:text-red-700 font-medium">
            <i class="fas fa-times mr-1"></i> Hủy thêm bài này
        </button>
    </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
}
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>