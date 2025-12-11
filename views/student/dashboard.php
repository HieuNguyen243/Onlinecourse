<?php require './views/layouts/header.php'; ?>

<div class="flex min-h-screen bg-gray-50">
    <?php require './views/layouts/sidebar.php'; ?>

    <div class="flex-1 p-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Xin chào, <?php echo htmlspecialchars($_SESSION['fullname']); ?>! 👋</h1>
                <p class="text-gray-500 text-sm">Hãy tiếp tục hành trình chinh phục tri thức.</p>
            </div>
            
            <form action="index.php" method="GET" class="flex w-full md:w-auto bg-white rounded-lg shadow-sm border border-gray-200 p-1">
                <input type="hidden" name="controller" value="student">
                <input type="hidden" name="action" value="dashboard">
                
                <select name="category_id" class="text-sm border-r border-gray-200 px-3 py-2 outline-none text-gray-600 bg-transparent">
                    <option value="">Tất cả chủ đề</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <input type="text" name="keyword" placeholder="Tìm khóa học..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" class="px-4 py-2 outline-none text-sm w-full md:w-64">
                
                <button type="submit" class="bg-purple-600 text-white px-4 rounded-md hover:bg-purple-700 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(empty($allCourses)): ?>
                <div class="col-span-full text-center py-12 text-gray-500">
                    Không tìm thấy khóa học nào phù hợp.
                </div>
            <?php else: ?>
                <?php foreach ($allCourses as $course): ?>
                    <?php 
                        // Kiểm tra trạng thái đăng ký
                        $isEnrolled = array_key_exists($course['id'], $enrolledData);
                        $progress = $isEnrolled ? $enrolledData[$course['id']]['progress'] : 0;
                    ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition flex flex-col h-full group">
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?php echo !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250'; ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <?php if($isEnrolled): ?>
                                <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow">
                                    <i class="fas fa-check-circle"></i> Đã đăng ký
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="text-xs font-bold text-purple-600 mb-1 uppercase tracking-wide">
                                <?php echo htmlspecialchars($course['category_name'] ?? 'General'); ?>
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg mb-2 line-clamp-2">
                                <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" class="hover:text-purple-600">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </a>
                            </h3>
                            
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                    <?php echo strtoupper(substr($course['instructor_name'] ?? 'G', 0, 1)); ?>
                                </div>
                                <span class="text-xs text-gray-500"><?php echo htmlspecialchars($course['instructor_name'] ?? 'Giảng viên'); ?></span>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <?php if($isEnrolled): ?>
                                    <div class="mb-3">
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-gray-500">Tiến độ</span>
                                            <span class="font-bold text-gray-700"><?php echo $progress; ?>%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full transition-all duration-1000" style="width: <?php echo $progress; ?>%"></div>
                                        </div>
                                    </div>
                                    <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" class="block w-full text-center bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white py-2 rounded-lg font-semibold transition">
                                        Tiếp tục học
                                    </a>
                                <?php else: ?>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-gray-400 text-sm"><i class="fas fa-clock"></i> <?php echo $course['duration_weeks']; ?> tuần</span>
                                        <span class="font-bold text-purple-600 text-lg">
                                            <?php echo ($course['price'] == 0) ? 'Miễn phí' : number_format($course['price']) . ' đ'; ?>
                                        </span>
                                    </div>
                                    
                                    <form action="index.php?controller=enrollment&action=register" method="POST">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <button type="submit" class="block w-full text-center bg-gray-900 text-white py-2 rounded-lg font-bold hover:bg-gray-800 transition">
                                            Đăng ký ngay
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require './views/layouts/footer.php'; ?>