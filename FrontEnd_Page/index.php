<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
}

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$pageTitle = 'Nike Shop';
include 'head.php';
?>

<body>
    <div id="main">
        <!-- Top nav -->
        <?php include 'top_nav.php'; ?>
        <!-- Header -->
        <?php include 'header.php'; ?>
        <!-- Slider -->
        <main id="main-content">
            <div class="main-section"></div>
            <div class="main-text">
                <h1>JUST DO IT</h1>
                <p>Tackle every challenge head-on, fearlessly. Just Do It with unwavering determination and relentless spirit. Let's do it</p>
                <div class="main-buttons">
                    <a href="product-cart.php" class="btn">BUY NOW</a>
                </div>
            </div>
        </main>

        <?php
        include 'footer.php';
        ?>
    </div>
</body>
<script src="./assets/javascript/script.js"></script>
<script src="./assets/javascript/search.js"></script>
</html>