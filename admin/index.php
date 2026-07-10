<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

// Dashboard stats
$stats = [];
$stats['products'] = $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1")->fetchColumn();
$stats['categories'] = $pdo->query("SELECT COUNT(*) FROM categories WHERE is_active = 1")->fetchColumn();
$stats['quotes_new'] = $pdo->query("SELECT COUNT(*) FROM quotes WHERE status = 'new'")->fetchColumn();
$stats['quotes_total'] = $pdo->query("SELECT COUNT(*) FROM quotes")->fetchColumn();
$stats['contacts'] = $pdo->query("SELECT COUNT(*) FROM contacts WHERE status = 'new'")->fetchColumn();
$stats['blog_posts'] = $pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();

// Recent quotes
$recentQuotes = $pdo->query("SELECT * FROM quotes ORDER BY created_at DESC LIMIT 10")->fetchAll();
// Recent contacts
$recentContacts = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <h1 class="page-title">Dashboard</h1>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background:#0066CC;"><i class="fas fa-cog"></i></div>
                    <div class="stat-info">
                        <span class="stat-number"><?= $stats['products'] ?></span>
                        <span class="stat-label">Total Engines</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#28a745;"><i class="fas fa-folder"></i></div>
                    <div class="stat-info">
                        <span class="stat-number"><?= $stats['categories'] ?></span>
                        <span class="stat-label">Categories</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#FF6B00;"><i class="fas fa-file-invoice"></i></div>
                    <div class="stat-info">
                        <span class="stat-number"><?= $stats['quotes_new'] ?></span>
                        <span class="stat-label">New Quotes</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#6f42c1;"><i class="fas fa-envelope"></i></div>
                    <div class="stat-info">
                        <span class="stat-number"><?= $stats['contacts'] ?></span>
                        <span class="stat-label">New Messages</span>
                    </div>
                </div>
            </div>

            <!-- Recent Quotes -->
            <div class="admin-card">
                <div class="card-header">
                    <h2><i class="fas fa-file-invoice"></i> Recent Quote Requests</h2>
                    <a href="<?= ADMIN_URL ?>/quotes.php" class="btn btn-sm">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Engine</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($recentQuotes)): ?>
                            <tr><td colspan="6" style="text-align:center;padding:30px;color:#666;">No quotes yet</td></tr>
                            <?php else: ?>
                            <?php foreach($recentQuotes as $q): ?>
                            <tr>
                                <td><?= date('M j, Y', strtotime($q['created_at'])) ?></td>
                                <td><?= sanitize($q['first_name'] . ' ' . $q['last_name']) ?></td>
                                <td><?= sanitize($q['email']) ?></td>
                                <td><?= sanitize($q['engine_model']) ?></td>
                                <td><span class="status-badge status-<?= $q['status'] ?>"><?= ucfirst($q['status']) ?></span></td>
                                <td><a href="<?= ADMIN_URL ?>/quote-view.php?id=<?= $q['id'] ?>" class="btn btn-sm">View</a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
