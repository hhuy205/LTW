<?php

include '../connectDB.php'; // Bao gồm tệp kết nối cơ sở dữ liệu

// Kiểm tra xem có ID không
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
    exit();
}

$id = intval($_GET['id']); // Chuyển đổi ID thành số nguyên để bảo mật

// Xóa dữ liệu sản phẩm
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}

$stmt->close();
$conn->close();
?>
