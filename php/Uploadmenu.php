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
                <option>Đăng xuất
            </a></option>
            </a>
        </div>
    </div>
    <div class="postsize">
        <form method="post">
            <div class="postpadding">
                <label id="name" for="name">Tên món ăn:</label>
                <input type="text" id="name" name="name" placeholder="Vui lòng nhập tên món ăn">
            </div>
            <div class="postpadding">
                <label id="price" for="price">Giá món:</label>
                <input type="text" id="price" name="price" placeholder="Vui lòng nhập thành phần món ăn">
            </div>
            <div class="postpadding">
                <label id="card-text mb-auto" for="contents">Nguyên Liệu</label>
                <textarea id="contents" name="contents" placeholder="Vui lòng nhập mô tả món ăn!"></textarea>
            </div>
            <button id="postbtn">Thêm món</button>

        </form>
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
    <script>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Nhận dữ liệu từ biểu mẫu đăng nhập
            $name = $_POST["name"];
            $price = $_POST["price"];
            $contents = $_POST["contents"];
            $stmt = $conn->prepare("SELECT Name FROM menu WHERE name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                echo 'alert("Món ăn đã có trong thực đơn!");';
            } else {
                $stmt = $conn->prepare("INSERT INTO menu (Name, Ingrediant, Price) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $contents, $price);
                if ($stmt->execute()) {
                    // Thêm món thành công, sử dụng JavaScript để hiển thị thông báo
                    echo 'alert("Thêm món thành công!");';
                } else {
                    // Xảy ra lỗi, hiển thị thông báo lỗi bằng JavaScript
                    echo 'alert("Có lỗi xảy ra trong quá trình thêm món!");';
                }

                $stmt->close();
            }
        }
        $conn->close();
        ?>
    </script>
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
                    echo '<td>' . $row["Name"] . '</td>';
                    echo '<td>' . $row["Ingrediant"] . '</td>';
                    echo '<td class="price">' . $row["Price"] . " VND" . '</td>';
                    echo '<td>';
                    echo '<button onclick="deleteItem(\'' . $row["Name"] . '\')">Xóa</button>';
                    echo '</td>';
                    echo '</tr>';
                    $Price = 30000;
                }
            } else {
                echo '<tr><td colspan="4">Không có món ăn nào trong menu.</td></tr>';
            }
            ?>
        </table>
        <script>
    function deleteItem(name) {
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
            xhttp.open("GET", "delete_item.php?name=" + name, true);
            xhttp.send();
        }
    }
</script>

        </script>
    </div>
</body>

</html>