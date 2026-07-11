<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/mailer.php';

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && $email && $message) {
        $pdo->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?,?,?,?,?)")
            ->execute([$name, $email, $phone, $subject, $message]);
        
        // Send email notification
        sendContactNotification([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message
        ]);
        
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | US Engines Production Marine</title>
    <meta name="description" content="Contact US Engines Production for remanufactured marine diesel engines. Get expert help finding the right engine for your vessel.">
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
            <h1>Contact Us</h1>
            <p>Get in touch with our marine diesel engine specialists</p>
        </div>
    </div>
    <section class="section">
        <div class="container" style="max-width:700px;">
            <?php if($success): ?>
            <div style="background:#d1fae5;color:#065f46;padding:20px;border-radius:8px;margin-bottom:20px;text-align:center;">
                <i class="fas fa-check-circle"></i> Message sent! We'll respond within 24 hours.
            </div>
            <?php endif; ?>
            <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.08);">
                <form method="POST">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
                        <div class="form-group"><label style="display:block;font-weight:600;margin-bottom:5px;font-size:14px;">Name *</label><input type="text" name="name" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"></div>
                        <div class="form-group"><label style="display:block;font-weight:600;margin-bottom:5px;font-size:14px;">Email *</label><input type="email" name="email" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-top:15px;">
                        <div class="form-group"><label style="display:block;font-weight:600;margin-bottom:5px;font-size:14px;">Phone</label><input type="tel" name="phone" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"></div>
                        <div class="form-group"><label style="display:block;font-weight:600;margin-bottom:5px;font-size:14px;">Subject</label><input type="text" name="subject" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"></div>
                    </div>
                    <div style="margin-top:15px;"><label style="display:block;font-weight:600;margin-bottom:5px;font-size:14px;">Message *</label><textarea name="message" required rows="5" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;font-family:inherit;"></textarea></div>
                    <button type="submit" class="btn btn-primary" style="width:100%;margin-top:20px;padding:14px;"><i class="fas fa-paper-plane"></i> Send Message</button>
                </form>
            </div>
        </div>
    </section>
    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
