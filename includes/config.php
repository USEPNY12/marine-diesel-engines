<?php
/**
 * US Engines Production - Marine Diesel Engines Website
 * Configuration File
 */

// Database Configuration (uses environment variables for Docker, falls back to defaults)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'marine_engines_db');
define('DB_USER', getenv('DB_USER') ?: 'marine_user');
define('DB_PASS', getenv('DB_PASS') ?: 'MarineEngines2026!');

// Site Configuration - Auto-detect URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'marinedieselremanengines.com';
$detectedUrl = $protocol . '://' . $host;
define('SITE_URL', $detectedUrl);
define('SITE_NAME', 'US Engines Production - Marine Division');
define('ADMIN_URL', SITE_URL . '/admin');

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('UPLOAD_URL', SITE_URL . '/assets/uploads/');
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB

// Session Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Database Connection with retry for Docker startup
$maxRetries = 10;
$retryDelay = 3;
$pdo = null;

for ($i = 0; $i < $maxRetries; $i++) {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        break;
    } catch (PDOException $e) {
        if ($i === $maxRetries - 1) {
            die("Database connection failed: " . $e->getMessage());
        }
        sleep($retryDelay);
    }
}

// Helper Functions
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

function getSetting($key) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    return $result ? $result['setting_value'] : '';
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . ADMIN_URL . '/login.php');
        exit;
    }
}

function formatPrice($price) {
    return '$' . number_format($price, 2);
}

function getActivePromotions($location = 'all') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM promotions WHERE is_active = 1 AND (display_location = ? OR display_location = 'all') AND (start_date IS NULL OR start_date <= CURDATE()) AND (end_date IS NULL OR end_date >= CURDATE()) ORDER BY id DESC");
    $stmt->execute([$location]);
    return $stmt->fetchAll();
}
