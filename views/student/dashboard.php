<?php require './views/includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-64 flex-shrink-0">
            <?php require './views/includes/sidebar.php'; ?>
        </div>
        
        <div class="flex-1">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-8 text-white shadow-lg mb-8">
                <h1 class="text-3xl font-bold mb-2">Khám phá tri thức mới 🚀</h1>
                <p class="text-purple-100 opacity-90">Hàng trăm khóa học đang chờ bạn đăng ký hôm nay.</p>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-6 border-l-4 border-purple-600 pl-3">Tất cả khóa học hiện có</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($allCourses as $course): ?>
                    <?php 
                        $isOwned = in_array($course['id'], $enrolledIds); 
                    ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition flex flex-col h-full">
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?php echo !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250'; ?>" class="w-full h-full object-cover">
                            <?php if($isOwned): ?>
                                <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow">
                                    <i class="fas fa-check"></i> Đã sở hữu
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-800 mb-2 line-clamp-2"><?php echo htmlspecialchars($course['title']); ?></h3>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-2 flex-1"><?php echo htmlspecialchars($course['description']); ?></p>
                            
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <?php if($isOwned): ?>
                                    <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" class="block w-full text-center bg-gray-100 text-gray-600 py-2 rounded-lg font-semibold hover:bg-gray-200 transition">
                                        Vào học ngay
                                    </a>
                                <?php else: ?>
                                    <form action="index.php?controller=enrollment&action=register" method="POST">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <button type="submit" onclick="return confirm('Bạn có chắc muốn đăng ký khóa học này?')" class="block w-full text-center bg-purple-600 text-white py-2 rounded-lg font-bold hover:bg-purple-700 transition shadow-lg shadow-purple-200">
                                            Đăng ký học
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require './views/includes/footer.php'; ?>