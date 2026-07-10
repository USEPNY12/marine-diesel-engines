<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>US Engines Production</h4>
                <p>America's premier supplier of remanufactured marine diesel engines. Every major brand, every model, built to exceed OEM specifications.</p>
                <div class="footer-contact">
                    <p><i class="fas fa-phone"></i> <?= getSetting('site_phone') ?: '(888) 555-0199' ?></p>
                    <p><i class="fas fa-envelope"></i> <?= getSetting('site_email') ?: 'info@usengineproduction.com' ?></p>
                </div>
            </div>
            <div class="footer-col">
                <h4>Popular Brands</h4>
                <ul>
                    <li><a href="<?= SITE_URL ?>/category.php?slug=cummins">Cummins Marine</a></li>
                    <li><a href="<?= SITE_URL ?>/category.php?slug=caterpillar">Caterpillar Marine</a></li>
                    <li><a href="<?= SITE_URL ?>/category.php?slug=detroit-diesel">Detroit Diesel Marine</a></li>
                    <li><a href="<?= SITE_URL ?>/category.php?slug=volvo-penta">Volvo Penta</a></li>
                    <li><a href="<?= SITE_URL ?>/category.php?slug=yanmar">Yanmar Marine</a></li>
                    <li><a href="<?= SITE_URL ?>/category.php?slug=man">MAN Marine</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Engine Types</h4>
                <ul>
                    <li><a href="<?= SITE_URL ?>/products.php?type=marine_propulsion">Marine Propulsion</a></li>
                    <li><a href="<?= SITE_URL ?>/products.php?type=marine_auxiliary">Marine Auxiliary</a></li>
                    <li><a href="<?= SITE_URL ?>/products.php?type=marine_generator">Marine Generators</a></li>
                    <li><a href="<?= SITE_URL ?>/products.php?type=industrial">Industrial Diesel</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?= SITE_URL ?>/about.php">About Us</a></li>
                    <li><a href="<?= SITE_URL ?>/quote.php">Request a Quote</a></li>
                    <li><a href="<?= SITE_URL ?>/warranty.php">Warranty Information</a></li>
                    <li><a href="<?= SITE_URL ?>/shipping.php">Shipping Policy</a></li>
                    <li><a href="<?= SITE_URL ?>/blog.php">Blog & Resources</a></li>
                    <li><a href="<?= SITE_URL ?>/contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p><?= getSetting('footer_text') ?: '© 2026 US Engines Production. All Rights Reserved.' ?></p>
            <div class="footer-links">
                <a href="<?= SITE_URL ?>/privacy.php">Privacy Policy</a>
                <a href="<?= SITE_URL ?>/terms.php">Terms of Service</a>
                <a href="<?= SITE_URL ?>/sitemap.php">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
<div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
