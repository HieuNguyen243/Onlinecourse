 <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - EduLearn</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* (Dán toàn bộ nội dung trong thẻ <style> của file login.php vào đây) */
        /* ... CSS code ... */
        
        /* Cần chỉnh lại một chút chiều cao container cho form đăng ký vì nó dài hơn */
        :root { --primary-color: #4e54c8; --secondary-color: #8f94fb; --text-color: #333; --bg-gray: #f4f7f6; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-gray); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px 0;}
        .container { background: #fff; width: 900px; max-width: 95%; display: flex; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-radius: 20px; overflow: hidden; min-height: 600px; /* Cao hơn chút */ }
        .left-panel { flex: 1; background: linear-gradient(rgba(78, 84, 200, 0.85), rgba(143, 148, 251, 0.9)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80'); background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; padding: 40px; text-align: center; }
        .left-panel h2 { font-size: 2em; margin-bottom: 15px; }
        .left-panel p { font-size: 0.95em; line-height: 1.6; opacity: 0.9; }
        .right-panel { flex: 1; padding: 40px 50px; display: flex; flex-direction: column; justify-content: center; }
        .logo { display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: var(--primary-color); font-weight: 700; font-size: 24px; }
        .logo i { font-size: 32px; margin-right: 10px; }
        h3 { text-align: center; color: var(--text-color); margin-bottom: 5px; font-size: 1.5em; }
        .subtitle { text-align: center; color: #888; font-size: 0.9em; margin-bottom: 25px; }
        .input-group { position: relative; margin-bottom: 15px; } /* Giảm margin chút cho gọn */
        .input-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa; transition: color 0.3s; }
        input { width: 100%; padding: 12px 15px 12px 45px; border: 2px solid #eee; border-radius: 8px; font-size: 14px; outline: none; transition: all 0.3s; }
        input:focus { border-color: var(--primary-color); }
        input:focus + i { color: var(--primary-color); }
        button.btn-submit { width: 100%; padding: 12px; background: linear-gradient(to right, #4e54c8, #8f94fb); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 5px 15px rgba(78, 84, 200, 0.3); transition: transform 0.2s; margin-top: 10px;}
        button.btn-submit:hover { transform: translateY(-2px); }
        .error-msg { background: #ffecec; color: #e74c3c; padding: 10px; border-radius: 5px; font-size: 0.85em; margin-bottom: 20px; border-left: 4px solid #e74c3c; }
        .switch-page { text-align: center; margin-top: 20px; font-size: 0.9em; }
        .switch-page a { color: var(--primary-color); text-decoration: none; font-weight: 600; }
        @media (max-width: 768px) { .container { flex-direction: column; height: auto; } .left-panel { display: none; } .right-panel { padding: 40px 30px; } }
    </style>
</head>
<body>

    <div class="container">
        <div class="left-panel">
            <h2>Gia nhập EduLearn</h2>
            <p>"Hành trình vạn dặm bắt đầu từ một bước chân." <br> Hãy tạo tài khoản để bắt đầu học ngay hôm nay.</p>
        </div>

        <div class="right-panel">
            <div class="logo">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>EduLearn</span>
            </div>

            <h3>Tạo Tài Khoản</h3>
            <span class="subtitle">Điền thông tin bên dưới để đăng ký</span>

            <?php if (isset($error)): ?>
                <div class="error-msg">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=auth&action=register" method="POST">
                <div class="input-group">
                    <input type="text" name="fullname" required placeholder="Họ và tên">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="input-group">
                    <input type="email" name="email" required placeholder="Địa chỉ Email">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="username" required placeholder="Tên đăng nhập">
                    <i class="fa-solid fa-at"></i>
                </div>
                
                <div class="input-group">
                    <input type="password" name="password" required placeholder="Mật khẩu">
                    <i class="fa-solid fa-lock"></i>
                </div>
                
                <button type="submit" class="btn-submit">Đăng ký thành viên</button>
            </form>

            <div class="switch-page">
                Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập</a>
            </div>
        </div>
    </div>

</body>
</html>