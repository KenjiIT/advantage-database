<?php
// Bắt đầu hoặc sử dụng session đã tồn tại
session_start();

if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
} else {
    $loggedInUser = "Khách"; // Hoặc thay thế bằng giá trị mặc định
}
?>
<link rel="stylesheet" href="/css/MainWebsite.css">
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Trang Chủ</title>
        
    </head>
    <body>
        <div class="container">
            <h1 id="usernameDisplay">Xin chào, <?php echo $loggedInUser; ?>!</h1>
            <button id="menuBtn">|||</button>
            <div class="menu" id="menu" style="display: none;">
            <a href="/php/Uploadmenu.php" class="textdecor">
                <option>Thêm món vào menu</option>
            </a>
            <a href="#" class="textdecor">
                <option>Lịch sử khách đặt hàng</option>
            </a>
            <a href="/php/Account.php" class="textdecor">
                <option>Đăng xuất</a></option>
            </a>
            </div>
        </div>

        <script>
        // Hiển thị hoặc ẩn menu khi click vào nút "|||"
        const menuBtn = document.getElementById("menuBtn");
        const menu = document.getElementById("menu");
        menuBtn.addEventListener("click", function() {
            if (menu.style.display === "block" || menu.style.display === "") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        });
        </script>
    </body>
</html>
