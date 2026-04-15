<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

try {
    // Get search keyword from URL (GET method)
    $search_keyword = $_GET['search_keyword'] ?? '';

    // Pass keyword to function to filter film list
    $films = getFilmsWithStats($pdo, $search_keyword);
    
    $title = 'Home - Film Review System';

    ob_start();
    include 'templates/home.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error';
    $output = 'Error: ' . $e->getMessage();
}

include 'templates/layout.html.php';