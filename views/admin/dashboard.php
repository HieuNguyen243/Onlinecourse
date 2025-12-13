<?php require './views/layouts/header.php'; ?>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
</style>

<div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none bg-gray-50">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-1/2 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
</div>
<div class="min-h-screen py-10">
    <div class="container mx-auto px-4">
        
        <div class="mb-12 text-center relative z-10">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Bảng điều khiển Quản Trị</h1>
            <p class="text-gray-600 mt-2 text-lg">Chào mừng trở lại! Hãy chọn một mục để bắt đầu quản lý.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto relative z-10">
            
            <a href="index.php?controller=admin&action=manageStudent" 
               class="group relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-white/50 cursor-pointer overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <i class="fas fa-user-graduate text-9xl text-blue-500 transform rotate-12 translate-x-4 -translate-y-4"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition shadow-inner">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="text-gray-500 font-bold text-sm uppercase tracking-wider mb-2">Sinh viên</h3>
                    <div class="text-4xl font-extrabold text-gray-800 mb-3 group-hover:text-blue-600 transition">
                        <?php echo $countStudent; ?>
                    </div>
                    <span class="inline-flex items-center text-sm font-bold text-blue-600 group-hover:translate-x-2 transition">
                        Xem danh sách <i class="fas fa-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>

            <a href="index.php?controller=admin&action=manageInstructor" 
               class="group relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-white/50 cursor-pointer overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <i class="fas fa-chalkboard-teacher text-9xl text-green-500 transform rotate-12 translate-x-4 -translate-y-4"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition shadow-inner">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="text-gray-500 font-bold text-sm uppercase tracking-wider mb-2">Giảng viên</h3>
                    <div class="text-4xl font-extrabold text-gray-800 mb-3 group-hover:text-green-600 transition">
                        <?php echo $countInstructor; ?>
                    </div>
                    <span class="inline-flex items-center text-sm font-bold text-green-600 group-hover:translate-x-2 transition">
                        Quản lý ngay <i class="fas fa-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>

            <a href="index.php?controller=admin&action=manageCourse" 
               class="group relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-white/50 cursor-pointer overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <i class="fas fa-book-open text-9xl text-purple-500 transform rotate-12 translate-x-4 -translate-y-4"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition shadow-inner">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h3 class="text-gray-500 font-bold text-sm uppercase tracking-wider mb-2">Khóa học</h3>
                    <div class="text-4xl font-extrabold text-gray-800 mb-3 group-hover:text-purple-600 transition">
                        <?php echo $countCourse; ?>
                    </div>
                    <span class="inline-flex items-center text-sm font-bold text-purple-600 group-hover:translate-x-2 transition">
                        Duyệt bài <i class="fas fa-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>

            <a href="index.php?controller=admin&action=manageAdmin" 
               onclick="alert('Chức năng đang phát triển'); return false;"
               class="group relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-white/50 cursor-pointer overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <i class="fas fa-user-shield text-9xl text-red-500 transform rotate-12 translate-x-4 -translate-y-4"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition shadow-inner">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="text-gray-500 font-bold text-sm uppercase tracking-wider mb-2">Quản trị viên</h3>
                    <div class="text-4xl font-extrabold text-gray-800 mb-3 group-hover:text-red-600 transition">
                        <?php echo $countAdmin; ?>
                    </div>
                    <span class="inline-flex items-center text-sm font-bold text-red-600 group-hover:translate-x-2 transition">
                        Xem chi tiết <i class="fas fa-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>

        </div>
    </div>
</div>

<?php require './views/layouts/footer.php'; ?>