<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

if (!$current_user_id) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit_comment'])) {
    $review_id = $_POST['review_id'];
    $comment_text = trim($_POST['comment_text']);
    
    // Get the previous page URL (reviews.php or myreviews.php)
    $return_url = $_POST['return_url'] ?? 'reviews.php';

    if (!empty($comment_text)) {
        insertComment($pdo, $review_id, $current_user_id, $comment_text);   
    }
    
    // Check if return_url already has a ? character to concatenate correctly
    $separator = (strpos($return_url, '?') !== false) ? '&' : '?';
    
    // Add active_review for JS to open the tab automatically
    header("Location: " . $return_url . $separator . "active_review=" . $review_id);
    exit();
}