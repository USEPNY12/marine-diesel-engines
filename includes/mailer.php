<?php
/**
 * US Engines Production - Marine Division
 * PHPMailer SMTP Configuration
 * 
 * UPDATE THESE SETTINGS WITH YOUR SMTP CREDENTIALS:
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/phpmailer/PHPMailer.php';
require __DIR__ . '/../vendor/phpmailer/SMTP.php';
require __DIR__ . '/../vendor/phpmailer/Exception.php';

// ============================================================
// SMTP CONFIGURATION - UPDATE THESE VALUES
// ============================================================
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.yourdomain.com');      // Your SMTP server
define('SMTP_PORT', getenv('SMTP_PORT') ?: 587);                         // 587 for TLS, 465 for SSL
define('SMTP_USERNAME', getenv('SMTP_USERNAME') ?: 'your-email@yourdomain.com');  // SMTP username
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD') ?: 'your-smtp-password');         // SMTP password
define('SMTP_ENCRYPTION', getenv('SMTP_ENCRYPTION') ?: 'tls');           // 'tls' or 'ssl'
define('MAIL_FROM_EMAIL', getenv('MAIL_FROM') ?: 'noreply@marinedieselremanengines.com');  // From email
define('MAIL_FROM_NAME', 'US Engines Production - Marine Division');
define('MAIL_TO_EMAIL', getenv('MAIL_TO') ?: 'eric@usepny.com');         // Where to receive notifications
// ============================================================

/**
 * Send an email using PHPMailer SMTP
 * 
 * @param string $to Recipient email
 * @param string $subject Email subject
 * @param string $htmlBody HTML email body
 * @param string $plainBody Plain text fallback (optional)
 * @param string|null $replyTo Reply-to email (optional)
 * @param string|null $replyToName Reply-to name (optional)
 * @return array ['success' => bool, 'message' => string]
 */
function sendEmail($to, $subject, $htmlBody, $plainBody = '', $replyTo = null, $replyToName = null) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
        $mail->addAddress($to);

        if ($replyTo) {
            $mail->addReplyTo($replyTo, $replyToName ?? '');
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->AltBody = $plainBody ?: strip_tags($htmlBody);

        $mail->send();
        return ['success' => true, 'message' => 'Email sent successfully'];
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        return ['success' => false, 'message' => "Email could not be sent. Error: {$mail->ErrorInfo}"];
    }
}

/**
 * Send a quote request notification
 */
function sendQuoteNotification($quoteData) {
    $subject = "New Quote Request: {$quoteData['name']} - {$quoteData['engine']}";
    
    $html = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <div style='background: #0a1628; color: white; padding: 20px; text-align: center;'>
            <h1 style='margin: 0; color: #00bcd4;'>New Quote Request</h1>
            <p style='margin: 5px 0 0; color: #ccc;'>Marine Diesel Remanufactured Engines</p>
        </div>
        <div style='padding: 20px; background: #f9f9f9;'>
            <table style='width: 100%; border-collapse: collapse;'>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Name:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$quoteData['name']}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Email:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$quoteData['email']}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Phone:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$quoteData['phone']}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Engine:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$quoteData['engine']}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>VIN/HIN:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>" . ($quoteData['vin'] ?? 'N/A') . "</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Message:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$quoteData['message']}</td></tr>
            </table>
        </div>
        <div style='background: #0a1628; color: #999; padding: 15px; text-align: center; font-size: 12px;'>
            <p>This notification was sent from marinedieselremanengines.com</p>
        </div>
    </div>";

    return sendEmail(MAIL_TO_EMAIL, $subject, $html, '', $quoteData['email'], $quoteData['name']);
}

/**
 * Send a contact form notification
 */
function sendContactNotification($contactData) {
    $subject = "New Contact Message: {$contactData['name']} - {$contactData['subject']}";
    
    $html = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <div style='background: #0a1628; color: white; padding: 20px; text-align: center;'>
            <h1 style='margin: 0; color: #00bcd4;'>New Contact Message</h1>
            <p style='margin: 5px 0 0; color: #ccc;'>Marine Diesel Remanufactured Engines</p>
        </div>
        <div style='padding: 20px; background: #f9f9f9;'>
            <table style='width: 100%; border-collapse: collapse;'>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Name:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$contactData['name']}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Email:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$contactData['email']}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Phone:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>" . ($contactData['phone'] ?? 'N/A') . "</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Subject:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$contactData['subject']}</td></tr>
                <tr><td style='padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;'>Message:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$contactData['message']}</td></tr>
            </table>
        </div>
        <div style='background: #0a1628; color: #999; padding: 15px; text-align: center; font-size: 12px;'>
            <p>This notification was sent from marinedieselremanengines.com</p>
        </div>
    </div>";

    return sendEmail(MAIL_TO_EMAIL, $subject, $html, '', $contactData['email'], $contactData['name']);
}
