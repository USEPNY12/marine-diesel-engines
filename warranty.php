<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle = '1-Year Unlimited Hours Warranty | US Engines Production Marine Diesel Engines';
$pageDescription = 'Our remanufactured marine diesel engines come with a comprehensive 1-Year Unlimited Hours warranty. Full coverage on parts and labor for complete peace of mind.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDescription ?>">
    <meta name="keywords" content="marine diesel engine warranty, remanufactured engine warranty, unlimited hours warranty, marine engine guarantee, Cummins marine warranty, Caterpillar marine warranty">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL ?>/warranty.php">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $pageTitle ?>">
    <meta property="og:description" content="<?= $pageDescription ?>">
    <meta property="og:url" content="<?= SITE_URL ?>/warranty.php">
    <meta property="og:site_name" content="US Engines Production - Marine Division">
    
    <!-- Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Warranty Information",
        "description": "<?= $pageDescription ?>",
        "url": "<?= SITE_URL ?>/warranty.php",
        "publisher": {
            "@type": "Organization",
            "name": "US Engines Production"
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
            <h1>1-Year Unlimited Hours Warranty</h1>
            <p>Industry-Leading Coverage on Every Remanufactured Marine Diesel Engine</p>
        </div>
    </div>

    <section class="section">
        <div class="container" style="max-width:900px;">
            <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.08);line-height:1.8;">
                
                <!-- Warranty Badge -->
                <div style="text-align:center;margin-bottom:30px;padding:30px;background:linear-gradient(135deg,#0a1628,#1a3a5c);border-radius:12px;color:white;">
                    <i class="fas fa-shield-alt" style="font-size:48px;color:#00d4ff;margin-bottom:15px;display:block;"></i>
                    <h2 style="font-size:32px;margin-bottom:10px;color:white;">1-Year Unlimited Hours</h2>
                    <p style="font-size:18px;opacity:0.9;margin:0;">No hour restrictions. No fine print. Complete peace of mind.</p>
                </div>

                <h2 style="font-size:28px;margin:30px 0 20px;">Warranty Overview</h2>
                <p>At US Engines Production, we stand behind the quality of every remanufactured marine diesel engine we sell. Our industry-leading <strong>1-Year Unlimited Hours Warranty</strong> provides comprehensive coverage from the date of purchase, regardless of how many hours you put on the engine. Whether you operate a commercial fishing vessel running 3,000+ hours per year or a recreational cruiser, your engine is fully protected.</p>

                <h2 style="font-size:28px;margin:30px 0 20px;">What Is Covered</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-top:15px;">
                    <div style="padding:20px;background:#e8f5e9;border-radius:8px;border-left:4px solid #4caf50;">
                        <strong><i class="fas fa-check-circle" style="color:#4caf50;"></i> Engine Block</strong><br>
                        Complete block assembly including cylinder liners, main bearings, and all internal components
                    </div>
                    <div style="padding:20px;background:#e8f5e9;border-radius:8px;border-left:4px solid #4caf50;">
                        <strong><i class="fas fa-check-circle" style="color:#4caf50;"></i> Cylinder Head</strong><br>
                        Cylinder head assembly, valves, valve guides, springs, rocker arms, and camshaft
                    </div>
                    <div style="padding:20px;background:#e8f5e9;border-radius:8px;border-left:4px solid #4caf50;">
                        <strong><i class="fas fa-check-circle" style="color:#4caf50;"></i> Crankshaft & Pistons</strong><br>
                        Crankshaft, connecting rods, pistons, piston rings, and wrist pins
                    </div>
                    <div style="padding:20px;background:#e8f5e9;border-radius:8px;border-left:4px solid #4caf50;">
                        <strong><i class="fas fa-check-circle" style="color:#4caf50;"></i> Oil & Fuel System</strong><br>
                        Oil pump, fuel injection pump, injectors (if remanufactured by us), and oil cooler
                    </div>
                    <div style="padding:20px;background:#e8f5e9;border-radius:8px;border-left:4px solid #4caf50;">
                        <strong><i class="fas fa-check-circle" style="color:#4caf50;"></i> Turbocharger</strong><br>
                        Turbocharger assembly (if included with engine purchase and remanufactured by us)
                    </div>
                    <div style="padding:20px;background:#e8f5e9;border-radius:8px;border-left:4px solid #4caf50;">
                        <strong><i class="fas fa-check-circle" style="color:#4caf50;"></i> Timing Components</strong><br>
                        Timing gears, timing chain/belt, idler pulleys, and tensioners
                    </div>
                </div>

                <h2 style="font-size:28px;margin:30px 0 20px;">Warranty Conditions</h2>
                <p>To maintain warranty coverage, the following conditions apply:</p>
                <ul style="margin:15px 0 15px 20px;line-height:2.2;">
                    <li><strong>Professional Installation:</strong> Engine must be installed by a qualified marine mechanic or certified marine diesel technician.</li>
                    <li><strong>Proper Break-In:</strong> Follow the break-in procedure provided with your engine (typically the first 50 hours of operation).</li>
                    <li><strong>Regular Maintenance:</strong> Maintain the engine per manufacturer-recommended service intervals (oil changes, filter replacements, coolant service).</li>
                    <li><strong>Approved Fluids:</strong> Use manufacturer-recommended oil grades, coolant types, and fuel specifications.</li>
                    <li><strong>Documentation:</strong> Keep records of maintenance performed (receipts, service logs).</li>
                </ul>

                <h2 style="font-size:28px;margin:30px 0 20px;">What Is Not Covered</h2>
                <div style="padding:20px;background:#fff3e0;border-radius:8px;border-left:4px solid #ff9800;margin-bottom:20px;">
                    <ul style="margin:0 0 0 15px;line-height:2.2;">
                        <li>Normal wear items: belts, hoses, gaskets, filters, zincs, impellers</li>
                        <li>Damage caused by overheating due to blocked raw water intake or failed external cooling components</li>
                        <li>Damage from contaminated fuel, water intrusion, or use of improper fluids</li>
                        <li>External accessories not supplied by US Engines Production (alternators, starters, heat exchangers, transmissions)</li>
                        <li>Damage resulting from improper installation or unauthorized modifications</li>
                        <li>Consequential damages (haul-out costs, lost revenue, towing)</li>
                    </ul>
                </div>

                <h2 style="font-size:28px;margin:30px 0 20px;">How to File a Warranty Claim</h2>
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:15px;margin-top:15px;">
                    <div style="text-align:center;padding:20px;background:#f8f9fa;border-radius:8px;">
                        <div style="width:40px;height:40px;background:#0066cc;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-weight:bold;">1</div>
                        <strong>Contact Us</strong><br><small>Call (888) 555-0199 or email us</small>
                    </div>
                    <div style="text-align:center;padding:20px;background:#f8f9fa;border-radius:8px;">
                        <div style="width:40px;height:40px;background:#0066cc;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-weight:bold;">2</div>
                        <strong>Describe Issue</strong><br><small>Provide symptoms and engine details</small>
                    </div>
                    <div style="text-align:center;padding:20px;background:#f8f9fa;border-radius:8px;">
                        <div style="width:40px;height:40px;background:#0066cc;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-weight:bold;">3</div>
                        <strong>Diagnosis</strong><br><small>We authorize inspection by local shop</small>
                    </div>
                    <div style="text-align:center;padding:20px;background:#f8f9fa;border-radius:8px;">
                        <div style="width:40px;height:40px;background:#0066cc;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-weight:bold;">4</div>
                        <strong>Resolution</strong><br><small>Repair, replace, or credit issued</small>
                    </div>
                </div>

                <h2 style="font-size:28px;margin:30px 0 20px;">Extended Warranty Options</h2>
                <p>Need longer coverage? We offer extended warranty plans for customers who want additional protection beyond the standard 1-year term:</p>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:15px;margin-top:15px;">
                    <div style="text-align:center;padding:25px;background:#f0f7ff;border-radius:8px;border:2px solid #e0e0e0;">
                        <h3 style="color:#0066cc;margin-bottom:10px;">Standard</h3>
                        <p style="font-size:24px;font-weight:bold;margin:10px 0;">1 Year</p>
                        <p style="color:#666;">Unlimited Hours<br>Included Free</p>
                    </div>
                    <div style="text-align:center;padding:25px;background:#f0f7ff;border-radius:8px;border:2px solid #0066cc;">
                        <h3 style="color:#0066cc;margin-bottom:10px;">Extended</h3>
                        <p style="font-size:24px;font-weight:bold;margin:10px 0;">2 Years</p>
                        <p style="color:#666;">Unlimited Hours<br>Call for Pricing</p>
                    </div>
                    <div style="text-align:center;padding:25px;background:#f0f7ff;border-radius:8px;border:2px solid #e0e0e0;">
                        <h3 style="color:#0066cc;margin-bottom:10px;">Premium</h3>
                        <p style="font-size:24px;font-weight:bold;margin:10px 0;">3 Years</p>
                        <p style="color:#666;">Unlimited Hours<br>Call for Pricing</p>
                    </div>
                </div>

                <div style="margin-top:40px;text-align:center;padding:30px;background:#f8f9fa;border-radius:12px;">
                    <h3 style="margin-bottom:15px;">Have Questions About Our Warranty?</h3>
                    <p style="margin-bottom:20px;">Our team is ready to help you understand your coverage options.</p>
                    <a href="<?= SITE_URL ?>/contact.php" class="btn btn-primary" style="margin-right:10px;">Contact Us</a>
                    <a href="<?= SITE_URL ?>/quote.php" class="btn btn-outline">Request a Quote</a>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
