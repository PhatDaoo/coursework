<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

try {
    $search_keyword = $_GET['search'] ?? $_GET['search_keyword'] ?? $_POST['search_keyword'] ?? '';
    $active_review_id = $_GET['active_review'] ?? null;

    $reviews = getReviews($pdo, $search_keyword);
    
    foreach ($reviews as $key => $review) {
        $reviews[$key]['comments'] = getCommentsByReviewId($pdo, $review['id']);
    }
    
    $totalReviews = count($reviews);
    $title = 'Reviews List - Film Review System';

    ob_start();
    include 'templates/reviews.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error';
    $output = 'Error: ' . $e->getMessage();
}

include 'templates/layout.html.php';