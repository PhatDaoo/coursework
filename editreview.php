<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

$review_id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$review_id) { 
    die("<h2 style='color:red; text-align:center;'>Error: Review ID not found!</h2>"); 
}

$review_to_edit = getReviewById($pdo, $review_id);

if (!$review_to_edit) { 
    die("<h2 style='color:red; text-align:center;'>Error: Review not found!</h2>"); 
}

// SECURITY: Kiểm tra quyền (Chỉ Tác giả hoặc Admin mới được sửa)
if ($review_to_edit['author_id'] != $current_user_id && !$is_admin) {
    die("<h2 style='color:red; text-align:center;'>Error: You don't have permission to edit this review!</h2>");
}

if (isset($_POST['reviewtext'])) {
    try {
        $author_name = trim($_POST['author_name']);
        $author_email = trim($_POST['author_email']);
        $review_text = trim($_POST['reviewtext']);
        $imageName = $_POST['current_image'] ?? null;

        // Xử lý ảnh mới
        if (!empty($_FILES['review_image']['name']) && $_FILES['review_image']['error'] == UPLOAD_ERR_OK) {
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            $imageName = time() . '_' . basename($_FILES['review_image']['name']); 
            move_uploaded_file($_FILES['review_image']['tmp_name'], 'uploads/' . $imageName);
        }

        // Tác giả
        $existingAuthor = getAuthorByEmail($pdo, $author_email);
        $author_id = $existingAuthor ? $existingAuthor['id'] : insertAuthor($pdo, $author_name, $author_email);

        // Cập nhật
        updateReview($pdo, $review_id, $review_text, $author_id, $_POST['film_id'], $imageName);

        header('Location: reviews.php?success=review_updated');
        exit();

    } catch (PDOException $e) {
        $title = 'Error';
        $output = 'Error: ' . $e->getMessage();
    }
} else {
    $title = 'Edit review';
    
    // Đẩy dữ liệu sang template
    $review = $review_to_edit;
    $films = getFilms($pdo);
    
    ob_start();
    include 'templates/editreview.html.php';
    $output = ob_get_clean();
}

include 'templates/layout.html.php';