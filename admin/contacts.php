<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

if (isset($_GET['mark_read'])) {
    $pdo->prepare("UPDATE contacts SET status = 'read' WHERE id = ?")->execute([$_GET['mark_read']]);
}

$contacts = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 50")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <h1 class="page-title">Contact Messages</h1>
            <div class="admin-card">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Status</th><th>Actions</th></tr></thead>
                        <tbody>
                            <?php foreach($contacts as $c): ?>
                            <tr style="<?= $c['status']==='new'?'font-weight:600;':'' ?>">
                                <td><?= date('M j, Y', strtotime($c['created_at'])) ?></td>
                                <td><?= sanitize($c['name']) ?></td>
                                <td><a href="mailto:<?= sanitize($c['email']) ?>"><?= sanitize($c['email']) ?></a></td>
                                <td><?= sanitize($c['subject']) ?></td>
                                <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= sanitize($c['message']) ?></td>
                                <td><span class="status-badge status-<?= $c['status'] ?>"><?= ucfirst($c['status']) ?></span></td>
                                <td><a href="?mark_read=<?= $c['id'] ?>" class="btn btn-sm btn-outline">Mark Read</a></td>
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
