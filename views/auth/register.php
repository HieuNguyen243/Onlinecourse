<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; margin-top: 50px; }
        .form-container { border: 1px solid #ccc; padding: 20px; border-radius: 5px; width: 350px; }
        input { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Đăng Ký Học Viên</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=register" method="POST">
            <label>Họ và tên:</label>
            <input type="text" name="fullname" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Tên đăng nhập:</label>
            <input type="text" name="username" required>
            
            <label>Mật khẩu:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Đăng ký</button>
        </form>
        
        <p>Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập</a></p>
    </div>
</body>
</html>