<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
}

// Kiểm tra nếu ID sản phẩm được gửi qua URL
if (!isset($_GET['id'])) {
    echo 'Invalid request';
    exit();
}

$productId = intval($_GET['id']);

// Kiểm tra nếu giỏ hàng tồn tại trong session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Xóa sản phẩm khỏi giỏ hàng
foreach ($_SESSION['cart'] as $index => $item) {
    if ($item['id'] == $productId) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Đưa các chỉ số mảng về liên tiếp
        break;
    }
}

// Điều hướng trở lại trang giỏ hàng
header('Location: cart.php');
exit();
?>
