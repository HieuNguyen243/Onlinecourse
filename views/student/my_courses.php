<?php require './views/includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-64 flex-shrink-0">
            <?php require './views/includes/sidebar.php'; ?>
        </div>

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Khóa học của tôi</h1>

            <?php if (!empty($result)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($result as $course): ?>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition group h-full flex flex-col">
                            <div class="relative h-40 overflow-hidden">
                                <img src="<?php echo !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250'; ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-black bg-opacity-10 group-hover:bg-opacity-0 transition"></div>
                            </div>
                            
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </h3>
                                
                                <div class="mt-auto">
                                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                                        <span>Đã hoàn thành</span>
                                        <span class="font-bold text-purple-600">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2 mb-4">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                    
                                    <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" class="block w-full text-center bg-white border border-purple-600 text-purple-600 py-2 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition">
                                        Vào học ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="flex flex-col items-center justify-center py-16 bg-white rounded-xl shadow-sm">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400 text-4xl">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Chưa có khóa học nào</h3>
                    <p class="text-gray-500 mb-6">Hãy tìm kiếm khóa học phù hợp và bắt đầu ngay hôm nay.</p>
                    <a href="index.php?controller=course&action=listAllCourses" class="px-8 py-3 bg-purple-600 text-white rounded-full font-bold shadow-lg hover:shadow-purple-500/30 hover:-translate-y-1 transition">
                        Tìm khóa học
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require './views/includes/footer.php'; ?>