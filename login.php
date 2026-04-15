<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

$successMessage = isset($_GET['success']) ? "Register successfully! You can login now." : null;

if (isset($_POST['login'])) {
    $email = trim($_POST['email']); // Add trim() to prevent errors from extra spaces
    $password = $_POST['password'];

    // OPTIMIZE: Call available function instead of Raw SQL
    $user = getAuthorByEmail($pdo, $email);

    // Check password using password_verify
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