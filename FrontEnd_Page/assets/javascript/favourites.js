// Get modal element
const modal = document.getElementById("sizeModal");
const cartForm = document.querySelector('.add-to-cart-form');

// Kiểm tra xem đã chọn size chưa
function isSizeSelected() {
    return document.querySelector('.size-option-btn.active') !== null;
}

// Xử lý mở modal
document.querySelectorAll('.open-modal-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        const itemId = this.getAttribute('data-item-id');
        const itemImage = this.getAttribute('data-item-image');
        const itemName = this.getAttribute('data-item-name');
        const itemPrice = this.getAttribute('data-item-price');
        const index = this.getAttribute('data-index');

        document.getElementById('modalImage').src = itemImage;
        document.getElementById('modalName').textContent = itemName;
        document.getElementById('modalPrice').textContent = `${parseFloat(itemPrice).toFixed(2)}$`;
        document.getElementById('itemId').value = itemId;

        modal.style.display = "block";

        // Xóa lựa chọn size trước đó
        document.querySelectorAll('.size-option-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });

        // Hiển thị size đã chọn trước đó (nếu có)
        const previousSize = localStorage.getItem(`selected_size_${index}`);
        if (previousSize) {
            document.querySelector(`.size-option-btn[value="${previousSize}"]`).classList.add('active');
        }
    });
});

// Đóng modal khi click bên ngoài
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

// Xử lý thêm sản phẩm vào giỏ hàng
cartForm.addEventListener('submit', function(event) {
    event.preventDefault();

    if (!isSizeSelected()) {
        document.querySelector('.size-options').classList.add('error');
        document.querySelector('.size-text').classList.add('error');
    } else {
        const selectedSize = document.querySelector('.size-option-btn.active').textContent.trim();
        document.getElementById('selected_size').value = selectedSize;
        const itemId = document.getElementById('itemId').value;
        
        // Cập nhật action của form
        cartForm.action = `add_to_cart.php?id=${itemId}`;

        const formData = new FormData(cartForm);

        fetch(cartForm.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                window.location.href = `cart.php`;
                modal.style.display = "none";
                const index = document.querySelector('.open-modal-btn.active').getAttribute('data-index');
                localStorage.setItem(`selected_size_${index}`, selectedSize);
            })
            .catch(error => console.error('Error:', error));
    }
});

// Xóa lỗi khi chọn size
document.querySelectorAll('.size-option-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        document.querySelector('.size-options').classList.remove('error');
        document.querySelector('.size-text').classList.remove('error');
        document.querySelectorAll('.size-option-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        this.classList.add('active');
        document.getElementById('selected_size').value = this.textContent.trim();
    });
});
