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
            <a href="/php/History.php" class="textdecor">
                <option>Lịch sử khách đặt hàng</option>
            </a>
            <a href="/php/Account.php" class="textdecor">
                <option>Đăng xuất
            </a></option>
            </a>
        </div>
    </div>
    <div class="menusize">
        <table>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Giá tiền</th>
                <th>Thời gian nhận đơn</th>
                <th>Thời gian đến</th>
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
            $sql = "SELECT * FROM ship";
            $result = $conn->query($sql);

            // Kiểm tra và hiển thị dữ liệu nếu có
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="editable" contenteditable="true">' . $row["S_ID"] . '</td>';
                    echo '<td class="editable" contenteditable="true">' . $row["Price_Ship"] . '</td>';
                    echo '<td class="editable" contenteditable="true">' . $row["Time_Delivery"] . '</td>';
                    echo '<td class="editable price" contenteditable="true">' . $row["Time_TO"] .  '</td>';
                    echo '<td>';
                    echo '<button onclick="deleteItem(\'' . $row["S_ID"] . '\')">giao</button>';
                    echo '</td>';
                    echo '<td>';
                    echo '<button onclick="deleteItem(\'' . $row["S_ID"] . '\')">hủy</button>';
                    echo '</td>';
                    echo '<td>';
                    echo '<button onclick=""deleteItem(\'' . $row["S_ID"] . '\')">đã giao</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">Không có đơn hàng nào</td></tr>';
            }
            ?>
        </table>
    </div>
    <script>
    function deleteItem(S_ID) {
        if (confirm("Bạn có chắc chắn muốn xóa món này?")) {
            // Gửi yêu cầu xóa món ăn bằng Ajax
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText === "success") {
                        alert("Xóa món thành công!");
                        // Cập nhật trang web hoặc làm bất kỳ điều gì bạn muốn ở đây
                        location.reload();
                    } else {
                        alert("Xóa món thất bại!");
                    }
                }
            };
            xhttp.open("GET", "deletejob.php?S_ID=" + S_ID, true);
            xhttp.send();
        }
    }
</script>
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