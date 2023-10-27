<?php
// Bắt đầu hoặc sử dụng session đã tồn tại
session_start();

if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
    $savecid = $_SESSION['cid'];
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
            <a href="#" class="textdecor">
                <option>Thông tin người dùng</option>
            </a>
            <a href="#" class="textdecor">
                <option>Lịch sử đặt hàng</option>
            </a>
            <a href="/php/Account.php" class="textdecor">
                <option>Đăng xuất
            </a></option>
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
    <!-- Phần HTML khác ở trang của bạn -->
    <div class="menusize">
        <table>
            <tr>
                <th>Menu</th>
                <th>Tên món ăn</th>
                <th>Nguyên liệu</th>
                <th>Giá</th>
                <th>Số lượng</th>
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
                    echo '<td>' . $row["M_ID"] . '</td>';
                    echo '<td>' . $row["Name"] . '</td>';
                    echo '<td>' . $row["Ingrediant"] . '</td>';
                    echo '<td class="price">' . $row["Price"] . " VND" . '</td>';
                    echo '<td>';
                    echo '<button class="number" onclick="decrementQuantity(this)">-</button>';
                    echo '<input class="number" type="text" value="0" oninput="calculateTotal()">';
                    echo '<button class="number" onclick="incrementQuantity(this)">+</button>';
                    echo '</td>';
                    echo '</tr>';
                    $Price = 30000;
                }
            } else {
                echo '<tr><td colspan="4">Không có món ăn nào trong menu.</td></tr>';
            }
            ?>
        </table>
    </div>

    <div class="totalamount">
        <label>Tổng tiền: <span id="total">0 VND</span></label>
    </div>

    <form class="totalamount" method="post" onsubmit="return validateForm()">
        <!-- Include your menu table here -->
        <button id="okk" type="submit" name="submitOrder">Thanh toán</button>
    </form>
    <!-- Tính giá -->
    <script>
        function calculateTotal() {
            const priceElements = document.querySelectorAll('.price');
            const quantityInputs = document.querySelectorAll('input.number');

            let total = 0;

            for (let i = 0; i < priceElements.length; i++) {
                const price = parseFloat(priceElements[i].textContent);
                const quantity = parseInt(quantityInputs[i].value);
                total += price * quantity;
                $sum = quantity;
            }

            document.getElementById('total').textContent = total.toFixed(0) + ' VND';
        }

        function incrementQuantity(button) {
            const input = button.parentElement.querySelector('input');
            input.value = parseInt(input.value) + 1;
            calculateTotal();
            $total = calculateTotal();
        }

        function decrementQuantity(button) {
            const input = button.parentElement.querySelector('input');
            const value = parseInt(input.value);
            if (value > 0) {
                input.value = value - 1;
                calculateTotal();
                $total = calculateTotal();
            }
        }

        function validateForm() {
            const quantityInputs = document.querySelectorAll('input.number');
            let allZero = true;

            for (let i = 0; i < quantityInputs.length; i++) {
                const quantity = parseInt(quantityInputs[i].value);
                if (quantity !== 0) {
                    allZero = false;
                    break;
                }
            }
            if (allZero) {
                alert('Vui lòng chọn ít nhất một món!');
                return false; // Prevent form submission
            }

            // If the validation passes, the form will be submitted
            return true;
        }
    </script>
    <!-- ship -->
    <script>
        
    
      <?php
if (isset($_POST['submitOrder'])) {
    $sql = "INSERT INTO ship (Price_Ship, Time_Delivery, Time_TO) VALUES (?, NOW(), DATE_ADD(NOW(), INTERVAL 1 HOUR)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Price);

    if ($stmt->execute()) {
        $sid = $conn->insert_id;
        session_start();
        $_SESSION['sid'] = $sid;
        $Status = "Pending"; // Change this value as needed
        $Sid = $_SESSION['sid'];
        $Cid = $_SESSION['cid'];

        $sql = "INSERT INTO Orderr (Date, Status, C_ID, S_ID) VALUES (NOW(), ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $Status, $Cid, $Sid);

        if ($stmt->execute()) {
            $Oid = $conn->insert_id;
            session_start();
            $_SESSION['Oid'] = $Oid;
            $Oid = $_SESSION['Oid'];
            $sql = "INSERT INTO Order_detail (TotalAmount, O_ID) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $sum, $Oid);

            if ($stmt->execute()) {
                echo '<script>alert("Successfully Order.");</script>';
            } else {
                echo '<script>alert("Failed to insert into Order_detail.");</script>';
            }
        } else {
            echo '<script>alert("Failed to insert into Orderr.");</script>';
        }
    } else {
        echo '<script>alert("Failed to insert into ship.");</script>';
    }

    $stmt->close();
    $conn->close();
}

?>


    </script>
    

</body>

</html>