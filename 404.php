<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | US Engines Production Marine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?>
    <section class="section" style="text-align:center;padding:100px 0;">
        <div class="container">
            <i class="fas fa-anchor" style="font-size:80px;color:var(--gray-300);margin-bottom:20px;display:block;"></i>
            <h1 style="font-size:48px;margin-bottom:10px;">404</h1>
            <p style="font-size:18px;color:var(--gray-600);margin-bottom:30px;">Page not found. The engine you're looking for may have shipped!</p>
            <a href="<?= SITE_URL ?>/" class="btn btn-primary btn-lg">Back to Home</a>
            <a href="<?= SITE_URL ?>/products.php" class="btn btn-outline btn-lg" style="border-color:var(--primary);color:var(--primary);">Browse Engines</a>
        </div>
    </section>
    <?php include __DIR__ . '/templates/footer.php'; ?>
</body>
</html>
