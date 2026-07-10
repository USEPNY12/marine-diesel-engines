<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'setting_') === 0) {
            $settingKey = substr($key, 8);
            $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?")->execute([trim($value), $settingKey]);
        }
    }
    // Handle logo upload
    if (!empty($_FILES['logo']['name'])) {
        $uploadDir = __DIR__ . '/../assets/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = 'logo.' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $filename)) {
            $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'logo'")->execute([$filename]);
        }
    }
    $success = 'Settings saved!';
}

$settings = $pdo->query("SELECT * FROM site_settings ORDER BY setting_group, id")->fetchAll();
$grouped = [];
foreach ($settings as $s) { $grouped[$s['setting_group']][] = $s; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <h1 class="page-title">Site Settings</h1>
            <?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <?php foreach($grouped as $group => $items): ?>
                <div class="admin-card">
                    <div class="card-header"><h2><?= ucfirst($group) ?> Settings</h2></div>
                    <div class="card-body">
                        <?php foreach($items as $item): ?>
                        <div class="form-group">
                            <label><?= ucwords(str_replace('_', ' ', $item['setting_key'])) ?></label>
                            <?php if($item['setting_type'] === 'textarea'): ?>
                            <textarea name="setting_<?= $item['setting_key'] ?>" rows="3"><?= sanitize($item['setting_value']) ?></textarea>
                            <?php elseif($item['setting_type'] === 'image'): ?>
                            <?php if($item['setting_value']): ?><img src="<?= UPLOAD_URL . $item['setting_value'] ?>" style="max-height:50px;margin-bottom:8px;display:block;"><?php endif; ?>
                            <input type="file" name="<?= $item['setting_key'] ?>" accept="image/*">
                            <?php else: ?>
                            <input type="text" name="setting_<?= $item['setting_key'] ?>" value="<?= sanitize($item['setting_value']) ?>">
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save Settings</button>
            </form>
        </div>
    </div>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
