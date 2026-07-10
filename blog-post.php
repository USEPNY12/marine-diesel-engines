<?php
require_once __DIR__ . '/includes/config.php';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    header('Location: ' . SITE_URL . '/blog.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$pageTitle = $post['meta_title'] ?: $post['title'] . ' | US Engines Production';
$pageDescription = $post['meta_description'] ?: substr(strip_tags($post['excerpt']), 0, 160);

// Get related posts
$relatedStmt = $pdo->prepare("SELECT id, title, slug, excerpt, published_at FROM blog_posts WHERE slug != ? AND status = 'published' ORDER BY published_at DESC LIMIT 3");
$relatedStmt->execute([$slug]);
$relatedPosts = $relatedStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle) ?></title>
    <meta name="description" content="<?= sanitize($pageDescription) ?>">
    <meta name="keywords" content="marine diesel engine, remanufactured marine engine, boat engine guide, diesel engine maintenance">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL ?>/blog-post.php?slug=<?= urlencode($slug) ?>">
    
    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= sanitize($post['title']) ?>">
    <meta property="og:description" content="<?= sanitize($pageDescription) ?>">
    <meta property="og:url" content="<?= SITE_URL ?>/blog-post.php?slug=<?= urlencode($slug) ?>">
    <meta property="og:site_name" content="US Engines Production - Marine Division">
    
    <!-- Article Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "<?= sanitize($post['title']) ?>",
        "description": "<?= sanitize($pageDescription) ?>",
        "datePublished": "<?= $post['published_at'] ?>",
        "author": {
            "@type": "Organization",
            "name": "US Engines Production"
        },
        "publisher": {
            "@type": "Organization",
            "name": "US Engines Production",
            "url": "<?= SITE_URL ?>"
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
            <h1><?= sanitize($post['title']) ?></h1>
            <p>Published <?= date('F j, Y', strtotime($post['published_at'])) ?></p>
        </div>
    </div>

    <section class="section">
        <div class="container" style="max-width:800px;">
            <!-- Breadcrumbs -->
            <nav style="margin-bottom:20px;font-size:14px;color:#666;">
                <a href="<?= SITE_URL ?>/" style="color:#0066cc;">Home</a> &raquo; 
                <a href="<?= SITE_URL ?>/blog.php" style="color:#0066cc;">Blog</a> &raquo; 
                <span><?= sanitize($post['title']) ?></span>
            </nav>

            <article style="background:white;padding:40px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.08);line-height:1.9;">
                <?php if (!empty($post['featured_image'])): ?>
                <img src="<?= SITE_URL ?>/assets/uploads/blog/<?= $post['featured_image'] ?>" alt="<?= sanitize($post['title']) ?>" style="width:100%;border-radius:8px;margin-bottom:30px;">
                <?php endif; ?>

                <div class="blog-content" style="font-size:17px;">
                    <?= $post['content'] ?>
                </div>

                <!-- CTA Box -->
                <div style="margin-top:40px;padding:30px;background:linear-gradient(135deg,#0a1628,#1a3a5c);border-radius:12px;color:white;text-align:center;">
                    <h3 style="color:white;margin-bottom:10px;">Need a Remanufactured Marine Diesel Engine?</h3>
                    <p style="opacity:0.9;margin-bottom:20px;">Browse our complete inventory of 103+ engines from 18 manufacturers.</p>
                    <a href="<?= SITE_URL ?>/products.php" style="display:inline-block;padding:12px 30px;background:#00d4ff;color:#0a1628;border-radius:6px;text-decoration:none;font-weight:700;margin-right:10px;">Browse Engines</a>
                    <a href="<?= SITE_URL ?>/quote.php" style="display:inline-block;padding:12px 30px;background:transparent;color:white;border:2px solid white;border-radius:6px;text-decoration:none;font-weight:600;">Get a Quote</a>
                </div>
            </article>

            <!-- Related Posts -->
            <?php if (!empty($relatedPosts)): ?>
            <div style="margin-top:40px;">
                <h3 style="margin-bottom:20px;">Related Articles</h3>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <?php foreach($relatedPosts as $related): ?>
                    <a href="<?= SITE_URL ?>/blog-post.php?slug=<?= $related['slug'] ?>" style="text-decoration:none;padding:20px;background:white;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                        <h4 style="color:#0a1628;margin-bottom:8px;"><?= sanitize($related['title']) ?></h4>
                        <p style="color:#666;font-size:14px;margin:0;"><?= date('M j, Y', strtotime($related['published_at'])) ?></p>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
