<?php
require_once __DIR__ . '/includes/config.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) { header('Location: ' . SITE_URL . '/products.php'); exit; }

$stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.slug = ? AND p.is_active = 1");
$stmt->execute([$slug]);
$product = $stmt->fetch();

if (!$product) { header('HTTP/1.0 404 Not Found'); include __DIR__ . '/404.php'; exit; }

// Increment views
$pdo->prepare("UPDATE products SET views = views + 1 WHERE id = ?")->execute([$product['id']]);

// Get product images
$stmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY display_order");
$stmt->execute([$product['id']]);
$images = $stmt->fetchAll();

// Get related products
$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? AND is_active = 1 ORDER BY RAND() LIMIT 4");
$stmt->execute([$product['category_id'], $product['id']]);
$related = $stmt->fetchAll();

$pageTitle = "Remanufactured " . $product['name'] . " Marine Diesel Engine";
$pageDescription = $product['meta_description'] ?: "Buy remanufactured {$product['name']} marine diesel engine. {$product['horsepower']} HP, {$product['cylinders']} cylinder. Built to OEM specs with warranty. Part# {$product['sku']}.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($product['meta_title'] ?: $pageTitle) ?> | US Engines Production</title>
    <meta name="description" content="<?= sanitize($pageDescription) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>">
    
    <meta property="og:type" content="product">
    <meta property="og:title" content="<?= sanitize($pageTitle) ?>">
    <meta property="og:description" content="<?= sanitize($pageDescription) ?>">
    <meta property="og:url" content="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>">
    <?php if($product['image']): ?>
    <meta property="og:image" content="<?= UPLOAD_URL . $product['image'] ?>">
    <?php endif; ?>
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Product",
        "name": "Remanufactured <?= sanitize($product['name']) ?>",
        "description": "<?= sanitize($pageDescription) ?>",
        "sku": "<?= sanitize($product['sku']) ?>",
        "brand": {
            "@type": "Brand",
            "name": "<?= sanitize($product['brand']) ?>"
        },
        "category": "Marine Diesel Engines",
        "itemCondition": "https://schema.org/RefurbishedCondition",
        <?php if($product['image']): ?>
        "image": "<?= UPLOAD_URL . $product['image'] ?>",
        <?php endif; ?>
        "offers": {
            "@type": "Offer",
            "availability": "<?= $product['in_stock'] ? 'https://schema.org/InStock' : 'https://schema.org/PreOrder' ?>",
            "priceCurrency": "USD",
            <?php if(!$product['call_for_price'] && $product['price']): ?>
            "price": "<?= $product['price'] ?>",
            <?php endif; ?>
            "seller": {
                "@type": "Organization",
                "name": "US Engines Production"
            },
            "warranty": {
                "@type": "WarrantyPromise",
                "warrantyScope": "<?= sanitize($product['warranty']) ?>"
            }
        },
        "additionalProperty": [
            {"@type": "PropertyValue", "name": "Horsepower", "value": "<?= sanitize($product['horsepower']) ?>"},
            {"@type": "PropertyValue", "name": "Cylinders", "value": "<?= sanitize($product['cylinders']) ?>"},
            {"@type": "PropertyValue", "name": "Displacement", "value": "<?= sanitize($product['displacement']) ?>"},
            {"@type": "PropertyValue", "name": "Condition", "value": "Remanufactured"},
            {"@type": "PropertyValue", "name": "Application", "value": "<?= sanitize($product['application']) ?>"}
        ]
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

    <div class="page-header" style="padding:30px 0;">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?= SITE_URL ?>/">Home</a><span>/</span>
                <a href="<?= SITE_URL ?>/products.php">Marine Engines</a><span>/</span>
                <?php if($product['category_name']): ?>
                <a href="<?= SITE_URL ?>/category.php?slug=<?= $product['category_slug'] ?>"><?= sanitize($product['category_name']) ?></a><span>/</span>
                <?php endif; ?>
                <span><?= sanitize($product['name']) ?></span>
            </div>
        </div>
    </div>

    <section class="product-detail">
        <div class="container">
            <div class="product-detail-grid">
                <!-- Gallery -->
                <div class="product-gallery">
                    <div class="product-gallery-main">
                        <?php if($product['image']): ?>
                        <img src="<?= UPLOAD_URL . $product['image'] ?>" alt="Remanufactured <?= sanitize($product['name']) ?>" id="mainImage">
                        <?php elseif(!empty($images)): ?>
                        <img src="<?= UPLOAD_URL . $images[0]['image_path'] ?>" alt="Remanufactured <?= sanitize($product['name']) ?>" id="mainImage">
                        <?php else: ?>
                        <div class="no-image" style="height:100%;"><i class="fas fa-cog"></i></div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($images)): ?>
                    <div class="product-gallery-thumbs">
                        <?php if($product['image']): ?>
                        <img src="<?= UPLOAD_URL . $product['image'] ?>" alt="Main" class="active" onclick="changeImage(this)">
                        <?php endif; ?>
                        <?php foreach($images as $img): ?>
                        <img src="<?= UPLOAD_URL . $img['image_path'] ?>" alt="<?= sanitize($img['alt_text']) ?>" onclick="changeImage(this)">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Info -->
                <div class="product-detail-info">
                    <span class="product-detail-brand"><?= sanitize($product['brand']) ?></span>
                    <h1>Remanufactured <?= sanitize($product['name']) ?></h1>
                    
                    <div style="display:flex;gap:15px;align-items:center;margin:15px 0;">
                        <span class="badge badge-condition" style="position:static;">Remanufactured</span>
                        <?php if($product['in_stock']): ?>
                        <span style="color:var(--success);font-weight:600;font-size:14px;"><i class="fas fa-check-circle"></i> In Stock</span>
                        <?php else: ?>
                        <span style="color:var(--warning);font-weight:600;font-size:14px;"><i class="fas fa-clock"></i> Build to Order</span>
                        <?php endif; ?>
                    </div>

                    <div class="product-detail-price">
                        <?php if($product['call_for_price']): ?>
                        <span style="color:var(--secondary);">Call for Price</span>
                        <?php elseif($product['sale_price']): ?>
                        <del style="color:var(--gray-500);font-size:18px;"><?= formatPrice($product['price']) ?></del>
                        <span><?= formatPrice($product['sale_price']) ?></span>
                        <?php elseif($product['price']): ?>
                        <span><?= formatPrice($product['price']) ?></span>
                        <?php endif; ?>
                        <?php if($product['core_charge']): ?>
                        <small style="display:block;font-size:13px;color:var(--gray-600);font-weight:400;">+ <?= formatPrice($product['core_charge']) ?> core charge (refundable)</small>
                        <?php endif; ?>
                    </div>

                    <p style="margin-bottom:20px;color:var(--gray-600);line-height:1.7;"><?= sanitize($product['short_description']) ?></p>

                    <!-- Specs Table -->
                    <table class="specs-table">
                        <tr><td>Part Number</td><td><strong><?= sanitize($product['sku']) ?></strong></td></tr>
                        <tr><td>Brand</td><td><?= sanitize($product['brand']) ?></td></tr>
                        <tr><td>Model</td><td><?= sanitize($product['model']) ?></td></tr>
                        <?php if($product['engine_series']): ?>
                        <tr><td>Series</td><td><?= sanitize($product['engine_series']) ?></td></tr>
                        <?php endif; ?>
                        <tr><td>Condition</td><td>Remanufactured</td></tr>
                        <?php if($product['cylinders']): ?>
                        <tr><td>Cylinders</td><td><?= sanitize($product['cylinders']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['configuration']): ?>
                        <tr><td>Configuration</td><td><?= sanitize($product['configuration']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['displacement']): ?>
                        <tr><td>Displacement</td><td><?= sanitize($product['displacement']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['horsepower']): ?>
                        <tr><td>Horsepower</td><td><?= sanitize($product['horsepower']) ?> HP</td></tr>
                        <?php endif; ?>
                        <?php if($product['torque']): ?>
                        <tr><td>Torque</td><td><?= sanitize($product['torque']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['rpm_range']): ?>
                        <tr><td>RPM Range</td><td><?= sanitize($product['rpm_range']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['weight_lbs']): ?>
                        <tr><td>Dry Weight</td><td><?= number_format($product['weight_lbs']) ?> lbs</td></tr>
                        <?php endif; ?>
                        <?php if($product['aspiration']): ?>
                        <tr><td>Aspiration</td><td><?= sanitize($product['aspiration']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['fuel_system']): ?>
                        <tr><td>Fuel System</td><td><?= sanitize($product['fuel_system']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['cooling_system']): ?>
                        <tr><td>Cooling</td><td><?= sanitize($product['cooling_system']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['emissions_tier']): ?>
                        <tr><td>Emissions</td><td><?= sanitize($product['emissions_tier']) ?></td></tr>
                        <?php endif; ?>
                        <?php if($product['application']): ?>
                        <tr><td>Application</td><td><?= sanitize($product['application']) ?></td></tr>
                        <?php endif; ?>
                        <tr><td>Warranty</td><td><?= sanitize($product['warranty']) ?></td></tr>
                    </table>

                    <!-- CTA Buttons -->
                    <div style="display:flex;gap:12px;margin-top:25px;flex-wrap:wrap;">
                        <a href="<?= SITE_URL ?>/quote.php?engine=<?= urlencode($product['name']) ?>&sku=<?= urlencode($product['sku']) ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-file-invoice"></i> Request Quote
                        </a>
                        <a href="tel:<?= getSetting('site_phone') ?>" class="btn btn-secondary btn-lg">
                            <i class="fas fa-phone"></i> Call Now
                        </a>
                    </div>

                    <div style="margin-top:20px;padding:15px;background:var(--gray-100);border-radius:var(--radius-sm);font-size:13px;color:var(--gray-600);">
                        <i class="fas fa-info-circle" style="color:var(--primary);"></i>
                        <strong>Core Exchange Available:</strong> Save money by returning your old engine core. Contact us for core return details and credit.
                    </div>
                </div>
            </div>

            <!-- Full Description -->
            <?php if($product['description']): ?>
            <div style="margin-top:50px;max-width:900px;">
                <h2 style="font-size:24px;margin-bottom:15px;">About the Remanufactured <?= sanitize($product['name']) ?></h2>
                <div style="color:var(--gray-700);line-height:1.8;"><?= $product['description'] ?></div>
            </div>
            <?php endif; ?>

            <!-- Related Products -->
            <?php if(!empty($related)): ?>
            <div style="margin-top:60px;">
                <h2 style="font-size:24px;margin-bottom:25px;">Related Marine Engines</h2>
                <div class="products-grid">
                    <?php foreach($related as $rel): ?>
                    <article class="product-card">
                        <a href="<?= SITE_URL ?>/product.php?slug=<?= $rel['slug'] ?>">
                            <div class="product-image">
                                <?php if($rel['image']): ?>
                                <img src="<?= UPLOAD_URL . $rel['image'] ?>" alt="Remanufactured <?= sanitize($rel['name']) ?>" loading="lazy">
                                <?php else: ?>
                                <div class="no-image"><i class="fas fa-cog"></i></div>
                                <?php endif; ?>
                                <span class="badge badge-condition">Remanufactured</span>
                            </div>
                            <div class="product-info">
                                <span class="product-brand"><?= sanitize($rel['brand']) ?></span>
                                <h3 class="product-title"><?= sanitize($rel['name']) ?></h3>
                                <div class="product-specs">
                                    <?php if($rel['horsepower']): ?><span><i class="fas fa-bolt"></i> <?= sanitize($rel['horsepower']) ?> HP</span><?php endif; ?>
                                    <?php if($rel['cylinders']): ?><span><i class="fas fa-cogs"></i> <?= sanitize($rel['cylinders']) ?> Cyl</span><?php endif; ?>
                                </div>
                                <div class="product-footer">
                                    <span class="product-price call-price">Call for Price</span>
                                    <span class="product-sku">Part# <?= sanitize($rel['sku']) ?></span>
                                </div>
                            </div>
                        </a>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
    <script>
    function changeImage(thumb) {
        document.getElementById('mainImage').src = thumb.src;
        document.querySelectorAll('.product-gallery-thumbs img').forEach(i => i.classList.remove('active'));
        thumb.classList.add('active');
    }
    </script>
</body>
</html>
