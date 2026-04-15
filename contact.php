<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

if (!$current_user_id) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['message_text'])) {
    try {
        insertMessage($pdo, $current_user_id, $_POST['message_text']);
        
        header('Location: contact.php?success=1');
        exit();
    } catch (PDOException $e) {
        $title = 'Error';
        $output = 'Error: ' . $e->getMessage();
    }
} else {
    try {
        $title = 'Contact Admin';
        
        $user = getAuthorById($pdo, $current_user_id);
        
        $is_success = isset($_GET['success']); 

        ob_start();
        include 'templates/contact.html.php';
        $output = ob_get_clean();
    } catch (PDOException $e) {
        $output = 'Error: ' . $e->getMessage();
    }
}

include 'templates/layout.html.php';