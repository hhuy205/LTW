<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
}

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId > 0 && isset($_SESSION['favourites'])) {
    foreach ($_SESSION['favourites'] as $index => $item) {
        if ($item['id'] == $productId) {
            unset($_SESSION['favourites'][$index]);
            break;
        }
    }

    // Sắp xếp lại các mục yêu thích
    $_SESSION['favourites'] = array_values($_SESSION['favourites']);
}

// Chuyển hướng người dùng về trang favourites
header('Location: favourite.php');
exit();
?>
