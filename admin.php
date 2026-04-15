<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

// Admin protection
if (!$is_admin) {
    header('Location: index.php');
    exit();
}

try {
    $title = 'Admin Control Panel';
    
    // Get data for 3 CRUD sections 
    $all_films = getFilms($pdo);
    $all_users = query($pdo, 'SELECT * FROM author')->fetchAll();
    $all_messages = getAllMessages($pdo); 

    ob_start();
    include 'templates/admin_dashboard.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $output = 'Database error: ' . $e->getMessage();
}

include 'templates/layout.html.php';