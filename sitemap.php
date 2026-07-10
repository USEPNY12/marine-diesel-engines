<?php
require_once __DIR__ . '/includes/config.php';
$categories = $pdo->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name")->fetchAll();
$products = $pdo->query("SELECT slug, name, brand FROM products WHERE is_active = 1 ORDER BY brand, name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap | US Engines Production Marine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?>
    <div class="page-header"><div class="container"><h1>Sitemap</h1></div></div>
    <section class="section">
        <div class="container" style="max-width:900px;">
            <h2>Pages</h2>
            <ul style="margin:10px 0 30px 20px;line-height:2;">
                <li><a href="<?= SITE_URL ?>/">Home</a></li>
                <li><a href="<?= SITE_URL ?>/products.php">All Marine Engines</a></li>
                <li><a href="<?= SITE_URL ?>/quote.php">Request a Quote</a></li>
                <li><a href="<?= SITE_URL ?>/about.php">About Us</a></li>
                <li><a href="<?= SITE_URL ?>/contact.php">Contact</a></li>
                <li><a href="<?= SITE_URL ?>/blog.php">Blog</a></li>
            </ul>
            <h2>Categories</h2>
            <ul style="margin:10px 0 30px 20px;line-height:2;">
                <?php foreach($categories as $c): ?>
                <li><a href="<?= SITE_URL ?>/category.php?slug=<?= $c['slug'] ?>"><?= sanitize($c['name']) ?> Marine Engines</a></li>
                <?php endforeach; ?>
            </ul>
            <h2>All Engines (<?= count($products) ?>)</h2>
            <ul style="margin:10px 0 30px 20px;line-height:2;columns:2;">
                <?php foreach($products as $p): ?>
                <li><a href="<?= SITE_URL ?>/product.php?slug=<?= $p['slug'] ?>"><?= sanitize($p['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <?php include __DIR__ . '/templates/footer.php'; ?>
</body>
</html>
