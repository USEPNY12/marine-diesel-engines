<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM blog_posts WHERE id = ?")->execute([$_GET['delete']]);
    header('Location: blog.php?msg=deleted');
    exit;
}

$posts = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                <h1 class="page-title" style="margin:0;">Blog Posts</h1>
                <a href="<?= ADMIN_URL ?>/blog-edit.php" class="btn btn-primary"><i class="fas fa-plus"></i> New Post</a>
            </div>
            <div class="admin-card">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead><tr><th>Title</th><th>Status</th><th>Date</th><th>Views</th><th>Actions</th></tr></thead>
                        <tbody>
                            <?php foreach($posts as $p): ?>
                            <tr>
                                <td><strong><?= sanitize($p['title']) ?></strong></td>
                                <td><span class="status-badge status-<?= $p['status']==='published'?'quoted':'new' ?>"><?= ucfirst($p['status']) ?></span></td>
                                <td><?= date('M j, Y', strtotime($p['created_at'])) ?></td>
                                <td><?= $p['views'] ?></td>
                                <td>
                                    <a href="blog-edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
                                    <a href="?delete=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
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
