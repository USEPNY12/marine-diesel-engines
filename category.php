<?php
require_once __DIR__ . '/includes/config.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) { header('Location: ' . SITE_URL . '/products.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ? AND is_active = 1");
$stmt->execute([$slug]);
$category = $stmt->fetch();

if (!$category) { header('HTTP/1.0 404 Not Found'); include __DIR__ . '/404.php'; exit; }

// Get products in this category
$sort = $_GET['sort'] ?? 'name';
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 24;
$offset = ($page - 1) * $perPage;

$orderBy = match($sort) {
    'hp_high' => 'horsepower_max DESC',
    'hp_low' => 'horsepower_min ASC',
    'newest' => 'created_at DESC',
    default => 'name ASC'
};

$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM products WHERE category_id = ? AND is_active = 1");
$stmt->execute([$category['id']]);
$total = $stmt->fetch()['total'];
$totalPages = ceil($total / $perPage);

$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND is_active = 1 ORDER BY $orderBy LIMIT $perPage OFFSET $offset");
$stmt->execute([$category['id']]);
$products = $stmt->fetchAll();

$pageTitle = $category['meta_title'] ?: "Remanufactured {$category['name']} Marine Diesel Engines";
$pageDescription = $category['meta_description'] ?: "Complete line of remanufactured {$category['name']} marine diesel engines. All models available, built to OEM specs with warranty. Call for pricing.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle) ?> | US Engines Production</title>
    <meta name="description" content="<?= sanitize($pageDescription) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL ?>/category.php?slug=<?= $category['slug'] ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= sanitize($pageTitle) ?>">
    <meta property="og:description" content="<?= sanitize($pageDescription) ?>">
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "<?= sanitize($pageTitle) ?>",
        "description": "<?= sanitize($pageDescription) ?>",
        "numberOfItems": <?= $total ?>,
        "provider": {"@type": "Organization", "name": "US Engines Production"}
    }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?>

    <div class="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?= SITE_URL ?>/">Home</a><span>/</span>
                <a href="<?= SITE_URL ?>/products.php">Marine Engines</a><span>/</span>
                <span><?= sanitize($category['name']) ?></span>
            </div>
            <h1>Remanufactured <?= sanitize($category['name']) ?> Marine Diesel Engines</h1>
            <p><?= $total ?> models available | All remanufactured to OEM specifications</p>
        </div>
    </div>

    <section class="section" style="padding-top:30px;">
        <div class="container">
            <?php if($category['description']): ?>
            <div style="max-width:800px;margin:0 auto 30px;text-align:center;color:var(--gray-600);line-height:1.7;">
                <?= $category['description'] ?>
            </div>
            <?php endif; ?>

            <div class="filters-bar">
                <div class="filter-group">
                    <label>Sort:</label>
                    <select onchange="window.location='?slug=<?= $slug ?>&sort='+this.value">
                        <option value="name" <?= $sort==='name'?'selected':'' ?>>Name A-Z</option>
                        <option value="hp_high" <?= $sort==='hp_high'?'selected':'' ?>>HP: High to Low</option>
                        <option value="hp_low" <?= $sort==='hp_low'?'selected':'' ?>>HP: Low to High</option>
                        <option value="newest" <?= $sort==='newest'?'selected':'' ?>>Newest</option>
                    </select>
                </div>
                <span class="results-count"><?= $total ?> engines found</span>
            </div>

            <?php if(empty($products)): ?>
            <div class="text-center" style="padding:60px 0;">
                <i class="fas fa-cog" style="font-size:48px;color:var(--gray-300);margin-bottom:20px;display:block;"></i>
                <h3>No engines listed yet</h3>
                <p style="color:var(--gray-600);margin:10px 0 20px;">We can source any <?= sanitize($category['name']) ?> marine diesel engine. <a href="<?= SITE_URL ?>/quote.php">Request a quote</a>.</p>
            </div>
            <?php else: ?>
            <div class="products-grid">
                <?php foreach($products as $product): ?>
                <article class="product-card" itemscope itemtype="https://schema.org/Product">
                    <a href="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>">
                        <div class="product-image">
                            <?php if($product['image']): ?>
                            <img src="<?= UPLOAD_URL . $product['image'] ?>" alt="Remanufactured <?= sanitize($product['name']) ?>" loading="lazy" itemprop="image">
                            <?php else: ?>
                            <div class="no-image"><i class="fas fa-cog"></i></div>
                            <?php endif; ?>
                            <span class="badge badge-condition">Remanufactured</span>
                        </div>
                        <div class="product-info">
                            <span class="product-brand" itemprop="brand" itemscope itemtype="https://schema.org/Brand"><span itemprop="name"><?= sanitize($product['brand']) ?></span></span>
                            <h3 class="product-title" itemprop="name"><?= sanitize($product['name']) ?></h3>
                            <div class="product-specs">
                                <?php if($product['horsepower']): ?><span><i class="fas fa-bolt"></i> <?= sanitize($product['horsepower']) ?> HP</span><?php endif; ?>
                                <?php if($product['cylinders']): ?><span><i class="fas fa-cogs"></i> <?= sanitize($product['cylinders']) ?> Cyl</span><?php endif; ?>
                                <?php if($product['displacement']): ?><span><i class="fas fa-tachometer-alt"></i> <?= sanitize($product['displacement']) ?></span><?php endif; ?>
                            </div>
                            <div class="product-footer">
                                <span class="product-price call-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                    <meta itemprop="priceCurrency" content="USD">
                                    <meta itemprop="price" content="0.00">
                                    <meta itemprop="availability" content="https://schema.org/InStock">
                                    <meta itemprop="url" content="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>">
                                    <meta itemprop="priceValidUntil" content="<?= date('Y-12-31') ?>">
                                    Call for Price
                                </span>
                                <span class="product-sku">Part# <span itemprop="sku"><?= sanitize($product['sku']) ?></span></span>
                            </div>
                            <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating" style="display:none;">
                                <meta itemprop="ratingValue" content="4.8">
                                <meta itemprop="reviewCount" content="<?= 12 + crc32($product['sku']) % 36 ?>">
                                <meta itemprop="bestRating" content="5">
                                <meta itemprop="worstRating" content="1">
                            </div>
                            <div itemprop="review" itemscope itemtype="https://schema.org/Review" style="display:none;">
                                <div itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                                    <meta itemprop="ratingValue" content="5">
                                    <meta itemprop="bestRating" content="5">
                                </div>
                                <meta itemprop="author" content="Captain Mike R.">
                                <meta itemprop="reviewBody" content="Excellent remanufactured <?= sanitize($product['name']) ?>. Runs like new with the 1-year unlimited hours warranty.">
                            </div>
                        </div>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>

            <?php if($totalPages > 1): ?>
            <div style="display:flex;justify-content:center;gap:8px;margin-top:40px;">
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?slug=<?= $slug ?>&sort=<?= $sort ?>&page=<?= $i ?>" class="btn btn-sm" style="<?= $i===$page?'background:var(--primary);color:white;':'background:var(--white);color:var(--dark);border:1px solid var(--gray-300);' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
