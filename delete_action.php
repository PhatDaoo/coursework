<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

// Nhận loại thực thể cần xóa (film, user, review) và ID
$type = $_REQUEST['type'] ?? '';
$id = $_REQUEST['id'] ?? null;

if (!$id || !$type) {
    die("Error: Invalid information to perform delete action!");
}

try {
    // 1. XÓA USER (Chỉ Admin)
    if ($type === 'user') {
        if (!$is_admin) die("Error: Access denied!");
        if ($id == $current_user_id) die("Error: Cannot delete your own account!");
        
        deleteAuthor($pdo, $id);
        header('Location: admin.php?success=user_deleted');
    }
    
    // 2. XÓA PHIM (Chỉ Admin)
    elseif ($type === 'film') {
        if (!$is_admin) die("Error: Access denied!");
        
        deleteFilm($pdo, $id);
        header('Location: admin.php?success=film_deleted');
    }
    
    // 3. XÓA REVIEW (Admin HOẶC chính tác giả bài viết)
    elseif ($type === 'review') {
        $review = getReviewById($pdo, $id);
        
        // VÁ LỖ HỔNG: Kiểm tra bài có tồn tại không, và người xóa có quyền không
        if (!$review || ($review['author_id'] != $current_user_id && !$is_admin)) {
            die("Error: You do not have permission to delete this review!");
        }
        
        // Xóa ảnh vật lý khỏi máy chủ
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