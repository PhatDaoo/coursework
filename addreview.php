<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

if (isset($_POST['reviewtext'])) {
    try {
        $author_name = trim($_POST['author_name']);
        $author_email = trim($_POST['author_email']);
        $review_text = trim($_POST['reviewtext']);

        // 1. Quản lý Tác giả (Rút gọn)
        $existingAuthor = getAuthorByEmail($pdo, $author_email);
        $author_id = $existingAuthor ? $existingAuthor['id'] : insertAuthor($pdo, $author_name, $author_email);

        // 2. Quản lý Phim
        $film_id = null;
        if (!empty($_POST['new_film_name'])) {
            $new_film_name = trim($_POST['new_film_name']);
            $publish_date = !empty($_POST['publish_date']) ? $_POST['publish_date'] : date('Y-m-d');
            
            $existingFilm = getFilmByName($pdo, $new_film_name);
            $film_id = $existingFilm ? $existingFilm['id'] : insertFilm($pdo, $new_film_name, $publish_date);
        } elseif (!empty($_POST['film_id'])) {
            $film_id = $_POST['film_id'];
        } else {
            throw new Exception("Please select a film or enter a new film name!");
        }

        // 3. Xử lý upload ảnh (Rút gọn)
        $imageName = null;
        if (!empty($_FILES['review_image']['name']) && $_FILES['review_image']['error'] == UPLOAD_ERR_OK) {
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            
            $imageName = time() . '_' . basename($_FILES['review_image']['name']); 
            move_uploaded_file($_FILES['review_image']['tmp_name'], 'uploads/' . $imageName);
        }

        // 4. Thêm bài đánh giá
        insertReview($pdo, $review_text, $author_id, $film_id, $imageName);

        header('Location: reviews.php');
        exit();

    } catch (Exception $e) { // Bắt chung mọi loại lỗi
        $title = 'Error';
        $output = '<div style="color:red; text-align:center; padding:20px;">Error: ' . $e->getMessage() . '</div>';
    }
} else {
    // GET: Tải form
    try {
        $title = 'Add new review';
        $current_name = '';
        $current_email = '';
        
        // TỐI ƯU: Sử dụng hàm getAuthorById thay vì viết SQL thô
        if ($current_user_id) {
            $user = getAuthorById($pdo, $current_user_id);
            if ($user) {
                $current_name = $user['name'];
                $current_email = $user['email'];
            }
        }

        $films = getFilms($pdo); 
        ob_start();
        include 'templates/addreview.html.php';
        $output = ob_get_clean();
    } catch (PDOException $e) {
        $output = 'Error: ' . $e->getMessage();
    }
}

include 'templates/layout.html.php';