<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

// Chỉ Admin mới được truy cập
if (!$is_admin) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    try {
        // TỐI ƯU: Truyền thẳng dữ liệu đã trim() vào hàm để tiết kiệm biến
        updateAuthor($pdo, $_POST['id'], trim($_POST['name']), trim($_POST['email']), $_POST['is_admin']);

        header('Location: admin.php?success=user_updated');
        exit();
    } catch (PDOException $e) {
        $title = 'Error';
        $output = 'Error: ' . $e->getMessage();
    }
} else {
    // TỐI ƯU: Bắt lỗi nếu URL không có ?id=
    if (!isset($_GET['id'])) {
        header('Location: admin.php');
        exit();
    }

    $user_to_edit = getAuthorById($pdo, $_GET['id']);
    
    if (!$user_to_edit) {
        die("<h2 style='color:red; text-align:center;'>Error: User not found!</h2>");
    }

    $title = 'Edit User: ' . $user_to_edit['name'];
    ob_start();
    include 'templates/edituser.html.php';
    $output = ob_get_clean();
}

include 'templates/layout.html.php';