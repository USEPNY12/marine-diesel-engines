<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <h2><i class="fas fa-anchor"></i> Marine Admin</h2>
        <button class="sidebar-close" id="sidebarClose"><i class="fas fa-times"></i></button>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= ADMIN_URL ?>/index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="<?= ADMIN_URL ?>/products.php" class="<?= basename($_SERVER['PHP_SELF']) === 'products.php' || basename($_SERVER['PHP_SELF']) === 'product-edit.php' ? 'active' : '' ?>">
            <i class="fas fa-cog"></i> Products/Engines
        </a>
        <a href="<?= ADMIN_URL ?>/categories.php" class="<?= basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : '' ?>">
            <i class="fas fa-folder"></i> Categories
        </a>
        <a href="<?= ADMIN_URL ?>/quotes.php" class="<?= basename($_SERVER['PHP_SELF']) === 'quotes.php' || basename($_SERVER['PHP_SELF']) === 'quote-view.php' ? 'active' : '' ?>">
            <i class="fas fa-file-invoice"></i> Quotes/Leads
            <?php 
            $newQuotes = $pdo->query("SELECT COUNT(*) FROM quotes WHERE status = 'new'")->fetchColumn();
            if($newQuotes > 0): ?>
            <span class="badge"><?= $newQuotes ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= ADMIN_URL ?>/contacts.php" class="<?= basename($_SERVER['PHP_SELF']) === 'contacts.php' ? 'active' : '' ?>">
            <i class="fas fa-envelope"></i> Messages
            <?php 
            $newContacts = $pdo->query("SELECT COUNT(*) FROM contacts WHERE status = 'new'")->fetchColumn();
            if($newContacts > 0): ?>
            <span class="badge"><?= $newContacts ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= ADMIN_URL ?>/promotions.php" class="<?= basename($_SERVER['PHP_SELF']) === 'promotions.php' ? 'active' : '' ?>">
            <i class="fas fa-bullhorn"></i> Promotions
        </a>
        <a href="<?= ADMIN_URL ?>/blog.php" class="<?= basename($_SERVER['PHP_SELF']) === 'blog.php' || basename($_SERVER['PHP_SELF']) === 'blog-edit.php' ? 'active' : '' ?>">
            <i class="fas fa-newspaper"></i> Blog
        </a>
        <a href="<?= ADMIN_URL ?>/settings.php" class="<?= basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : '' ?>">
            <i class="fas fa-sliders-h"></i> Settings
        </a>
        <a href="<?= ADMIN_URL ?>/seo.php" class="<?= basename($_SERVER['PHP_SELF']) === 'seo.php' ? 'active' : '' ?>">
            <i class="fas fa-search"></i> SEO
        </a>
        <div class="sidebar-divider"></div>
        <a href="<?= SITE_URL ?>/" target="_blank">
            <i class="fas fa-external-link-alt"></i> View Website
        </a>
        <a href="<?= ADMIN_URL ?>/logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>
