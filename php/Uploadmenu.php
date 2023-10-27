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
</body>

</html>