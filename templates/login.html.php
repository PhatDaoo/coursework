<div class="form-container">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="" method="post" class="review-form">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required placeholder="Enter your password">
        </div>
        <button type="submit" name="login" class="submit-btn">Login</button>
    </form>
    <p style="text-align: center;">Don't have an account? <a href="register.php">Register now</a></p>
</div>