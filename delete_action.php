<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

// Get type of entity to delete (film, user, review) and ID
$type = $_REQUEST['type'] ?? '';
$id = $_REQUEST['id'] ?? null;

if (!$id || !$type) {
    die("Error: Invalid information to perform delete action!");
}

try {
    // 1. DELETE USER (Admin only)
    if ($type === 'user') {
        if (!$is_admin) die("Error: Access denied!");
        if ($id == $current_user_id) die("Error: Cannot delete your own account!");
        
        deleteAuthor($pdo, $id);
        header('Location: admin.php?success=user_deleted');
    }
    
    // 2. DELETE FILM (Admin only)
    elseif ($type === 'film') {
        if (!$is_admin) die("Error: Access denied!");
        
        deleteFilm($pdo, $id);
        header('Location: admin.php?success=film_deleted');
    }
    
    // 3. DELETE REVIEW (Admin or author)
    elseif ($type === 'review') {
        $review = getReviewById($pdo, $id);
        
        if (!$review || ($review['author_id'] != $current_user_id && !$is_admin)) {
            die("Error: You do not have permission to delete this review!");
        }
        
        // Delete image from server
        if (!empty($review['image']) && file_exists('uploads/' . $review['image'])) {
            unlink('uploads/' . $review['image']); 
        }
        
        deleteReview($pdo, $id);
        header('Location: reviews.php?success=review_deleted');
    }
    exit();

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}