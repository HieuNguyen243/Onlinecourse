<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-purple-600 px-6 py-4">
            <h1 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-user-edit"></i> Cập nhật hồ sơ
            </h1>
        </div>

        <div class="p-6">
            <?php if (!empty($message)): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-4"> 
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Họ tên</label>
                    <input type="text" name="fullname" 
                           value="<?php echo isset($currentUser['fullname']) ? htmlspecialchars($currentUser['fullname']) : ''; ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" 
                           value="<?php echo isset($currentUser['email']) ? htmlspecialchars($currentUser['email']) : ''; ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition" required>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Đổi mật khẩu (Tùy chọn)</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu mới</label>
                        <input type="password" name="new_password" placeholder="Để trống nếu không đổi"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nhập lại mật khẩu mới</label>
                        <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow transition transform hover:scale-105">
                        Lưu thay đổi
                    </button>
                    <a href="index.php" class="text-gray-500 hover:text-purple-600 font-medium transition">
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>