<?php require __DIR__ . '/../layouts/header.php'; ?>

<?php
$course_id = isset($course_id) ? $course_id : (isset($_GET['course_id']) ? $_GET['course_id'] : null);
?>

<div class="container mx-auto px-4 py-12 max-w-7xl">
    <div class="flex justify-between items-center mb-6 border-b pb-3">
        <h2 class="text-3xl font-bold text-gray-800">Quản lý Bài học (Khóa #<?php echo htmlspecialchars($course_id); ?>)</h2>
        <a href="index.php?controller=Lesson&action=create&course_id=<?php echo htmlspecialchars($course_id); ?>" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-full transition shadow-md">
            <i class="fas fa-plus-circle mr-2"></i> Thêm Bài Học
        </a>
    </div>

    <?php if (empty($lessons)): ?>
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 text-center">
            <i class="fas fa-graduation-cap text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 font-medium">Khóa học này chưa có bài học nào.</p>
            <a href="index.php?controller=Lesson&action=create&course_id=<?php echo htmlspecialchars($course_id); ?>" class="text-purple-600 hover:text-purple-700 mt-3 block font-semibold">
                Tạo bài học đầu tiên ngay!
            </a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề Bài học</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thứ tự</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tài liệu</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($lessons as $i => $lesson): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $i + 1; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <h4 class="text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($lesson['title']); ?></h4>
                                <span class="text-xs text-gray-500"><?php echo !empty($lesson['video_url']) ? 'Video Bài giảng' : 'Bài học Văn bản'; ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($lesson['order']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php
                                if (!empty($lesson['materials']) && is_array($lesson['materials'])):
                                    foreach ($lesson['materials'] as $m):
                                ?>
                                        <div class="flex items-center space-x-2 text-xs">
                                            <i class="fas fa-file-pdf text-red-500"></i>
                                            <a href="<?php echo htmlspecialchars($m['file_path']); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 truncate max-w-xs">
                                                <?php echo htmlspecialchars($m['file_name']); ?>
                                            </a>
                                            <a href="index.php?controller=Lesson&action=deleteMaterial&material_id=<?php echo $m['id']; ?>&course_id=<?php echo htmlspecialchars($course_id); ?>" onclick="return confirm('Xóa tài liệu này?')" class="text-red-500 hover:text-red-700" title="Xóa tài liệu">
                                                <i class="fas fa-times-circle"></i>
                                            </a>
                                        </div>
                                <?php
                                    endforeach;
                                else:
                                    echo '<em class="text-muted text-xs">Không có tài liệu</em>';
                                endif;
                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="index.php?controller=Lesson&action=edit&id=<?php echo $lesson['id']; ?>&course_id=<?php echo htmlspecialchars($course_id); ?>" 
                                   class="text-blue-600 hover:text-blue-900 transition" title="Sửa bài học">
                                   <i class="fas fa-edit"></i> Sửa
                                </a>
                                
                                <a href="index.php?controller=Lesson&action=delete&id=<?php echo $lesson['id']; ?>&course_id=<?php echo htmlspecialchars($course_id); ?>" 
                                   onclick="return confirm('Xóa bài học này?')" 
                                   class="text-red-600 hover:text-red-900 transition" title="Xóa bài học">
                                   <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="mt-8">
        <a href="index.php?controller=Instructor&action=dashboard" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-lg font-medium transition">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại Dashboard
        </a>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>