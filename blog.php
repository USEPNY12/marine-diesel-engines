<?php
require_once __DIR__ . '/includes/config.php';
$posts = $pdo->query("SELECT * FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Marine Diesel Engine Resources | US Engines Production</title>
    <meta name="description" content="Expert articles and resources about marine diesel engines, maintenance tips, and industry news from US Engines Production.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?>
    <div class="page-header"><div class="container"><h1>Blog & Resources</h1><p>Expert articles about marine diesel engines</p></div></div>
    <section class="section">
        <div class="container" style="max-width:900px;">
            <?php if(empty($posts)): ?>
            <p style="text-align:center;color:var(--gray-600);padding:40px;">Blog posts coming soon. Check back for expert marine diesel engine articles and resources.</p>
            <?php else: ?>
            <?php foreach($posts as $post): ?>
            <article style="background:white;padding:30px;border-radius:12px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                <h2 style="margin-bottom:8px;"><a href="<?= SITE_URL ?>/blog-post.php?slug=<?= $post['slug'] ?>" style="text-decoration:none;color:var(--dark);"><?= sanitize($post['title']) ?></a></h2>
                <p style="color:var(--gray-500);font-size:13px;margin-bottom:10px;"><?= date('F j, Y', strtotime($post['published_at'])) ?></p>
                <p style="color:var(--gray-600);"><?= sanitize($post['excerpt']) ?></p>
                <a href="<?= SITE_URL ?>/blog-post.php?slug=<?= $post['slug'] ?>" style="color:var(--primary);font-weight:600;font-size:14px;">Read More →</a>
            </article>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
