<?php
// Lấy Controller và Action hiện tại để highlight menu
$currentController = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$currentAction     = isset($_GET['action']) ? $_GET['action'] : 'index';

// Helper function để check active menu
function isActive($ctr, $act = null) {
    global $currentController, $currentAction;
    if ($act) {
        return ($currentController == $ctr && $currentAction == $act) ? 'text-purple-600 font-bold' : 'text-gray-700 hover:text-purple-600 font-medium';
    }
    return ($currentController == $ctr) ? 'text-purple-600 font-bold' : 'text-gray-700 hover:text-purple-600 font-medium';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nền tảng học trực tuyến hàng đầu">
    
    <title><?php echo isset($pageTitle) ? $pageTitle : 'EduLearn - Nền tảng học trực tuyến'; ?></title>
    
    <link rel="icon" href="./assets/images/favicon.ico">

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        
        /* Hiệu ứng gạch chân menu */
        .nav-link { position: relative; transition: color 0.3s; }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background: #667eea;
            transition: all 0.3s;
            transform: translateX(-50%);
        }
        .nav-link:hover::after { width: 100%; }
        
        /* Dropdown logic */
        .dropdown:hover .dropdown-menu { display: block; animation: fadeIn 0.2s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                
                <div class="flex items-center space-x-8">
                    <a href="index.php" class="flex items-center space-x-2 group">
                        <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-purple-200 transition">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                            EduLearn
                        </span>
                    </a>
                    
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="index.php" class="nav-link <?php echo isActive('home'); ?>">
                            Trang chủ
                        </a>
                        <a href="index.php?controller=course&action=listAllCourses" class="nav-link <?php echo isActive('course', 'listAllCourses'); ?>">
                            Khóa học
                        </a>
                        
                        <?php if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
                        <a href="index.php?controller=course&action=listEnrolledCourses" class="nav-link <?php echo isActive('course', 'listEnrolledCourses'); ?>">
                            Khóa của tôi
                        </a>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                        <a href="index.php?controller=Instructor&action=progress" class="nav-link <?php echo isActive('Instructor', 'progress'); ?>">
                            Theo dõi tiến độ
                        </a>
                        <?php endif; ?>

                    </div>
                </div>
                
                <div class="hidden lg:flex flex-1 max-w-md mx-8">
                    <form action="index.php?controller=course&action=searchCourses" method="POST" class="w-full">
                        <div class="relative group">
                            <input 
                                type="text" 
                                name="keyword" 
                                placeholder="Tìm kiếm khóa học..." 
                                class="w-full pl-10 pr-10 py-2 border border-gray-200 rounded-full bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            >
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-purple-500"></i>
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-purple-600 cursor-pointer">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <button class="relative p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-full transition">
                            <i class="far fa-bell text-xl"></i>
                            <span class="absolute top-1 right-2 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                        </button>
                        
                        <div class="relative dropdown z-50">
                            <button class="flex items-center space-x-2 p-1 hover:bg-gray-100 rounded-full transition border border-transparent hover:border-gray-200">
                                <div class="w-9 h-9 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    <?php echo strtoupper(substr($_SESSION['fullname'] ?? 'U', 0, 1)); ?>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-gray-700 pr-2">
                                    <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'User'); ?>
                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 pr-2"></i>
                            </button>
                            
                            <div class="dropdown-menu hidden absolute right-0 mt-2 w-60 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                                    <p class="text-sm font-bold text-gray-800"><?php echo htmlspecialchars($_SESSION['fullname'] ?? 'User'); ?></p>
                                    <p class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></p>
                                </div>
                                
                                <div class="py-1">
                                    <?php 
                                        $dashboardLink = 'index.php?controller=student&action=dashboard'; // Mặc định student
                                        if (isset($_SESSION['role'])) {
                                            if ($_SESSION['role'] == 1) $dashboardLink = 'index.php?controller=instructor&action=dashboard';
                                            if ($_SESSION['role'] == 2) $dashboardLink = 'index.php?controller=admin&action=dashboard';
                                        }
                                    ?>
                                    <a href="<?php echo $dashboardLink; ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                        <i class="fas fa-tachometer-alt w-6 text-center"></i>
                                        <span class="font-medium">Bảng điều khiển</span>
                                    </a>

                                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
                                    <a href="index.php?controller=course&action=listEnrolledCourses" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                        <i class="fas fa-book-reader w-6 text-center"></i>
                                        <span class="font-medium">Khóa học của tôi</span>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <a href="index.php?controller=auth&action=profile" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                        <i class="far fa-user-circle w-6 text-center"></i>
                                        <span>Thông tin cá nhân</span>
                                    </a>
                                </div>
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <a href="index.php?controller=auth&action=logout" class="flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                    <i class="fas fa-sign-out-alt w-6 text-center"></i>
                                    <span class="font-medium">Đăng xuất</span>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center space-x-3">
                            <a href="index.php?controller=auth&action=login" class="hidden sm:block px-5 py-2 text-gray-600 hover:text-purple-600 font-medium transition rounded-full hover:bg-purple-50">
                                Đăng nhập
                            </a>
                            <a href="index.php?controller=auth&action=register" class="px-5 py-2 bg-gray-900 text-white rounded-full hover:bg-gray-800 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 font-medium text-sm">
                                Đăng ký ngay
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <button id="mobile-menu-btn" class="md:hidden p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-3 space-y-1">
                <a href="index.php" class="block px-3 py-2 rounded-lg text-base font-medium <?php echo ($currentController == 'home') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50'; ?>">
                    <i class="fas fa-home w-6"></i> Trang chủ
                </a>
                <a href="index.php?controller=course&action=listAllCourses" class="block px-3 py-2 rounded-lg text-base font-medium <?php echo ($currentController == 'course' && $currentAction == 'listAllCourses') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50'; ?>">
                    <i class="fas fa-book w-6"></i> Khóa học
                </a>
                
                <?php if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                <a href="index.php?controller=Instructor&action=progress" class="block px-3 py-2 rounded-lg text-base font-medium <?php echo ($currentController == 'Instructor' && $currentAction == 'progress') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50'; ?>">
                    <i class="fas fa-chart-pie w-6"></i> Theo dõi tiến độ
                </a>
                <?php endif; ?>

                <?php if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
                <a href="index.php?controller=course&action=listEnrolledCourses" class="block px-3 py-2 rounded-lg text-base font-medium <?php echo ($currentController == 'course' && $currentAction == 'listEnrolledCourses') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50'; ?>">
                    <i class="fas fa-book-reader w-6"></i> Khóa của tôi
                </a>
                <?php endif; ?>
                
                <div class="pt-4 pb-2">
                    <form action="index.php?controller=course&action=searchCourses" method="POST">
                        <div class="relative">
                            <input type="text" name="keyword" placeholder="Tìm kiếm khóa học..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-gray-50">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        if(btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    </script>
    
    <main class="flex-grow">