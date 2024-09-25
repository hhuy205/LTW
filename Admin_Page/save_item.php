<?php
include '../connectDB.php'; // Bao gồm tệp kết nối cơ sở dữ liệu


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Đường dẫn lưu trữ hình ảnh
    $uploadDir = '../Admin_Page/image/';
    
    // Kiểm tra nếu thư mục lưu trữ tồn tại, nếu không thì tạo
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Tạo thư mục nếu chưa tồn tại
    }

    $imageName = null;

    // Xử lý hình ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        // Di chuyển tệp hình ảnh từ thư mục tạm thời đến thư mục lưu trữ
        if (!move_uploaded_file($imageTmpPath, $imagePath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
            exit();
        }
    } else {
        // Nếu không có hình ảnh mới, giữ nguyên hình ảnh cũ
        if ($id) {
            $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $imageName = $row['image'];
            }
            $stmt->close();
        }
    }

    // Kiểm tra nếu có ID thì là cập nhật, nếu không có ID thì là thêm mới
    if ($id) {
        // Cập nhật sản phẩm
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, quantity = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $name, $price, $quantity, $imageName, $id);
    } else {
        // Thêm mới sản phẩm
        $stmt = $conn->prepare("INSERT INTO products (id, name, price, quantity, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $id, $name, $price, $quantity, $imageName);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }

    $stmt->close();
    $conn->close();
}
?>
