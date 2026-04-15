<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

try {
    // 1. Nhận các tham số điều hướng từ URL hoặc Form
    $search_keyword = $_GET['search'] ?? $_GET['search_keyword'] ?? $_POST['search_keyword'] ?? '';
    $active_review_id = $_GET['active_review'] ?? null;

    // 2. Lấy dữ liệu bài đánh giá từ Database (TỐI ƯU: Chỉ gọi 1 hàm duy nhất)
    $reviews = getReviews($pdo, $search_keyword);
    
    // 3. Gắn thêm danh sách bình luận vào từng bài đánh giá
    foreach ($reviews as $key => $review) {
        $reviews[$key]['comments'] = getCommentsByReviewId($pdo, $review['id']);
    }
    
    // 4. Thống kê và thiết lập tiêu đề trang
    $totalReviews = count($reviews);
    $title = 'Reviews List - Film Review System';

    // 5. Xuất ra giao diện
    ob_start();
    include 'templates/reviews.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error';
    $output = 'Error: ' . $e->getMessage();
}

include 'templates/layout.html.php';