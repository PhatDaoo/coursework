<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

if (isset($_POST['register'])) {
    try {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // 1. Kiểm tra email đã tồn tại chưa
        $existingUser = getAuthorByEmail($pdo, $email);

        if ($existingUser) {
            $error = "This email has been registered. Please choose another email!";
        } else {
            // 2. Tiến hành đăng ký
            registerAuthor($pdo, $name, $email, $password);
            
            // 3. Thông báo thành công và chuyển hướng sang Login
            header('Location: login.php?success=1');
            exit();
        }
    } catch (PDOException $e) {
        $error = "System error: " . $e->getMessage();
    }
}

$title = 'Register';
ob_start();
include 'templates/register.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';