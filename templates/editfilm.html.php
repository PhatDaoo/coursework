<div class="form-container">
    <h2>Edit Film Details</h2>
    
    <form action="" method="post" enctype="multipart/form-data" class="review-form">
        <input type="hidden" name="id" value="<?= $film['id'] ?>">
        
        <input type="hidden" name="current_image" value="<?= htmlspecialchars($film['image'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
            <label for="film_name">Film Name:</label>
            <input type="text" name="film_name" id="film_name" required 
                   value="<?= htmlspecialchars($film['film_name'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label for="publish_date">Publish Date:</label>
            <input type="date" name="publish_date" id="publish_date" required 
                   value="<?= $film['publish_date'] ?>">
        </div>

        <div class="form-group">
            <label>Current Poster:</label>
            <?php if (!empty($film['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($film['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Poster" style="max-width: 150px; border-radius: 5px;">
            <?php else: ?>
                <p style="color: #7f8c8d; font-style: italic; margin: 0;">No poster available.</p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="film_image">Upload New Poster:</label>
            <input type="file" name="film_image" id="film_image" accept="image/*">
            <small style="color: #666;">(Leave blank if you don't want to change the image)</small>
        </div>

        <button type="submit" name="submit" class="submit-btn">Save Changes</button>
    </form>
</div>