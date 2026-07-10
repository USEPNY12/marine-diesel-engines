<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);
        $slug = slugify($name);
        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../assets/uploads/categories/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $filename = $slug . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                $imagePath = 'categories/' . $filename;
            }
        }
        $pdo->prepare("INSERT INTO categories (name, slug, description, image) VALUES (?, ?, ?, ?)")->execute([$name, $slug, $desc, $imagePath]);
        $success = 'Category added!';
    } elseif ($action === 'edit') {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);
        $pdo->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?")->execute([$name, $desc, $id]);
        $success = 'Category updated!';
    } elseif ($action === 'delete') {
        $pdo->prepare("UPDATE categories SET is_active = 0 WHERE id = ?")->execute([$_POST['id']]);
        $success = 'Category deleted!';
    }
}

$categories = $pdo->query("SELECT c.*, COUNT(p.id) as product_count FROM categories c LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1 WHERE c.is_active = 1 GROUP BY c.id ORDER BY c.display_order, c.name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <h1 class="page-title">Categories (Manufacturers)</h1>
            <?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:25px;">
                <div class="admin-card">
                    <div class="card-header"><h2>Add Category</h2></div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" required placeholder="e.g., Cummins">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="3" placeholder="Brief description..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Logo/Image</label>
                                <input type="file" name="image" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</button>
                        </form>
                    </div>
                </div>
                <div class="admin-card">
                    <div class="card-header"><h2>Existing Categories</h2></div>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead><tr><th>Name</th><th>Products</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach($categories as $c): ?>
                                <tr>
                                    <td><strong><?= sanitize($c['name']) ?></strong></td>
                                    <td><?= $c['product_count'] ?></td>
                                    <td>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
