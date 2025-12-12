<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start mb-8 border-b pb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Bảng Điều Khiển Giảng Viên</h1>
            <p class="text-gray-600 mt-1">Quản lý khóa học, bài học và theo dõi tiến độ học viên của bạn.</p>
        </div>
        <a href="index.php?controller=Instructor&action=createCourse" 
           class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-full transition shadow-md mt-4 md:mt-0">
            <i class="fas fa-plus-circle mr-2"></i> Tạo Khóa học mới
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 sticky top-24">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Quản lý</h4>
                <nav class="space-y-1">
                    <a href="index.php?controller=Instructor&action=dashboard" class="flex items-center px-4 py-2 text-sm transition rounded-lg bg-purple-50 text-purple-700 font-semibold">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>Dashboard Tổng quan</span>
                    </a>
                    <a href="index.php?controller=Instructor&action=progress" class="flex items-center px-4 py-2 text-sm transition rounded-lg text-gray-700 hover:bg-gray-50 hover:text-purple-600">
                        <i class="fas fa-chart-line w-6"></i>
                        <span>Theo dõi Tiến độ</span>
                    </a>
                    <a href="index.php?controller=Instructor&action=viewStudents" class="flex items-center px-4 py-2 text-sm transition rounded-lg text-gray-700 hover:bg-gray-50 hover:text-purple-600">
                        <i class="fas fa-users w-6"></i>
                        <span>Danh sách Học viên</span>
                    </a>
                </nav>
            </div>
        </div>

        <div class="lg:col-span-9">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Khóa học Đang Hoạt động (<?php echo count($courses); ?>)</h3>
            
            <?php if (!empty($courses)): ?>
                <div class="space-y-4">
                    <?php foreach ($courses as $course): ?>
                        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition flex flex-col md:flex-row justify-between items-start md:items-center">
                            
                            <div class="flex-1 min-w-0 mb-3 md:mb-0">
                                <h4 class="text-lg font-bold text-gray-900 truncate hover:text-purple-600">
                                    <a href="index.php?controller=course&action=detail&course_id=<?php echo urlencode($course['id']); ?>">
                                        <?php echo htmlspecialchars($course['title'] ?? 'Không tên'); ?>
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-tag mr-1 text-purple-400"></i> <?php echo htmlspecialchars($course['category_name'] ?? 'Chưa phân loại'); ?> 
                                    • <span class="text-gray-400">ID: <?php echo htmlspecialchars($course['id']); ?></span>
                                </p>
                            </div>
                            
                            <div class="flex flex-wrap space-x-2 md:space-x-3 items-center">
                                
                                <a href="index.php?controller=Lesson&action=manage&course_id=<?php echo urlencode($course['id']); ?>" 
                                   class="btn btn-sm bg-gray-200 text-gray-800 hover:bg-gray-300 px-3 py-1 rounded-lg font-medium text-xs transition">
                                    <i class="fas fa-book-open mr-1"></i> Bài học
                                </a>
                                
                                <a href="index.php?controller=Instructor&action=updateCourse&id=<?php echo urlencode($course['id']); ?>" 
                                   class="btn btn-sm bg-blue-500 text-white hover:bg-blue-600 px-3 py-1 rounded-lg font-medium text-xs transition">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                
                                <a href="index.php?controller=Instructor&action=deleteCourse&id=<?php echo urlencode($course['id']); ?>" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này và toàn bộ dữ liệu liên quan?')"
                                   class="btn btn-sm bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded-lg font-medium text-xs transition">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 text-center">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">Bạn chưa đăng tải khóa học nào.</p>
                    <a href="index.php?controller=Instructor&action=createCourse" class="text-purple-600 hover:text-purple-700 mt-3 block font-semibold">
                        Nhấn vào đây để tạo khóa học đầu tiên!
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>