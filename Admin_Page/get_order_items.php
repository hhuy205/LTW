<?php
header('Content-Type: application/json');
include '../connectDB.php';

$order_id = intval($_GET['order_id']);

$sql = "
    SELECT p.name AS product_name, oi.quantity, oi.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$orderItems = [];
while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row;
}

echo json_encode($orderItems);

$stmt->close();
$conn->close();
?>
