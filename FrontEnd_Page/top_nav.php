<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div id="top-nav">
    <ul>
        <li><a href="">Find a Store</a>
        <span>|</span></li>
        <li><a href="">Help</a>
        <span>|</span></li>
        <li><a href="">Join Us</a>
        <span>|</span></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="logOut.php">Log out</a></li>
        <?php else: ?>
            <li><a href="signIn.php" id="auth-link">Sign In</a></li>
        <?php endif; ?>
    </ul>
</div>
