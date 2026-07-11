<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/mailer.php';

$success = false;
$error = '';
$prefillEngine = $_GET['engine'] ?? '';
$prefillSku = $_GET['sku'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $vesselName = trim($_POST['vessel_name'] ?? '');
    $vesselType = trim($_POST['vessel_type'] ?? '');
    $vin = trim($_POST['vin'] ?? '');
    $engineModel = trim($_POST['engine_model'] ?? '');
    $engineType = trim($_POST['engine_type'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$firstName || !$lastName || !$email) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO quotes (first_name, last_name, email, phone, company, vessel_name, vessel_type, vin, engine_model, engine_type, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $phone, $company, $vesselName, $vesselType, $vin, $engineModel, $engineType, $message]);
        
        // Send email notification
        sendQuoteNotification([
            'name' => $firstName . ' ' . $lastName,
            'email' => $email,
            'phone' => $phone,
            'engine' => $engineModel,
            'vin' => $vin,
            'message' => "Company: $company | Vessel: $vesselName ($vesselType) | Engine Type: $engineType | Message: $message"
        ]);
        
        $success = true;
    }
}

$pageTitle = "Request a Quote - Remanufactured Marine Diesel Engines";
$pageDescription = "Get a free quote on any remanufactured marine diesel engine. Cummins, Caterpillar, Detroit Diesel, Volvo Penta, Yanmar and more. Fast response guaranteed.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> | US Engines Production</title>
    <meta name="description" content="<?= $pageDescription ?>">
    <link rel="canonical" href="<?= SITE_URL ?>/quote.php">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <style>
        .quote-form { max-width: 800px; margin: 0 auto; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; color: var(--dark); }
        .form-group label .required { color: var(--danger); }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px 16px; border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm); font-size: 15px; font-family: var(--font-primary);
            transition: var(--transition);
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(0,102,204,0.1);
        }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .alert { padding: 15px 20px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?>

    <div class="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?= SITE_URL ?>/">Home</a><span>/</span><span>Request a Quote</span>
            </div>
            <h1>Request a Free Quote</h1>
            <p>Get pricing on any remanufactured marine diesel engine — we'll respond within 24 hours</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="quote-form">
                <?php if($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <strong>Quote Request Submitted!</strong> Our team will review your request and respond within 24 hours. Thank you for choosing US Engines Production.
                </div>
                <?php endif; ?>
                <?php if($error): ?>
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= sanitize($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>First Name <span class="required">*</span></label>
                            <input type="text" name="first_name" required placeholder="John">
                        </div>
                        <div class="form-group">
                            <label>Last Name <span class="required">*</span></label>
                            <input type="text" name="last_name" required placeholder="Smith">
                        </div>
                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" required placeholder="john@example.com">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" name="phone" placeholder="(555) 123-4567">
                        </div>
                        <div class="form-group">
                            <label>Company / Marina</label>
                            <input type="text" name="company" placeholder="Company name">
                        </div>
                        <div class="form-group">
                            <label>Vessel Name</label>
                            <input type="text" name="vessel_name" placeholder="Vessel name">
                        </div>
                        <div class="form-group">
                            <label>Vessel Type</label>
                            <select name="vessel_type">
                                <option value="">Select vessel type...</option>
                                <option value="Sport Fishing">Sport Fishing</option>
                                <option value="Yacht">Yacht</option>
                                <option value="Trawler">Trawler</option>
                                <option value="Commercial Fishing">Commercial Fishing</option>
                                <option value="Tugboat">Tugboat</option>
                                <option value="Passenger Vessel">Passenger Vessel</option>
                                <option value="Cargo/Freight">Cargo/Freight</option>
                                <option value="Workboat">Workboat</option>
                                <option value="Sailboat">Sailboat</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>VIN / Hull ID Number</label>
                            <input type="text" name="vin" placeholder="Vehicle/Hull Identification Number">
                        </div>
                        <div class="form-group">
                            <label>Engine Model Needed</label>
                            <input type="text" name="engine_model" value="<?= sanitize($prefillEngine) ?>" placeholder="e.g., Cummins QSB6.7, CAT C18">
                        </div>
                        <div class="form-group">
                            <label>Engine Type</label>
                            <select name="engine_type">
                                <option value="">Select type...</option>
                                <option value="Marine Propulsion">Marine Propulsion</option>
                                <option value="Marine Auxiliary">Marine Auxiliary</option>
                                <option value="Marine Generator">Marine Generator</option>
                                <option value="Industrial">Industrial</option>
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Additional Details</label>
                            <textarea name="message" placeholder="Please provide any additional details about your engine needs, current engine condition, desired horsepower, etc."><?= $prefillSku ? "Part# $prefillSku" : '' ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                        <i class="fas fa-paper-plane"></i> Submit Quote Request
                    </button>
                    <p style="text-align:center;margin-top:15px;font-size:13px;color:var(--gray-600);">
                        We typically respond within 24 hours. For urgent needs, call us at <?= getSetting('site_phone') ?: '(888) 555-0199' ?>
                    </p>
                </form>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
