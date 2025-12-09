<?php include 'views/layouts/header.php'; ?>

<div style="padding: 20px;">
    <h2>Quản Lý Người Dùng</h2>

    <a href="index.php?controller=admin&action=createUser" 
       style="background: green; color: white; padding: 10px; text-decoration: none;">
       + Thêm người dùng mới
    </a>

    <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>ID</th>
                <th>Username</th>
                <th>Họ tên</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['fullname']; ?></td>
                <td>
                    <?php 
                        if($user['role'] == 0) echo "Học viên";
                        elseif($user['role'] == 1) echo "Giảng viên";
                        elseif($user['role'] == 2) echo "Admin";
                    ?>
                </td>
                <td style="text-align: center;">
                    <a href="index.php?controller=admin&action=deleteUser&id=<?php echo $user['id']; ?>" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa user này không?');"
                       style="color: red;">
                       Xóa
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>