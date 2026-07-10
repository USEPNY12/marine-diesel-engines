<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$status = $_GET['status'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$where = "1=1";
$params = [];
if ($status) { $where .= " AND status = ?"; $params[] = $status; }

$total = $pdo->prepare("SELECT COUNT(*) FROM quotes WHERE $where");
$total->execute($params);
$totalCount = $total->fetchColumn();

$stmt = $pdo->prepare("SELECT q.*, p.name as product_name FROM quotes q LEFT JOIN products p ON q.product_id = p.id WHERE $where ORDER BY q.created_at DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$quotes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotes & Leads | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <h1 class="page-title">Quotes & Leads (<?= $totalCount ?>)</h1>
            
            <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
                <a href="?status=" class="btn btn-sm <?= !$status?'btn-primary':'btn-outline' ?>">All</a>
                <a href="?status=new" class="btn btn-sm <?= $status==='new'?'btn-primary':'btn-outline' ?>">New</a>
                <a href="?status=contacted" class="btn btn-sm <?= $status==='contacted'?'btn-primary':'btn-outline' ?>">Contacted</a>
                <a href="?status=quoted" class="btn btn-sm <?= $status==='quoted'?'btn-primary':'btn-outline' ?>">Quoted</a>
                <a href="?status=converted" class="btn btn-sm <?= $status==='converted'?'btn-primary':'btn-outline' ?>">Converted</a>
            </div>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr><th>Date</th><th>Name</th><th>Email</th><th>Phone</th><th>Engine</th><th>VIN</th><th>Status</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($quotes as $q): ?>
                            <tr>
                                <td><?= date('M j, Y', strtotime($q['created_at'])) ?></td>
                                <td><strong><?= sanitize($q['first_name'].' '.$q['last_name']) ?></strong></td>
                                <td><a href="mailto:<?= sanitize($q['email']) ?>"><?= sanitize($q['email']) ?></a></td>
                                <td><?= sanitize($q['phone']) ?></td>
                                <td><?= sanitize($q['engine_model']) ?></td>
                                <td><code><?= sanitize($q['vin']) ?></code></td>
                                <td><span class="status-badge status-<?= $q['status'] ?>"><?= ucfirst($q['status']) ?></span></td>
                                <td><a href="<?= ADMIN_URL ?>/quote-view.php?id=<?= $q['id'] ?>" class="btn btn-sm btn-outline">View</a></td>
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
