<?php require __DIR__ . '/../layouts/header.php'; ?>

<?php
$course_id = isset($course_id) ? $course_id : (isset($_GET['course_id']) ? $_GET['course_id'] : null);
?>

<div class="row">
    <div class="col-12">
        <h2>Quản lý bài học<?php echo $course_id ? " - Khóa học #$course_id" : ""; ?></h2>

        <p><a href="index.php?controller=Lesson&action=create&course_id=<?php echo htmlspecialchars($course_id); ?>" class="btn btn-success">Thêm bài học mới</a></p>

        <?php if (empty($lessons)): ?>
            <div class="alert alert-info">Không có bài học.</div>
        <?php else: ?>
            <table class="table table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Thứ tự</th>
                        <th>Video</th>
                        <th>Tài liệu</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lessons as $i => $lesson): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                            <td><?php echo htmlspecialchars($lesson['order']); ?></td>
                            <td><?php echo !empty($lesson['video_url']) ? '<a href="'.htmlspecialchars($lesson['video_url']).'" target="_blank" class="btn btn-sm btn-link">Xem</a>' : '-'; ?></td>
                            <td>
                                <?php
                                if (!empty($lesson['materials']) && is_array($lesson['materials'])):
                                    foreach ($lesson['materials'] as $m):
                                ?>
                                        <div>
                                            <a href="<?php echo htmlspecialchars($m['file_path']); ?>" target="_blank"><?php echo htmlspecialchars($m['file_name']); ?></a>
                                            | <a href="index.php?controller=Lesson&action=deleteMaterial&material_id=<?php echo $m['id']; ?>&course_id=<?php echo htmlspecialchars($course_id); ?>" onclick="return confirm('Xóa tài liệu này?')" class="text-danger">Xóa</a>
                                        </div>
                                <?php
                                    endforeach;
                                else:
                                    echo '<em class="text-muted">Chưa có tài liệu</em>';
                                endif;
                                ?>
                            </td>
                            <td>
                                <a href="index.php?controller=Lesson&action=edit&id=<?php echo $lesson['id']; ?>&course_id=<?php echo htmlspecialchars($course_id); ?>" class="btn btn-sm btn-primary">Sửa</a>
                                | <a href="index.php?controller=Lesson&action=delete&id=<?php echo $lesson['id']; ?>&course_id=<?php echo htmlspecialchars($course_id); ?>" onclick="return confirm('Xóa bài học này?')" class="btn btn-sm btn-danger">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="index.php?controller=Instructor&action=index" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
