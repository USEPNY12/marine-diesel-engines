<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: quotes.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = $_POST['status'];
    $notes = trim($_POST['notes']);
    $pdo->prepare("UPDATE quotes SET status = ?, notes = ? WHERE id = ?")->execute([$newStatus, $notes, $id]);
    header("Location: quote-view.php?id=$id&saved=1");
    exit;
}

$stmt = $pdo->prepare("SELECT q.*, p.name as product_name FROM quotes q LEFT JOIN products p ON q.product_id = p.id WHERE q.id = ?");
$stmt->execute([$id]);
$quote = $stmt->fetch();
if (!$quote) { header('Location: quotes.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote #<?= $id ?> | Marine Admin</title>
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
                <h1 class="page-title" style="margin:0;">Quote #<?= $id ?></h1>
                <a href="<?= ADMIN_URL ?>/quotes.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
            <?php if(isset($_GET['saved'])): ?><div class="alert alert-success">Quote updated successfully.</div><?php endif; ?>

            <div style="display:grid;grid-template-columns:2fr 1fr;gap:25px;">
                <div class="admin-card">
                    <div class="card-header"><h2>Customer Information</h2></div>
                    <div class="card-body">
                        <table style="width:100%;">
                            <tr><td style="padding:8px 0;font-weight:600;width:150px;">Name:</td><td><?= sanitize($quote['first_name'].' '.$quote['last_name']) ?></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Email:</td><td><a href="mailto:<?= sanitize($quote['email']) ?>"><?= sanitize($quote['email']) ?></a></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Phone:</td><td><a href="tel:<?= sanitize($quote['phone']) ?>"><?= sanitize($quote['phone']) ?></a></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Company:</td><td><?= sanitize($quote['company']) ?></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Vessel Name:</td><td><?= sanitize($quote['vessel_name']) ?></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Vessel Type:</td><td><?= sanitize($quote['vessel_type']) ?></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">VIN/Hull ID:</td><td><code><?= sanitize($quote['vin']) ?></code></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Engine Model:</td><td><strong><?= sanitize($quote['engine_model']) ?></strong></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Engine Type:</td><td><?= sanitize($quote['engine_type']) ?></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Message:</td><td><?= nl2br(sanitize($quote['message'])) ?></td></tr>
                            <tr><td style="padding:8px 0;font-weight:600;">Submitted:</td><td><?= date('M j, Y g:i A', strtotime($quote['created_at'])) ?></td></tr>
                        </table>
                    </div>
                </div>
                <div>
                    <form method="POST" class="admin-card">
                        <div class="card-header"><h2>Update Status</h2></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status">
                                    <option value="new" <?= $quote['status']==='new'?'selected':'' ?>>New</option>
                                    <option value="contacted" <?= $quote['status']==='contacted'?'selected':'' ?>>Contacted</option>
                                    <option value="quoted" <?= $quote['status']==='quoted'?'selected':'' ?>>Quoted</option>
                                    <option value="converted" <?= $quote['status']==='converted'?'selected':'' ?>>Converted</option>
                                    <option value="closed" <?= $quote['status']==='closed'?'selected':'' ?>>Closed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Internal Notes</label>
                                <textarea name="notes" rows="5"><?= sanitize($quote['notes']) ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fas fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
