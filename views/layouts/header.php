<nav>
    <a href="index.php">Trang chủ</a>


    <?php if (isset($_SESSION['user_id'])): ?>
        <span>Xin chào, <b><?php echo $_SESSION['username']; ?></b></span>
       
        <?php if ($_SESSION['role'] == 2): ?>
            <a href="index.php?controller=admin&action=index">Quản trị</a>
        <?php endif; ?>


        <a href="index.php?controller=auth&action=logout"
           style="color: red; margin-left: 10px;">
           Đăng xuất
        </a>


    <?php else: ?>
        <a href="index.php?controller=auth&action=login">Đăng nhập</a>
        <a href="index.php?controller=auth&action=register">Đăng ký</a>
    <?php endif; ?>
</nav>
<hr>
