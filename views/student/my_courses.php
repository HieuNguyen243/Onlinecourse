<?php require './views/layouts/header.php'; ?>

<div class="flex min-h-screen bg-gray-50">
    <?php require './views/layouts/sidebar.php'; ?>

    <div class="flex-1 p-4 md:p-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-book-reader mr-2 text-purple-600"></i>Khóa học của tôi
                </h1>
                <p class="text-gray-500 text-sm mt-1">Quản lý tiến độ và tiếp tục học tập.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-sm font-bold">
                    <?php echo isset($courses) && is_array($courses) ? count($courses) : 0; ?> khóa học đang học
                </span>
            </div>
        </div>

        <?php if(isset($courses) && is_array($courses) && count($courses) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($courses as $course): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition flex flex-col h-full group">
                        <div class="relative h-48 overflow-hidden">
                            <?php $imgSrc = !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250?text=No+Image'; ?>
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            
                            <div class="absolute top-2 right-2">
                                <?php 
                                    $progress = $course['progress'] ?? 0;
                                    $statusClass = ($progress == 100) ? 'bg-green-500' : 'bg-blue-500';
                                ?>
                                <span class="<?php echo $statusClass; ?> text-white text-xs font-bold px-2 py-1 rounded shadow">
                                    <?php echo $progress; ?>%
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="text-xs font-bold text-purple-600 mb-1 uppercase tracking-wide">
                                <?php echo htmlspecialchars($course['category_name'] ?? 'Khóa học'); ?>
                            </div>
                            
                            <h3 class="font-bold text-gray-800 text-lg mb-2 line-clamp-2" title="<?php echo htmlspecialchars($course['title']); ?>">
                                <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" class="hover:text-purple-600 transition">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </a>
                            </h3>
                            
                            <div class="flex items-center space-x-2 mb-4">
                                <i class="fas fa-user-circle text-gray-400"></i>
                                <span class="text-xs text-gray-500"><?php echo htmlspecialchars($course['instructor_name'] ?? 'Giảng viên'); ?></span>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <div class="mb-3">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-500">Tiến độ hoàn thành</span>
                                        <span class="font-bold text-gray-700"><?php echo $progress; ?>%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="<?php echo ($progress == 100) ? 'bg-green-500' : 'bg-purple-600'; ?> h-2 rounded-full transition-all duration-1000" 
                                             style="width: <?php echo $progress; ?>%"></div>
                                    </div>
                                </div>

                                <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" 
                                   class="block w-full text-center bg-purple-600 text-white py-2 rounded-lg font-semibold hover:bg-purple-700 hover:shadow-md transition">
                                    <i class="fas fa-play-circle mr-1"></i> Tiếp tục học
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="text-purple-100 text-6xl mb-4">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Bạn chưa đăng ký khóa học nào</h3>
                <p class="text-gray-500 mb-6">Hãy khám phá kho tàng kiến thức và bắt đầu hành trình học tập ngay hôm nay.</p>
                <a href="index.php?controller=course&action=listAllCourses" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-full font-bold hover:bg-purple-700 transition shadow-lg">
                    Khám phá khóa học
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require './views/layouts/footer.php'; ?>