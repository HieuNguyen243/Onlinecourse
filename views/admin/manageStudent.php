<?php require './views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800"><i class="fas fa-user-graduate mr-2 text-blue-600"></i> Danh sách sinh viên</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Họ tên</th>
                        <th class="px-6 py-4">Email / Username</th>
                        <th class="px-6 py-4 text-center">Đang học</th> 
                        <th class="px-6 py-4">Ngày tham gia</th>
                        <th class="px-6 py-4 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(!empty($students)): ?>
                        <?php foreach($students as $st): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800"><?php echo htmlspecialchars($st['fullname']); ?></td>
                            <td class="px-6 py-4">
                                <p class="text-sm"><?php echo htmlspecialchars($st['email']); ?></p>
                                <p class="text-xs text-gray-400">@<?php echo htmlspecialchars($st['username']); ?></p>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <?php if($st['course_count'] > 0): ?>
                                    <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                                        <?php echo $st['course_count']; ?> khóa
                                    </span>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400">Chưa đăng ký</span>
                                <?php endif; ?>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo date('d/m/Y', strtotime($st['created_at'])); ?></td>
                            <td class="px-6 py-4 text-center">
                                <a href="index.php?controller=admin&action=deleteUser&id=<?php echo $st['id']; ?>&type=student" 
                                   onclick="return confirm('Bạn chắc chắn muốn xóa sinh viên này?');"
                                   class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1 rounded text-sm font-medium transition">
                                    <i class="fas fa-trash-alt mr-1"></i> Xóa
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Chưa có sinh viên nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require './views/layouts/footer.php'; ?>