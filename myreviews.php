<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

// SECURITY: Must login
if (!$current_user_id) {
    header('Location: login.php');
    exit();
}

try {
    $search_keyword = $_GET['search'] ?? $_GET['search_keyword'] ?? $_POST['search_keyword'] ?? '';

    // Get ID of the review being selected to view comments (if any)
    $active_review_id = $_GET['active_review'] ?? null;

    $reviews = getReviews($pdo, $search_keyword);
    
    // Ensure you have added this line to get comments for EACH review (as instructed in the previous section)
    foreach ($reviews as $key => $review) {
        $reviews[$key]['comments'] = getCommentsByReviewId($pdo, $review['id']);
    }

    // Start loading interface
    ob_start();
    include 'templates/reviews.html.php';
    $output = ob_get_clean();

    $search_keyword = $_GET['search'] ?? $_GET['search_keyword'] ?? '';

    // OPTIMIZE: Shorten table name with Alias (r, a, f) and use query() function
    if ($search_keyword) {
        $sql = 'SELECT r.*, a.name as author_name, f.film_name 
                FROM reviews r 
                JOIN author a ON r.author_id = a.id 
                JOIN film f ON r.film_id = f.id
                WHERE r.author_id = :my_id 
                  AND (f.film_name LIKE :search OR r.review_text LIKE :search)
                ORDER BY r.review_date DESC';
                
        $reviews = query($pdo, $sql, [
            'my_id' => $current_user_id,
            'search' => '%' . $search_keyword . '%'
        ])->fetchAll();
    } else {
        $sql = 'SELECT r.*, a.name as author_name, f.film_name 
                FROM reviews r 
                JOIN author a ON r.author_id = a.id 
                JOIN film f ON r.film_id = f.id
                WHERE r.author_id = :my_id
                ORDER BY r.review_date DESC';
        
        $reviews = query($pdo, $sql, ['my_id' => $current_user_id])->fetchAll();
    }

    foreach ($reviews as $key => $review) {
        $reviews[$key]['comments'] = getCommentsByReviewId($pdo, $review['id']);
    }

    $totalReviews = count($reviews);
    $title = 'My Reviews';

    // Reuse interface
    ob_start();
    include 'templates/reviews.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error';
    $output = 'Error: ' . $e->getMessage();
}

include 'templates/layout.html.php';