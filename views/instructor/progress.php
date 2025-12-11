<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <h3>Theo dõi tiến độ học viên</h3>
        
        <div class="mb-3">
            <form method="get" action="index.php" class="form-inline">
                <input type="hidden" name="controller" value="Instructor">
                <input type="hidden" name="action" value="progress">
                <label for="course_filter" class="me-2">Chọn khóa học:</label>
                <select name="course_id" id="course_filter" class="form-select me-2" onchange="this.form.submit();">
                    <option value="">-- Tất cả khóa học --</option>
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $c): ?>
                            <option value="<?php echo htmlspecialchars($c['id']); ?>" 
                                <?php echo (!empty($_GET['course_id']) && $_GET['course_id'] == $c['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($c['title'] ?? $c['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </form>
        </div>

        <?php if (!empty($students)): ?>
            <table class="table table-striped table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Tên học viên</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Tiến độ</th>
                        <th>Ngày đăng ký</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['fullname'] ?? $student['name'] ?? 'Không tên'); ?></td>
                            <td><?php echo htmlspecialchars($student['email'] ?? ''); ?></td>
                            <td>
                                <?php 
                                    $status = $student['status'] ?? 'unknown';
                                    $badge_class = ($status === 'completed') ? 'bg-success' : (($status === 'active') ? 'bg-info' : 'bg-secondary');
                                    echo '<span class="badge ' . $badge_class . '">' . htmlspecialchars($status) . '</span>';
                                ?>
                            </td>
                            <td>
                                <div class="progress" style="width: 200px;">
                                    <div class="progress-bar" 
                                         role="progressbar" 
                                         style="width: <?php echo htmlspecialchars($student['progress'] ?? 0); ?>%;" 
                                         aria-valuenow="<?php echo htmlspecialchars($student['progress'] ?? 0); ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <?php echo htmlspecialchars($student['progress'] ?? 0); ?>%
                                    </div>
                                </div>
                            </td>
                            <td><?php echo !empty($student['enrolled_date']) ? date('d/m/Y H:i', strtotime($student['enrolled_date'])) : '-'; ?></td>
                            <td>
                                <a href="index.php?controller=Instructor&action=studentDetail&student_id=<?php echo urlencode($student['id'] ?? $student['student_id']); ?>" 
                                   class="btn btn-sm btn-info">Chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info mt-3">Chưa có dữ liệu học viên để hiển thị.</div>
        <?php endif; ?>
        
        <a href="index.php?controller=Instructor&action=index" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
