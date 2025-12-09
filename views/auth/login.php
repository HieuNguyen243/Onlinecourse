<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; margin-top: 50px; }
        .form-container { border: 1px solid #ccc; padding: 20px; border-radius: 5px; width: 300px; }
        input { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Đăng Nhập</h2>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=login" method="POST">
            <label>Email đăng nhập:</label>
            <input type="text" name="email" required placeholder="Nhập email">
            
            <label>Mật khẩu:</label>
            <input type="password" name="password" required placeholder="Nhập password">
            
            <button type="submit">Đăng nhập</button>
        </form>
        
        <p>Chưa có tài khoản? <a href="index.php?controller=auth&action=register">Đăng ký ngay</a></p>
    </div>
</body>
</html>