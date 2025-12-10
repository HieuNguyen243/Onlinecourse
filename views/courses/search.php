<?php require './views/includes/header.php'; ?>

<?php
// Lấy từ khóa đã nhập để hiển thị lại
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Kết quả tìm kiếm</h1>
            <div class="max-w-xl mx-auto">
                <form action="index.php?controller=course&action=searchCourses" method="POST" class="relative">
                    <input type="text" 
                           name="keyword" 
                           value="<?php echo htmlspecialchars($keyword); ?>"
                           placeholder="Nhập tên khóa học bạn muốn tìm..." 
                           class="w-full pl-6 pr-12 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 shadow-sm"
                           required>
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-purple-600 text-white rounded-full hover:bg-purple-700 flex items-center justify-center transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="mb-6">
            <?php if (!empty($keyword)): ?>
                <p class="text-gray-600">
                    Tìm thấy <span class="font-bold text-purple-600"><?php echo count($result); ?></span> kết quả cho từ khóa "<span class="italic"><?php echo htmlspecialchars($keyword); ?></span>":
                </p>
            <?php endif; ?>
        </div>

        <?php if (!empty($result)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($result as $course): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full">
                        <div class="relative overflow-hidden h-40">
                             <?php $imgSrc = !empty($course['image']) ? $course['image'] : 'https://via.placeholder.com/400x250?text=Course'; ?>
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 hover:text-purple-600 transition">
                                <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>
                            
                            <div class="mt-auto flex justify-between items-center pt-3 border-t border-gray-50">
                                <span class="text-purple-600 font-bold text-sm">
                                    <?php echo ($course['price'] > 0) ? number_format($course['price']).' đ' : 'Miễn phí'; ?>
                                </span>
                                <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" class="text-gray-500 hover:text-purple-600 text-sm font-medium">
                                    Xem chi tiết <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-dashed border-gray-300">
                <div class="inline-block p-4 rounded-full bg-gray-50 mb-4">
                    <i class="fas fa-search text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Không tìm thấy kết quả phù hợp</h3>
                <p class="text-gray-500 mb-6">Hãy thử tìm kiếm với từ khóa khác hoặc xem tất cả khóa học.</p>
                <a href="index.php?controller=course&action=listAllCourses" class="text-purple-600 font-semibold hover:underline">
                    Xem tất cả khóa học
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require './views/includes/footer.php'; ?>