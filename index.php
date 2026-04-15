<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

try {
    // Lấy từ khóa tìm kiếm từ URL (phương thức GET)
    $search_keyword = $_GET['search_keyword'] ?? '';

    // Truyền từ khóa vào hàm để lọc danh sách phim
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