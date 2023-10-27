<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>x
    <link rel="stylesheet" href="/css/register.css">
</head>

<body>
    <div class="login-container">
        <h2>Register</h2>
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="Confirm">Confirm Your Password:</label>
                <input type="password" id="Confirm" name="Confirm" required>
            </div>
            <div class="form-group">
                <label for="fullname">Your full name:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                    <label for="phone">Phone number:</label>
                    <input type="tel" maxlength="10" minlength="10" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
                <div class="cbox">
                    <input type="checkbox" id="chatbox" required>
                    <label for="checkbox">I agree to all terms of the shop</label>
                </div>
                <div class="form-group">
                    <input type="submit" value="Sign up">
                </div>
            </div>
    </div>

    </form>
    </div>
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
            $username = $_POST["username"];
            $password = $_POST["password"];
            $confirm = $_POST["Confirm"];
            $fullname = $_POST["fullname"];
            $address = $_POST["address"];
            $phone = $_POST["phone"];
            $stmt = $conn->prepare("SELECT Username FROM customer WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                echo 'alert("Username đã tồn tại.");';
            } else {
                if ($password === $confirm) {
                    $stmt = $conn->prepare("INSERT INTO customer (Name, username, Address, PhoneNumber, password) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $fullname, $username, $address, $phone, $password);
                    if ($stmt->execute()) {
                        echo "Đăng ký thành công!";
                        // Thực hiện kiểm tra đăng nhập ngay sau khi đăng ký
                        $stmt = $conn->prepare("SELECT C_ID FROM customer WHERE username = ? AND password = ?");
                        $stmt->bind_param("ss", $username, $password);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows == 1) {
                            $row = $result->fetch_assoc();
                            $cid = $row['C_ID'];
                            session_start(); // Bắt đầu hoặc sử dụng session đã tồn tại
                            $_SESSION['cid'] = $cid;
                            $_SESSION['username'] = $username;
                            header("Location: /php/homepage.php");
                            exit();
                        } else {
                            echo 'alert("Tên người dùng hoặc mật khẩu không đúng.");';
                        }
                    } else {
                        echo 'alert("Có lỗi xảy ra trong quá trình đăng ký.");';
                    }
                    $stmt->close();
                } else {
                    echo 'alert("Mật khẩu và xác nhận mật khẩu không khớp. Vui lòng thử lại.");';
                }
            }
        }

        $conn->close();
        ?>
    </script>
</body>

</html>