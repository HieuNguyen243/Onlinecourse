<?php

$currCtr = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$currAct = isset($_GET['action']) ? $_GET['action'] : 'index';

function isSideActive($ctr, $act = null) {
    global $currCtr, $currAct;
    if ($act) {
        return ($currCtr == $ctr && $currAct == $act) ? 'bg-purple-50 text-purple-700 border-r-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600';
    }
    return ($currCtr == $ctr) ? 'bg-purple-50 text-purple-700 border-r-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600';
}
?>

<aside class="w-64 bg-white border-r border-gray-100 hidden md:block flex-shrink-0 min-h-screen">
    <div class="p-6 sticky top-20">
        
        <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 0): ?>
            <div class="flex items-center space-x-3 mb-8 pb-6 border-b border-gray-100">
                <div class="w-12 h-12 bg-gradient-to-tr from-purple-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                    <?php echo strtoupper(substr($_SESSION['fullname'] ?? 'S', 0, 1)); ?>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800"><?php echo htmlspecialchars($_SESSION['fullname']); ?></h3>
                    <p class="text-xs text-green-500 font-medium"><i class="fas fa-circle text-[8px] mr-1"></i>Học viên</p>
                </div>
            </div>

            <div class="mb-8">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Quản lý học tập</h4>
                <nav class="space-y-1">
                    <a href="index.php?controller=student&action=dashboard" class="flex items-center px-4 py-3 text-sm transition rounded-lg <?php echo isSideActive('student', 'dashboard'); ?>">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>Tổng quan</span>
                    </a>
                    
                    <a href="index.php?controller=course&action=listEnrolledCourses" class="flex items-center px-4 py-3 text-sm transition rounded-lg <?php echo isSideActive('course', 'listEnrolledCourses'); ?>">
                        <i class="fas fa-book-reader w-6"></i>
                        <span>Khóa học của tôi</span>
                        <span class="ml-auto bg-purple-100 text-purple-600 py-0.5 px-2 rounded-full text-xs font-bold">
                            3
                        </span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 text-sm transition rounded-lg text-gray-600 hover:bg-gray-50 hover:text-purple-600">
                        <i class="fas fa-chart-line w-6"></i>
                        <span>Tiến độ học tập</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-3 text-sm transition rounded-lg text-gray-600 hover:bg-gray-50 hover:text-purple-600">
                        <i class="fas fa-heart w-6"></i>
                        <span>Yêu thích</span>
                    </a>
                </nav>
            </div>

            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Cá nhân</h4>
                <nav class="space-y-1">
                    <a href="index.php?controller=auth&action=profile" class="flex items-center px-4 py-3 text-sm transition rounded-lg text-gray-600 hover:bg-gray-50 hover:text-purple-600">
                        <i class="fas fa-user-cog w-6"></i>
                        <span>Cài đặt tài khoản</span>
                    </a>
                    <a href="index.php?controller=auth&action=logout" class="flex items-center px-4 py-3 text-sm transition rounded-lg text-red-500 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span>Đăng xuất</span>
                    </a>
                </nav>
            </div>

        <?php else: ?>
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-5 mb-8 text-white shadow-lg relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 bg-white/10 w-24 h-24 rounded-full group-hover:scale-150 transition duration-700"></div>
                <h3 class="font-bold text-lg mb-2 relative z-10">Bắt đầu học ngay!</h3>
                <p class="text-xs text-purple-100 mb-4 relative z-10 opacity-90">Đăng ký để truy cập hàng ngàn khóa học chất lượng.</p>
                <a href="index.php?controller=auth&action=register" class="inline-block w-full text-center bg-white text-purple-600 text-xs font-bold py-2 rounded-lg hover:bg-purple-50 transition relative z-10 shadow-sm">
                    Tạo tài khoản miễn phí
                </a>
            </div>

            <div class="mb-8">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Khám phá</h4>
                <nav class="space-y-1">
                    <a href="index.php?controller=course&action=listAllCourses" class="flex items-center px-4 py-3 text-sm transition rounded-lg <?php echo isSideActive('course', 'listAllCourses'); ?>">
                        <i class="fas fa-th-large w-6"></i>
                        <span>Tất cả khóa học</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-sm transition rounded-lg text-gray-600 hover:bg-gray-50 hover:text-purple-600">
                        <i class="fas fa-fire w-6 text-red-500"></i>
                        <span>Phổ biến nhất</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-sm transition rounded-lg text-gray-600 hover:bg-gray-50 hover:text-purple-600">
                        <i class="fas fa-star w-6 text-yellow-500"></i>
                        <span>Đánh giá cao</span>
                    </a>
                </nav>
            </div>

            <?php if(isset($categories) && is_array($categories)): ?>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Chủ đề</h4>
                <nav class="space-y-1 max-h-64 overflow-y-auto custom-scrollbar pr-2">
                    <?php foreach($categories as $cat): ?>
                    <form action="index.php?controller=course&action=listCoursesByCategory" method="POST" id="cat-form-<?php echo $cat['id']; ?>">
                        <input type="hidden" name="category_id" value="<?php echo $cat['id']; ?>">
                        <a href="#" onclick="document.getElementById('cat-form-<?php echo $cat['id']; ?>').submit();" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:text-purple-600 transition group">
                            <span class="w-2 h-2 rounded-full bg-gray-300 group-hover:bg-purple-500 mr-3 transition"></span>
                            <span><?php echo htmlspecialchars($cat['name']); ?></span>
                        </a>
                    </form>
                    <?php endforeach; ?>
                </nav>
            </div>
            <?php endif; ?>

        <?php endif; ?>
        
    </div>
</aside>