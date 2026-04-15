<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

if (isset($_POST['register'])) {
    try {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // 1. Check if email already exists
        $existingUser = getAuthorByEmail($pdo, $email);

        if ($existingUser) {
            $error = "This email has been registered. Please choose another email!";
        } else {
            // 2. Register
            registerAuthor($pdo, $name, $email, $password);
            
            // 3. Success message and redirect to Login
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