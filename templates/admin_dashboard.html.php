<div class="admin-dashboard">
    <h2 style="border-bottom: 2px solid var(--secondary-color); padding-bottom: 10px; color: var(--primary-color);">
        Admin Dashboard</h2>

    <section class="admin-section" style="margin-bottom: 40px;">
        <h3 style="color: var(--primary-color);"><i class="fas fa-envelope"></i> [Admin Inbox] - User Feedbacks</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Sender</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_messages as $msg): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($msg['author_name']) ?></strong><br>
                            <small style="color: #666;"><?= htmlspecialchars($msg['author_email']) ?></small>
                        </td>
                        <td><?= nl2br(htmlspecialchars($msg['message_text'])) ?></td>
                        <td><?= $msg['date_sent'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="admin-section" style="margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: var(--primary-color);"><i class="fas fa-film"></i> Manage Films</h3>
            <a href="addfilm.php" class="submit-btn" style="text-decoration: none; padding: 10px 15px; margin: 0;">+ Add
                New Film</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Film Name</th>
                    <th>Release Date</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_films as $film): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($film['film_name']) ?></strong></td>
                        <td><?= date('d/m/Y', strtotime($film['publish_date'])) ?></td>
                        <td style="text-align: center;">
                            <a href="editfilm.php?id=<?= $film['id'] ?>" class="edit-link">Edit</a> |
                            <a href="delete_action.php?type=film&id=<?= $film['id'] ?>" class="delete-btn"
                                style="text-decoration: none;"
                                onclick="return confirm('Delete this film will delete all the related reviews. Continue?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="admin-section">
        <h3 style="color: var(--primary-color);"><i class="fas fa-users"></i> Manage Users</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <?php if ($user['is_admin']): ?>
                                <span
                                    style="background: #f1c40f; color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Admin</span>
                            <?php else: ?>
                                <span style="color: #666;">User</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <a href="edituser.php?id=<?= $user['id'] ?>" class="edit-link">Edit</a> |
                            <a href="delete_action.php?type=user&id=<?= $user['id'] ?>" class="delete-btn"
                                style="text-decoration: none;"
                                onclick="return confirm('Warning: Delete this user will delete all the related reviews. Continue?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>