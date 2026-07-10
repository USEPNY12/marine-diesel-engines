<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

// Handle delete
if (isset($_GET['delete'])) {
    $pdo->prepare("UPDATE products SET is_active = 0 WHERE id = ?")->execute([$_GET['delete']]);
    header('Location: ' . ADMIN_URL . '/products.php?msg=deleted');
    exit;
}

$search = $_GET['q'] ?? '';
$catFilter = $_GET['cat'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 25;
$offset = ($page - 1) * $perPage;

$where = ["1=1"];
$params = [];
if ($search) {
    $where[] = "(name LIKE ? OR sku LIKE ? OR brand LIKE ? OR model LIKE ?)";
    $s = "%$search%";
    $params = array_merge($params, [$s,$s,$s,$s]);
}
if ($catFilter) {
    $where[] = "category_id = ?";
    $params[] = $catFilter;
}
$whereStr = implode(' AND ', $where);

$total = $pdo->prepare("SELECT COUNT(*) FROM products WHERE $whereStr");
$total->execute($params);
$totalCount = $total->fetchColumn();
$totalPages = ceil($totalCount / $perPage);

$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE $whereStr ORDER BY p.brand, p.name LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$products = $stmt->fetchAll();

$categories = $pdo->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;flex-wrap:wrap;gap:15px;">
                <h1 class="page-title" style="margin:0;">Products (<?= $totalCount ?>)</h1>
                <a href="<?= ADMIN_URL ?>/product-edit.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Engine</a>
            </div>

            <?php if(isset($_GET['msg'])): ?>
            <div class="alert alert-success"><i class="fas fa-check"></i> Product <?= $_GET['msg'] === 'deleted' ? 'deleted' : 'saved' ?> successfully.</div>
            <?php endif; ?>

            <!-- Filters -->
            <div class="admin-card">
                <div class="card-body" style="padding:15px 20px;">
                    <form method="GET" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                        <input type="text" name="q" value="<?= sanitize($search) ?>" placeholder="Search engines..." style="padding:8px 14px;border:1px solid var(--admin-border);border-radius:6px;font-size:14px;min-width:200px;">
                        <select name="cat" style="padding:8px 14px;border:1px solid var(--admin-border);border-radius:6px;font-size:14px;">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $catFilter == $c['id'] ? 'selected' : '' ?>><?= sanitize($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Filter</button>
                        <a href="<?= ADMIN_URL ?>/products.php" class="btn btn-sm btn-outline">Clear</a>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="admin-card">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>SKU/Part#</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>HP</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $p): ?>
                            <tr>
                                <td>
                                    <?php if($p['image']): ?>
                                    <img src="<?= UPLOAD_URL . $p['image'] ?>" style="width:50px;height:40px;object-fit:cover;border-radius:4px;">
                                    <?php else: ?>
                                    <div style="width:50px;height:40px;background:#f1f5f9;border-radius:4px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image" style="color:#ccc;"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td><code style="font-size:12px;"><?= sanitize($p['sku']) ?></code></td>
                                <td><strong><?= sanitize($p['name']) ?></strong></td>
                                <td><?= sanitize($p['brand']) ?></td>
                                <td><?= sanitize($p['horsepower']) ?></td>
                                <td><?= sanitize($p['category_name']) ?></td>
                                <td>
                                    <?php if($p['is_active']): ?>
                                    <span class="status-badge status-quoted">Active</span>
                                    <?php else: ?>
                                    <span class="status-badge status-closed">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= ADMIN_URL ?>/product-edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
                                    <a href="<?= ADMIN_URL ?>/products.php?delete=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($totalPages > 1): ?>
                <div style="padding:15px 20px;display:flex;justify-content:center;gap:5px;">
                    <?php for($i=1;$i<=$totalPages;$i++): ?>
                    <a href="?page=<?= $i ?>&q=<?= $search ?>&cat=<?= $catFilter ?>" class="btn btn-sm <?= $i===$page?'btn-primary':'btn-outline' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
