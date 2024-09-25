<?php
session_start();

if (!isset($_SESSION['cart']) || !isset($_GET['index']) || !isset($_GET['quantity'])) {
    echo 'Invalid request';
    exit();
}

$index = intval($_GET['index']);
$quantity = intval($_GET['quantity']);

// Kiểm tra nếu chỉ số và số lượng hợp lệ
if ($index < 0 || $index >= count($_SESSION['cart']) || $quantity <= 0 || $quantity > $_SESSION['cart'][$index]['stock']) {
    echo 'Invalid quantity';
    exit();
}

// Cập nhật số lượng sản phẩm trong giỏ hàng
$_SESSION['cart'][$index]['quantity'] = $quantity;

// Tính lại giá cho sản phẩm cập nhật
$itemTotalPrice = $_SESSION['cart'][$index]['price'] * $_SESSION['cart'][$index]['quantity'];

// Tính lại tổng giá của toàn bộ giỏ hàng
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
// Cộng phí giao hàng nếu có sản phẩm trong giỏ hàng
// $shippingFee = $totalPrice > 0 ? 25 : 0;
// $totalPrice += $shippingFee;

// Trả về giá của sản phẩm cập nhật và tổng giá giỏ hàng
echo json_encode([
    'itemTotalPrice' => number_format($itemTotalPrice, 2, '.', ','),
    'totalPrice' => number_format($totalPrice, 2, '.', ',') // Định dạng chính xác để sử dụng trong JavaScript
]);
?>
