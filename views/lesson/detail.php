<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($currentLesson['title']); ?> - Học trực tuyến</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex flex-col h-screen overflow-hidden">
    
    <header class="h-16 bg-gray-900 text-white flex items-center justify-between px-6 flex-shrink-0 z-20 shadow-md">
        <div class="flex items-center">
            <a href="index.php?controller=course&action=detail&course_id=<?php echo $course_id; ?>" class="text-gray-400 hover:text-white mr-4 transition">
                <i class="fas fa-chevron-left"></i> Quay lại khóa học
            </a>
            <h1 class="font-bold text-lg truncate max-w-md border-l border-gray-700 pl-4">
                <?php echo htmlspecialchars($currentLesson['title']); ?>
            </h1>
        </div>
        
        <div class="flex items-center space-x-4">
            <form action="index.php?controller=lesson&action=complete" method="POST" class="inline">
                <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                
                <?php if($currentLesson['completed']): ?>
                     <button type="button" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold cursor-default opacity-80">
                        <i class="fas fa-check mr-1"></i> Đã hoàn thành
                    </button>
                <?php else: ?>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg text-sm font-bold transition shadow-lg shadow-purple-900/50">
                        Hoàn thành bài học
                    </button>
                <?php endif; ?>
            </form>

            <?php if(!empty($next_lesson_id)): ?>
                <a href="index.php?controller=lesson&action=detail&course_id=<?php echo $course_id; ?>&lesson_id=<?php echo $next_lesson_id; ?>" class="text-white bg-gray-700 hover:bg-gray-600 w-9 h-9 flex items-center justify-center rounded-full transition" title="Bài tiếp theo">
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
    </header>

    <div class="flex-1 flex overflow-hidden">
        <main class="flex-1 flex flex-col bg-black relative overflow-y-auto custom-scrollbar">
            <div class="flex-1 flex items-center justify-center bg-black min-h-[50vh]">
                <?php if(!empty($currentLesson['video_url'])): ?>
                    <div class="w-full h-full max-w-5xl aspect-video shadow-2xl">
                        <iframe class="w-full h-full" 
                                src="<?php echo htmlspecialchars($currentLesson['video_url']); ?>" 
                                title="Video bài giảng" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                <?php else: ?>
                    <div class="text-center text-gray-500">
                        <i class="fas fa-book-open text-6xl mb-4 opacity-50"></i>
                        <p>Bài học này dạng văn bản. Vui lòng đọc nội dung bên dưới.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-white min-h-[400px] p-8">
                <div class="max-w-4xl mx-auto">
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <a href="#" class="border-purple-500 text-purple-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Nội dung bài học
                            </a>
                        </nav>
                    </div>

                    <div class="prose max-w-none text-gray-800 mb-8">
                        <?php echo nl2br(htmlspecialchars($currentLesson['content'])); ?>
                    </div>

                    <?php if(!empty($material)): ?>
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-paperclip mr-2"></i> Tài liệu đính kèm</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php foreach($material as $mat): ?>
                                    <a href="<?php echo htmlspecialchars($mat['file_path']); ?>" download class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:border-purple-500 hover:shadow-md transition group">
                                        <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-600 group-hover:text-white transition">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-sm font-medium text-gray-900 truncate"><?php echo htmlspecialchars($mat['filename']); ?></p>
                                            <p class="text-xs text-gray-500">Nhấn để tải xuống</p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <aside class="w-80 bg-white border-l border-gray-200 flex-shrink-0 flex flex-col hidden lg:flex">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-800">Nội dung khóa học</h3>
                <p class="text-xs text-gray-500 mt-1"><?php echo count($listLessons); ?> bài học</p>
            </div>
            
            <div class="flex-1 overflow-y-auto">
                <?php foreach($listLessons as $idx => $l): ?>
                    <?php 
                        $activeClass = $l['is_current'] ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-50 border-l-4 border-transparent';
                        $iconStatus = $l['completed'] ? '<i class="fas fa-check-circle text-green-500"></i>' : '<i class="far fa-circle text-gray-400"></i>';
                        if($l['is_current']) $iconStatus = '<i class="fas fa-play-circle text-purple-600"></i>';
                    ?>
                    <a href="index.php?controller=lesson&action=detail&course_id=<?php echo $course_id; ?>&lesson_id=<?php echo $l['id']; ?>" class="block p-4 border-b border-gray-100 transition <?php echo $activeClass; ?>">
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 text-sm">
                                <?php echo $iconStatus; ?>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-800 <?php echo $l['is_current'] ? 'text-purple-700' : ''; ?>">
                                    <?php echo $idx + 1; ?>. <?php echo htmlspecialchars($l['title']); ?>
                                </h4>
                                <span class="text-xs text-gray-400 mt-1 block">Video • 10m</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>
</body>
</html>