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

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $stmt = $conn->prepare("DELETE FROM  ship  WHERE S_ID = ?");
    $stmt->bind_param("s", $S_ID);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "fail";
    }

    $stmt->close();
}

$conn->close();
?>
