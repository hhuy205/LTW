document.addEventListener("DOMContentLoaded", function() {
    fetchProducts();
});

function fetchProducts() {
    fetch('get_products.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json(); // Phân tích cú pháp dữ liệu JSON
        })
        .then(data => {
            if (data.error) {
                console.error('Error fetching products:', data.error);
                return;
            }

            const productSection = document.getElementById('product-section');
            productSection.innerHTML = ''; // Xóa nội dung cũ

            data.forEach(product => {
                const productStatus = product.status || 'Just In';
                const productContainer = document.createElement('div');
                productContainer.classList.add('product-container');

                productContainer.innerHTML = `
                    <a href="order.php?id=${product.id}" class="product-card">
                        <div class="product-image-wrapper">
                            <img src="../Admin_Page/image/${product.image}" class="product-image" alt="${product.name}">
                        </div>
                        <div class="product-info-container">
                            <div class="product-thumbnails">
                                <!-- Placeholder thumbnails; replace if needed -->
                                <img src="../Admin_Page/image/${product.image}" alt="Thumbnail 1" class="thumbnail">
                                <img src="../Admin_Page/image/${product.image}" alt="Thumbnail 2" class="thumbnail">
                                <img src="../Admin_Page/image/${product.image}" alt="Thumbnail 3" class="thumbnail">
                            </div>
                            <div class="product-status">${productStatus}</div>
                            <div class="product-title">${product.name}</div>
                            <div class="product-category">${product.category || 'Shoes'}</div>
                            <div class="product-colors">${product.colors || '3 Colours'}</div>
                            <div class="product-price">$${formatPrice(product.price)}</div>
                        </div>
                    </a>
                `;

                productSection.appendChild(productContainer);
            });
        })
        .catch(error => console.error('Error fetching products:', error));
}

function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}
