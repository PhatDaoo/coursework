<div class="form-container">
    <h2>Add new film</h2>
    
    <form action="" method="post" enctype="multipart/form-data" class="review-form">
        
        <div class="form-group">
            <label for="film_name">Film name:</label>
            <input type="text" name="film_name" id="film_name" required placeholder="Enter film name...">
        </div>

        <div class="form-group">
            <label for="publish_date">Publish date:</label>
            <input type="date" name="publish_date" id="publish_date" required>
        </div>

        <div class="form-group">
            <label for="film_image">Poster image (Optional):</label>
            <input type="file" name="film_image" id="film_image" accept="image/*">
            <small style="color: #666;">Recommend using portrait images for posters</small>
        </div>

        <button type="submit" name="submit" class="submit-btn">+ Add Film</button>
    </form>
    
    <p style="text-align: center; margin-top: 15px;">
        <a href="admin.php" style="color: #666; text-decoration: none;">← Back to Dashboard</a>
    </p>
</div>