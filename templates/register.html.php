<div class="form-container">
    <h2>Create new account</h2>
    
    <?php if (isset($error)): ?>
        <p style="color: #e74c3c; background: #fdf2f0; padding: 10px; border-radius: 5px;"><?= $error ?></p>
    <?php endif; ?>

    <form action="" method="post" class="review-form">
        <div class="form-group">
            <label for="name">Full name:</label>
            <input type="text" name="name" id="name" required placeholder="Enter your name">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required placeholder="Create a password">
        </div>

        <button type="submit" name="register" class="submit-btn">Register</button>
    </form>
    
    <p style="text-align: center; margin-top: 15px;">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>