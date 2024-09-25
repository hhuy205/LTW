<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
}

include '../connectDB.php';

$pageTitle = 'Favourites';
include 'head.php';

?>

<body>
    <!-- Top nav -->
    <?php include 'top_nav.php'; ?>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <div class="favourites-container">
        <h1>Favourites</h1>
        <div class="favourite-item-list">
            <?php if (!empty($_SESSION['favourites'])): ?>
                <?php foreach ($_SESSION['favourites'] as $index => $item):
                    // Lấy thông tin sản phẩm từ database để kiểm tra số lượng
                    $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = ?");
                    $stmt->bind_param("i", $item['id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $product = $result->fetch_assoc();
                    $stmt->close();

                    $isOutOfStock = $product['quantity'] <= 0;

                ?>
                    <!-- <div class="favourite-item">
                        <img src="../Admin_Page/image/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="item-detail">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <div><?php echo number_format($item['price'], 2, ',', '.') ?>$</div>
                        </div>
                        <div class="actions-btn">
                            <?php if ($isOutOfStock): ?>
                                <button class="out-of-stock" disabled>Out of Stock</button>
                            <?php else: ?>
                                <button id="openModalBtn" class="open-modal-btn" data-item-id="<?php echo $item['id']; ?>" data-index="<?php echo $index; ?>">Select Size</button>
                            <?php endif; ?>

                            <a href="remove_from_favourite.php?id=<?php echo $item['id']; ?>"><i class="item-icon ti-trash"></i></a>
                        </div>
                    </div> -->
                    <div class="favourite-item">
                        <img src="../Admin_Page/image/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="item-detail">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <div><?php echo number_format($item['price'], 2, ',', '.') ?>$</div>
                        </div>
                        <div class="actions-btn">
                            <?php if ($isOutOfStock): ?>
                                <button class="out-of-stock" disabled>Out of Stock</button>
                            <?php else: ?>
                                <button class="open-modal-btn"
                                    data-item-id="<?php echo $item['id']; ?>"
                                    data-item-image="../Admin_Page/image/<?php echo htmlspecialchars($item['image']); ?>"
                                    data-item-name="<?php echo htmlspecialchars($item['name']); ?>"
                                    data-item-price="<?php echo htmlspecialchars($item['price']); ?>"
                                    data-index="<?php echo $index; ?>">
                                    Select Size
                                </button>
                            <?php endif; ?>
                            <a href="remove_from_favourite.php?id=<?php echo $item['id']; ?>"><i class="item-icon ti-trash"></i></a>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p>Your favourites list is empty.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal chọn size -->
    <div id="sizeModal" class="modal">
        <div class="modal-content">
            <img id="modalImage" src="" alt="">
            <div class="modal-detail">
                <div class="item-detail">
                    <h3 id="modalName"></h3>
                    <div id="modalPrice"></div>
                </div>
                <div class="item-detail-r2">
                    <div class="product-sizes">
                        <legend class="product-sizes-text">
                            <label class="size-text" for="size">Select Size</label>
                        </legend>
                        <div class="size-options" id="sizeOptions">
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
                    <form id="cartForm" action="" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="id" id="itemId" value="">
                        <input type="hidden" name="selected_size" id="selected_size" value="">
                        <button type="submit" class="addToBag">Add to Bag</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php
    include 'footer.php';
    ?>
</body>
<!-- JavaScript cho modal -->
<script src="./assets/javascript/favourites.js"></script>
<script src="./assets/javascript/search.js"></script>
</html>