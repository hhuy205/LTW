<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
}

include '../connectDB.php';

// Lấy ID sản phẩm từ URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId <= 0) {
    echo 'Invalid product ID';
    exit();
}

// Lấy thông tin sản phẩm từ database
$stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo 'Product not found';
    exit();
}

$product = $result->fetch_assoc();
$stmt->close();

// Kiểm tra danh sách yêu thích trong session
if (!isset($_SESSION['favourites'])) {
    $_SESSION['favourites'] = array();
}

// Kiểm tra xem sản phẩm đã có trong danh sách yêu thích hay chưa
$productExists = false;
foreach ($_SESSION['favourites'] as $item) {
    if ($item['id'] == $productId) {
        $productExists = true;
        break;
    }
}

if (!$productExists) {
    // Thêm sản phẩm vào danh sách yêu thích
    $_SESSION['favourites'][] = array(
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['image']
    );
}

// Đóng kết nối
$conn->close();

// Điều hướng tới trang yêu thích
header('Location: favourite.php');
exit();
?>
