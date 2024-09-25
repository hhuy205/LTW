<?php
$pageTitle = 'Sign In';
include 'head.php';

session_start(); // Bắt đầu phiên làm việc

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../connectDB.php'; // Kết nối tới database

    // Lấy thông tin từ form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra email và mật khẩu
    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Kiểm tra mật khẩu
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id; // Lưu user_id vào session
                header("Location: index.php"); // Chuyển hướng về trang index
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "Email does not exist!";
        }
        $stmt->close();
    } else {
        $error = "Please enter email and password!";
    }
    $conn->close();
}
?>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="logo">
                <img src="./assets/image/logo.png" alt="Nike Logo">
            </div>
            <h1>Login or die?</h1>
            <form id="login-form" action="signIn.php" method="post">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <a href="register.php">Register account</a>
                <button type="submit">Sign In</button>
                <?php if (isset($error)) : ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
<!-- <script src="./assets/javascript/script.js"></script> -->

</html>