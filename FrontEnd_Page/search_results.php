<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
}

$pageTitle = 'Search Results';
include 'head.php';

// Kết nối cơ sở dữ liệu
include '../connectDB.php';

// Lấy từ khóa tìm kiếm từ truy vấn
$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

?>
<body>
    <!-- Top nav -->
    <?php include 'top_nav.php'; ?>
    <!-- Header -->
    <header id="header">
        <div class="logo">
            <a href="index.php"><img src="./assets/image/logo.png" alt="Logo"></a>
        </div>
        <!-- Nav -->
        <nav>
            <ul id="main-nav">
                <li><a href="#">New & Featured</a></li>
                <li><a href="product-cart.php">Men</a></li>
                <li><a href="product-cart.php">Women</a></li>
                <li><a href="product-cart.php">Kids</a></li>
                <li><a href="#">Sale</a></li>
                <li><a href="#">Customise</a></li>
                <li><a href="#">SNKRS</a></li>
            </ul>
        </nav>
        <!-- Header button -->
        <div class="header-btn">
            <div class="search-box">
                <form action="search_results.php" method="get">
                    <input type="text" name="q" placeholder="Search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <a href="#" class="search-icon"><i class="ti-search"></i></a>
                </form>
            </div>
            <a href="favourite.php" class="heart-icon ti-heart"></a>
            <a href="cart.php" class="bag-icon ti-bag"></a>
        </div>
    </header>

    <div class="search-results-container">
    <h1>Search Results for "<?php echo htmlspecialchars($searchTerm); ?>"</h1>
    <div class="search-results">
        <?php
        if (!empty($searchTerm)):
            // Truy vấn cơ sở dữ liệu để tìm sản phẩm dựa trên từ khóa
            $stmt = $conn->prepare("SELECT id, name, image, price, quantity FROM products WHERE name LIKE ?");
            $searchTermParam = '%' . $searchTerm . '%';
            $stmt->bind_param("s", $searchTermParam);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0):
                while ($product = $result->fetch_assoc()):
                    // Xác định trạng thái sản phẩm và thuộc tính disabled
                    $productStatus = $product['quantity'] == 0 ? 'Sold Out' : 'Just In';
                    $isDisabled = $product['quantity'] == 0 ? 'disabled' : '';
        ?>
                <div class="product-container">
                <a href="order.php?id=<?php echo $product['id']; ?>" class="product-card">
                    <div class="product-image-wrapper">
                        <img src="../Admin_Page/image/<?php echo htmlspecialchars($product['image']); ?>" class="product-image" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="product-info-container">
                        <div class="product-thumbnails">
                            <!-- Thumbnails; có thể thay thế nếu cần -->
                            <img src="../Admin_Page/image/<?php echo htmlspecialchars($product['image']); ?>" alt="Thumbnail 1" class="thumbnail">
                            <img src="../Admin_Page/image/<?php echo htmlspecialchars($product['image']); ?>" alt="Thumbnail 2" class="thumbnail">
                            <img src="../Admin_Page/image/<?php echo htmlspecialchars($product['image']); ?>" alt="Thumbnail 3" class="thumbnail">
                        </div>
                        <div class="product-status"><?php echo $productStatus; ?></div>
                        <div class="product-title"><?php echo htmlspecialchars($product['name']); ?></div>
                        <div class="product-category"><?php echo htmlspecialchars($product['category'] ?? 'Men\'s Shoes'); ?></div>
                        <div class="product-colors"><?php echo htmlspecialchars($product['colors'] ?? '3 Colours'); ?></div>
                        <div class="product-price">$<?php echo number_format($product['price'], 2, ',', '.'); ?></div>
                    </div>
                </a>
                </div>
        <?php
                endwhile;
            else:
                echo '<p>No results found.</p>';
            endif;
            $stmt->close();
        else:
            echo '<p>Please enter a search term.</p>';
        endif;

        // Đóng kết nối
        $conn->close();
        ?>
    </div>
</div>


    <!-- footer -->
    <?php include 'footer.php'; ?>
</body>
<script src="./assets/javascript/search.js"></script>
</html>
