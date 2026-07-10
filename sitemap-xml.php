<?php
require_once __DIR__ . '/includes/config.php';
header('Content-Type: application/xml; charset=utf-8');

$categories = $pdo->query("SELECT slug FROM categories WHERE is_active = 1")->fetchAll();
$products = $pdo->query("SELECT slug, updated_at FROM products WHERE is_active = 1")->fetchAll();
$blogs = $pdo->query("SELECT slug, published_at FROM blog_posts WHERE status = 'published'")->fetchAll();

$domain = 'https://marinedieselremanengines.com';
$today = date('Y-m-d');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc><?= $domain ?>/</loc><lastmod><?= $today ?></lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>
    <url><loc><?= $domain ?>/products.php</loc><lastmod><?= $today ?></lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>
    <url><loc><?= $domain ?>/quote.php</loc><lastmod><?= $today ?></lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>
    <url><loc><?= $domain ?>/about.php</loc><lastmod><?= $today ?></lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>
    <url><loc><?= $domain ?>/contact.php</loc><lastmod><?= $today ?></lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>
    <url><loc><?= $domain ?>/blog.php</loc><lastmod><?= $today ?></lastmod><changefreq>weekly</changefreq><priority>0.7</priority></url>
    <url><loc><?= $domain ?>/warranty.php</loc><lastmod><?= $today ?></lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>
    <url><loc><?= $domain ?>/shipping.php</loc><lastmod><?= $today ?></lastmod><changefreq>monthly</changefreq><priority>0.6</priority></url>
<?php foreach ($categories as $c): ?>
    <url><loc><?= $domain ?>/category.php?slug=<?= $c['slug'] ?></loc><lastmod><?= $today ?></lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>
<?php endforeach; ?>
<?php foreach ($products as $p): ?>
    <url><loc><?= $domain ?>/product.php?slug=<?= $p['slug'] ?></loc><lastmod><?= $p['updated_at'] ? date('Y-m-d', strtotime($p['updated_at'])) : $today ?></lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>
<?php endforeach; ?>
<?php foreach ($blogs as $b): ?>
    <url><loc><?= $domain ?>/blog-post.php?slug=<?= $b['slug'] ?></loc><lastmod><?= date('Y-m-d', strtotime($b['published_at'])) ?></lastmod><changefreq>monthly</changefreq><priority>0.6</priority></url>
<?php endforeach; ?>
</urlset>
