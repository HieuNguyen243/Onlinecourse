<?php require './views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6 z-10">
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
        </div>
    </div>
</div>
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Tất cả khóa học</h2>
                <p class="text-gray-600">Khám phá kho tàng kiến thức đa dạng</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php 
            // Sử dụng biến $allcourses đã được CourseController tải
            $courses_to_display = isset($allcourses) ? $allcourses : [];
            if (!empty($courses_to_display)): 
                foreach ($courses_to_display as $course): 
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
                    <p class="text-gray-500">Chưa có khóa học nào được đăng tải hoặc không tìm thấy kết quả.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require './views/layouts/footer.php'; ?>