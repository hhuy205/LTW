<?php
header('Content-Type: application/json');
include '../connectDB.php';

// Query to get total orders, total items sold, and total revenue
$sql = "
    SELECT 
        (SELECT COUNT(*) FROM orders) AS total_orders,
        (SELECT COALESCE(SUM(quantity), 0) FROM order_items) AS total_items_sold,
        (SELECT COALESCE(SUM(total_price), 0) FROM orders WHERE status = 'paid') AS total_revenue
";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode($data);

$conn->close();
?>
