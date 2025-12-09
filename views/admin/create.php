<?php include 'views/layouts/header.php'; ?>

<div style="width: 400px; margin: 20px auto; border: 1px solid #ccc; padding: 20px;">
    <h3>Thêm Người Dùng Mới</h3>
    
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form action="index.php?controller=admin&action=createUser" method="POST">
        <div style="margin-bottom: 10px;">
            <label>Tên đăng nhập:</label><br>
            <input type="text" name="username" required style="width: 100%">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label>Mật khẩu:</label><br>
            <input type="password" name="password" required style="width: 100%">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Họ và tên:</label><br>
            <input type="text" name="fullname" required style="width: 100%">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Email:</label><br>
            <input type="email" name="email" required style="width: 100%">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Vai trò:</label><br>
            <select name="role" style="width: 100%">
                <option value="0">Học viên</option>
                <option value="1">Giảng viên</option>
                <option value="2">Quản trị viên</option>
            </select>
        </div>

        <button type="submit" style="background: blue; color: white; padding: 10px; width: 100%;">
            Lưu người dùng
        </button>
    </form>
    
    <br>
    <a href="index.php?controller=admin&action=index">Quay lại danh sách</a>
</div>