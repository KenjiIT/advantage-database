<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tư vấn sinh viên</title>
    <link rel="stylesheet" href="/css/Login.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
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
                <a id="signup" href="/php/Register.php">Do you have account yet? Click here!!!</a>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
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
           // Nhận dữ liệu từ biểu mẫu đăng nhập
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT Username, C_ID FROM customer WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $cid = $row['C_ID'];

        // Kiểm tra mật khẩu ở đây nếu cần
        session_start(); // Bắt đầu hoặc sử dụng session đã tồn tại
        $_SESSION['cid'] = $cid;
        $_SESSION['username'] = $username;
        header("Location: /php/homepage.php");
        exit();
    }
            $stmt = $conn->prepare("SELECT ManageAccount,password FROM employee WHERE ManageAccount = ? AND password = ?");
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    session_start(); // Bắt đầu hoặc sử dụng session đã tồn tại
                    $row = $result->fetch_assoc();
                    $cid = $row['C_ID'];
                    $_SESSION['username'] = $username;
                    $_SESSION['cid'] = $cid;
                    header("Location: /php/AdminPage.php");
                    exit();
                } else {
                    echo 'alert("Tên người dùng hoặc mật khẩu không đúng.");';
                }
        }
        $conn->close();
        ?>
    </script>
</body>
</html>