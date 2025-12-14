<?php require './views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-red-50 to-white">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-user-shield mr-2 text-red-600"></i> Danh sách Quản trị viên
            </h2>
            </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Họ tên</th>
                        <th class="px-6 py-4">Email / Username</th>
                        <th class="px-6 py-4">Ngày tham gia</th>
                        <th class="px-6 py-4 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(!empty($admins)): ?>
                        <?php foreach($admins as $index => $admin): ?>
                        <tr class="hover:bg-red-50/30 transition">
                            <td class="px-6 py-4 text-gray-400 font-mono text-xs"><?php echo $index + 1; ?></td>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                <?php echo htmlspecialchars($admin['fullname']); ?>
                                <?php if($admin['id'] == $_SESSION['user_id']): ?>
                                    <span class="ml-2 bg-red-100 text-red-600 text-[10px] px-2 py-0.5 rounded-full border border-red-200">Tôi</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium"><?php echo htmlspecialchars($admin['email']); ?></p>
                                <p class="text-xs text-gray-400">@<?php echo htmlspecialchars($admin['username']); ?></p>
                            </td>
                            
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php echo date('d/m/Y', strtotime($admin['created_at'])); ?>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                <?php if($admin['id'] != $_SESSION['user_id']): ?>
                                    <a href="index.php?controller=admin&action=deleteUser&id=<?php echo $admin['id']; ?>&type=admin" 
                                       onclick="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa quyền quản trị của người này?');"
                                       class="text-red-500 hover:text-white border border-red-200 hover:bg-red-500 px-3 py-1.5 rounded text-xs font-bold transition shadow-sm">
                                        <i class="fas fa-trash-alt mr-1"></i> Xóa
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-300 text-xs italic">Đang truy cập</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Không tìm thấy quản trị viên nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require './views/layouts/footer.php'; ?>