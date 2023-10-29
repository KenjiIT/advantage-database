<?php
// Bắt đầu hoặc sử dụng session đã tồn tại
session_start();

if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
    $cid = $_SESSION['cid'];
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
            <a href="/php/employmanage.php" class="textdecor">
                <option>Quản lý nhân viên</option>
            </a>
            <a href="/php/Uploadmenu.php" class="textdecor">
                <option>Thêm món vào menu</option>
            </a>
            <a href="php/History.php" class="textdecor">
                <option>Lịch sử khách đặt hàng</option>
            </a>
            <a href="/php/Account.php" class="textdecor">
                <option>Đăng xuất</a></option>
            </a>
            </div>
        </div>
        <div class="menusize">
        <table>
            <tr>
                <th>Tên món ăn</th>
                <th>Nguyên liệu</th>
                <th>Giá</th>
            </tr>
            <?php
            // Kết nối với cơ sở dữ liệu SQL
            $servername = "localhost";
            $username = "root";
            $password = "1234";
            $dbname = "employee";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Thực hiện truy vấn SQL để lấy dữ liệu từ bảng menu
            $sql = "SELECT * FROM menu";
            $result = $conn->query($sql);

            // Kiểm tra và hiển thị dữ liệu nếu có
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="editable" contenteditable="true">' . $row["Name"] . '</td>';
                    echo '<td class="editable" contenteditable="true">' . $row["Ingrediant"] . '</td>';
                    echo '<td class="editable price" contenteditable="true">' . $row["Price"] . " VND" . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">Không có món ăn nào trong menu.</td></tr>';
            }
            ?>
        </table>
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
