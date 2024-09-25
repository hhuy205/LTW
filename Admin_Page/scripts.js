document.addEventListener('DOMContentLoaded', () => {
    // Function to fetch and display overview data
    function updateOverview() {
        fetch('get_overview_data.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-orders').textContent = data.total_orders;
                document.getElementById('total-items').textContent = data.total_items_sold;
                document.getElementById('total-revenue').textContent = `$${data.total_revenue}`;
            })
            .catch(error => console.error('Error fetching overview data:', error));
    }

    // Call updateOverview when the page is loaded
    updateOverview();
});


document.addEventListener('DOMContentLoaded', function () {
    // Thay thế dữ liệu giả bằng dữ liệu thực từ server
    fetchItems();
    // Xử lý liên kết điều hướng
    const navLinks = document.querySelectorAll('aside nav ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetSectionId = this.getAttribute('href').substring(1); // Lấy ID của section
            const targetSection = document.getElementById(targetSectionId);

            if (targetSection) {
                // Ẩn tất cả các section
                document.querySelectorAll('main section').forEach(section => {
                    section.style.display = 'none';
                });

                // Hiển thị section mục tiêu
                targetSection.style.display = 'block';
            }
        });
    });

    // Mặc định hiển thị section Overview
    document.querySelector('#overview').style.display = 'block';

    // Xử lý sự kiện submit của form thêm/sửa sản phẩm
    const itemForm = document.getElementById("item-form");
    itemForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const itemId = document.getElementById("item-id").value;
        const name = document.getElementById("item-name").value;
        const price = parseFloat(document.getElementById("item-price").value);
        const quantity = parseInt(document.getElementById("item-quantity").value);
        const image = document.getElementById("item-image").files[0];

        if (price < 0) {
            document.getElementById("price-error").style.display = "block";
        } else {
            document.getElementById("price-error").style.display = "none";
            const formData = new FormData();
            formData.append('id', itemId);
            formData.append('name', name);
            formData.append('price', price);
            formData.append('quantity', quantity);
            if (image) formData.append('image', image);

            fetch('save_item.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // Chuyển đổi trước khi phân tích JSON
            .then(text => {
                try {
                    const data = JSON.parse(text); // Phân tích JSON
                    if (data.success) {
                        alert('Item saved successfully!');
                        fetchItems(); // Cập nhật danh sách sản phẩm
                        itemForm.reset(); // Reset form
                    } else {
                        alert(`Error: ${data.message}`);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('An unexpected error occurred. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});

// Hàm để lấy danh sách sản phẩm từ server
function fetchItems(page = 1) {
    fetch(`get_items.php?page=${page}`)
    .then(response => response.text()) // Chuyển đổi trước khi phân tích JSON
    .then(text => {
        try {
            const data = JSON.parse(text); // Phân tích JSON
            renderItems(data.items);
            renderPagination(data.page, data.totalPages);
        } catch (error) {
            console.error('Error parsing JSON:', error);
            alert('An unexpected error occurred while fetching items.');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Hàm để hiển thị sản phẩm
function renderItems(items) {
    const tbody = document.querySelector("#items tbody");
    tbody.innerHTML = "";
    
    items.forEach(item => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.price}</td>
            <td>${item.quantity}</td>
            <td><img src="../Admin_Page/image/${item.image}" alt="${item.name}" style="width: 50px; height: 50px;"></td>
            <td>
                <button onclick="editItem(${item.id})">Edit</button>
                <button onclick="deleteItem(${item.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// Hàm để phân trang
function renderPagination(currentPage, totalPages) {
    const pageNumbers = document.querySelector(".pagination .page-numbers");
    pageNumbers.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
        const a = document.createElement("a");
        a.href = "#";
        a.classList.add("page-number");
        a.textContent = i;
        a.addEventListener("click", (e) => {
            e.preventDefault();
            fetchItems(i);
        });
        if (i === currentPage) {
            a.classList.add("active");
        }
        pageNumbers.appendChild(a);
    }
}



// Hàm chỉnh sửa sản phẩm
function editItem(id) {
    fetch(`get_item.php?id=${id}`)
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    const item = data.item;
                    document.getElementById("item-id").value = item.id;
                    document.getElementById("item-name").value = item.name;
                    document.getElementById("item-price").value = item.price;
                    document.getElementById("item-quantity").value = item.quantity;
                    // Không cần thay đổi hình ảnh, nếu không có hình ảnh mới thì giữ nguyên hình ảnh cũ
                    document.querySelector("#item-form button").textContent = 'Update Item';
                } else {
                    alert(`Error: ${data.message}`);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
                alert('An unexpected error occurred. Please try again.');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Hàm xóa sản phẩm
function deleteItem(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        fetch(`delete_item.php?id=${id}`, { method: 'GET' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Item deleted successfully!');
                    fetchItems(); // Cập nhật danh sách sản phẩm
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

document.addEventListener('DOMContentLoaded', function () {
    fetchOrders(); // Load orders on page load

    document.getElementById('previous-page').addEventListener('click', function (e) {
        e.preventDefault();
        changePage(-1);
    });

    document.getElementById('next-page').addEventListener('click', function (e) {
        e.preventDefault();
        changePage(1);
    });

    // Handle navigation
    const navLinks = document.querySelectorAll('aside nav ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetSectionId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetSectionId);

            if (targetSection) {
                document.querySelectorAll('main section').forEach(section => {
                    section.style.display = 'none';
                });
                targetSection.style.display = 'block';
            }
        });
    });

    // Default to showing the Overview section
    document.querySelector('#overview').style.display = 'block';
});

let currentPage = 1;
// Fetch and display orders
function fetchOrders(page = 1) {
    fetch(`get_orders.php?page=${page}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderOrders(data.orders);
            renderPagination(data.page, data.totalPages);
        } else {
            alert('Failed to fetch orders.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function renderOrders(orders) {
    const tbody = document.querySelector("#orders tbody");
    tbody.innerHTML = "";

    orders.forEach(order => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${order.id}</td>
            <td>${order.firstname} ${order.lastname}</td>
            <td><button onclick="viewItems(${order.id})">View Items</button></td>
            <td>${order.total_price}</td>
            <td>
                <select onchange="updateStatus(${order.id}, this.value)">
                    <option value="paid" ${order.status === 'paid' ? 'selected' : ''}>Paid</option>
                    <option value="in delivery" ${order.status === 'in delivery' ? 'selected' : ''}>In Delivery</option>
                </select>
            </td>
            <td>
                <button onclick="deleteOrder(${order.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function renderOrderPagination(currentPage, totalPages) {
    const pageNumbers = document.getElementById("page-numbers");
    pageNumbers.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
        const a = document.createElement("a");
        a.href = "#";
        a.textContent = i;
        a.classList.add(i === currentPage ? 'active' : '');
        a.addEventListener('click', function (e) {
            e.preventDefault();
            fetchOrders(i);
        });
        pageNumbers.appendChild(a);
    }
}

function updateStatus(orderId, status) {
    fetch('update_order_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${orderId}&status=${status}`,
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Failed to update order status.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteOrder(orderId) {
    if (confirm('Are you sure you want to delete this order?')) {
        fetch('delete_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${orderId}`,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchOrders(currentPage);
            } else {
                alert('Failed to delete order.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function changePage(delta) {
    fetchOrders(currentPage + delta);
}

// Function to open the modal and display order details
function viewItems(orderId) {
    const modal = document.getElementById('order-modal');
    const tbody = document.querySelector('#order-details-table tbody');
    
    // Fetch order items from the server
    fetch(`get_order_items.php?order_id=${orderId}`)
        .then(response => response.json())
        .then(orderItems => {
            tbody.innerHTML = ''; // Clear previous items
            orderItems.forEach(item => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.product_name}</td>
                    <td>${item.quantity}</td>
                    <td>${item.price}</td>
                `;
                tbody.appendChild(tr);
            });
            modal.style.display = 'block'; // Show the modal
        })
        .catch(error => console.error('Error fetching order items:', error));
}

// Function to close the modal
function closeModal() {
    document.getElementById('order-modal').style.display = 'none';
}

// Add event listener to the close button
document.querySelector('.close-button').addEventListener('click', closeModal);

// Add event listener to close the modal when clicking outside the content
window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('order-modal')) {
        closeModal();
    }
});
