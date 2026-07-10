<?php
require_once __DIR__ . '/includes/config.php';

// Get featured products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.is_active = 1 AND p.featured = 1 ORDER BY p.created_at DESC LIMIT 12");
$featured = $stmt->fetchAll();

// Get all categories with product count
$stmt = $pdo->query("SELECT c.*, COUNT(p.id) as product_count FROM categories c LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1 WHERE c.is_active = 1 AND c.parent_id IS NULL GROUP BY c.id ORDER BY c.display_order, c.name");
$categories = $stmt->fetchAll();

// Get promotions
$promotions = getActivePromotions('homepage');

// Get total product count
$stmt = $pdo->query("SELECT COUNT(*) as total FROM products WHERE is_active = 1");
$totalProducts = $stmt->fetch()['total'];

$pageTitle = getSetting('meta_title') ?: 'US Engines Production | Remanufactured Marine Diesel Engines';
$pageDescription = getSetting('meta_description') ?: 'Leading supplier of remanufactured marine diesel engines. Cummins, Caterpillar, Detroit Diesel, Volvo Penta, Yanmar, MAN, MTU and more.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle) ?></title>
    <meta name="description" content="<?= sanitize($pageDescription) ?>">
    <meta name="keywords" content="remanufactured marine diesel engines, marine engine rebuild, Cummins marine, Caterpillar marine, Detroit Diesel marine, Volvo Penta, Yanmar marine, MAN marine, MTU marine, marine diesel remanufactured">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL ?>/">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= sanitize($pageTitle) ?>">
    <meta property="og:description" content="<?= sanitize($pageDescription) ?>">
    <meta property="og:url" content="<?= SITE_URL ?>/">
    <meta property="og:site_name" content="US Engines Production - Marine Division">
    <meta property="og:image" content="<?= SITE_URL ?>/assets/images/og-image.jpg">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= sanitize($pageTitle) ?>">
    <meta name="twitter:description" content="<?= sanitize($pageDescription) ?>">
    
    <!-- Geo Tags for Local SEO -->
    <meta name="geo.region" content="US">
    <meta name="geo.placename" content="United States">
    
    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "US Engines Production",
        "description": "Premium remanufactured marine diesel engines supplier",
        "url": "<?= SITE_URL ?>",
        "logo": "<?= SITE_URL ?>/assets/images/logo.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?= getSetting('site_phone') ?>",
            "contactType": "sales",
            "availableLanguage": "English"
        },
        "sameAs": [],
        "offers": {
            "@type": "AggregateOffer",
            "itemCondition": "https://schema.org/RefurbishedCondition",
            "offerCount": "<?= $totalProducts ?>",
            "priceCurrency": "USD"
        }
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "US Engines Production - Marine Division",
        "url": "<?= SITE_URL ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?= SITE_URL ?>/search.php?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/assets/images/favicon.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <span><i class="fas fa-phone"></i> <?= getSetting('site_phone') ?: '(888) 555-0199' ?></span>
                    <span><i class="fas fa-envelope"></i> <?= getSetting('site_email') ?: 'info@usengineproduction.com' ?></span>
                </div>
                <div class="top-bar-right">
                    <span><i class="fas fa-shipping-fast"></i> Nationwide Shipping</span>
                    <span><i class="fas fa-shield-alt"></i> Warranty on All Engines</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <a href="<?= SITE_URL ?>/" class="logo">
                    <img src="<?= SITE_URL ?>/assets/images/logo.png" alt="US Engines Production" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                    <span class="logo-text" style="display:none;">US Engines Production</span>
                </a>
                <nav class="main-nav" id="mainNav">
                    <a href="<?= SITE_URL ?>/" class="active">Home</a>
                    <div class="nav-dropdown">
                        <a href="<?= SITE_URL ?>/products.php">Marine Engines <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown-content">
                            <?php foreach(array_slice($categories, 0, 12) as $cat): ?>
                            <a href="<?= SITE_URL ?>/category.php?slug=<?= $cat['slug'] ?>"><?= sanitize($cat['name']) ?></a>
                            <?php endforeach; ?>
                            <a href="<?= SITE_URL ?>/products.php" class="view-all">View All Brands →</a>
                        </div>
                    </div>
                    <a href="<?= SITE_URL ?>/about.php">About Us</a>
                    <a href="<?= SITE_URL ?>/quote.php">Get a Quote</a>
                    <a href="<?= SITE_URL ?>/blog.php">Blog</a>
                    <a href="<?= SITE_URL ?>/contact.php">Contact</a>
                </nav>
                <div class="header-actions">
                    <a href="<?= SITE_URL ?>/search.php" class="header-search"><i class="fas fa-search"></i></a>
                    <a href="<?= SITE_URL ?>/quote.php" class="btn btn-primary btn-sm">Request Quote</a>
                    <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Premium Remanufactured<br>Marine Diesel Engines</h1>
                <p class="hero-subtitle">The industry's most complete selection of remanufactured marine diesel engines. From Cummins to Caterpillar, Detroit Diesel to Volvo Penta — every major brand, every model, built to exceed OEM specifications.</p>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number"><?= $totalProducts ?>+</span>
                        <span class="stat-label">Engine Models</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Brands</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Remanufactured</span>
                    </div>
                </div>
                <div class="hero-actions">
                    <a href="<?= SITE_URL ?>/products.php" class="btn btn-primary btn-lg">Browse All Engines</a>
                    <a href="<?= SITE_URL ?>/quote.php" class="btn btn-outline btn-lg">Get a Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Promotions Banner -->
    <?php if (!empty($promotions)): ?>
    <?php foreach($promotions as $promo): ?>
    <section class="promo-banner">
        <div class="container">
            <div class="promo-content">
                <div class="promo-text">
                    <strong><?= sanitize($promo['title']) ?></strong>
                    <?php if($promo['description']): ?>
                    <span><?= sanitize($promo['description']) ?></span>
                    <?php endif; ?>
                </div>
                <?php if($promo['link_url']): ?>
                <a href="<?= sanitize($promo['link_url']) ?>" class="btn btn-sm btn-white"><?= sanitize($promo['link_text'] ?: 'Learn More') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- Brands/Categories Section -->
    <section class="section brands-section">
        <div class="container">
            <div class="section-header">
                <h2>Shop by Manufacturer</h2>
                <p>We carry remanufactured marine diesel engines from every major manufacturer in the industry</p>
            </div>
            <div class="brands-grid">
                <?php foreach($categories as $cat): ?>
                <a href="<?= SITE_URL ?>/category.php?slug=<?= $cat['slug'] ?>" class="brand-card">
                    <div class="brand-icon">
                        <?php if($cat['image']): ?>
                        <img src="<?= UPLOAD_URL . $cat['image'] ?>" alt="<?= sanitize($cat['name']) ?>">
                        <?php else: ?>
                        <i class="fas fa-cog"></i>
                        <?php endif; ?>
                    </div>
                    <h3><?= sanitize($cat['name']) ?></h3>
                    <span class="product-count"><?= $cat['product_count'] ?> Engines</span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <?php if(!empty($featured)): ?>
    <section class="section featured-section">
        <div class="container">
            <div class="section-header">
                <h2>Featured Remanufactured Marine Engines</h2>
                <p>Our most popular remanufactured marine diesel engines, built to OEM specifications</p>
            </div>
            <div class="products-grid">
                <?php foreach($featured as $product): ?>
                <article class="product-card">
                    <a href="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>">
                        <div class="product-image">
                            <?php if($product['image']): ?>
                            <img src="<?= UPLOAD_URL . $product['image'] ?>" alt="Remanufactured <?= sanitize($product['name']) ?>" loading="lazy">
                            <?php else: ?>
                            <div class="no-image"><i class="fas fa-cog"></i></div>
                            <?php endif; ?>
                            <?php if($product['featured']): ?>
                            <span class="badge badge-featured">Featured</span>
                            <?php endif; ?>
                            <span class="badge badge-condition">Remanufactured</span>
                        </div>
                        <div class="product-info">
                            <span class="product-brand"><?= sanitize($product['brand']) ?></span>
                            <h3 class="product-title"><?= sanitize($product['name']) ?></h3>
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
                                <?php if($product['call_for_price']): ?>
                                <span class="product-price call-price">Call for Price</span>
                                <?php elseif($product['sale_price']): ?>
                                <span class="product-price"><del><?= formatPrice($product['price']) ?></del> <?= formatPrice($product['sale_price']) ?></span>
                                <?php elseif($product['price']): ?>
                                <span class="product-price"><?= formatPrice($product['price']) ?></span>
                                <?php endif; ?>
                                <span class="product-sku">Part# <?= sanitize($product['sku']) ?></span>
                            </div>
                        </div>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
            <div class="section-footer">
                <a href="<?= SITE_URL ?>/products.php" class="btn btn-primary btn-lg">View All Marine Engines</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Why Choose Us -->
    <section class="section why-section">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose US Engines Production</h2>
                <p>Industry-leading remanufactured marine diesel engines with unmatched quality and service</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-award"></i></div>
                    <h3>OEM Specifications</h3>
                    <p>Every remanufactured engine is built to meet or exceed original manufacturer specifications using premium components.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Industry-Leading Warranty</h3>
                    <p>All our remanufactured marine diesel engines come with comprehensive warranty coverage for your peace of mind.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-truck"></i></div>
                    <h3>Nationwide Shipping</h3>
                    <p>Fast, reliable shipping to any port or marina in the United States. Commercial freight available for all engine sizes.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3>Expert Support</h3>
                    <p>Our marine diesel specialists help you find the exact engine for your vessel with technical guidance and support.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-sync-alt"></i></div>
                    <h3>Core Exchange Program</h3>
                    <p>Save money with our core return program. Send us your old engine and receive credit toward your remanufactured replacement.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-check-circle"></i></div>
                    <h3>Dyno Tested</h3>
                    <p>Every remanufactured engine is dynamometer tested before shipping to ensure peak performance and reliability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Can't Find Your Engine?</h2>
                <p>We can source and remanufacture virtually any marine diesel engine. Send us your requirements and our specialists will provide a custom quote with VIN verification.</p>
                <a href="<?= SITE_URL ?>/quote.php" class="btn btn-primary btn-lg">Request a Custom Quote</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>US Engines Production</h4>
                    <p>America's premier supplier of remanufactured marine diesel engines. Every major brand, every model, built to exceed OEM specifications.</p>
                    <div class="footer-contact">
                        <p><i class="fas fa-phone"></i> <?= getSetting('site_phone') ?: '(888) 555-0199' ?></p>
                        <p><i class="fas fa-envelope"></i> <?= getSetting('site_email') ?: 'info@usengineproduction.com' ?></p>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Popular Brands</h4>
                    <ul>
                        <li><a href="<?= SITE_URL ?>/category.php?slug=cummins">Cummins Marine</a></li>
                        <li><a href="<?= SITE_URL ?>/category.php?slug=caterpillar">Caterpillar Marine</a></li>
                        <li><a href="<?= SITE_URL ?>/category.php?slug=detroit-diesel">Detroit Diesel Marine</a></li>
                        <li><a href="<?= SITE_URL ?>/category.php?slug=volvo-penta">Volvo Penta</a></li>
                        <li><a href="<?= SITE_URL ?>/category.php?slug=yanmar">Yanmar Marine</a></li>
                        <li><a href="<?= SITE_URL ?>/category.php?slug=man">MAN Marine</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Engine Types</h4>
                    <ul>
                        <li><a href="<?= SITE_URL ?>/products.php?type=marine_propulsion">Marine Propulsion</a></li>
                        <li><a href="<?= SITE_URL ?>/products.php?type=marine_auxiliary">Marine Auxiliary</a></li>
                        <li><a href="<?= SITE_URL ?>/products.php?type=marine_generator">Marine Generators</a></li>
                        <li><a href="<?= SITE_URL ?>/products.php?type=industrial">Industrial Diesel</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?= SITE_URL ?>/about.php">About Us</a></li>
                        <li><a href="<?= SITE_URL ?>/quote.php">Request a Quote</a></li>
                        <li><a href="<?= SITE_URL ?>/warranty.php">Warranty Information</a></li>
                        <li><a href="<?= SITE_URL ?>/shipping.php">Shipping Policy</a></li>
                        <li><a href="<?= SITE_URL ?>/blog.php">Blog & Resources</a></li>
                        <li><a href="<?= SITE_URL ?>/contact.php">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p><?= getSetting('footer_text') ?: '© 2026 US Engines Production. All Rights Reserved.' ?></p>
                <div class="footer-links">
                    <a href="<?= SITE_URL ?>/privacy.php">Privacy Policy</a>
                    <a href="<?= SITE_URL ?>/terms.php">Terms of Service</a>
                    <a href="<?= SITE_URL ?>/sitemap.php">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Nav Overlay -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>

    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
