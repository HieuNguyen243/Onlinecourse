<?php require './views/layouts/header.php'; ?>

<div class="flex min-h-screen bg-gray-50">


    <div class="flex-1 p-4 md:p-8">
        
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Xin chào, <span class="text-purple-600"><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>! 👋
                </h1>
                <p class="text-gray-500 text-sm mt-1">Chúc bạn có một ngày học tập hiệu quả.</p>
            </div>
            
            <form action="index.php" method="GET" class="w-full xl:w-auto flex bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <input type="hidden" name="controller" value="student">
                <input type="hidden" name="action" value="dashboard">
                <?php if(isset($_GET['filter'])): ?>
                    <input type="hidden" name="filter" value="<?php echo htmlspecialchars($_GET['filter']); ?>">
                <?php endif; ?>
                
                <select name="category_id" class="text-sm border-r border-gray-200 px-3 py-2 outline-none text-gray-600 bg-gray-50 hover:bg-white cursor-pointer transition max-w-[120px] md:max-w-xs truncate">
                    <option value="">Tất cả chủ đề</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <input type="text" name="keyword" 
                       value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                       placeholder="Tìm kiếm khóa học..." 
                       class="px-4 py-2 outline-none text-sm w-full md:w-64 text-gray-700">
                
                <button type="submit" class="bg-purple-600 text-white px-5 hover:bg-purple-700 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <?php 
            $isFilteringEnrolled = (isset($_GET['filter']) && $_GET['filter'] == 'enrolled');
            $sectionTitle = $isFilteringEnrolled ? 'Khóa học của tôi' : 'Khám phá khóa học mới';
            $sectionIcon = $isFilteringEnrolled ? 'fa-user-graduate' : 'fa-compass';
            $sectionColor = $isFilteringEnrolled ? 'text-purple-600' : 'text-blue-600';
            $sectionBg = $isFilteringEnrolled ? 'bg-purple-100' : 'bg-blue-100';
        ?>

        <div class="flex items-center space-x-3 mb-6">
            <div class="p-2 <?php echo $sectionBg; ?> <?php echo $sectionColor; ?> rounded-lg">
                <i class="fas <?php echo $sectionIcon; ?>"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">
                <?php echo $sectionTitle; ?>
            </h2>
            <?php if(!empty($allCourses)): ?>
                <span class="text-xs font-semibold bg-gray-200 text-gray-600 px-2 py-1 rounded-full">
                    <?php echo count($allCourses); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php if(empty($allCourses)): ?>
                <div class="col-span-full py-16 text-center bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="inline-block p-4 rounded-full bg-gray-50 mb-4 text-gray-300">
                        <i class="fas fa-search text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700 mb-1">Không tìm thấy khóa học nào</h3>
                    <p class="text-gray-500 text-sm">Hãy thử thay đổi từ khóa hoặc bộ lọc tìm kiếm.</p>
                    
                    <?php if($isFilteringEnrolled): ?>
                        <a href="index.php?controller=student&action=dashboard" class="inline-block mt-4 px-6 py-2 bg-purple-600 text-white rounded-lg text-sm font-bold hover:bg-purple-700 transition">
                            Khám phá khóa học ngay
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($allCourses as $course): ?>
                    <?php 
                        // Logic kiểm tra trạng thái đăng ký từ Controller
                        $isEnrolled = array_key_exists($course['id'], $enrolledData);
                        $progress = $isEnrolled ? $enrolledData[$course['id']]['progress'] : 0;
                        $enrollmentStatus = $isEnrolled ? $enrolledData[$course['id']]['status'] : null;
                    ?>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-300 flex flex-col h-full group">
                        <div class="relative h-44 overflow-hidden">
                            <img src="<?php echo !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250?text=Course+Image'; ?>" 
                                 alt="<?php echo htmlspecialchars($course['title']); ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            
                            <div class="absolute top-2 left-2">
                                <span class="bg-black/60 backdrop-blur-sm text-white text-[10px] px-2 py-1 rounded font-medium">
                                    <?php echo htmlspecialchars($course['category_name'] ?? 'General'); ?>
                                </span>
                            </div>

                            <?php if($isEnrolled): ?>
                                <div class="absolute top-2 right-2 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm flex items-center">
                                    <i class="fas fa-check-circle mr-1"></i> Đã đăng ký
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-800 text-base mb-2 line-clamp-2" title="<?php echo htmlspecialchars($course['title']); ?>">
                                <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" class="hover:text-purple-600 transition">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </a>
                            </h3>
                            
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-500">
                                    <?php echo strtoupper(substr($course['instructor_name'] ?? 'G', 0, 1)); ?>
                                </div>
                                <span class="text-xs text-gray-500 truncate max-w-[150px]">
                                    <?php echo htmlspecialchars($course['instructor_name'] ?? 'Giảng viên'); ?>
                                </span>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-50">
                                <?php if($isEnrolled): ?>
                                    <div class="mb-3">
                                        <div class="flex justify-between text-[11px] mb-1">
                                            <span class="text-gray-500 font-medium">Hoàn thành</span>
                                            <span class="font-bold text-purple-600"><?php echo $progress; ?>%</span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-purple-600 h-1.5 rounded-full transition-all duration-1000 ease-out" style="width: <?php echo $progress; ?>%"></div>
                                        </div>
                                    </div>
                                    
                                    <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" 
                                       class="flex items-center justify-center w-full bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white py-2 rounded-lg text-sm font-bold transition group-btn">
                                        <span><?php echo ($progress > 0) ? 'Tiếp tục học' : 'Vào học ngay'; ?></span>
                                        <i class="fas fa-arrow-right ml-2 text-xs transition-transform group-btn-hover:translate-x-1"></i>
                                    </a>
                                <?php else: ?>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-gray-400 text-xs flex items-center bg-gray-50 px-2 py-1 rounded">
                                            <i class="far fa-clock mr-1"></i> <?php echo $course['duration_weeks'] ?? 4; ?> tuần
                                        </span>
                                        <span class="font-bold text-gray-900 text-lg">
                                            <?php echo ($course['price'] == 0) ? 'Miễn phí' : number_format($course['price']) . ' đ'; ?>
                                        </span>
                                    </div>
                                    
                                    <form action="index.php?controller=enrollment&action=register" method="POST">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <button type="submit" onclick="return confirm('Bạn có chắc muốn đăng ký khóa học này?')" 
                                                class="w-full bg-gray-900 text-white py-2 rounded-lg text-sm font-bold hover:bg-gray-800 transition shadow-lg shadow-gray-200 transform active:scale-95">
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