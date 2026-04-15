<div class="form-container">
    <h2>Edit user</h2>
    
    <form action="" method="post" class="review-form">
        <input type="hidden" name="id" value="<?= $user_to_edit['id'] ?>">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required 
                   value="<?= htmlspecialchars($user_to_edit['name'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required 
                   value="<?= htmlspecialchars($user_to_edit['email'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label for="is_admin">Role:</label>
            <select name="is_admin" id="is_admin">
                <option value="0" <?= $user_to_edit['is_admin'] == 0 ? 'selected' : '' ?>>User</option>
                <option value="1" <?= $user_to_edit['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <button type="submit" name="submit" class="submit-btn">Save changes</button>
        <p style="text-align: center; margin-top: 15px;">
            <a href="admin.php" style="color: #666; text-decoration: none;">← Back to Dashboard</a>
        </p>
    </form>
</div>