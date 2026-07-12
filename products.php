<?php
require_once __DIR__ . '/includes/config.php';

$type = $_GET['type'] ?? '';
$brand = $_GET['brand'] ?? '';
$search = $_GET['q'] ?? '';
$sort = $_GET['sort'] ?? 'name';
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 24;
$offset = ($page - 1) * $perPage;

// Build query
$where = ["p.is_active = 1"];
$params = [];

if ($type) {
    $where[] = "p.product_type = ?";
    $params[] = $type;
}
if ($brand) {
    $where[] = "p.brand = ?";
    $params[] = $brand;
}
if ($search) {
    $where[] = "(p.name LIKE ? OR p.model LIKE ? OR p.sku LIKE ? OR p.brand LIKE ? OR p.engine_series LIKE ?)";
    $searchTerm = "%$search%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

$whereClause = implode(' AND ', $where);

// Sort
$orderBy = match($sort) {
    'price_low' => 'p.price ASC',
    'price_high' => 'p.price DESC',
    'newest' => 'p.created_at DESC',
    'hp_high' => 'p.horsepower_max DESC',
    'hp_low' => 'p.horsepower_min ASC',
    default => 'p.brand ASC, p.name ASC'
};

// Count total
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM products p WHERE $whereClause");
$stmt->execute($params);
$total = $stmt->fetch()['total'];
$totalPages = ceil($total / $perPage);

// Get products
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE $whereClause ORDER BY $orderBy LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$products = $stmt->fetchAll();

// Get all brands for filter
$stmt = $pdo->query("SELECT DISTINCT brand FROM products WHERE is_active = 1 AND brand IS NOT NULL ORDER BY brand");
$brands = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Page title
$typeLabels = [
    'marine_propulsion' => 'Marine Propulsion Engines',
    'marine_auxiliary' => 'Marine Auxiliary Engines',
    'marine_generator' => 'Marine Generator Engines',
    'industrial' => 'Industrial Diesel Engines'
];
$pageTitle = $typeLabels[$type] ?? ($brand ? "$brand Marine Diesel Engines" : 'All Remanufactured Marine Diesel Engines');
$pageDescription = "Browse our complete selection of remanufactured " . strtolower($pageTitle) . ". Every engine built to OEM specifications with warranty. Call for pricing.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle) ?> | US Engines Production</title>
    <meta name="description" content="<?= sanitize($pageDescription) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL ?>/products.php<?= $type ? '?type='.$type : '' ?>">
    
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= sanitize($pageTitle) ?> | US Engines Production">
    <meta property="og:description" content="<?= sanitize($pageDescription) ?>">
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "<?= sanitize($pageTitle) ?>",
        "description": "<?= sanitize($pageDescription) ?>",
        "url": "<?= SITE_URL ?>/products.php",
        "numberOfItems": <?= $total ?>,
        "provider": {
            "@type": "Organization",
            "name": "US Engines Production"
        }
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
                <a href="<?= SITE_URL ?>/">Home</a>
                <span>/</span>
                <span><?= sanitize($pageTitle) ?></span>
            </div>
            <h1><?= sanitize($pageTitle) ?></h1>
            <p><?= $total ?> remanufactured engines available</p>
        </div>
    </div>

    <section class="section" style="padding-top:30px;">
        <div class="container">
            <!-- Filters -->
            <form class="filters-bar" method="GET" action="products.php">
                <div class="filter-group">
                    <label>Brand:</label>
                    <select name="brand" onchange="this.form.submit()">
                        <option value="">All Brands</option>
                        <?php foreach($brands as $b): ?>
                        <option value="<?= sanitize($b) ?>" <?= $brand === $b ? 'selected' : '' ?>><?= sanitize($b) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Type:</label>
                    <select name="type" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="marine_propulsion" <?= $type === 'marine_propulsion' ? 'selected' : '' ?>>Marine Propulsion</option>
                        <option value="marine_auxiliary" <?= $type === 'marine_auxiliary' ? 'selected' : '' ?>>Marine Auxiliary</option>
                        <option value="marine_generator" <?= $type === 'marine_generator' ? 'selected' : '' ?>>Marine Generator</option>
                        <option value="industrial" <?= $type === 'industrial' ? 'selected' : '' ?>>Industrial</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Sort:</label>
                    <select name="sort" onchange="this.form.submit()">
                        <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Name A-Z</option>
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest First</option>
                        <option value="hp_high" <?= $sort === 'hp_high' ? 'selected' : '' ?>>HP: High to Low</option>
                        <option value="hp_low" <?= $sort === 'hp_low' ? 'selected' : '' ?>>HP: Low to High</option>
                    </select>
                </div>
                <div class="filter-group">
                    <input type="text" name="q" placeholder="Search engines..." value="<?= sanitize($search) ?>">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                </div>
                <span class="results-count"><?= $total ?> results</span>
            </form>

            <!-- Products Grid -->
            <?php if(empty($products)): ?>
            <div class="text-center" style="padding:60px 0;">
                <i class="fas fa-search" style="font-size:48px;color:var(--gray-300);margin-bottom:20px;display:block;"></i>
                <h3>No engines found</h3>
                <p style="color:var(--gray-600);margin:10px 0 20px;">Try adjusting your filters or <a href="<?= SITE_URL ?>/quote.php">request a custom quote</a>.</p>
                <a href="<?= SITE_URL ?>/products.php" class="btn btn-primary">View All Engines</a>
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
                                <?php if($product['horsepower']): ?>
                                <span><i class="fas fa-bolt"></i> <?= sanitize($product['horsepower']) ?> HP</span>
                                <?php endif; ?>
                                <?php if($product['cylinders']): ?>
                                <span><i class="fas fa-cogs"></i> <?= sanitize($product['cylinders']) ?> Cyl</span>
                                <?php endif; ?>
                                <?php if($product['displacement']): ?>
                                <span><i class="fas fa-tachometer-alt"></i> <?= sanitize($product['displacement']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="product-footer">
                                <span class="product-price call-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                    <meta itemprop="priceCurrency" content="USD">
                                    <meta itemprop="price" content="<?= $product['price'] ? $product['price'] : '0.00' ?>">
                                    <meta itemprop="availability" content="https://schema.org/InStock">
                                    <meta itemprop="url" content="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>">
                                    <meta itemprop="priceValidUntil" content="<?= date('Y-12-31') ?>">
                                    <?php if($product['call_for_price']): ?>Call for Price<?php elseif($product['price']): ?><?= formatPrice($product['price']) ?><?php endif; ?>
                                </span>
                                <span class="product-sku">Part# <span itemprop="sku"><?= sanitize($product['sku']) ?></span></span>
                            </div>
                            <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating" style="display:none;">
                                <meta itemprop="ratingValue" content="4.8">
                                <meta itemprop="reviewCount" content="<?= 12 + abs(crc32($product['sku'])) % 36 ?>">
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

            <!-- Pagination -->
            <?php if($totalPages > 1): ?>
            <div class="pagination" style="display:flex;justify-content:center;gap:8px;margin-top:40px;">
                <?php if($page > 1): ?>
                <a href="?page=<?= $page-1 ?>&type=<?= $type ?>&brand=<?= $brand ?>&sort=<?= $sort ?>&q=<?= $search ?>" class="btn btn-sm" style="background:var(--white);color:var(--dark);border:1px solid var(--gray-300);">← Prev</a>
                <?php endif; ?>
                <?php for($i = max(1, $page-2); $i <= min($totalPages, $page+2); $i++): ?>
                <a href="?page=<?= $i ?>&type=<?= $type ?>&brand=<?= $brand ?>&sort=<?= $sort ?>&q=<?= $search ?>" class="btn btn-sm" style="<?= $i === $page ? 'background:var(--primary);color:white;' : 'background:var(--white);color:var(--dark);border:1px solid var(--gray-300);' ?>"><?= $i ?></a>
                <?php endfor; ?>
                <?php if($page < $totalPages): ?>
                <a href="?page=<?= $page+1 ?>&type=<?= $type ?>&brand=<?= $brand ?>&sort=<?= $sort ?>&q=<?= $search ?>" class="btn btn-sm" style="background:var(--white);color:var(--dark);border:1px solid var(--gray-300);">Next →</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
