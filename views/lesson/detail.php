<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($currentLesson['title'] ?? 'Bài học'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 h-screen flex flex-col overflow-hidden">
    <div class="flex-1 flex overflow-hidden">
        <main class="flex-1 overflow-y-auto bg-black flex flex-col items-center justify-center relative">
            
            <div class="w-full h-full max-w-5xl max-h-[75vh] aspect-video bg-black shadow-2xl relative">
                <?php if(!empty($currentLesson['video_url'])): ?>
                    <iframe class="w-full h-full" 
                            src="<?php echo htmlspecialchars($currentLesson['video_url']); ?>" 
                            title="Video player" frameborder="0" allowfullscreen>
                    </iframe>
                <?php else: ?>
                    <div class="flex items-center justify-center h-full text-white flex-col">
                        <i class="fas fa-book-open text-4xl mb-4 text-gray-500"></i>
                        <p>Bài học này dạng văn bản hoặc chưa có video.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="w-full bg-gray-900 border-t border-gray-800 p-4 flex justify-between items-center text-white h-auto min-h-[15vh]">
                <div>
                    <h2 class="font-bold text-xl text-purple-400 mb-1">
                        <?php echo htmlspecialchars($currentLesson['title']); ?>
                    </h2>
                    
                    <?php if(!empty($currentLesson['content'])): ?>
                        <div class="text-sm text-gray-400 line-clamp-2 max-w-2xl cursor-pointer hover:text-white" onclick="alert('<?php echo htmlspecialchars(strip_tags($currentLesson['content']), ENT_QUOTES); ?>')">
                            <?php echo strip_tags($currentLesson['content']); ?> <span class="text-xs text-blue-400">(Xem chi tiết)</span>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($materials)): ?>
                        <div class="mt-2 flex space-x-3">
                            <?php foreach($materials as $mat): ?>
                                <a href="<?php echo htmlspecialchars($mat['file_path']); ?>" target="_blank" class="text-xs bg-gray-800 hover:bg-gray-700 px-3 py-1 rounded border border-gray-600 flex items-center">
                                    <i class="fas fa-paperclip mr-2 text-gray-400"></i>
                                    <?php echo htmlspecialchars($mat['filename']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <form action="index.php?controller=lesson&action=complete" method="POST">
                    <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
                    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-bold">
                        Hoàn thành bài học
                    </button>
                </form>
            </div>
        </main>

        <aside class="w-80 bg-white border-l border-gray-200 overflow-y-auto flex-shrink-0">
             </aside>
    </div>
</body>
</html>