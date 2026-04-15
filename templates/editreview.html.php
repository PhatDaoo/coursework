<div class="form-container">
    <h2>Edit Review</h2>
    
    <form action="" method="post" enctype="multipart/form-data" class="review-form">
        <input type="hidden" name="id" value="<?= $review['id'] ?>">
        
        <input type="hidden" name="current_image" value="<?= htmlspecialchars($review['image'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
            <label for="author_name">Reviewer:</label>
            <input type="text" name="author_name" id="author_name" required value="<?= htmlspecialchars($review_to_edit['author_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label for="author_email">Email:</label>
            <input type="email" name="author_email" id="author_email" required value="<?= htmlspecialchars($review_to_edit['author_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label for="film_id">Movie:</label>
            <select name="film_id" id="film_id">
                <?php foreach ($films as $film): ?>
                    <option value="<?= $film['id'] ?>" <?= $film['id'] == $review['film_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($film['film_name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="reviewtext">Review content:</label>
            <textarea id="reviewtext" name="reviewtext" rows="6" required><?= htmlspecialchars($review['review_text'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="form-group">
            <label>Current Image:</label>
            <?php if (!empty($review['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($review['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Review Image" style="max-width: 200px; border-radius: 8px; margin-bottom: 10px;">
            <?php else: ?>
                <p style="color: #888; font-style: italic;">No image uploaded for this review.</p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="review_image">Upload New Image (Optional):</label>
            <input type="file" name="review_image" id="review_image" accept="image/*">
            <small style="color: #666;">Leave blank to keep the current image.</small>
        </div>

        <button type="submit" name="submit" class="submit-btn">Save Changes</button>
    </form>
</div>