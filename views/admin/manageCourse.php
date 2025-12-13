<?php require './views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quản lý Khóa học</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden h-fit">
            <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-100">
                <h2 class="text-lg font-bold text-yellow-700 flex items-center">
                    <i class="fas fa-clock mr-2"></i> Đang chờ phê duyệt
                    <span class="ml-2 bg-yellow-200 text-yellow-800 text-xs px-2 py-0.5 rounded-full"><?php echo count($pendingCourses); ?></span>
                </h2>
            </div>
            <div class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto custom-scrollbar">
                <?php if(!empty($pendingCourses)): ?>
                    <?php foreach($pendingCourses as $pc): ?>
                    <div class="p-6 hover:bg-yellow-50/30 transition">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded uppercase"><?php echo htmlspecialchars($pc['category_name']); ?></span>
                            <span class="text-xs text-gray-400"><?php echo date('d/m/Y', strtotime($pc['created_at'])); ?></span>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1 text-lg"><?php echo htmlspecialchars($pc['title']); ?></h3>
                        <p class="text-sm text-gray-500 mb-3"><i class="fas fa-user-tie mr-1"></i> GV: <?php echo htmlspecialchars($pc['instructor_name']); ?></p>
                        
                        <div class="flex space-x-2 mt-4">
                            <a href="index.php?controller=admin&action=setCourseStatus&id=<?php echo $pc['id']; ?>&status=approved" 
                               class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-2 rounded text-sm font-bold shadow transition">
                                <i class="fas fa-check"></i> Chấp nhận
                            </a>
                            <a href="index.php?controller=admin&action=setCourseStatus&id=<?php echo $pc['id']; ?>&status=rejected" 
                               onclick="return confirm('Từ chối khóa học này?');"
                               class="flex-1 bg-red-100 hover:bg-red-200 text-red-600 text-center py-2 rounded text-sm font-bold transition">
                                <i class="fas fa-times"></i> Từ chối
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-8 text-center text-gray-400">Không có khóa học nào chờ duyệt.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden h-fit">
            <div class="bg-green-50 px-6 py-4 border-b border-green-100">
                <h2 class="text-lg font-bold text-green-700 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Đã phê duyệt & Hoạt động
                    <span class="ml-2 bg-green-200 text-green-800 text-xs px-2 py-0.5 rounded-full"><?php echo count($approvedCourses); ?></span>
                </h2>
            </div>
            <div class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto custom-scrollbar">
                <?php if(!empty($approvedCourses)): ?>
                    <?php foreach($approvedCourses as $ac): ?>
                    <div class="p-6 hover:bg-gray-50 transition flex justify-between items-center group">
                        <div class="flex-1 pr-4">
                            <h3 class="font-bold text-gray-800 mb-1 group-hover:text-purple-600 transition">
                                <a href="index.php?controller=course&action=detail&course_id=<?php echo $ac['id']; ?>"><?php echo htmlspecialchars($ac['title']); ?></a>
                            </h3>
                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                                <span><i class="fas fa-user-tie text-gray-400"></i> <?php echo htmlspecialchars($ac['instructor_name']); ?></span>
                                <span><i class="fas fa-users text-blue-500"></i> <b><?php echo $ac['student_count']; ?></b> học viên</span>
                            </div>
                        </div>
                        <div>
                             <a href="index.php?controller=admin&action=setCourseStatus&id=<?php echo $ac['id']; ?>&status=pending" 
                               title="Gỡ khóa học (về trạng thái chờ)"
                               class="text-gray-300 hover:text-yellow-500 transition">
                                <i class="fas fa-undo-alt text-lg"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-8 text-center text-gray-400">Chưa có khóa học nào hoạt động.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>