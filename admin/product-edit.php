<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$id = $_GET['id'] ?? null;
$product = null;
$images = [];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    $imgStmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY display_order");
    $imgStmt->execute([$id]);
    $images = $imgStmt->fetchAll();
}

$categories = $pdo->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name")->fetchAll();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => trim($_POST['name']),
        'sku' => trim($_POST['sku']),
        'slug' => slugify($_POST['name']),
        'brand' => trim($_POST['brand']),
        'model' => trim($_POST['model']),
        'engine_series' => trim($_POST['engine_series']),
        'category_id' => $_POST['category_id'] ?: null,
        'product_type' => $_POST['product_type'],
        'short_description' => trim($_POST['short_description']),
        'description' => $_POST['description'],
        'cylinders' => trim($_POST['cylinders']),
        'configuration' => trim($_POST['configuration']),
        'displacement' => trim($_POST['displacement']),
        'horsepower' => trim($_POST['horsepower']),
        'horsepower_min' => intval($_POST['horsepower_min']) ?: null,
        'horsepower_max' => intval($_POST['horsepower_max']) ?: null,
        'torque' => trim($_POST['torque']),
        'rpm_range' => trim($_POST['rpm_range']),
        'weight_lbs' => intval($_POST['weight_lbs']) ?: null,
        'aspiration' => trim($_POST['aspiration']),
        'fuel_system' => trim($_POST['fuel_system']),
        'cooling_system' => trim($_POST['cooling_system']),
        'emissions_tier' => trim($_POST['emissions_tier']),
        'application' => trim($_POST['application']),
        'condition_type' => $_POST['condition_type'],
        'warranty' => trim($_POST['warranty']),
        'price' => floatval($_POST['price']) ?: null,
        'sale_price' => floatval($_POST['sale_price']) ?: null,
        'call_for_price' => isset($_POST['call_for_price']) ? 1 : 0,
        'core_charge' => floatval($_POST['core_charge']) ?: null,
        'in_stock' => isset($_POST['in_stock']) ? 1 : 0,
        'featured' => isset($_POST['featured']) ? 1 : 0,
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'meta_title' => trim($_POST['meta_title']),
        'meta_description' => trim($_POST['meta_description']),
    ];

    // Handle image upload
    $imagePath = $product ? $product['image'] : '';
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../assets/uploads/products/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $filename = 'engine_' . time() . '_' . rand(1000,9999) . '.' . $ext;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
            $imagePath = 'products/' . $filename;
        }
    }
    $data['image'] = $imagePath;

    try {
        if ($id) {
            $fields = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
            $stmt = $pdo->prepare("UPDATE products SET $fields WHERE id = ?");
            $stmt->execute([...array_values($data), $id]);
        } else {
            $fields = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $stmt = $pdo->prepare("INSERT INTO products ($fields) VALUES ($placeholders)");
            $stmt->execute(array_values($data));
            $id = $pdo->lastInsertId();
        }

        // Handle additional images
        if (!empty($_FILES['additional_images']['name'][0])) {
            $uploadDir = __DIR__ . '/../assets/uploads/products/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            foreach ($_FILES['additional_images']['name'] as $key => $name) {
                if ($_FILES['additional_images']['error'][$key] === 0) {
                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    $filename = 'engine_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                    if (move_uploaded_file($_FILES['additional_images']['tmp_name'][$key], $uploadDir . $filename)) {
                        $pdo->prepare("INSERT INTO product_images (product_id, image_path, display_order) VALUES (?, ?, ?)")
                            ->execute([$id, 'products/' . $filename, $key]);
                    }
                }
            }
        }

        $success = 'Product saved successfully!';
        header('Location: ' . ADMIN_URL . '/products.php?msg=saved');
        exit;
    } catch (Exception $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Edit' : 'Add' ?> Product | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                <h1 class="page-title" style="margin:0;"><?= $id ? 'Edit Engine' : 'Add New Engine' ?></h1>
                <a href="<?= ADMIN_URL ?>/products.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
            </div>

            <?php if($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div style="display:grid;grid-template-columns:2fr 1fr;gap:25px;">
                    <!-- Main Content -->
                    <div>
                        <div class="admin-card">
                            <div class="card-header"><h2>Engine Information</h2></div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Engine Name *</label>
                                        <input type="text" name="name" required value="<?= sanitize($product['name'] ?? '') ?>" placeholder="e.g., Cummins QSB6.7">
                                    </div>
                                    <div class="form-group">
                                        <label>Part Number / SKU *</label>
                                        <input type="text" name="sku" required value="<?= sanitize($product['sku'] ?? '') ?>" placeholder="e.g., CUM-QSB67-M">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <input type="text" name="brand" value="<?= sanitize($product['brand'] ?? '') ?>" placeholder="e.g., Cummins">
                                    </div>
                                    <div class="form-group">
                                        <label>Model</label>
                                        <input type="text" name="model" value="<?= sanitize($product['model'] ?? '') ?>" placeholder="e.g., QSB6.7">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Engine Series</label>
                                        <input type="text" name="engine_series" value="<?= sanitize($product['engine_series'] ?? '') ?>" placeholder="e.g., QSB Series">
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id">
                                            <option value="">Select category...</option>
                                            <?php foreach($categories as $c): ?>
                                            <option value="<?= $c['id'] ?>" <?= ($product['category_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= sanitize($c['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Short Description</label>
                                    <textarea name="short_description" rows="3" placeholder="Brief description for listings..."><?= sanitize($product['short_description'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Full Description</label>
                                    <div id="editor" style="min-height:200px;"><?= $product['description'] ?? '' ?></div>
                                    <input type="hidden" name="description" id="descriptionField">
                                </div>
                            </div>
                        </div>

                        <div class="admin-card">
                            <div class="card-header"><h2>Technical Specifications</h2></div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Cylinders</label>
                                        <input type="text" name="cylinders" value="<?= sanitize($product['cylinders'] ?? '') ?>" placeholder="e.g., 6">
                                    </div>
                                    <div class="form-group">
                                        <label>Configuration</label>
                                        <input type="text" name="configuration" value="<?= sanitize($product['configuration'] ?? '') ?>" placeholder="e.g., Inline 6, V8">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Displacement</label>
                                        <input type="text" name="displacement" value="<?= sanitize($product['displacement'] ?? '') ?>" placeholder="e.g., 6.7L">
                                    </div>
                                    <div class="form-group">
                                        <label>Horsepower (Display)</label>
                                        <input type="text" name="horsepower" value="<?= sanitize($product['horsepower'] ?? '') ?>" placeholder="e.g., 380 or 247-542">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>HP Min (for filtering)</label>
                                        <input type="number" name="horsepower_min" value="<?= $product['horsepower_min'] ?? '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>HP Max (for filtering)</label>
                                        <input type="number" name="horsepower_max" value="<?= $product['horsepower_max'] ?? '' ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Torque</label>
                                        <input type="text" name="torque" value="<?= sanitize($product['torque'] ?? '') ?>" placeholder="e.g., 860 lb-ft">
                                    </div>
                                    <div class="form-group">
                                        <label>RPM Range</label>
                                        <input type="text" name="rpm_range" value="<?= sanitize($product['rpm_range'] ?? '') ?>" placeholder="e.g., 1800-2600">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Weight (lbs)</label>
                                        <input type="number" name="weight_lbs" value="<?= $product['weight_lbs'] ?? '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Aspiration</label>
                                        <input type="text" name="aspiration" value="<?= sanitize($product['aspiration'] ?? '') ?>" placeholder="e.g., Turbocharged, Naturally Aspirated">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Fuel System</label>
                                        <input type="text" name="fuel_system" value="<?= sanitize($product['fuel_system'] ?? '') ?>" placeholder="e.g., Common Rail, Mechanical Injection">
                                    </div>
                                    <div class="form-group">
                                        <label>Cooling System</label>
                                        <input type="text" name="cooling_system" value="<?= sanitize($product['cooling_system'] ?? '') ?>" placeholder="e.g., Heat Exchanger, Keel Cooled">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Emissions Tier</label>
                                        <input type="text" name="emissions_tier" value="<?= sanitize($product['emissions_tier'] ?? '') ?>" placeholder="e.g., EPA Tier 3, IMO II">
                                    </div>
                                    <div class="form-group">
                                        <label>Application</label>
                                        <input type="text" name="application" value="<?= sanitize($product['application'] ?? '') ?>" placeholder="e.g., Sport Fishing, Commercial, Yacht">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div>
                        <div class="admin-card">
                            <div class="card-header"><h2>Status & Pricing</h2></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Product Type</label>
                                    <select name="product_type">
                                        <option value="marine_propulsion" <?= ($product['product_type'] ?? '') === 'marine_propulsion' ? 'selected' : '' ?>>Marine Propulsion</option>
                                        <option value="marine_auxiliary" <?= ($product['product_type'] ?? '') === 'marine_auxiliary' ? 'selected' : '' ?>>Marine Auxiliary</option>
                                        <option value="marine_generator" <?= ($product['product_type'] ?? '') === 'marine_generator' ? 'selected' : '' ?>>Marine Generator</option>
                                        <option value="industrial" <?= ($product['product_type'] ?? '') === 'industrial' ? 'selected' : '' ?>>Industrial</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Condition</label>
                                    <select name="condition_type">
                                        <option value="remanufactured" <?= ($product['condition_type'] ?? 'remanufactured') === 'remanufactured' ? 'selected' : '' ?>>Remanufactured</option>
                                        <option value="rebuilt" <?= ($product['condition_type'] ?? '') === 'rebuilt' ? 'selected' : '' ?>>Rebuilt</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Price ($)</label>
                                    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Sale Price ($)</label>
                                    <input type="number" step="0.01" name="sale_price" value="<?= $product['sale_price'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Core Charge ($)</label>
                                    <input type="number" step="0.01" name="core_charge" value="<?= $product['core_charge'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Warranty</label>
                                    <input type="text" name="warranty" value="<?= sanitize($product['warranty'] ?? '1-Year Unlimited Hours') ?>">
                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="call_for_price" <?= ($product['call_for_price'] ?? 1) ? 'checked' : '' ?>> Call for Price</label>
                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="in_stock" <?= ($product['in_stock'] ?? 1) ? 'checked' : '' ?>> In Stock</label>
                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="featured" <?= ($product['featured'] ?? 0) ? 'checked' : '' ?>> Featured</label>
                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="is_active" <?= ($product['is_active'] ?? 1) ? 'checked' : '' ?>> Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="admin-card">
                            <div class="card-header"><h2>Main Image</h2></div>
                            <div class="card-body">
                                <?php if($product && $product['image']): ?>
                                <img src="<?= UPLOAD_URL . $product['image'] ?>" class="image-preview" style="display:block;margin-bottom:10px;">
                                <?php endif; ?>
                                <div class="form-group">
                                    <input type="file" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="admin-card">
                            <div class="card-header"><h2>Additional Images</h2></div>
                            <div class="card-body">
                                <?php foreach($images as $img): ?>
                                <img src="<?= UPLOAD_URL . $img['image_path'] ?>" style="width:60px;height:45px;object-fit:cover;border-radius:4px;margin:3px;">
                                <?php endforeach; ?>
                                <div class="form-group" style="margin-top:10px;">
                                    <input type="file" name="additional_images[]" accept="image/*" multiple>
                                    <small style="color:var(--admin-muted);">Select multiple images</small>
                                </div>
                            </div>
                        </div>

                        <div class="admin-card">
                            <div class="card-header"><h2>SEO</h2></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" value="<?= sanitize($product['meta_title'] ?? '') ?>" placeholder="SEO title (auto-generated if empty)">
                                </div>
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" rows="3" placeholder="SEO description (auto-generated if empty)"><?= sanitize($product['meta_description'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;padding:14px;font-size:16px;">
                            <i class="fas fa-save"></i> <?= $id ? 'Update Engine' : 'Add Engine' ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: { toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link', 'image'],
            ['clean']
        ]}
    });
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('descriptionField').value = quill.root.innerHTML;
    });
    </script>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
