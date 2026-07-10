<?php
// Get categories for nav
$navStmt = $pdo->query("SELECT * FROM categories WHERE is_active = 1 AND parent_id IS NULL ORDER BY display_order, name LIMIT 12");
$navCategories = $navStmt->fetchAll();
?>
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
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <a href="<?= SITE_URL ?>/" class="logo">
                <img src="<?= SITE_URL ?>/assets/images/logo.png" alt="US Engines Production" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span class="logo-text" style="display:none;">US Engines Production</span>
            </a>
            <nav class="main-nav" id="mainNav">
                <a href="<?= SITE_URL ?>/">Home</a>
                <div class="nav-dropdown">
                    <a href="<?= SITE_URL ?>/products.php">Marine Engines <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-content">
                        <?php foreach($navCategories as $cat): ?>
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
