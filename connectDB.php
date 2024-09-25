<?php
// Cấu hình kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'mysql_shoewebsite';
$username = 'root';
$password = '';

// Kết nối cơ sở dữ liệu
// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}
?>
