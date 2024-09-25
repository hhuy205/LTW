<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signIn.php');
    exit();
}

$pageTitle = 'Nike Shop';
include 'head.php';

// Kiểm tra thông báo thành công
$showPopup = isset($_GET['success']) && $_GET['success'] == 'true';

include '../connectDB.php';

$userId = $_SESSION['user_id'];

// Lấy thông tin người dùng
$userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
$userQuery->bind_param("i", $userId);
$userQuery->execute();
$userResult = $userQuery->get_result();
$userData = $userResult->fetch_assoc();

// Tính toán ngày giao hàng
$currentDate = new DateTime();
$deliveryStartDate = clone $currentDate; // Tạo một bản sao của $currentDate để tránh ghi đè
$deliveryStartDate->add(new DateInterval('P5D')); // Ngày bắt đầu giao hàng (5 ngày sau)

$deliveryEndDate = clone $currentDate; // Tạo một bản sao khác của $currentDate
$deliveryEndDate->add(new DateInterval('P7D')); // Ngày kết thúc giao hàng (7 ngày sau)

// Định dạng ngày
$deliveryStartDateFormatted = $deliveryStartDate->format('D, M j');
$deliveryEndDateFormatted = $deliveryEndDate->format('D, M j');

?>

<body>

    <!-- Header -->
    <header id="header">
        <div class="logo">
            <a href="index.php"><img src="./assets/image/logo.png" alt="Logo"></a>
        </div>
        <!-- Header button -->
        <div class="header-btn">
            <a href="favourite.php" class="heart-icon ti-heart"></a>
            <a href="cart.php" class="bag-icon ti-bag"></a>
        </div>
    </header>

    <main class="main-checkout">
        <div class="checkout-container">
            <div class="customer-info">
                <h2>How would you like to get your order?</h2>
                <div class="delivery-method">
                    <input type="radio" id="deliver" name="delivery" value="deliver" checked>
                    <label for="deliver">Deliver It</label>
                </div>
                <h2>Enter your name and address:</h2>
                <form class="address-form" method="POST" action="process_order.php">
                    <input type="text" name="first_name" placeholder="Tên" value="<?php echo htmlspecialchars($userData['firstname'] ?? ''); ?>" required>
                    <input type="text" name="last_name" placeholder="Họ" value="<?php echo htmlspecialchars($userData['lastname'] ?? ''); ?>" required>
                    <input type="text" name="phone_number" placeholder="Số điện thoại" value="<?php echo htmlspecialchars($userData['phone_number'] ?? ''); ?>" required>
                    <input type="text" name="address" placeholder="Địa chỉ" value="<?php echo htmlspecialchars($userData['address'] ?? ''); ?>" required>
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    <button id="confirmBtn" type="submit">Confirm</button>
                </form>
            </div>
            <div class="order-summary">
                <h2>Order Summary</h2>
                <div class="summary-details">
                    <?php
                    $totalPrice = 0;
                    if (!empty($_SESSION['cart'])):
                        foreach ($_SESSION['cart'] as $item):
                            $totalPrice += $item['price'] * $item['quantity'];
                        endforeach;
                    endif;
                    $deliveryFee = $totalPrice > 0 ? 25 : 0;
                    $grandTotal = $totalPrice + $deliveryFee;
                    ?>
                    <div>Subtotal <span><?php echo number_format($totalPrice, 0, ',', '.'); ?>$</span></div>
                    <div>Delivery/Shipping <span><?php echo $deliveryFee ? number_format($deliveryFee, 0, ',', '.') . '$' : 'Free'; ?></span></div>
                    <div class="total">Total <span><?php echo number_format($grandTotal, 0, ',', '.'); ?>$</span></div>
                </div>
                <h3>Arrives <?php echo $deliveryStartDateFormatted; ?> - <?php echo $deliveryEndDateFormatted; ?></h3>
                <div class="product-list">
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <div class="product-item">
                                <img src="../Admin_Page/image/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                <div>
                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p>Qty 1</p>
                                    <p>Size <?php echo htmlspecialchars($item['size']); ?></p>
                                    <p><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>$</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Your cart is empty.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Popup -->
    <?php if ($showPopup): ?>
        <div id="orderPopup" class="popup" style="display: block;">
            <div class="popup-content">
                <p>Your order has been placed successfully!</p>
                <a href="index.php">Return to Home</a>
            </div>
        </div>
    <?php endif; ?>

    <?php
    include 'footer.php';
    ?>
    </div>
    <script src="./assets/javascript/script.js"></script>
    <script src="./assets/javascript/search.js"></script>
</body>

</html>