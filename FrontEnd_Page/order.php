<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
}

include '../connectDB.php';

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId <= 0) {
    echo 'Invalid product ID';
    exit();
}

// Chuẩn bị và thực thi câu lệnh SQL để lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo 'Product not found';
    exit();
}

$product = $result->fetch_assoc();
$quantity = $product['quantity'];

$stmt->close();
$conn->close();

$pageTitle = 'Nike Shop';
include 'head.php';
?>

<body>
    <div id="main">
        <!-- Top nav -->
        <?php include 'top_nav.php'; ?>
        <!-- Header -->
        <?php include 'header.php'; ?>

        <!-- Main content -->
        <main id="product-content">
            <!-- <section class="product-section"> -->
            <div class="product-gallery">
                <div class="thumbnail-images">
                    <!-- Add thumbnail images here as needed -->
                    <img src="../Admin_Page/image/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="product-images">
                    <!-- <img src="./assets/image/air-max-1-essential-shoes-Vz0BS9.png" alt="Nike Air Max 1 Essential"> -->
                    <img src="../Admin_Page/image/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <!-- Add more images here as needed -->
                </div>

            </div>
            <div class="product-details">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="product-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>$</p>
                <div class="product-sizes">
                    <legend class="product-sizes-text">
                        <label class="size-text" for="size">Select Size</label>
                        <a href="#">Size Guide</a>
                    </legend>
                    <div class="size-options">
                        <button class="size-option-btn" value="EU 40">EU 40</button>
                        <button class="size-option-btn" value="EU 41">EU 41</button>
                        <button class="size-option-btn" value="EU 42">EU 42</button>
                        <button class="size-option-btn" value="EU 43">EU 43</button>
                        <button class="size-option-btn" value="EU 44">EU 44</button>
                        <button class="size-option-btn" value="EU 45">EU 45</button>
                        <button class="size-option-btn" value="EU 46">EU 46</button>
                        <button class="size-option-btn" value="EU 47">EU 47</button>
                    </div>
                </div>
                <form action="add_to_cart.php?id=<?php echo $product['id']; ?>" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="selected_size" id="selected_size" value="">
                    <?php if ($quantity > 0): ?>
                        <button type="submit" class="add-to-bag">Add to Bag</button>
                    <?php else: ?>
                        <button type="button" class="add-to-bag" disabled>Out of Stock</button>
                    <?php endif; ?>
                </form>

                <form action="add_to_favourite.php?id=<?php echo $product['id']; ?>" method="POST" class="add-to-fav-form">
                    <button type="submit" class="favourite">Favourite<i class="ti-heart"></i></button>
                </form>
                <div class="description">
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <!-- <p>
                                Meet the leader of the pack. Walking on clouds above the noise, the Air Max 1 blends timeless design with cushioned comfort. Sporting a Max Air unit and mixed materials, this icon hit the scene in '87 and continues to be the soul of the franchise today.
                            </p> -->
                    <ul class="description-list">
                        <li class="description-color">Colour Shown: White/Summit White/Black</li>
                        <li class="description-style">Style: FZ5808-101</li>
                    </ul>

                    <button class="description-btn js-description-btn"><span>
                            View Product Details
                        </span></button>
                </div>
            </div>
            <!-- </section> -->
        </main>


        <?php
        include 'footer.php';
        ?>


    </div>
    <div class="modal js-modal">
        <div class="modal-container js-modal-container">
            <div class="modal-close js-modal-close">
                <i class="ti-close"></i>
            </div>
            <header class="modal-header">
                <img src="../Admin_Page/image/<?php echo htmlspecialchars($product['image']); ?>">
                <div class="modal-header-sub">
                    <p><?php echo htmlspecialchars($product['name']); ?></p>
                    <span><?php echo number_format($product['price'], 0, ',', '.'); ?>$</span>
                </div>
            </header>

            <div class="modal-body">
                <div class="modal-body-text">
                    <p>Meet the leader of the pack. Walking on clouds above the noise, the Air Max 1 blends timeless design with cushioned comfort. Sporting a Max Air unit and mixed materials, this icon hit the scene in '87 and continues to be the soul of the franchise today.</p>
                    <br>
                    <p>Benefits</p>
                    <ul>
                        <li>The upper mixes synthetic leather, suede and mesh for a layered look built to last. </li>
                        <li>Foam midsole with a Max Air unit in the heel provides lightweight cushioning.</li>
                        <li>Rubber Waffle outsole adds durable traction and heritage style.</li>
                        <li>The padded, low-cut collar feels soft and comfortable.</li>
                        <li>Colour Shown: Phantom/Light Orewood Brown/Black/Khaki</li>
                        <li>Style: FZ5808-001</li>
                        <li>Country/Region of Origin: China</li>
                    </ul>
                    <br>
                    <p>Air Max 1</p>
                    <br>
                    <p>Sure, Air Max 1 started as a running shoe, but you can't keep innovation contained. Adopted by hip-hop culture, this runner with a controversial exposed Air unit could be found anywhere from the heart of Brooklyn to the streets of London. Its cutting-edge design and striking colourways, to this day, are celebrated year after year.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Thông báo đã add sản phẩm vào giỏ -->
    <div class="notification"></div>
    <div class="notification-fav"></div>

</body>
<script src="./assets/javascript/view-detail-click.js"></script>
<script src="./assets/javascript/script.js"></script>
<script src="./assets/javascript/order.js"></script>
</html>