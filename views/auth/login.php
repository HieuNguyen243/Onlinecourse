
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - EduLearn</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4e54c8;
            --secondary-color: #8f94fb;
            --text-color: #333;
            --bg-gray: #f4f7f6;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-gray);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            width: 900px;
            max-width: 95%;
            height: 550px;
            display: flex;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-radius: 20px;
            overflow: hidden;
        }

        /* Phần bên trái - Ảnh minh họa */
        .left-panel {
            flex: 1;
            background: linear-gradient(rgba(78, 84, 200, 0.85), rgba(143, 148, 251, 0.9)), 
                        url('https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            text-align: center;
        }

        .left-panel h2 { font-size: 2em; margin-bottom: 15px; }
        .left-panel p { font-size: 0.95em; line-height: 1.6; opacity: 0.9; }

        /* Phần bên phải - Form */
        .right-panel {
            flex: 1;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Logo Design */
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 24px;
        }
        .logo i { font-size: 32px; margin-right: 10px; }

        h3 { 
            text-align: center; 
            color: var(--text-color); 
            margin-bottom: 5px; 
            font-size: 1.5em;
        }
        
        .subtitle {
            text-align: center;
            color: #888;
            font-size: 0.9em;
            margin-bottom: 30px;
        }

        /* Input Group có Icon */
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            transition: color 0.3s;
        }
        
        input {
            width: 100%;
            padding: 12px 15px 12px 45px; /* Padding left lớn để né icon */
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
        }

        input:focus {
            border-color: var(--primary-color);
        }
        
        input:focus + i {
            color: var(--primary-color);
        }

        button.btn-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(78, 84, 200, 0.3);
            transition: transform 0.2s;
        }

        button.btn-submit:hover { transform: translateY(-2px); }

        .error-msg {
            background: #ffecec;
            color: #e74c3c;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.85em;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
        }

        .switch-page {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9em;
        }
        .switch-page a { color: var(--primary-color); text-decoration: none; font-weight: 600; }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container { flex-direction: column; height: auto; }
            .left-panel { display: none; } /* Ẩn ảnh trên mobile để gọn */
            .right-panel { padding: 40px 30px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="left-panel">
            <h2>Học không giới hạn</h2>
            <p>"Đầu tư vào tri thức luôn mang lại lợi nhuận cao nhất." <br>- Benjamin Franklin</p>
        </div>

        <div class="right-panel">
            <div class="logo">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>EduLearn</span>
            </div>

            <h3>Đăng Nhập</h3>
            <span class="subtitle">Chào mừng bạn quay trở lại!</span>

            <?php if (isset($error)): ?>
                <div class="error-msg">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=auth&action=login" method="POST">
                <div class="input-group">
                    <input type="email" name="email" required placeholder="Email của bạn">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                
                <div class="input-group">
                    <input type="password" name="password" required placeholder="Mật khẩu">
                    <i class="fa-solid fa-lock"></i>
                </div>
                
                <button type="submit" class="btn-submit">Đăng nhập</button>
            </form>

            <div class="switch-page">
                Chưa có tài khoản? <a href="index.php?controller=auth&action=register">Đăng ký ngay</a>
            </div>
        </div>
    </div>

</body>
</html>