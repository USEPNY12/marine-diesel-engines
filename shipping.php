<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Shipping Policy | US Engines Production - Marine Diesel Engine Delivery';
$pageDescription = 'Nationwide shipping on all remanufactured marine diesel engines. Learn about our shipping methods, delivery timelines, freight options, and crating standards.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDescription ?>">
    <meta name="keywords" content="marine engine shipping, diesel engine delivery, freight shipping engines, engine crating, nationwide engine shipping">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL ?>/shipping.php">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $pageTitle ?>">
    <meta property="og:description" content="<?= $pageDescription ?>">
    <meta property="og:url" content="<?= SITE_URL ?>/shipping.php">
    <meta property="og:site_name" content="US Engines Production - Marine Division">
    
    <!-- Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Shipping Policy",
        "description": "<?= $pageDescription ?>",
        "url": "<?= SITE_URL ?>/shipping.php",
        "publisher": {"@type": "Organization", "name": "US Engines Production"}
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
            <h1>Shipping Policy</h1>
            <p>Nationwide Delivery of Remanufactured Marine Diesel Engines</p>
        </div>
    </div>

    <section class="section">
        <div class="container" style="max-width:900px;">
            <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.08);line-height:1.8;">
                
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-bottom:30px;">
                    <div style="text-align:center;padding:25px;background:linear-gradient(135deg,#0a1628,#1a3a5c);border-radius:12px;color:white;">
                        <i class="fas fa-truck" style="font-size:32px;color:#00d4ff;margin-bottom:10px;display:block;"></i>
                        <strong>Nationwide</strong><br><small>All 50 States</small>
                    </div>
                    <div style="text-align:center;padding:25px;background:linear-gradient(135deg,#0a1628,#1a3a5c);border-radius:12px;color:white;">
                        <i class="fas fa-box" style="font-size:32px;color:#00d4ff;margin-bottom:10px;display:block;"></i>
                        <strong>Custom Crated</strong><br><small>Every Engine</small>
                    </div>
                    <div style="text-align:center;padding:25px;background:linear-gradient(135deg,#0a1628,#1a3a5c);border-radius:12px;color:white;">
                        <i class="fas fa-clock" style="font-size:32px;color:#00d4ff;margin-bottom:10px;display:block;"></i>
                        <strong>3-7 Days</strong><br><small>Transit Time</small>
                    </div>
                </div>

                <h2 style="font-size:28px;margin:30px 0 20px;">Shipping Methods</h2>
                <p>Due to the size and weight of marine diesel engines, all shipments are sent via <strong>LTL (Less Than Truckload) freight</strong>. We work with top-rated carriers to ensure your engine arrives safely and on time. Our shipping partners include:</p>
                <ul style="margin:15px 0 15px 20px;line-height:2.2;">
                    <li>Old Dominion Freight Line (ODFL)</li>
                    <li>XPO Logistics</li>
                    <li>Estes Express Lines</li>
                    <li>R+L Carriers</li>
                    <li>FedEx Freight</li>
                </ul>

                <h2 style="font-size:28px;margin:30px 0 20px;">Delivery Timelines</h2>
                <table style="width:100%;border-collapse:collapse;margin:15px 0;">
                    <thead>
                        <tr style="background:#0a1628;color:white;">
                            <th style="padding:12px 15px;text-align:left;">Destination</th>
                            <th style="padding:12px 15px;text-align:left;">Estimated Transit</th>
                            <th style="padding:12px 15px;text-align:left;">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom:1px solid #eee;">
                            <td style="padding:12px 15px;">East Coast (FL, GA, SC, NC, VA, MD, NJ, NY, CT, MA)</td>
                            <td style="padding:12px 15px;">3-5 Business Days</td>
                            <td style="padding:12px 15px;">Direct routes available</td>
                        </tr>
                        <tr style="border-bottom:1px solid #eee;background:#f9f9f9;">
                            <td style="padding:12px 15px;">Gulf Coast (TX, LA, MS, AL)</td>
                            <td style="padding:12px 15px;">3-5 Business Days</td>
                            <td style="padding:12px 15px;">Major port cities prioritized</td>
                        </tr>
                        <tr style="border-bottom:1px solid #eee;">
                            <td style="padding:12px 15px;">Midwest (OH, MI, IL, WI, MN, IN)</td>
                            <td style="padding:12px 15px;">4-6 Business Days</td>
                            <td style="padding:12px 15px;">Great Lakes region</td>
                        </tr>
                        <tr style="border-bottom:1px solid #eee;background:#f9f9f9;">
                            <td style="padding:12px 15px;">West Coast (CA, OR, WA)</td>
                            <td style="padding:12px 15px;">5-7 Business Days</td>
                            <td style="padding:12px 15px;">Pacific coast delivery</td>
                        </tr>
                        <tr style="border-bottom:1px solid #eee;">
                            <td style="padding:12px 15px;">Alaska & Hawaii</td>
                            <td style="padding:12px 15px;">7-14 Business Days</td>
                            <td style="padding:12px 15px;">Ocean freight may be required</td>
                        </tr>
                    </tbody>
                </table>

                <h2 style="font-size:28px;margin:30px 0 20px;">Packaging & Crating</h2>
                <p>Every remanufactured marine diesel engine is professionally packaged for safe transit:</p>
                <ul style="margin:15px 0 15px 20px;line-height:2.2;">
                    <li><strong>Custom-Built Wooden Crate:</strong> Each engine is secured in a heavy-duty wooden crate built to the engine's exact dimensions.</li>
                    <li><strong>Engine Stand or Pallet:</strong> Engines are bolted to a steel engine stand or heavy-duty pallet to prevent shifting.</li>
                    <li><strong>Protective Wrapping:</strong> VCI (Vapor Corrosion Inhibitor) wrap protects against moisture and corrosion during transit.</li>
                    <li><strong>Port Protection:</strong> All openings (intake, exhaust, oil ports) are sealed to prevent contamination.</li>
                    <li><strong>Fluid Drained:</strong> All fluids are drained per DOT shipping regulations.</li>
                </ul>

                <h2 style="font-size:28px;margin:30px 0 20px;">Delivery Options</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-top:15px;">
                    <div style="padding:20px;background:#f0f7ff;border-radius:8px;border-left:4px solid #0066cc;">
                        <strong><i class="fas fa-warehouse"></i> Commercial Address</strong><br>
                        Standard delivery to business addresses, marinas, boatyards, and repair shops. Liftgate available upon request.
                    </div>
                    <div style="padding:20px;background:#f0f7ff;border-radius:8px;border-left:4px solid #0066cc;">
                        <strong><i class="fas fa-home"></i> Residential Address</strong><br>
                        Residential delivery available with liftgate service. Additional fees may apply. Call-ahead notification included.
                    </div>
                    <div style="padding:20px;background:#f0f7ff;border-radius:8px;border-left:4px solid #0066cc;">
                        <strong><i class="fas fa-anchor"></i> Marina / Dock Delivery</strong><br>
                        We deliver directly to marinas and boatyards. Coordinate with your facility for forklift availability.
                    </div>
                    <div style="padding:20px;background:#f0f7ff;border-radius:8px;border-left:4px solid #0066cc;">
                        <strong><i class="fas fa-people-carry"></i> Will Call / Pickup</strong><br>
                        Save on shipping by picking up your engine from our facility. Call to schedule pickup time.
                    </div>
                </div>

                <h2 style="font-size:28px;margin:30px 0 20px;">Shipping Costs</h2>
                <p>Shipping costs are calculated based on engine weight, dimensions, and delivery location. Most marine diesel engines weigh between 400 and 5,000 lbs, so freight costs typically range from <strong>$300 to $1,200</strong> for continental US delivery. We provide exact shipping quotes with every engine quote. Contact us for a complete delivered price.</p>

                <h2 style="font-size:28px;margin:30px 0 20px;">Core Return Shipping</h2>
                <p>If you are participating in our core exchange program, we provide a prepaid return shipping label for your old engine core. The same crate your new engine arrived in can be used to return the core. Core must be returned within 30 days of receiving your remanufactured engine.</p>

                <h2 style="font-size:28px;margin:30px 0 20px;">International Shipping</h2>
                <p>We ship internationally to Canada, Mexico, the Caribbean, Central America, and select overseas destinations. International shipments require additional documentation and may be subject to customs duties and import taxes. Contact us for international shipping quotes and requirements.</p>

                <div style="margin-top:40px;text-align:center;padding:30px;background:#f8f9fa;border-radius:12px;">
                    <h3 style="margin-bottom:15px;">Need a Shipping Quote?</h3>
                    <p style="margin-bottom:20px;">Contact us with your zip code and engine model for an exact delivered price.</p>
                    <a href="<?= SITE_URL ?>/quote.php" class="btn btn-primary" style="margin-right:10px;">Get a Quote</a>
                    <a href="tel:8885550199" class="btn btn-outline">Call (888) 555-0199</a>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
