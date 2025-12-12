<?php require './views/layouts/header.php'; ?>

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
                    Truy cập hàng ngàn khóa học từ lập trình, thiết kế đến kinh doanh. Đăng ký ngay để bắt đầu hành trình.
                </p>
                
                <form action="index.php?controller=course&action=searchCourses" method="POST" class="flex flex-col md:flex-row max-w-xl shadow-lg rounded-2xl md:rounded-full overflow-hidden border border-gray-200 bg-white">
                    <div class="relative min-w-[150px] border-b md:border-b-0 md:border-r border-gray-200">
                        <select name="category_id" class="w-full h-full px-6 py-4 appearance-none bg-transparent outline-none text-gray-700 font-medium cursor-pointer">
                            <option value="">Tất cả danh mục</option>
                            <?php if(!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    
                    <input type="text" name="keyword" placeholder="Tìm khóa học..." class="flex-1 px-6 py-4 focus:outline-none text-gray-700">
                    
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-4 font-bold transition md:rounded-r-full">
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
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Tất cả khóa học</h2>
                <p class="text-gray-600">Khám phá kho tàng kiến thức đa dạng</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php 
            // CẬP NHẬT: Hiển thị toàn bộ khóa học thay vì giới hạn
            if (!empty($allcourses)): 
                foreach ($allcourses as $course): 
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
                        <div class="text-xs font-semibold text-purple-600 mb-2 uppercase tracking-wide">
                            <?php echo htmlspecialchars($course['category_name'] ?? 'General'); ?>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 hover:text-purple-600 transition">
                            <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </a>
                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </p>
                        
                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                        <?php echo strtoupper(substr($course['instructor_name'] ?? 'G', 0, 1)); ?>
                                    </div>
                                    <span class="text-xs text-gray-600 font-medium truncate max-w-[100px]">
                                        <?php echo htmlspecialchars($course['instructor_name'] ?? 'Giảng viên'); ?>
                                    </span>
                                </div>
                                <div class="text-purple-600 font-bold">
                                    <?php echo isset($course['price']) && $course['price'] > 0 ? number_format($course['price']).' đ' : 'Miễn phí'; ?>
                                </div>
                            </div>

                            <a href="index.php?controller=auth&action=login" class="block w-full text-center bg-purple-600 text-white py-2.5 rounded-lg font-bold hover:bg-purple-700 hover:shadow-lg transition">
                                Đăng ký ngay
                            </a>
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
    <div class="container mx-auto px-4 relative z-10 text-center text-white">
        <h2 class="text-4xl font-bold mb-6">Bạn đã sẵn sàng để bắt đầu?</h2>
        <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">Tham gia cùng cộng đồng hơn 10,000 học viên và bắt đầu hành trình chinh phục tri thức ngay hôm nay.</p>
        <div class="flex justify-center space-x-4">
            <a href="index.php?controller=auth&action=register" class="bg-white text-purple-700 px-8 py-3 rounded-full font-bold shadow-lg hover:bg-gray-100 hover:shadow-xl hover:-translate-y-1 transition">
                Tạo tài khoản mới
            </a>
            <a href="index.php?controller=auth&action=login" class="border-2 border-white text-white px-8 py-3 rounded-full font-bold hover:bg-white/10 transition">
                Đăng nhập ngay
            </a>
        </div>
    </div>
</section>

<?php require './views/layouts/footer.php'; ?>