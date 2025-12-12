<?php
// views/admin/users/manage.php

// Hàm helper để hiển thị Role đẹp hơn (có thể viết vào file helper riêng)
function getRoleBadge($role) {
    switch ($role) {
        case 2:
            return '<span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Admin</span>';
        case 1:
            return '<span class="px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Giảng viên</span>';
        default:
            return '<span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Học viên</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    
    <div class="container mx-auto px-4 py-8">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 border-l-4 border-purple-600 pl-4">
                Danh sách người dùng
            </h1>
            <a href="index.php?controller=admin&action=createUser" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg shadow transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Thêm giảng viên
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Họ và tên
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Email / Username
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Vai trò
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Ngày tạo
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-500">
                                    #<?php echo $user['id']; ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <div class="w-full h-full rounded-full bg-gradient-to-br from-purple-400 to-blue-500 flex items-center justify-center text-white font-bold uppercase">
                                                <?php echo substr($user['fullname'], 0, 1); ?>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 font-bold whitespace-no-wrap">
                                                <?php echo htmlspecialchars($user['fullname']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($user['email']); ?></p>
                                    <p class="text-gray-400 text-xs mt-1">@<?php echo htmlspecialchars($user['username']); ?></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <?php echo getRoleBadge($user['role']); ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-500">
                                    <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <div class="flex justify-center space-x-3">
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <a href="index.php?controller=admin&action=deleteUser&id=<?php echo $user['id']; ?>" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác!');"
                                               class="text-red-500 hover:text-red-700 transition" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-300 cursor-not-allowed" title="Không thể xóa chính mình"><i class="fas fa-trash-alt"></i></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                    Chưa có dữ liệu người dùng.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <a href="index.php" class="text-gray-600 hover:text-purple-600 font-medium">
                &larr; Quay về trang chủ
            </a>
        </div>
    </div>

</body>
</html>