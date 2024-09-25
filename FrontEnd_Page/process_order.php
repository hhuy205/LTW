<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['user_id'])) {
    header('Location: signIn.php');
    exit();
}

include '../connectDB.php';

$userId = $_SESSION['user_id'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$phoneNumber = $_POST['phone_number'];
$address = $_POST['address'];


// Cập nhật thông tin người dùng vào cơ sở dữ liệu
$updateUserQuery = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, phone_number = ?, address = ? WHERE id = ?");
$updateUserQuery->bind_param("ssssi", $firstName, $lastName, $phoneNumber, $address, $userId);
$updateUserQuery->execute();

// Tạo đơn hàng mới
$orderDate = date('Y-m-d H:i:s');
$totalPrice = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }
}

$deliveryFee = $totalPrice > 0 ? 25 : 0;
$grandTotal = $totalPrice + $deliveryFee;

// Thêm đơn hàng vào bảng orders
$insertOrderQuery = $conn->prepare("INSERT INTO orders (customer_id, order_date, total_price, status) VALUES (?, ?, ?, 'in delivery')");
$insertOrderQuery->bind_param("isd", $userId, $orderDate, $grandTotal);
$insertOrderQuery->execute();
$orderId = $insertOrderQuery->insert_id;

// Thêm các sản phẩm vào bảng order_items
$insertOrderItemsQuery = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($_SESSION['cart'] as $item) {
    $itemTotalPrice = $item['price'] * $item['quantity'];
    $insertOrderItemsQuery->bind_param("iiid", $orderId, $item['id'], $item['quantity'], $itemTotalPrice);
    $insertOrderItemsQuery->execute();

    // Cập nhật số lượng sản phẩm trong bảng products
    $updateProductQuery = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
    $updateProductQuery->bind_param("ii", $item['quantity'], $item['id']);
    $updateProductQuery->execute();
}

// Xóa giỏ hàng sau khi đặt hàng
unset($_SESSION['cart']);

// Đóng kết nối cơ sở dữ liệu
$conn->close();

// Chuyển hướng đến trang thành công
header('Location: checkOut.php?success=true');
exit();
?>
