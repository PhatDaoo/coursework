<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reviews.css">
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <h1>Film Review System</h1>
        <?php if ($current_user_id): ?>
            <div class="user-info">
                <i class="fas fa-user-circle"></i> User: <strong><?= htmlspecialchars($logged_in_name, ENT_QUOTES, 'UTF-8') ?></strong>
            </div>
        <?php endif; ?>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="reviews.php">Reviews</a></li>

            <?php if (isset($current_user_id) && $current_user_id): ?>
                <li><a href="addreview.php">Add Review</a></li>
                <li><a href="contact.php">Contact Admin</a></li>
                <li><b>|</b></li>
                <li><a href="myreviews.php">My Reviews</a></li>
                
                <?php if (isset($is_admin) && $is_admin): ?>
                    <li><a href="admin.php" style="color: #f1c40f;">[Admin Dashboard]</a></li>
                <?php endif; ?>

                <li class="auth-btn"><a href="logout.php" class="btn-logout">Logout</a></li>
            <?php else: ?>
                <li class="auth-btn"><a href="login.php" class="btn-login">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main>
        <?= $output ?>
    </main>
    
    <footer>
        &copy; <?= date('Y') ?> Film Review System. Designed for Coursework.
    </footer>
</body>
</html>