<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    if ($action === 'add') {
        $pdo->prepare("INSERT INTO promotions (title, description, promo_type, link_url, link_text, discount_percent, start_date, end_date, display_location, is_active) VALUES (?,?,?,?,?,?,?,?,?,?)")
            ->execute([
                trim($_POST['title']), trim($_POST['description']), $_POST['promo_type'],
                trim($_POST['link_url']), trim($_POST['link_text']),
                intval($_POST['discount_percent']) ?: null,
                $_POST['start_date'] ?: null, $_POST['end_date'] ?: null,
                $_POST['display_location'], isset($_POST['is_active']) ? 1 : 0
            ]);
        $success = 'Promotion added!';
    } elseif ($action === 'delete') {
        $pdo->prepare("DELETE FROM promotions WHERE id = ?")->execute([$_POST['id']]);
        $success = 'Promotion deleted!';
    } elseif ($action === 'toggle') {
        $pdo->prepare("UPDATE promotions SET is_active = NOT is_active WHERE id = ?")->execute([$_POST['id']]);
        $success = 'Promotion toggled!';
    }
}

$promotions = $pdo->query("SELECT * FROM promotions ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <h1 class="page-title">Promotions & Announcements</h1>
            <?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

            <div class="admin-card">
                <div class="card-header"><h2>Add Promotion</h2></div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="form-row">
                            <div class="form-group"><label>Title</label><input type="text" name="title" required placeholder="e.g., Summer Sale - 10% Off"></div>
                            <div class="form-group"><label>Type</label>
                                <select name="promo_type"><option value="banner">Banner</option><option value="sale">Sale</option><option value="announcement">Announcement</option></select>
                            </div>
                        </div>
                        <div class="form-group"><label>Description</label><textarea name="description" rows="2" placeholder="Promo details..."></textarea></div>
                        <div class="form-row">
                            <div class="form-group"><label>Link URL</label><input type="text" name="link_url" placeholder="https://..."></div>
                            <div class="form-group"><label>Link Text</label><input type="text" name="link_text" placeholder="Shop Now"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group"><label>Discount %</label><input type="number" name="discount_percent"></div>
                            <div class="form-group"><label>Display Location</label>
                                <select name="display_location"><option value="homepage">Homepage</option><option value="all">All Pages</option><option value="category">Category</option><option value="product">Product</option></select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group"><label>Start Date</label><input type="date" name="start_date"></div>
                            <div class="form-group"><label>End Date</label><input type="date" name="end_date"></div>
                        </div>
                        <div class="form-group"><label><input type="checkbox" name="is_active" checked> Active</label></div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Promotion</button>
                    </form>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header"><h2>Active Promotions</h2></div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead><tr><th>Title</th><th>Type</th><th>Location</th><th>Dates</th><th>Status</th><th>Actions</th></tr></thead>
                        <tbody>
                            <?php foreach($promotions as $p): ?>
                            <tr>
                                <td><strong><?= sanitize($p['title']) ?></strong></td>
                                <td><?= ucfirst($p['promo_type']) ?></td>
                                <td><?= ucfirst($p['display_location']) ?></td>
                                <td><?= $p['start_date'] ? date('M j', strtotime($p['start_date'])) . ' - ' . date('M j', strtotime($p['end_date'])) : 'Always' ?></td>
                                <td><span class="status-badge <?= $p['is_active'] ? 'status-quoted' : 'status-closed' ?>"><?= $p['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                                <td>
                                    <form method="POST" style="display:inline;"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= $p['id'] ?>"><button class="btn btn-sm btn-outline"><i class="fas fa-toggle-on"></i></button></form>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Delete?')"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $p['id'] ?>"><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
