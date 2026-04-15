<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

$successMessage = isset($_GET['success']) ? "Register successfully! You can login now." : null;

if (isset($_POST['login'])) {
    $email = trim($_POST['email']); // Thêm trim() để chống lỗi do gõ thừa dấu cách
    $password = $_POST['password'];

    // TỐI ƯU: Gọi hàm có sẵn thay vì Raw SQL
    $user = getAuthorByEmail($pdo, $email);

    // Kiểm tra mật khẩu bằng password_verify
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Email or password is not correct!";
    }
}

$title = 'Login';
ob_start();
include 'templates/login.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';