<?php
require_once __DIR__ . '/includes/config.php';
$q = trim($_GET['q'] ?? '');
$results = [];
if ($q) {
    $s = "%$q%";
    $stmt = $pdo->prepare("SELECT * FROM products WHERE is_active = 1 AND (name LIKE ? OR brand LIKE ? OR model LIKE ? OR sku LIKE ? OR engine_series LIKE ? OR description LIKE ?) ORDER BY brand, name LIMIT 50");
    $stmt->execute([$s,$s,$s,$s,$s,$s]);
    $results = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search <?= $q ? '- '.sanitize($q) : '' ?> | US Engines Production Marine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?>
    <div class="page-header">
        <div class="container"><h1>Search Marine Engines</h1></div>
    </div>
    <section class="section" style="padding-top:30px;">
        <div class="container">
            <form method="GET" style="max-width:600px;margin:0 auto 30px;display:flex;gap:10px;">
                <input type="text" name="q" value="<?= sanitize($q) ?>" placeholder="Search by engine name, brand, model, part number..." style="flex:1;padding:14px 18px;border:1px solid #ddd;border-radius:8px;font-size:16px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </form>
            <?php if($q): ?>
            <p style="text-align:center;margin-bottom:20px;color:var(--gray-600);"><?= count($results) ?> results for "<?= sanitize($q) ?>"</p>
            <?php if(!empty($results)): ?>
            <div class="products-grid">
                <?php foreach($results as $product): ?>
                <article class="product-card">
                    <a href="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>">
                        <div class="product-image">
                            <?php if($product['image']): ?><img src="<?= UPLOAD_URL . $product['image'] ?>" alt="<?= sanitize($product['name']) ?>" loading="lazy"><?php else: ?><div class="no-image"><i class="fas fa-cog"></i></div><?php endif; ?>
                            <span class="badge badge-condition">Remanufactured</span>
                        </div>
                        <div class="product-info">
                            <span class="product-brand"><?= sanitize($product['brand']) ?></span>
                            <h3 class="product-title"><?= sanitize($product['name']) ?></h3>
                            <div class="product-specs">
                                <?php if($product['horsepower']): ?><span><i class="fas fa-bolt"></i> <?= sanitize($product['horsepower']) ?> HP</span><?php endif; ?>
                                <?php if($product['cylinders']): ?><span><i class="fas fa-cogs"></i> <?= sanitize($product['cylinders']) ?> Cyl</span><?php endif; ?>
                            </div>
                            <div class="product-footer">
                                <span class="product-price call-price">Call for Price</span>
                                <span class="product-sku">Part# <?= sanitize($product['sku']) ?></span>
                            </div>
                        </div>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center" style="padding:40px;">
                <p>No engines found. <a href="<?= SITE_URL ?>/quote.php">Request a custom quote</a> for any engine.</p>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
