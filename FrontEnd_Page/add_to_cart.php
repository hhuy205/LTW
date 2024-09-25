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
$selectedSize = isset($_POST['selected_size']) ? $_POST['selected_size'] : '';

if (!$selectedSize) {
    echo 'Please select a size.';
    exit();
}

if ($productId <= 0) {
    echo 'Invalid product ID';
    exit();
}

// Lấy thông tin sản phẩm từ database
$stmt = $conn->prepare("SELECT id, name, price, quantity AS stock, image FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo 'Product not found';
    exit();
}

$product = $result->fetch_assoc();
$stmt->close();

// Kiểm tra giỏ hàng trong session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Kiểm tra xem sản phẩm đã có trong giỏ hàng hay chưa
$productExists = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $productId && $item['size'] == $selectedSize) {
        $item['quantity'] += 1; // Tăng số lượng sản phẩm
        $productExists = true;
        break;
    }
}

if (!$productExists) {
    // Thêm sản phẩm vào giỏ hàng
    $_SESSION['cart'][] = array(
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => 1,
        'image' => $product['image'],
        'stock' => $product['stock'],
        'size' => $selectedSize
    );
}



// Đóng kết nối
$conn->close();

// echo "<script>
//     console.log('Cart:', " . json_encode($_SESSION['cart']) . ");
// </script>";

// Điều hướng tới trang giỏ hàng
header('Location: cart.php');
exit();
?>
