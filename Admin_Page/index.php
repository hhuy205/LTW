<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="./image/favicon.ico" type="nike-icon">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="admin-dashboard">
        <header>
            <h1>Admin Dashboard</h1>
        </header>
        <aside>
            <div class="logo">
                <a href="#"><img src="../Admin_Page/image/logo.png" alt="Logo"></a>
            </div>
            <nav>
                <ul>
                    <li><a href="#overview">Overview</a></li>
                    <li><a href="#items">Manage Items</a></li>
                    <li><a href="#orders">Manage Orders</a></li>
                    <li><a href="#notifications">Notifications</a></li>
                </ul>
            </nav>
        </aside>
        <main>
            <section id="overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Total Orders</h3>
                        <p id="total-orders">0</p>
                    </div>
                    <div class="card">
                        <h3>Total Items</h3>
                        <p id="total-items">0</p>
                    </div>
                    <div class="card">
                        <h3>Total Revenue</h3>
                        <p id="total-revenue">$0</p>
                    </div>
                </div>
            </section>
            <section id="notifications" style="display: none;">
                <h2>Notifications</h2>
                <ul id="notification-list"></ul>
            </section>
            <section id="items" style="display: none;">
                <h2>Item List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Item rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
                <div class="pagination">
                    <a href="#" class="previous" id="previous-page">&laquo; Previous</a>
                    <span class="page-numbers" id="page-numbers">
                        <!-- Page numbers will be dynamically inserted here by JavaScript -->
                    </span>
                    <a href="#" class="next" id="next-page">Next &raquo;</a>
                </div>
                <h2>Add/Edit Item</h2>
                <form id="item-form">
                    <input type="hidden" id="item-id">
                    <label for="item-name">Name:</label>
                    <input type="text" id="item-name" required>
                    <label for="item-price">Price:</label>
                    <input type="number" id="item-price" required>
                    <label for="item-quantity">Quantity:</label>
                    <input type="number" id="item-quantity" required>
                    <label for="item-image">Product Image:</label>
                    <input type="file" id="item-image" accept="image/*">
                    <button type="submit">Save Item</button>
                    <p id="price-error" style="color: red; display: none;">Price cannot be negative.</p>
                </form>
            </section>
            <section id="orders" style="display: none;">
                <h2>Order List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Order rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
                <div class="pagination">
                    <a href="#" class="previous" id="previous-page">&laquo; Previous</a>
                    <span class="page-numbers" id="page-numbers">
                        <!-- Page numbers will be dynamically inserted here by JavaScript -->
                    </span>
                    <a href="#" class="next" id="next-page">Next &raquo;</a>
                </div>
            </section>
        </main>

        <!-- Order Details Modal -->
        <div id="order-modal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Order Details</h2>
                <table id="order-details-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Order item rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>

</html>