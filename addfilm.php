<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

// Bảo vệ an ninh: Chỉ Admin
if (!$is_admin) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    try {
        $film_name = trim($_POST['film_name']);
        $publish_date = $_POST['publish_date'];
        $imageName = null;

        // Xử lý upload ảnh Poster (Đã rút gọn logic check thư mục)
        if (!empty($_FILES['film_image']['name']) && $_FILES['film_image']['error'] == UPLOAD_ERR_OK) {
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            
            $imageName = time() . '_poster_' . basename($_FILES['film_image']['name']); 
            move_uploaded_file($_FILES['film_image']['tmp_name'], 'uploads/' . $imageName);
        }

        // TỐI ƯU: Sử dụng hàm dùng chung thay vì viết Raw SQL
        insertFilm($pdo, $film_name, $publish_date, $imageName);

        header('Location: admin.php?success=film_added');
        exit();

    } catch (PDOException $e) {
        $title = 'Lỗi hệ thống';
        $output = 'Error: ' . $e->getMessage();
    }
} else {
    $title = 'Add New Film';
    ob_start();
    include 'templates/addfilm.html.php';
    $output = ob_get_clean();
}

include 'templates/layout.html.php';