<?php require './views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">🛡️ Duyệt Khóa Học</h1>
        <a href="index.php?controller=admin&action=index" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    
    <?php if(empty($pendingCourses)): ?>
        <div class="bg-green-100 border border-green-200 text-green-700 p-6 rounded-lg text-center">
            <i class="fas fa-check-circle text-4xl mb-3"></i>
            <p class="font-medium">Tuyệt vời! Không có khóa học nào đang chờ duyệt.</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khóa học</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giảng viên</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <?php foreach ($pendingCourses as $course): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 text-base mb-1"><?php echo htmlspecialchars($course['title']); ?></div>
                            <div class="text-sm text-gray-500 line-clamp-1"><?php echo htmlspecialchars($course['description']); ?></div>
                            <div class="text-xs text-gray-400 mt-1">ID: <?php echo $course['id']; ?> • Tạo: <?php echo $course['created_at']; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-xs mr-2">
                                    <?php echo strtoupper(substr($course['instructor_name'] ?? 'G', 0, 1)); ?>
                                </div>
                                <span class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($course['instructor_name']); ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo htmlspecialchars($course['category_name'] ?? 'Chưa phân loại'); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-purple-600">
                            <?php echo number_format($course['price']); ?> đ
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="index.php?controller=course&action=detail&course_id=<?php echo $course['id']; ?>" target="_blank" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded transition">
                                <i class="fas fa-eye"></i> Xem
                            </a>
                            
                            <a href="index.php?controller=admin&action=reject&id=<?php echo $course['id']; ?>" 
                               onclick="return confirm('Bạn chắc chắn muốn từ chối khóa học này?')"
                               class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded transition">
                               <i class="fas fa-times"></i> Từ chối
                            </a>
                               
                            <a href="index.php?controller=admin&action=approve&id=<?php echo $course['id']; ?>" 
                               class="text-green-600 hover:text-green-900 bg-green-50 px-3 py-1 rounded transition border border-green-200 shadow-sm hover:shadow">
                               <i class="fas fa-check"></i> Duyệt
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require './views/layouts/footer.php'; ?>