<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
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
        
        <div id="product-section">
            <!-- Products will be dynamically inserted here -->

        </div>


    </div>


</body>
<!-- <script src="get_products.js"></script> -->
<script src="./assets/javascript/get_products.js"></script>
<script src="./assets/javascript/search.js"></script>
</html>