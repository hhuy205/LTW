<?php
include '../connectDB.php';

$term = isset($_GET['term']) ? $_GET['term'] : '';

if (strlen($term) > 2) {
    $stmt = $conn->prepare("SELECT name FROM products WHERE name LIKE ? LIMIT 10");
    $term = '%' . $term . '%';
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="suggestion-item">' . htmlspecialchars($row['name']) . '</div>';
        }
    } else {
        echo '<div class="suggestion-item">No suggestions found</div>';
    }
    
    $stmt->close();
}

$conn->close();
?>
