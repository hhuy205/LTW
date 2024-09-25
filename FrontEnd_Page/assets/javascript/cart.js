const SHIPPING_FEE = 25; // Biến phí vận chuyển

function updateCartQuantity(index, quantity) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'update_cart.php?index=' + index + '&quantity=' + quantity, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('item-price-' + index).innerHTML = '$' + response.itemTotalPrice;

            // Cập nhật tổng giá và phí giao hàng
            var subtotal = parseFloat(response.totalPrice.replace(/[^0-9.-]+/g, ""));
            var totalPrice = subtotal > 0 ? subtotal + SHIPPING_FEE : 0;

            document.getElementById('subtotal').innerHTML = numberWithCommas(subtotal) + '$';
            document.getElementById('total-price').innerHTML = (totalPrice > 0) ? numberWithCommas(totalPrice) + '$' : '--';
            document.getElementById('delivery-fee').innerHTML = (subtotal > 0) ? numberWithCommas(SHIPPING_FEE) + '$' : '--';

            // Cập nhật trạng thái checkout
            document.getElementById('checkout-button').disabled = (subtotal = 0);
        }
    };
    xhr.send();
}

function numberWithCommas(x) {
    // Format number with commas as thousand separator
    return x.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

// Initial setup
document.addEventListener('DOMContentLoaded', function () {
    var subtotalText = document.getElementById('subtotal').textContent.replace(/[^0-9.-]+/g, "");
    var subtotal = parseFloat(subtotalText);
    var totalPrice = subtotal > 0 ? subtotal + SHIPPING_FEE : 0;

    document.getElementById('total-price').innerHTML = (totalPrice > 0) ? numberWithCommas(totalPrice) + '$' : '--';
    document.getElementById('delivery-fee').innerHTML = (subtotal > 0) ? numberWithCommas(SHIPPING_FEE) + '$' : '--';
});