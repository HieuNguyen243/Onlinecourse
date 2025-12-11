<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <h3>Danh sách học viên</h3>
        <?php if (!empty($students)): ?>
            <table class="table table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Tên học viên</th>
                        <th>Email</th>
                        <th>Ngày đăng ký</th>
                        <th>Trạng thái</th>
                        <th>Tiến độ (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['fullname'] ?? $student['name'] ?? 'Không tên'); ?></td>
                            <td><?php echo htmlspecialchars($student['email'] ?? ''); ?></td>
                            <td><?php echo !empty($student['enrolled_date']) ? date('d/m/Y', strtotime($student['enrolled_date'])) : '-'; ?></td>
                            <td>
                                <?php 
                                    $status = $student['status'] ?? 'unknown';
                                    $badge_class = ($status === 'completed') ? 'bg-success' : (($status === 'active') ? 'bg-info' : 'bg-secondary');
                                    echo '<span class="badge ' . $badge_class . '">' . htmlspecialchars($status) . '</span>';
                                ?>
                            </td>
                            <td>
                                <div class="progress" style="width: 150px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: <?php echo htmlspecialchars($student['progress'] ?? 0); ?>%;" 
                                         aria-valuenow="<?php echo htmlspecialchars($student['progress'] ?? 0); ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <?php echo htmlspecialchars($student['progress'] ?? 0); ?>%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info mt-3">Chưa có học viên đăng ký khóa học này.</div>
        <?php endif; ?>
        <a href="index.php?controller=Instructor&action=index" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
