<?php require './views/includes/header.php'; ?>

<div class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            <div class="lg:col-span-2 space-y-4">
                <div class="text-sm font-bold text-purple-400 uppercase tracking-wide">
                    <?php echo htmlspecialchars($course['category_name'] ?? 'General'); ?>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-extrabold leading-tight">
                    <?php echo htmlspecialchars($course['title']); ?>
                </h1>
                <p class="text-lg text-gray-300 line-clamp-3">
                    <?php echo htmlspecialchars($course['description']); ?>
                </p>
                
                <div class="flex flex-wrap items-center gap-4 text-sm pt-2">
                    <span class="flex items-center text-yellow-400 bg-yellow-400/10 px-3 py-1 rounded-full">
                        <i class="fas fa-signal mr-2"></i> <?php echo htmlspecialchars($course['level'] ?? 'Beginner'); ?>
                    </span>
                    <span class="flex items-center text-gray-300 bg-gray-800 px-3 py-1 rounded-full">
                        <i class="fas fa-clock mr-2"></i> <?php echo htmlspecialchars($course['duration_weeks'] ?? 0); ?> tuần
                    </span>
                    <span class="flex items-center text-gray-300 bg-gray-800 px-3 py-1 rounded-full">
                        <i class="fas fa-book mr-2"></i> <?php echo count($lessons); ?> bài học
                    </span>
                </div>
                
                <div class="flex items-center space-x-3 pt-4 border-t border-gray-800 mt-4">
                    <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-sm font-bold">
                        <?php echo strtoupper(substr($course['instructor_name'] ?? 'G', 0, 1)); ?>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Giảng viên</div>
                        <div class="font-bold text-sm"><?php echo htmlspecialchars($course['instructor_name'] ?? 'Không rõ'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12 relative">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <div class="lg:col-span-2">
             <div class="mb-10">
                <div class="flex justify-between items-end mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Nội dung bài học</h2>
                </div>
                <div class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm">
                    <?php if (!empty($lessons)): ?>
                        <?php foreach ($lessons as $index => $lesson): ?>
                            <?php 
                                $canView = $isEnrolled; 
                                $icon = $canView ? 'fa-play-circle text-purple-600' : 'fa-lock text-gray-400';
                                $link = $canView ? "index.php?controller=lesson&action=detail&course_id={$course['id']}&lesson_id={$lesson['id']}" : "#";
                                $completedIcon = ($isEnrolled && !empty($lesson['is_completed'])) ? '<i class="fas fa-check-circle text-green-500 ml-2"></i>' : '';
                            ?>
                            <a href="<?php echo $link; ?>" class="flex items-center justify-between p-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="text-gray-400 font-medium w-6"><?php echo $index + 1; ?></div>
                                    <i class="fas <?php echo $icon; ?> text-lg"></i>
                                    <div>
                                        <span class="text-gray-800 font-medium"><?php echo htmlspecialchars($lesson['title']); ?></span>
                                        <?php echo $completedIcon; ?>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-24 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="relative h-48 bg-gray-100">
                    <img src="<?php echo !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250'; ?>" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="text-3xl font-bold text-gray-900 mb-2">
                        <?php echo ($course['price'] == 0) ? 'Miễn phí' : number_format($course['price']) . ' đ'; ?>
                    </div>
                    
                    <div class="mt-4">
                        <?php if ($isEnrolled): ?>
                            <a href="index.php?controller=lesson&action=detail&course_id=<?php echo $course['id']; ?>&lesson_id=<?php echo $lessons[0]['id'] ?? ''; ?>" class="block w-full text-center bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition">Tiếp tục học</a>
                        <?php else: ?>
                            <form action="index.php?controller=enrollment&action=register" method="POST">
                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                <button type="submit" class="block w-full text-center bg-purple-600 text-white py-3 rounded-lg font-bold hover:bg-purple-700 transition">Đăng ký ngay</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require './views/includes/footer.php'; ?>