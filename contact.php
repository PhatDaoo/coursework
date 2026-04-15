<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

// UX: Thay vì báo lỗi khô khan, tự động đẩy người dùng về trang đăng nhập
if (!$current_user_id) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['message_text'])) {
    try {
        // Lưu tin nhắn
        insertMessage($pdo, $current_user_id, $_POST['message_text']);
        
        // UX: Gửi xong thì tự reload lại trang kèm thông báo thành công trên URL
        header('Location: contact.php?success=1');
        exit();
    } catch (PDOException $e) {
        $title = 'Error';
        $output = 'Error: ' . $e->getMessage();
    }
} else {
    try {
        $title = 'Contact Admin';
        
        // Lấy thông tin user bằng hàm đã tối ưu
        $user = getAuthorById($pdo, $current_user_id);
        
        // Cờ kiểm tra xem có hiển thị thông báo "Gửi thành công" không
        $is_success = isset($_GET['success']); 

        ob_start();
        include 'templates/contact.html.php';
        $output = ob_get_clean();
    } catch (PDOException $e) {
        $output = 'Error: ' . $e->getMessage();
    }
}

include 'templates/layout.html.php';