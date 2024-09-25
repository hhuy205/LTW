// Chuyển từ trang index sang trang login

// document.addEventListener('DOMContentLoaded', function() {
//     const authLink = document.getElementById('auth-link');

//     if (authLink) {
//         // Kiểm tra trạng thái đăng nhập
//         const isLoggedIn = sessionStorage.getItem('isLoggedIn');
//         if (isLoggedIn) {
//             authLink.innerHTML = 'Log Out';
//             authLink.href = 'logOut.php'; // Liên kết đến trang đăng xuất

//             authLink.addEventListener('click', function(event) {
//                 event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
//                 sessionStorage.removeItem('isLoggedIn'); // Xóa trạng thái đăng nhập
//                 window.location.href = 'signIn.php'; // Chuyển hướng đến trang đăng nhập
//             });
//         } else {
//             authLink.innerHTML = 'Sign In';
//             authLink.href = 'signIn.php'; // Đảm bảo liên kết đúng cho đăng nhập
//         }
//     }
// });

// chuyển từ cart sang checkout

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("checkout-button").addEventListener("click", function() {
        window.location.href = "checkOut.php";
    });
})


// Khi nhấn vào Confirm trong Cart xác nhận đặt hàng thành công
document.addEventListener('DOMContentLoaded', function() {
    // Get the popup and button
    var popup = document.getElementById("orderPopup");
    var btn = document.getElementById("confirmBtn");
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the popup
    btn.addEventListener('click', function() {
        popup.style.display = "block";
    });

    // When the user clicks on <span> (x), close the popup
    span.addEventListener('click', function() {
        popup.style.display = "none";
    });

    // When the user clicks anywhere outside of the popup, close it
    window.addEventListener('click', function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
        }
    });
});



// Show Pop Up when order successfull

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("confirm-button").addEventListener("click", function() {
        document.getElementById("orderPopup").style.display = "block";
    });

    document.querySelector(".btn-home").addEventListener("click", function() {
        document.getElementById("orderPopup").style.display = "none";
    });
});