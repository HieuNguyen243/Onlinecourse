<?php require './views/includes/header.php'; ?>

<?php
// Xử lý chuẩn hóa biến đầu vào từ Controller
// Vì Controller truyền $allcourses (khi xem tất cả) hoặc $result (khi xem theo danh mục)
$courses = [];
if (isset($allcourses)) {
    $courses = $allcourses;
    $title = "Tất cả khóa học";
} elseif (isset($result)) {
    $courses = $result;
    $title = "Danh sách khóa học";
}
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">
                <i class="fas fa-graduation-cap text-purple-600 mr-2"></i> <?php echo $title; ?>
            </h1>
            
            <div class="text-gray-500 text-sm">
                Hiển thị <strong><?php echo count($courses); ?></strong> khóa học
            </div>
        </div>

        <?php if (!empty($courses)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full group">
                        <div class="relative overflow-hidden h-48">
                            <?php $imgSrc = !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250?text=Course+Image'; ?>
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" 
                                 alt="<?php echo htmlspecialchars($course['title']); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            
                            <?php if (isset($course['category_name'])): ?>
                                <span class="absolute top-3 left-3 bg-purple-600 text-white text-xs px-2 py-1 rounded-md font-medium shadow-md">
                                    <?php echo htmlspecialchars($course['category_name']); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 group-hover:text-purple-600 transition">
                                <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </a>
                            </h3>
                            
                            <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>
                            
                            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                        <?php echo strtoupper(substr($course['instructor_name'] ?? 'G', 0, 1)); ?>
                                    </div>
                                    <span class="text-xs text-gray-600 font-medium truncate max-w-[80px]">
                                        <?php echo htmlspecialchars($course['instructor_name'] ?? 'Giảng viên'); ?>
                                    </span>
                                </div>
                                <div class="text-purple-600 font-bold">
                                    <?php echo isset($course['price']) && $course['price'] > 0 ? number_format($course['price']).' đ' : 'Miễn phí'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="text-gray-300 text-6xl mb-4"><i class="fas fa-search"></i></div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Không tìm thấy khóa học nào</h3>
                <p class="text-gray-500">Hiện tại chưa có khóa học nào trong danh sách này.</p>
                <a href="index.php" class="mt-6 px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition">
                    Quay về trang chủ
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require './views/includes/footer.php'; ?>