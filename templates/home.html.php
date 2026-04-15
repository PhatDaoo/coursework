<div class="home-container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    
    <div class="search-container" style="margin-bottom: 30px;">
        <form action="index.php" method="get" class="search-form" style="display: flex; gap: 10px;">
            <input type="text" name="search_keyword" 
                   value="<?= htmlspecialchars($search_keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                   placeholder="Search for a film..." 
                   style="flex-grow: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            <button type="submit" class="submit-btn" style="margin: 0; padding: 10px 25px;">Search</button>
            
            <?php if (!empty($search_keyword)): ?>
                <a href="index.php" class="clear-search" style="align-self: center;">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 10px; border-bottom: 2px dashed #eee;">
        
        <h2 style="color: var(--primary-color); margin: 0;">
            <?= !empty($search_keyword) ? 'Search Results for: "' . htmlspecialchars($search_keyword) . '"' : 'All Films' ?>
        </h2>

        <?php if (isset($is_admin) && $is_admin): ?>
            <a href="addfilm.php" class="submit-btn" style="background-color: #27ae60; text-decoration: none; padding: 10px 18px; margin: 0; display: inline-flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.2rem; font-weight: bold;">+</span> Add New Film
            </a>
        <?php endif; ?>

    </div>

    <div class="film-grid">
        <?php if (empty($films)): ?>
            <p style="text-align: center; grid-column: 1 / -1; padding: 50px; color: #666;">No films found matching your search.</p>
        <?php else: ?>
            <?php foreach ($films as $film): ?>
                <div class="film-card">
                    <a href="reviews.php?search=<?= urlencode($film['film_name']) ?>">
                        <?php if ($film['thumbnail']): ?>
                            <img src="uploads/<?= htmlspecialchars($film['thumbnail']) ?>" alt="<?= htmlspecialchars($film['film_name']) ?>">
                        <?php else: ?>
                            <div class="no-image-placeholder">
                                <span>No Image<br>Available</span>
                            </div>
                        <?php endif; ?>
                    </a>

                    <div class="film-card-info">
                        <h3>
                            <a href="reviews.php?search=<?= urlencode($film['film_name']) ?>">
                                <?= htmlspecialchars($film['film_name']) ?>
                            </a>
                        </h3>
                        <p>
                            <span class="star-icon">★ <?= $film['review_count'] ?></span> reviews
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>