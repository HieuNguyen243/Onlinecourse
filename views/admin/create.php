<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Giảng viên mới</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-lg bg-white rounded-xl shadow-lg overflow-hidden m-4">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Thêm Giảng viên mới
            </h2>
        </div>

        <div class="p-8">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p class="font-bold">Lỗi!</p>
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=admin&action=createUser" method="POST">
                
                <div class="mb-5">
                    <label for="fullname" class="block text-gray-700 text-sm font-bold mb-2">Họ và tên</label>
                    <input type="text" name="fullname" id="fullname" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           placeholder="Nhập họ tên đầy đủ">
                </div>

                <div class="mb-5">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Tên đăng nhập</label>
                    <input type="text" name="username" id="username" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           placeholder="username123">
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           placeholder="example@email.com">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           placeholder="••••••••">
                </div>

                <div class="mb-6 bg-blue-50 text-blue-800 px-4 py-3 rounded text-sm flex items-start gap-2">
                    <i class="fas fa-info-circle mt-1"></i>
                    <span>Tài khoản tạo ra sẽ mặc định có quyền là <strong>Giảng viên (Role 1)</strong> theo thiết lập hệ thống.</span>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <a href="index.php?controller=admin&action=index" 
                       class="w-1/2 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition">
                        Hủy bỏ
                    </a>
                    <button type="submit" 
                            class="w-1/2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg shadow transition transform hover:scale-105">
                        Tạo tài khoản
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>