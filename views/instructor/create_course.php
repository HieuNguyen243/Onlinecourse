<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Tạo Khóa Học Mới</h3>
        
        <form action="index.php?controller=Instructor&action=storeCourse" method="post" class="space-y-5">
            
            <div class="input-group">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề khóa học</label>
                <input type="text" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="title" name="title" required placeholder="Ví dụ: Lập trình PHP với mô hình MVC">
            </div>
            
            <div class="input-group">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả chi tiết</label>
                <textarea class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="description" name="description" rows="6" required placeholder="Cung cấp cái nhìn tổng quan về khóa học, nội dung, và lợi ích"></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="input-group">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục (ID)</label>
                    <input type="number" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="category_id" name="category_id" required min="1" placeholder="Ví dụ: 1 (Lập trình)">
                </div>
                <div class="input-group">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Giá (VND)</label>
                    <input type="number" class="form-control w-full p-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" id="price" name="price" min="0" required placeholder="Nhập 0 cho khóa học miễn phí">
                </div>
            </div>
            
            <div class="flex justify-end space-x-4 pt-4">
                <a href="index.php?controller=Instructor&action=index" class="btn bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-2 rounded-lg font-medium transition">
                    Hủy
                </a>
                <button type="submit" class="btn bg-purple-600 text-white hover:bg-purple-700 px-6 py-2 rounded-lg font-bold transition shadow-lg shadow-purple-200">
                    <i class="fas fa-save mr-2"></i> Tạo Khóa Học
                </button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>