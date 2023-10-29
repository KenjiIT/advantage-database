<!DOCTYPE html>
<html>
<link rel="stylesheet" href="/css/MainWebsite.css">

<head>
    <meta charset="UTF-8">
    <title>Trang Chủ</title>
</head>

<body>
    <!-- Your existing HTML code -->

    <form class="pay" method="post" onsubmit="return confirmPayment()">
        <!-- Include your menu table here -->

        <h2>Chọn phương thức thanh toán:</h2>
        
        <input type="radio" name="paymentMethod" id="cash" value="cash"> Thanh toán bằng tiền mặt<br>
        <input type="radio" name="paymentMethod" id="creditcard" value="creditcard"> Thanh toán bằng thẻ tín dụng<br>
        <input type="radio" name="paymentMethod" id="paypal" value="paypal"> Thanh toán bằng Momo<br>
        <div class="mgp">
        <button id="okk" type="submit" name="submitOrder">Thanh toán</button>
        </div>
    </form>

    <!-- Continue with your JavaScript code -->

    <script>
        function confirmPayment() {
            // Check which payment method is selected
            const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked');

            if (!selectedPaymentMethod) {
                alert("Vui lòng chọn phương thức thanh toán.");
                return false; // Prevent form submission
            }

            // Show a confirmation dialog with the selected payment method
            const paymentMethod = selectedPaymentMethod.value;
            const confirmation = confirm("Bạn có chắc chắn muốn thanh toán bằng " + paymentMethod + "?");

            if (confirmation) {
                return true;
            } else {
                // User canceled, form submission will be prevented
                return false;
            }
        }
    </script>

    <!-- Your PHP code for database connection and data insertion -->
    <?php
session_start();
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "employee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem biến 'paymentMethod' có tồn tại trong mảng POST hay không
    if (isset($_POST["paymentMethod"])) {
        $paymentmethod = $_POST["paymentMethod"];
        $stmt = $conn->prepare("INSERT INTO payment (Payment_Method, Total_price) VALUES (?, ?)");
        $stmt->bind_param("ss", $paymentmethod, $Totalprice);
        if ($stmt->execute()) {
            // Thêm món thành công, sử dụng JavaScript để hiển thị thông báo
            echo '<script> alert("Chờ thanh toán"); </script>';
        } else {
            // Xảy ra lỗi, hiển thị thông báo lỗi bằng JavaScript
            echo '<script> alert("Vui lòng chọn phương thức thanh toán.");</script> ';
        }
        $stmt->close();
    } 
}

$conn->close();
?>

</body>

</html>
