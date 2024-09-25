<link rel="stylesheet" href="./assets/css/header.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
                <!-- <input type="text" name="q" placeholder="Search">
                <a href="#" class="search-icon"><i class="ti-search"></i></a> -->
                <div class="search-container">
                    <input type="text" name="q" id="search-input" placeholder="Search">
                    <a href="#" class="search-icon" id="search-button"><i class="ti-search"></i></a>
                    <div id="suggestions-box" class="suggestions-box"></div>
                </div>
            </form>
        </div>
        <a href="favourite.php" class="heart-icon ti-heart"></a>
        <a href="cart.php" class="bag-icon ti-bag"></a>
    </div>
    <script src="./assets/javascript/search.js"></script>
    <script>
        document.getElementById('search-button').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a
            document.querySelector('form').submit(); // Gửi biểu mẫu
        });
    </script>
</header>