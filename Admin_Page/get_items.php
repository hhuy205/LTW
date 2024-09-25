<?php
header('Content-Type: application/json');
include '../connectDB.php';


$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 10;
$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT * FROM products LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

$items = [];
while($row = $result->fetch_assoc()) {
    $items[] = $row;
}

$sqlTotal = "SELECT COUNT(*) AS total FROM products";
$totalResult = $conn->query($sqlTotal);
$totalRow = $totalResult->fetch_assoc();
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

echo json_encode([
    'success' => true,
    'items' => $items,
    'page' => $page,
    'totalPages' => $totalPages
]);

$conn->close();
?>
