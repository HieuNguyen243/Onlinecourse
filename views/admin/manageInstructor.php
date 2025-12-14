<?php require './views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    
    <div class="mb-8 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
        <h2 class="text-lg font-bold mb-4 flex items-center"><i class="fas fa-plus-circle mr-2"></i> Thêm giảng viên mới</h2>
        <form action="index.php?controller=admin&action=createInstructor" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <input type="text" name="fullname" placeholder="Họ tên" required class="px-4 py-2 rounded text-gray-800 focus:outline-none">
            <input type="text" name="username" placeholder="Username" required class="px-4 py-2 rounded text-gray-800 focus:outline-none">
            <input type="email" name="email" placeholder="Email" required class="px-4 py-2 rounded text-gray-800 focus:outline-none">
            <input type="password" name="password" placeholder="Mật khẩu" required class="px-4 py-2 rounded text-gray-800 focus:outline-none">
            <button type="submit" class="bg-white text-purple-600 font-bold py-2 rounded hover:bg-gray-100 transition shadow">
                <i class="fas fa-user-plus"></i> Thêm ngay
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <?php if(!empty($instructors)): ?>
            <?php foreach($instructors as $inst): ?>
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-50">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-xl">
                            <?php echo strtoupper(substr($inst['fullname'], 0, 1)); ?>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-800"><?php echo htmlspecialchars($inst['fullname']); ?></h3>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($inst['email']); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                         <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                            <?php echo count($inst['courses']); ?> khóa học
                        </span>
                        <a href="index.php?controller=admin&action=deleteUser&id=<?php echo $inst['id']; ?>&type=instructor" 
                           onclick="return confirm('Xóa giảng viên này? Lưu ý: Không thể xóa nếu họ đang có khóa học.');"
                           class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 px-4 py-2 rounded-lg text-sm font-bold transition">
                            <i class="fas fa-trash-alt"></i> Xóa GV
                        </a>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Khóa học phụ trách:</h4>
                    <?php if(!empty($inst['courses'])): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach($inst['courses'] as $c): ?>
                                <span class="bg-white border border-gray-200 text-gray-700 text-xs px-3 py-1 rounded shadow-sm">
                                    <?php echo htmlspecialchars($c['title']); ?>
                                    <?php if($c['status'] == 'approved'): ?>
                                        <i class="fas fa-check-circle text-green-500 ml-1"></i>
                                    <?php else: ?>
                                        <i class="fas fa-clock text-yellow-500 ml-1"></i>
                                    <?php endif; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-xs text-gray-400 italic">Chưa có khóa học nào.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-10 text-gray-500">Chưa có giảng viên nào.</div>
        <?php endif; ?>
    </div>
</div>