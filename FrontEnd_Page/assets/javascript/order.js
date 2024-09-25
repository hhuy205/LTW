document.addEventListener('DOMContentLoaded', function() {
    const cartForm = document.querySelector('.add-to-cart-form');
    const favForm = document.querySelector('.add-to-fav-form');
    const notification = document.createElement("div");
    const notificationFav = document.createElement("div");

    notification.classList.add("notification");
    notificationFav.classList.add("notification-fav");
    document.body.appendChild(notification);
    document.body.appendChild(notificationFav);

    function isSizeSelected() {
        return document.querySelector('.size-option-btn.active') !== null;
    }

    // Hàm xử lý thêm sản phẩm vào giỏ hàng
    cartForm.addEventListener('submit', function(event) {
        event.preventDefault();

        if (!isSizeSelected()) {
            document.querySelector('.size-options').classList.add('error');
            document.querySelector('.size-text').classList.add('error');
        } else {
            const selectedSize = document.querySelector('.size-option-btn.active').textContent.trim();
            document.getElementById('selected_size').value = selectedSize;

            const formData = new FormData(cartForm);

            fetch(cartForm.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                showNotification("Product has been added to your cart!");
            })
            .catch(error => console.error('Error:', error));
        }
    });

    // Hàm xử lý thêm sản phẩm vào danh sách yêu thích
    favForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(favForm);

        fetch(favForm.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            showNotificationFav("Product has been added to your favourite!");
        })
        .catch(error => console.error('Error:', error));
    });

    // Xóa viền đỏ khi chọn size
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

    function showNotification(message) {
        notification.textContent = message;
        notification.classList.add("show");

        setTimeout(function() {
            notification.classList.remove("show");
        }, 3000);
    }

    function showNotificationFav(message) {
        notificationFav.textContent = message;
        notificationFav.classList.add("show");

        setTimeout(function() {
            notificationFav.classList.remove("show");
        }, 3000);
    }
});