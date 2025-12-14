<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-12 max-w-7xl">
    <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">📚 Danh Sách Học Viên Khóa Học</h3>
        
        <?php if (!empty($students)): ?>
             <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên học viên</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đăng ký</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Tiến độ (%)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($student['fullname'] ?? $student['name'] ?? 'Không tên'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($student['email'] ?? ''); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo !empty($student['enrolled_date']) ? date('d/m/Y', strtotime($student['enrolled_date'])) : '-'; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php 
                                        $status = $student['status'] ?? 'unknown';
                                        $badge_class = ($status === 'completed') ? 'bg-green-500' : (($status === 'active') ? 'bg-blue-500' : 'bg-gray-500');
                                        echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white ' . $badge_class . '">' . htmlspecialchars(ucfirst($status)) . '</span>';
                                    ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full text-xs text-white text-center transition-all duration-500 
                                            <?php echo ($student['progress'] ?? 0) == 100 ? 'bg-green-500' : 'bg-purple-600'; ?>" 
                                            style="width: <?php echo htmlspecialchars($student['progress'] ?? 0); ?>%;">
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 mt-1 block"><?php echo htmlspecialchars($student['progress'] ?? 0); ?>%</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert bg-blue-100 text-blue-700 p-4 rounded-lg text-center">
                <i class="fas fa-info-circle mr-2"></i> Chưa có học viên đăng ký khóa học này.
            </div>
        <?php endif; ?>
        
        <div class="mt-8">
            <a href="index.php?controller=Instructor&action=dashboard" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-lg font-medium transition">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại Dashboard
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>