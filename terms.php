<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Terms of Service | US Engines Production - Marine Diesel Engines';
$pageDescription = 'Terms and conditions for purchasing remanufactured marine diesel engines from US Engines Production. Core exchange, returns, and warranty terms.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDescription ?>">
    <meta name="keywords" content="terms of service marine engines, engine purchase terms, core exchange policy, marine engine return policy">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL ?>/terms.php">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $pageTitle ?>">
    <meta property="og:description" content="<?= $pageDescription ?>">
    <meta property="og:url" content="<?= SITE_URL ?>/terms.php">
    <meta property="og:site_name" content="US Engines Production - Marine Division">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Terms of Service",
        "description": "<?= $pageDescription ?>",
        "url": "<?= SITE_URL ?>/terms.php",
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
            <h1>Terms of Service</h1>
            <p>Terms & Conditions for Purchasing Remanufactured Marine Diesel Engines</p>
        </div>
    </div>

    <section class="section">
        <div class="container" style="max-width:900px;">
            <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.08);line-height:1.8;">
                
                <p style="color:#666;margin-bottom:30px;"><strong>Effective Date:</strong> July 10, 2026</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">1. Acceptance of Terms</h2>
                <p>By accessing or using the website marinedieselremanengines.com ("Website") operated by US Engines Production ("Company," "we," "our"), you agree to be bound by these Terms of Service. If you do not agree with any part of these terms, you must not use our Website or purchase our products.</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">2. Products & Services</h2>
                <p>US Engines Production specializes in the sale of remanufactured marine diesel engines. All engines listed on our Website are remanufactured units unless otherwise stated. Product descriptions, specifications, and images are provided for informational purposes and may vary slightly from the actual product. We reserve the right to modify product listings, pricing, and availability without prior notice.</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">3. Pricing & Payment</h2>
                <ul style="margin:15px 0 15px 20px;line-height:2.2;">
                    <li>All prices are listed in US Dollars (USD) and do not include shipping, handling, or applicable taxes unless explicitly stated.</li>
                    <li>Prices displayed as "Call for Price" require a direct quote from our sales team.</li>
                    <li>A deposit may be required to secure an engine order. Deposit amounts vary by engine and will be communicated at the time of purchase.</li>
                    <li>We accept payment via wire transfer, ACH, certified check, and major credit cards.</li>
                    <li>Full payment must be received before engine shipment unless prior credit arrangements have been made.</li>
                </ul>

                <h2 style="font-size:24px;margin:30px 0 15px;">4. Core Exchange Policy</h2>
                <p>Many of our remanufactured engines are sold on a <strong>core exchange basis</strong>. This means:</p>
                <ul style="margin:15px 0 15px 20px;line-height:2.2;">
                    <li>A core deposit (typically $500 - $3,000 depending on engine model) is charged at the time of purchase.</li>
                    <li>The core deposit is refunded when your old engine (the "core") is returned to us in rebuildable condition.</li>
                    <li>Cores must be returned within <strong>30 days</strong> of receiving your remanufactured engine.</li>
                    <li>Cores must be complete (block, head, crank, cam) and free of catastrophic damage (cracked block, spun main bearing bores, fire damage).</li>
                    <li>Cores that are incomplete or damaged beyond rebuildable condition may receive a partial refund or no refund at our discretion.</li>
                    <li>We provide a prepaid return shipping label for core returns within the continental US.</li>
                </ul>

                <h2 style="font-size:24px;margin:30px 0 15px;">5. Shipping & Delivery</h2>
                <p>Please refer to our <a href="<?= SITE_URL ?>/shipping.php" style="color:#0066cc;">Shipping Policy</a> page for detailed information about shipping methods, timelines, and costs. Key points:</p>
                <ul style="margin:15px 0 15px 20px;line-height:2.2;">
                    <li>Risk of loss and title transfer to the buyer upon delivery to the carrier.</li>
                    <li>Buyer is responsible for inspecting the shipment upon delivery and noting any visible damage on the carrier's delivery receipt.</li>
                    <li>Concealed damage must be reported within 48 hours of delivery.</li>
                    <li>Shipping damage claims are filed with the carrier; we will assist in the claims process.</li>
                </ul>

                <h2 style="font-size:24px;margin:30px 0 15px;">6. Warranty</h2>
                <p>All remanufactured marine diesel engines sold by US Engines Production come with a <strong>1-Year Unlimited Hours Warranty</strong>. Please refer to our <a href="<?= SITE_URL ?>/warranty.php" style="color:#0066cc;">Warranty Information</a> page for complete terms, conditions, and claim procedures.</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">7. Returns & Cancellations</h2>
                <ul style="margin:15px 0 15px 20px;line-height:2.2;">
                    <li><strong>Before Shipment:</strong> Orders may be cancelled before shipment for a full refund of the engine purchase price. Custom-built engines (non-stock configurations) may be subject to a 15% restocking fee.</li>
                    <li><strong>After Delivery:</strong> Engines may be returned within 30 days of delivery if unused, uninstalled, and in original packaging. Buyer is responsible for return shipping costs. A 20% restocking fee applies.</li>
                    <li><strong>Installed Engines:</strong> Once an engine has been installed, it cannot be returned. Warranty coverage applies for defects.</li>
                    <li><strong>Refund Processing:</strong> Refunds are processed within 5-10 business days of receiving the returned engine and confirming its condition.</li>
                </ul>

                <h2 style="font-size:24px;margin:30px 0 15px;">8. Limitation of Liability</h2>
                <p>To the maximum extent permitted by law, US Engines Production shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from the purchase or use of our products. This includes, but is not limited to, loss of revenue, lost profits, loss of use of the vessel, haul-out costs, towing charges, marina fees, or any other economic losses. Our total liability shall not exceed the purchase price of the engine.</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">9. Disclaimer</h2>
                <p>While we strive for accuracy, the information on our Website (including specifications, horsepower ratings, and compatibility information) is provided "as is" without warranty of any kind. We recommend consulting with a qualified marine mechanic to confirm engine compatibility with your specific vessel before purchasing.</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">10. Intellectual Property</h2>
                <p>All content on this Website, including text, images, logos, and design elements, is the property of US Engines Production and is protected by copyright law. Brand names and model numbers (Cummins, Caterpillar, Detroit Diesel, Volvo Penta, Yanmar, etc.) are trademarks of their respective owners and are used for identification purposes only. US Engines Production is an independent remanufacturer and is not affiliated with or endorsed by these manufacturers.</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">11. Governing Law</h2>
                <p>These Terms of Service shall be governed by and construed in accordance with the laws of the State of New York, without regard to its conflict of law provisions. Any disputes arising from these terms or your use of our products shall be resolved in the courts located in New York.</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">12. Changes to Terms</h2>
                <p>We reserve the right to modify these Terms of Service at any time. Changes become effective immediately upon posting to the Website. Your continued use of the Website after changes are posted constitutes acceptance of the modified terms.</p>

                <h2 style="font-size:24px;margin:30px 0 15px;">13. Contact Information</h2>
                <p>For questions about these Terms of Service, please contact us:</p>
                <div style="padding:20px;background:#f8f9fa;border-radius:8px;margin-top:15px;">
                    <p style="margin:5px 0;"><strong>US Engines Production - Marine Division</strong></p>
                    <p style="margin:5px 0;"><i class="fas fa-envelope"></i> info@marinedieselremanengines.com</p>
                    <p style="margin:5px 0;"><i class="fas fa-phone"></i> (888) 555-0199</p>
                    <p style="margin:5px 0;"><i class="fas fa-globe"></i> marinedieselremanengines.com</p>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/templates/footer.php'; ?>
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
