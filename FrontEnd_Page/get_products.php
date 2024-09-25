<?php
header('Content-Type: application/json');

include '../connectDB.php';

// Query to fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Kiểm tra nếu số lượng bằng 0, thay đổi trạng thái thành 'Sold Out'
        $row['status'] = ($row['quantity'] == 0) ? 'Sold Out' : 'Just In';
        $products[] = $row;
    }
}

// Return results as JSON
echo json_encode($products);

$conn->close();
?>
