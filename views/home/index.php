<?php require './views/includes/header.php'; ?>

<section class="relative bg-white overflow-hidden">
    <div class="container mx-auto px-4 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="space-y-6 z-10">
                <div class="inline-block px-4 py-1.5 bg-purple-100 text-purple-700 font-bold rounded-full text-sm mb-2">
                    🚀 Khởi động tương lai của bạn
                </div>
                <h1 class="text-4xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
                    Học kỹ năng mới,<br>
                    <span class="bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">Mở lối thành công</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-lg">
                    Truy cập hơn 5,000 khóa học từ lập trình, thiết kế đến kinh doanh. Học mọi lúc, mọi nơi với các chuyên gia hàng đầu.
                </p>
                
                <form action="index.php?controller=course&action=searchCourses" method="POST" class="flex max-w-md shadow-lg rounded-full overflow-hidden border border-gray-200">
                    <input type="text" name="keyword" placeholder="Bạn muốn học gì hôm nay?" class="flex-1 px-6 py-4 focus:outline-none text-gray-700" required>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 font-bold transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <div class="flex items-center space-x-4 text-sm text-gray-500 pt-2">
                    <span class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Học trọn đời</span>
                    <span class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i> Cấp chứng chỉ</span>
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="absolute inset-0 bg-gradient-to-tr from-purple-200 to-indigo-200 rounded-full filter blur-3xl opacity-50 transform translate-x-10 translate-y-10"></div>
                <img src="https://img.freepik.com/free-vector/online-learning-isometric-concept_1284-17947.jpg?w=800" alt="Online Learning" class="relative z-10 w-full hover:scale-105 transition duration-500 drop-shadow-2xl">
            </div>
        </div>
    </div>
</section>

<div class="bg-gray-900 py-10 text-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-800">
            <div>
                <div class="text-3xl font-bold text-purple-400">10K+</div>
                <div class="text-gray-400 text-sm mt-1">Học viên</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-purple-400">500+</div>
                <div class="text-gray-400 text-sm mt-1">Khóa học</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-purple-400">100+</div>
                <div class="text-gray-400 text-sm mt-1">Giảng viên</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-purple-400">4.8/5</div>
                <div class="text-gray-400 text-sm mt-1">Đánh giá</div>
            </div>
        </div>
    </div>
</div>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Chủ đề phổ biến</h2>
            <p class="text-gray-600">Khám phá các lĩnh vực được quan tâm nhất hiện nay</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <form action="index.php?controller=course&action=listCoursesByCategory" method="POST" id="home-cat-<?php echo $cat['id']; ?>" class="group">
                        <input type="hidden" name="category_id" value="<?php echo $cat['id']; ?>">
                        <div onclick="document.getElementById('home-cat-<?php echo $cat['id']; ?>').submit();" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition cursor-pointer text-center border border-gray-100 h-full flex flex-col justify-center items-center group-hover:-translate-y-1">
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mb-3 group-hover:bg-purple-600 group-hover:text-white transition">
                                <i class="fas fa-laptop-code text-xl"></i> </div>
                            <h3 class="font-semibold text-gray-800 group-hover:text-purple-600 transition"><?php echo htmlspecialchars($cat['name']); ?></h3>
                        </div>
                    </form>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center w-full text-gray-500">Đang cập nhật danh mục...</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Khóa học mới nhất</h2>
                <p class="text-gray-600">Cập nhật kiến thức mới mỗi ngày</p>
            </div>
            <a href="index.php?controller=course&action=listAllCourses" class="text-purple-600 font-semibold hover:text-purple-800 transition flex items-center">
                Xem tất cả <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php 
            // Giới hạn hiển thị 4-8 khóa học đầu tiên
            $displayCourses = array_slice($allcourses, 0, 8);
            if (!empty($displayCourses)): 
                foreach ($displayCourses as $course): 
            ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full group">
                    <div class="relative overflow-hidden h-48">
                        <?php $imgSrc = !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250?text=No+Image'; ?>
                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-gray-800 shadow-sm">
                            <i class="fas fa-star text-yellow-400 mr-1"></i> 4.5
                        </div>
                    </div>
                    
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="text-xs font-semibold text-purple-600 mb-2 uppercase tracking-wide">Development</div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 hover:text-purple-600 transition">
                            <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </a>
                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </p>
                        
                        <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">GV</div>
                                <span class="text-xs text-gray-600 font-medium">Giảng viên</span>
                            </div>
                            <div class="text-purple-600 font-bold">
                                <?php echo isset($course['price']) && $course['price'] > 0 ? number_format($course['price']).' đ' : 'Miễn phí'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach; 
            else: 
            ?>
                <div class="col-span-full text-center py-10">
                    <div class="text-gray-400 text-6xl mb-4"><i class="fas fa-box-open"></i></div>
                    <p class="text-gray-500">Chưa có khóa học nào được đăng tải.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-indigo-800"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,...');"></div> 
    
    <div class="container mx-auto px-4 relative z-10 text-center text-white">
        <h2 class="text-4xl font-bold mb-6">Bạn đã sẵn sàng để bắt đầu?</h2>
        <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">Tham gia cùng cộng đồng hơn 10,000 học viên và bắt đầu hành trình chinh phục tri thức ngay hôm nay.</p>
        <div class="flex justify-center space-x-4">
            <a href="index.php?controller=auth&action=register" class="bg-white text-purple-700 px-8 py-3 rounded-full font-bold shadow-lg hover:bg-gray-100 hover:shadow-xl hover:-translate-y-1 transition">
                Đăng ký tài khoản
            </a>
            <a href="index.php?controller=course&action=listAllCourses" class="border-2 border-white text-white px-8 py-3 rounded-full font-bold hover:bg-white/10 transition">
                Xem khóa học
            </a>
        </div>
    </div>
</section>

<?php require './views/includes/footer.php'; ?>