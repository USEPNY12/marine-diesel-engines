<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | US Engines Production - Remanufactured Marine Diesel Engines</title>
    <meta name="description" content="US Engines Production is America's premier supplier of remanufactured marine diesel engines. Learn about our quality process and commitment to excellence.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/templates/header.php'; ?>
    <div class="page-header">
        <div class="container"><h1>About US Engines Production</h1><p>America's Premier Remanufactured Marine Diesel Engine Supplier</p></div>
    </div>
    <section class="section">
        <div class="container" style="max-width:900px;">
            <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.08);line-height:1.8;">
                <h2 style="font-size:28px;margin-bottom:20px;">Our Mission</h2>
                <p>US Engines Production is the nation's leading supplier of premium remanufactured marine diesel engines. We provide boat owners, commercial operators, and marine service professionals with high-quality remanufactured engines that meet or exceed original manufacturer specifications.</p>
                
                <h2 style="font-size:28px;margin:30px 0 20px;">Our Remanufacturing Process</h2>
                <p>Every engine that leaves our facility undergoes a comprehensive remanufacturing process:</p>
                <ul style="margin:15px 0 15px 20px;">
                    <li>Complete disassembly and thorough cleaning</li>
                    <li>100% inspection of all components</li>
                    <li>Replacement of all wear items with OEM or premium aftermarket parts</li>
                    <li>Precision machining to factory specifications</li>
                    <li>Assembly by certified marine diesel technicians</li>
                    <li>Full dynamometer testing before shipment</li>
                    <li>Quality control verification at every stage</li>
                </ul>

                <h2 style="font-size:28px;margin:30px 0 20px;">Complete Brand Coverage</h2>
                <p>We carry remanufactured marine diesel engines from every major manufacturer including Cummins, Caterpillar, Detroit Diesel, Volvo Penta, Yanmar, MAN, MTU, John Deere, Mitsubishi, Scania, Perkins, FPT/Iveco, Deutz, Doosan, and more. From small sailboat auxiliaries to large commercial propulsion systems, we have the engine you need.</p>

                <h2 style="font-size:28px;margin:30px 0 20px;">Why Choose Us</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:15px;">
                    <div style="padding:20px;background:#f8f9fa;border-radius:8px;"><strong>Industry-Leading Warranty</strong><br>Comprehensive coverage on all remanufactured engines</div>
                    <div style="padding:20px;background:#f8f9fa;border-radius:8px;"><strong>Nationwide Shipping</strong><br>Fast delivery to any port or marina in the US</div>
                    <div style="padding:20px;background:#f8f9fa;border-radius:8px;"><strong>Expert Support</strong><br>Marine diesel specialists ready to help</div>
                    <div style="padding:20px;background:#f8f9fa;border-radius:8px;"><strong>Core Exchange</strong><br>Save money with our core return program</div>
                </div>
            </div>
        </div>
    </section>
    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
