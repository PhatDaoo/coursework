<div class="form-container">
    <h2>Add new review</h2>
    <form action="" method="post" enctype="multipart/form-data" class="review-form">
        
        <div class="form-group">
            <label for="author_name">Reviewer:</label>
            <input type="text" name="author_name" id="author_name" required value="<?= htmlspecialchars($current_name, ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label for="author_email">Email:</label>
            <input type="email" name="author_email" id="author_email" required value="<?= htmlspecialchars($current_email, ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <fieldset class="form-fieldset">
            <legend>Movie Selection</legend>
            
            <div class="form-group">
                <label for="film_id">1. Select a film that already exists:</label>
                <select name="film_id" id="film_id">
                    <option value="">-- Click to select a film --</option>
                    <?php foreach ($films as $film): ?>
                        <option value="<?= htmlspecialchars($film['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($film['film_name'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="divider-text">--- OR ---</div>

            <div class="form-group">
                <label for="new_film_name">2. Add new film (If not in the list above):</label>
                <input type="text" name="new_film_name" id="new_film_name" placeholder="Enter new film name...">
                
                <label for="publish_date" style="margin-top: 10px; display: block;">Publish Date (compulsory if adding new film):</label>
                <input type="date" name="publish_date" id="publish_date">
            </div>
        </fieldset>

        <div class="form-group">
            <label for="reviewtext">Review content:</label>
            <textarea id="reviewtext" name="reviewtext" rows="6" required placeholder="Your thoughts..."></textarea>
        </div>
        
        <div class="form-group">
            <label for="review_image">Image (Optional):</label>
            <input type="file" name="review_image" id="review_image" accept="image/*">
        </div>
        
        <button type="submit" name="submit" class="submit-btn">Submit Review</button>
    </form>
</div>