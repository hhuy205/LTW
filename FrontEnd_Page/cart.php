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

$pageTitle = 'Shopping Cart';
include 'head.php';
?>

<body>
    <div id="main">
        <!-- Top nav -->
        <?php include 'top_nav.php'; ?>
        <!-- Header -->
        <?php include 'header.php'; ?>

        <main class="main-cart">
            <div class="cart-container">
                <div class="bag">
                    <h2>Bag</h2>
                    <div class="cart-item-list">
                        <!-- Một item trong giỏ hàng -->

                        <?php if (!empty($_SESSION['cart'])): ?>
                            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                                <div class="cart-item">
                                    <img src="../Admin_Page/image/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <div class="item-details">
                                        <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                                        <div>Price: <?php echo number_format($item['price'], 2, ',', '.'); ?>$</div>
                                        <div>Size: <?php echo htmlspecialchars($item['size']); ?></div>
                                        <div>Quantity:
                                            <select id="quantity-<?php echo $index; ?>" onchange="updateCartQuantity(<?php echo $index; ?>, this.value)">
                                                <?php for ($i = 1; $i <= $item['stock']; $i++): ?>
                                                    <option value="<?php echo $i; ?>" <?php echo ($i == $item['quantity']) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="item-actions">
                                            <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>"><i class="item-icon ti-trash"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-price" id="item-price-<?php echo $index; ?>">
                                        $<?php echo number_format($item['price'] * $item['quantity'], 2, '.', ','); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Your cart is empty.</p>
                        <?php endif; ?>
                    </div>


                    <!-- <script>
                        const SHIPPING_FEE = 25; // Biến phí vận chuyển

                        function updateCartQuantity(index, quantity) {
                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', 'update_cart.php?index=' + index + '&quantity=' + quantity, true);
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    var response = JSON.parse(xhr.responseText);
                                    document.getElementById('item-price-' + index).innerHTML = '$' + response.itemTotalPrice;

                                    // Cập nhật tổng giá và phí giao hàng
                                    var subtotal = parseFloat(response.totalPrice.replace(/[^0-9.-]+/g, ""));
                                    var totalPrice = subtotal > 0 ? subtotal + SHIPPING_FEE : 0;

                                    document.getElementById('subtotal').innerHTML = numberWithCommas(subtotal) + '$';
                                    document.getElementById('total-price').innerHTML = (totalPrice > 0) ? numberWithCommas(totalPrice) + '$' : '--';
                                    document.getElementById('delivery-fee').innerHTML = (subtotal > 0) ? numberWithCommas(SHIPPING_FEE) + '$' : '--';

                                    // Cập nhật trạng thái checkout
                                    document.getElementById('checkout-button').disabled = (subtotal = 0);
                                }
                            };
                            xhr.send();
                        }

                        function numberWithCommas(x) {
                            // Format number with commas as thousand separator
                            return x.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                        }

                        // Initial setup
                        document.addEventListener('DOMContentLoaded', function() {
                            var subtotalText = document.getElementById('subtotal').textContent.replace(/[^0-9.-]+/g, "");
                            var subtotal = parseFloat(subtotalText);
                            var totalPrice = subtotal > 0 ? subtotal + SHIPPING_FEE : 0;

                            document.getElementById('total-price').innerHTML = (totalPrice > 0) ? numberWithCommas(totalPrice) + '$' : '--';
                            document.getElementById('delivery-fee').innerHTML = (subtotal > 0) ? numberWithCommas(SHIPPING_FEE) + '$' : '--';
                        });
                    </script> -->

                </div>

                <div class="summary">
                    <h2>Summary</h2>
                    <div>Subtotal<span id="subtotal">
                            <?php
                            $total = 0;
                            foreach ($_SESSION['cart'] as $item) {
                                $total += $item['price'] * $item['quantity'];
                            }
                            // echo number_format($total, 2, '.', ',') . '$';
                            echo ($total === 0) ? '--' : number_format($total, 2, '.', ',') . ' $';
                            ?>
                        </span></div>
                    <div>Estimated Delivery & Handling<span id="delivery-fee">
                            <?php echo ($total > 0) ? number_format(25, 2, '.', ',') . '$' : '0$'; ?>
                        </span></div>
                    <div class="total">Total<span id="total-price">
                            <?php echo ($total > 0) ? number_format($total, 2, '.', ',') . '$' : '--'; ?>
                        </span></div>
                    <div class="button">
                        <button id="checkout-button" <?php echo empty($_SESSION['cart']) ? 'disabled' : ''; ?>>Checkout</button>
                    </div>

                </div>

            </div>
        </main>

        <!-- footer -->
        <?php
        include 'footer.php';
        ?>
    </div>
</body>
<script src="./assets/javascript/script.js"></script>
<script src="./assets/javascript/search.js"></script>
<script src="./assets/javascript/cart.js"></script>
</html>