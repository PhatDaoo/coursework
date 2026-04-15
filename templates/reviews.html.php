<style>
    /* OVERRIDE MAIN TAG TO EXPAND TO FULL SCREEN */
    main {
        max-width: 1400px !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
    }

    /* 2-COLUMN LAYOUT */
    .reviews-layout { display: flex; gap: 30px; align-items: flex-start; }
    .reviews-list-col { flex: 6.5; background: var(--white); padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
    .comments-sidebar { flex: 3.5; position: sticky; top: 80px; background: var(--white); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); height: calc(100vh - 120px); display: flex; flex-direction: column; overflow: hidden; border: 1px solid #e1e8ed; }

    /* COMMENT COLUMN DETAILS */
    .comment-panel { display: flex; flex-direction: column; height: 100%; }
    .comments-header { padding: 20px; background: var(--primary-color); color: white; margin: 0; font-size: 1.1rem; display: flex; justify-content: space-between; align-items: center; }
    .close-panel-btn { background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; opacity: 0.8; }
    .close-panel-btn:hover { opacity: 1; }
    .comment-input-box { width: 100%; padding: 12px; border: 2px solid #e1e8ed; border-radius: 8px; resize: none; box-sizing: border-box; margin-bottom: 10px; font-family: inherit; transition: 0.3s; }
    .comment-input-box:focus { border-color: var(--secondary-color); outline: none; }
</style>

<div class="reviews-layout">
    
    <div class="reviews-list-col">
        <div class="review-stats">
            Total Reviews: <strong><?= $totalReviews ?></strong>
        </div>

        <div class="search-container">
            <form action="" method="get" class="search-form">
                <input type="text" name="search_keyword" value="<?= htmlspecialchars($search_keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Search film, author or content...">
                <button type="submit" class="submit-btn search-btn">Search</button>
                <?php if(!empty($_GET['search_keyword'])): ?>
                    <a href="<?= basename($_SERVER['PHP_SELF']) ?>" class="clear-search">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (isset($reviews) && !empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <blockquote class="review-card">
                    <h3 class="movie-title"><?= htmlspecialchars($review['film_name'], ENT_QUOTES, 'UTF-8') ?></h3>
                    
                    <?php if (!empty($review['image'])): ?>
                        <div class="review-image" style="text-align: left;">
                            <img src="uploads/<?= htmlspecialchars($review['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Film Image">
                        </div>
                    <?php endif; ?>

                    <p class="review-content"><?= nl2br(htmlspecialchars($review['review_text'], ENT_QUOTES, 'UTF-8')) ?></p>
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px dashed #eee; padding-top: 15px; margin-top: 15px;">
                        
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="font-size: 0.9rem; color: #888; line-height: 1.4;">
                                By: <strong><?= htmlspecialchars($review['author_name'], ENT_QUOTES, 'UTF-8') ?></strong><br>
                                <?= date('d/m/Y', strtotime($review['review_date'])) ?>
                            </div>
                            
                            <?php if ($current_user_id == $review['author_id'] || (isset($is_admin) && $is_admin)): ?>
                                <div style="display: flex; gap: 10px; border-left: 1px solid #ddd; padding-left: 15px;">
                                    <a href="editreview.php?id=<?= $review['id'] ?>" class="edit-link">Edit</a>
                                    <form action="delete_action.php" method="post" onsubmit="return confirm('Delete this review?');" style="margin: 0;">
                                        <input type="hidden" name="type" value="review">
                                        <input type="hidden" name="id" value="<?= $review['id'] ?>">
                                        <button type="submit" class="delete-btn" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-weight: bold; padding: 0;">Delete</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <button type="button" class="submit-btn" onclick="openComments(<?= $review['id'] ?>)" style="padding: 8px 15px; margin: 0; background: var(--secondary-color);">
                                Comment (<?= count($review['comments'] ?? []) ?>)
                            </button>
                        </div>
                    </div>
                </blockquote>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; color: #666; padding: 40px 0;">No reviews found.</p>
        <?php endif; ?>
    </div>


    <div class="comments-sidebar">
        
        <div id="default-comment-msg" style="text-align: center; padding: 60px 20px; color: #888; height: 100%; display: flex; flex-direction: column; justify-content: center;">
            <div style="font-size: 4rem; color: #e1e8ed; margin-bottom: 20px;">💬</div>
            <h3 style="color: var(--primary-color);">Discussion Panel</h3>
            <p>Click the "Comment" button on any review to join the discussion.</p>
        </div>

        <?php if (isset($reviews) && !empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div id="comment-panel-<?= $review['id'] ?>" class="comment-panel" style="display: none;">
                    
                    <h3 class="comments-header">
                        <span><?= htmlspecialchars($review['film_name'], ENT_QUOTES, 'UTF-8') ?></span>
                        <button class="close-panel-btn" onclick="closeComments()">✖</button>
                    </h3>
                    
                    <div class="comments-list" style="flex-grow: 1; padding: 20px; overflow-y: auto;">
                        <?php if (!empty($review['comments'])): ?>
                            <?php foreach ($review['comments'] as $comment): ?>
                                <div style="margin-bottom: 15px; font-size: 0.9rem; border-bottom: 1px dashed #eee; padding-bottom: 10px;">
                                    <strong style="color: var(--secondary-color);"><?= htmlspecialchars($comment['author_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                                    <span style="color: #999; font-size: 0.8rem; margin-left: 10px;"><?= date('d/m H:i', strtotime($comment['comment_date'])) ?></span>
                                    <div style="margin-top: 5px; color: #444; line-height: 1.4;">
                                        <?= nl2br(htmlspecialchars($comment['comment_text'], ENT_QUOTES, 'UTF-8')) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: #aaa; text-align: center; font-style: italic; margin-top: 20px;">Be the first to comment!</p>
                        <?php endif; ?>
                    </div>

                    <div class="comment-form-container" style="padding: 15px 20px; background: #fff; border-top: 1px solid #eee;">
                        <?php if ($current_user_id): ?>
                            <form action="comment_action.php" method="post" style="margin: 0;">
                                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                <input type="hidden" name="return_url" value="<?= basename($_SERVER['PHP_SELF']) . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '') ?>">
                                <textarea name="comment_text" class="comment-input-box" rows="3" placeholder="Write a comment..." required></textarea>
                                <button type="submit" name="submit_comment" class="submit-btn" style="width: 100%; padding: 10px; font-size: 1rem; margin-top: 0;">Post Comment</button>
                            </form>
                        <?php else: ?>
                            <div style="text-align: center; padding: 15px; background: #fdf2f0; border: 1px dashed #e74c3c; border-radius: 6px;">
                                <a href="login.php" style="color: #e74c3c; font-weight: bold; text-decoration: none;">Login</a> to join the discussion.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function openComments(reviewId) {
        document.getElementById('default-comment-msg').style.display = 'none';
        
        let panels = document.querySelectorAll('.comment-panel');
        panels.forEach(panel => panel.style.display = 'none');

        let targetPanel = document.getElementById('comment-panel-' + reviewId);
        if (targetPanel) { targetPanel.style.display = 'flex'; }

        // Save state in URL so that after submitting comment (reload) it opens automatically
        let url = new URL(window.location);
        url.searchParams.set('active_review', reviewId);
        window.history.pushState({}, '', url);
    }

    function closeComments() {
        let panels = document.querySelectorAll('.comment-panel');
        panels.forEach(panel => panel.style.display = 'none');
        document.getElementById('default-comment-msg').style.display = 'flex';
        
        let url = new URL(window.location);
        url.searchParams.delete('active_review');
        window.history.pushState({}, '', url);
    }

    // Automatically open comment tab if URL has parameters (case: just submitted a comment)
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeId = urlParams.get('active_review');
        if (activeId) {
            openComments(activeId);
        }
    }
</script>