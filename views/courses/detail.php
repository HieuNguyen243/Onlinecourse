<?php require './views/layouts/header.php'; ?>

<div class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <span class="text-purple-400 font-bold uppercase tracking-wider text-sm"><?php echo htmlspecialchars($course['category_name'] ?? 'Khóa học'); ?></span>
            <h1 class="text-3xl md:text-5xl font-extrabold mt-2 mb-4 leading-tight"><?php echo htmlspecialchars($course['title']); ?></h1>
            <p class="text-gray-400 text-lg mb-6 line-clamp-3"><?php echo htmlspecialchars($course['description']); ?></p>
            
            <div class="flex items-center space-x-6 text-sm">
                <div class="flex items-center"><i class="fas fa-user-tie mr-2 text-gray-500"></i> <?php echo htmlspecialchars($course['instructor_name']); ?></div>
                <div class="flex items-center"><i class="fas fa-signal mr-2 text-gray-500"></i> <?php echo htmlspecialchars($course['level']); ?></div>
                <div class="flex items-center"><i class="fas fa-book mr-2 text-gray-500"></i> <?php echo count($lessons); ?> bài học</div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="flex flex-col lg:flex-row gap-10">
        <div class="flex-1">
            <div class="flex justify-between items-end mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Nội dung khóa học</h2>
                <?php if($isEnrolled): ?>
                    <span class="text-sm text-green-600 font-medium"><i class="fas fa-check-circle"></i> Đã đăng ký</span>
                <?php endif; ?>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <?php if(empty($lessons)): ?>
                    <div class="p-6 text-center text-gray-500">Chưa có bài học nào được cập nhật.</div>
                <?php else: ?>
                    <?php foreach ($lessons as $index => $lesson): ?>
                        <?php 
                            // Logic: Nếu đã đăng ký thì xem được, chưa đăng ký thì bị khóa (trừ bài đầu tiên nếu muốn cho học thử - ở đây tôi khóa hết nếu chưa đăng ký)
                            $isCompleted = isset($lesson['is_completed']) && $lesson['is_completed'];
                            
                            // Tạo link
                            if ($isEnrolled) {
                                $link = "index.php?controller=lesson&action=detail&course_id={$course['id']}&lesson_id={$lesson['id']}";
                                $iconClass = $isCompleted ? "fa-check-circle text-green-500" : "fa-play-circle text-purple-600";
                                $rowClass = "hover:bg-gray-50 cursor-pointer";
                                $textClass = "text-gray-800";
                            } else {
                                $link = "#"; // Chặn click
                                $iconClass = "fa-lock text-gray-400";
                                $rowClass = "opacity-75 cursor-not-allowed bg-gray-50";
                                $textClass = "text-gray-500";
                            }
                        ?>
                        
                        <a href="<?php echo $link; ?>" class="flex items-center p-4 border-b border-gray-100 last:border-0 transition <?php echo $rowClass; ?>">
                            <div class="mr-4 text-gray-400 font-mono text-sm w-6 text-center"><?php echo $index + 1; ?></div>
                            <div class="flex-1">
                                <h3 class="font-medium <?php echo $textClass; ?>"><?php echo htmlspecialchars($lesson['title']); ?></h3>
                            </div>
                            <div class="ml-4">
                                <i class="fas <?php echo $iconClass; ?> text-xl"></i>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="w-full lg:w-80 flex-shrink-0">
            <div class="sticky top-24 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <img src="<?php echo !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250'; ?>" class="w-full h-40 object-cover">
                <div class="p-6">
                    <div class="text-3xl font-bold text-gray-900 mb-2">
                        <?php echo ($course['price'] == 0) ? 'Miễn phí' : number_format($course['price']) . ' đ'; ?>
                    </div>
                    
                    <?php if ($isEnrolled): ?>
                        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg text-sm font-medium text-center mb-4">
                            Bạn đã sở hữu khóa học này
                        </div>
                        <?php if(!empty($lessons)): ?>
                            <a href="index.php?controller=lesson&action=detail&course_id=<?php echo $course['id']; ?>&lesson_id=<?php echo $lessons[0]['id']; ?>" class="block w-full text-center bg-purple-600 text-white py-3 rounded-lg font-bold hover:bg-purple-700 transition">
                                Vào học ngay
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <form action="index.php?controller=enrollment&action=register" method="POST">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <button type="submit" class="block w-full text-center bg-purple-600 text-white py-3 rounded-lg font-bold hover:bg-purple-700 transition shadow-lg shadow-purple-200">
                                Đăng ký ngay
                            </button>
                        </form>
                        <p class="text-xs text-center text-gray-500 mt-3">Truy cập trọn đời • Cấp chứng chỉ</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './views/layouts/footer.php'; ?>