<?php
// Xác định link Dashboard dựa trên Role
$dashboardLink = 'index.php'; // Mặc định cho khách
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 0) $dashboardLink = 'index.php?controller=student&action=dashboard';
    elseif ($_SESSION['role'] == 1) $dashboardLink = 'index.php?controller=instructor&action=dashboard';
    elseif ($_SESSION['role'] == 2) $dashboardLink = 'index.php?controller=admin&action=dashboard';
}

// Logic active menu
$currCtr = $_GET['controller'] ?? 'home';
$currAct = $_GET['action'] ?? 'index';
$currFilter = $_GET['filter'] ?? '';

function isHeaderActive($ctr, $act, $filter = '') {
    global $currCtr, $currAct, $currFilter;
    if ($currCtr == $ctr && $currAct == $act && $currFilter == $filter) {
        return 'text-purple-600 font-bold after:w-full';
    }
    return 'text-gray-600 hover:text-purple-600 font-medium';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLearn - Học trực tuyến</title>
    <link rel="icon" href="./assets/images/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .nav-link { position: relative; transition: color 0.3s; }
        .nav-link::after {
            content: ''; position: absolute; width: 0; height: 2px; bottom: -5px; left: 50%;
            background: #667eea; transition: all 0.3s; transform: translateX(-50%);
        }
        .nav-link:hover::after { width: 100%; }
        .nav-link.after\:w-full::after { width: 100%; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                
                <div class="flex items-center space-x-12">
                    <a href="<?php echo $dashboardLink; ?>" class="flex items-center space-x-2 group">
                        <div class="w-9 h-9 gradient-bg rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-purple-200 transition">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                            EduLearn
                        </span>
                    </a>
                    
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="<?php echo $dashboardLink; ?>" class="nav-link <?php echo isHeaderActive('student', 'dashboard', ''); ?>">
                            Trang chủ
                        </a>
                        
                        <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 0): ?>
                        <a href="index.php?controller=student&action=dashboard&filter=enrolled" class="nav-link <?php echo isHeaderActive('student', 'dashboard', 'enrolled'); ?>">
                            Khóa học của tôi
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="relative z-50">
                            <button id="user-menu-btn" class="flex items-center space-x-2 p-1 hover:bg-gray-100 rounded-full transition border border-transparent hover:border-gray-200 focus:outline-none">
                                <div class="w-9 h-9 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    <?php echo strtoupper(substr($_SESSION['fullname'] ?? 'U', 0, 1)); ?>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-gray-700 pr-2">
                                    <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'User'); ?>
                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 pr-2"></i>
                            </button>
                            
                            <div id="user-menu-content" class="hidden absolute right-0 mt-2 w-60 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 overflow-hidden transform origin-top-right transition-all duration-200">
                                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                                    <p class="text-sm font-bold text-gray-800"><?php echo htmlspecialchars($_SESSION['fullname'] ?? 'User'); ?></p>
                                    <p class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></p>
                                </div>
                                <div class="py-1">
                                    <a href="<?php echo $dashboardLink; ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                        <i class="fas fa-tachometer-alt w-6 text-center"></i>
                                        <span class="font-medium">Bảng điều khiển</span>
                                    </a>

                                    <a href="index.php?controller=manageprofile&action=editProfile" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                        <i class="fas fa-tachometer-alt w-6 text-center"></i>
                                        <span class="font-medium">Chỉnh sửa thông tin tài khoản</span>
                                    </a>

                                    <a href="index.php?controller=auth&action=logout" class="flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt w-6 text-center"></i>
                                        <span class="font-medium">Đăng xuất</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center space-x-3">
                            <a href="index.php?controller=auth&action=login" class="text-gray-600 hover:text-purple-600 font-medium transition text-sm">Đăng nhập</a>
                            <a href="index.php?controller=auth&action=register" class="px-5 py-2 bg-gray-900 text-white rounded-full hover:bg-gray-800 shadow-lg transition text-sm font-medium">Đăng ký</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userBtn = document.getElementById('user-menu-btn');
            const userMenu = document.getElementById('user-menu-content');
            if (userBtn && userMenu) {
                userBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                });
                document.addEventListener('click', (e) => {
                    if (!userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    <main class="flex-grow">