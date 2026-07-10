<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'generate_sitemap') {
        // Generate XML sitemap
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= '<url><loc>' . SITE_URL . '/</loc><priority>1.0</priority><changefreq>daily</changefreq></url>' . "\n";
        $xml .= '<url><loc>' . SITE_URL . '/products.php</loc><priority>0.9</priority><changefreq>daily</changefreq></url>' . "\n";
        $xml .= '<url><loc>' . SITE_URL . '/quote.php</loc><priority>0.8</priority></url>' . "\n";
        $xml .= '<url><loc>' . SITE_URL . '/about.php</loc><priority>0.7</priority></url>' . "\n";
        $xml .= '<url><loc>' . SITE_URL . '/contact.php</loc><priority>0.7</priority></url>' . "\n";
        
        $cats = $pdo->query("SELECT slug FROM categories WHERE is_active = 1")->fetchAll();
        foreach ($cats as $c) {
            $xml .= '<url><loc>' . SITE_URL . '/category.php?slug=' . $c['slug'] . '</loc><priority>0.8</priority><changefreq>weekly</changefreq></url>' . "\n";
        }
        $prods = $pdo->query("SELECT slug, updated_at FROM products WHERE is_active = 1")->fetchAll();
        foreach ($prods as $p) {
            $xml .= '<url><loc>' . SITE_URL . '/product.php?slug=' . $p['slug'] . '</loc><lastmod>' . date('Y-m-d', strtotime($p['updated_at'])) . '</lastmod><priority>0.7</priority></url>' . "\n";
        }
        $xml .= '</urlset>';
        file_put_contents(__DIR__ . '/../sitemap.xml', $xml);
        $success = 'Sitemap generated! (' . (count($cats) + count($prods) + 5) . ' URLs)';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO Tools | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <h1 class="page-title">SEO Tools</h1>
            <?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

            <div class="admin-card">
                <div class="card-header"><h2><i class="fas fa-sitemap"></i> XML Sitemap</h2></div>
                <div class="card-body">
                    <p style="margin-bottom:15px;">Generate an XML sitemap for search engines. Submit to Google Search Console for faster indexing.</p>
                    <form method="POST">
                        <input type="hidden" name="action" value="generate_sitemap">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i> Generate Sitemap</button>
                    </form>
                    <?php if(file_exists(__DIR__ . '/../sitemap.xml')): ?>
                    <p style="margin-top:10px;font-size:13px;color:var(--admin-muted);">
                        Sitemap URL: <a href="<?= SITE_URL ?>/sitemap.xml" target="_blank"><?= SITE_URL ?>/sitemap.xml</a>
                    </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header"><h2><i class="fas fa-search"></i> SEO Checklist</h2></div>
                <div class="card-body">
                    <ul style="list-style:none;padding:0;">
                        <li style="padding:8px 0;border-bottom:1px solid #eee;"><i class="fas fa-check-circle" style="color:var(--admin-success);margin-right:8px;"></i> Schema.org structured data on all product pages</li>
                        <li style="padding:8px 0;border-bottom:1px solid #eee;"><i class="fas fa-check-circle" style="color:var(--admin-success);margin-right:8px;"></i> Open Graph meta tags for social sharing</li>
                        <li style="padding:8px 0;border-bottom:1px solid #eee;"><i class="fas fa-check-circle" style="color:var(--admin-success);margin-right:8px;"></i> Canonical URLs on all pages</li>
                        <li style="padding:8px 0;border-bottom:1px solid #eee;"><i class="fas fa-check-circle" style="color:var(--admin-success);margin-right:8px;"></i> Keyword-rich meta titles and descriptions</li>
                        <li style="padding:8px 0;border-bottom:1px solid #eee;"><i class="fas fa-check-circle" style="color:var(--admin-success);margin-right:8px;"></i> Mobile-responsive design</li>
                        <li style="padding:8px 0;border-bottom:1px solid #eee;"><i class="fas fa-check-circle" style="color:var(--admin-success);margin-right:8px;"></i> Fast page load (minimal dependencies)</li>
                        <li style="padding:8px 0;border-bottom:1px solid #eee;"><i class="fas fa-check-circle" style="color:var(--admin-success);margin-right:8px;"></i> XML Sitemap generation</li>
                        <li style="padding:8px 0;"><i class="fas fa-check-circle" style="color:var(--admin-success);margin-right:8px;"></i> Semantic HTML5 structure</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
