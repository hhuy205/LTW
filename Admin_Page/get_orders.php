<?php
header('Content-Type: application/json');
include '../connectDB.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 10;
$offset = ($page - 1) * $itemsPerPage;

$sql = "
    SELECT o.id, u.firstname, u.lastname, o.total_price, o.status
    FROM orders o
    JOIN users u ON o.customer_id = u.id
    LIMIT $itemsPerPage OFFSET $offset
";
$result = $conn->query($sql);

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$sqlTotal = "SELECT COUNT(*) AS total FROM orders";
$totalResult = $conn->query($sqlTotal);
$totalRow = $totalResult->fetch_assoc();
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

echo json_encode([
    'success' => true,
    'orders' => $orders,
    'page' => $page,
    'totalPages' => $totalPages
]);

$conn->close();
?>
