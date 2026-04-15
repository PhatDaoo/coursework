<div class="form-container">
    <h2>Admin contact</h2>
    
    <?php if (!empty($is_success)): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; text-align: center;">
            <strong>Success!</strong> Your message has been sent to the Admin.
        </div>
    <?php endif; ?>

    <form action="" method="post" class="review-form">
        <div class="form-group">
            <label>Your name:</label>   
            <input type="text" value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" readonly>
        </div>

        <div class="form-group">
            <label>Your email:</label>
            <input type="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" readonly>
        </div>

        <div class="form-group">
            <label for="message_text">Message content:</label>
            <textarea id="message_text" name="message_text" rows="6" required placeholder="What do you want to feedback to Admin?"></textarea>
        </div>
        
        <button type="submit" name="submit" class="submit-btn">Send feedback</button>
    </form>
</div>