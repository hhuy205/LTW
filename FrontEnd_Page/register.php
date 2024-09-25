<?php
$pageTitle = 'Register';
include 'head.php';

include '../connectDB.php'; // Kết nối tới cơ sở dữ liệu

session_start(); // Bắt đầu phiên làm việc

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6 || strlen($password) > 24) {
        $error = "Password must be between 6 and 24 characters long.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Kiểm tra xem email đã tồn tại chưa
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "This email is already registered.";
        } else {
            // Băm mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Lưu thông tin vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashed_password);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id; // Lưu user_id vào session
                header("Location: signIn.php"); // Chuyển hướng về trang index
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }

        $stmt->close();
    }
}
$conn->close();
?>

<body>
    <div class="register-wrapper">
        <div class="register-container">
            <div class="logo">
                <img src="./assets/image/logo.png" alt="Nike Logo">
            </div>
            <h1>Create an Account</h1>
            <form id="register-form" action="register.php" method="post">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <a href="signIn.php">Sign In</a>
                <button type="submit">Register</button>
                <?php if (isset($error)) : ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
