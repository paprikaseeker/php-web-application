<?php
session_start();
require_once 'config.php';
require_once 'databaselogin.php';
require_once 'security.php';

// Include PHPMailer classes directly
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['fname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $csrf_token = $_POST['csrf_token'] ?? null;

    // Validate CSRF token
    if (!$csrf_token || !validateCSRFToken($csrf_token)) {
        echo json_encode(["success" => false, "message" => "Invalid security token"]);
        exit;
    }

    $result = $db->saveContactMessage($firstName, $email, $message);

    if ($result['success']) {
        // Send email notification using PHPMailer with ABV.bg SMTP
        $mail = new PHPMailer(true);

        try {
            // Server settings - ABV.bg SMTP
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD; // Loaded from .env file
            $mail->SMTPSecure = 'ssl';
            $mail->Port = SMTP_PORT;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Recipients
            $mail->setFrom(SMTP_USERNAME, SITE_NAME);
            $mail->addAddress(ADMIN_EMAIL);
            $mail->addReplyTo($email, $firstName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Contact Form Message - ' . SITE_NAME;

            $emailMessage = "
            <html>
            <head>
                <title>New Contact Message</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .header { background-color: #B77724; color: white; padding: 10px; }
                    .content { padding: 20px; }
                    .message { background-color: #f9f9f9; padding: 15px; border-left: 4px solid #B77724; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <h2>New Contact Form Submission</h2>
                </div>
                <div class='content'>
                    <p><strong>From:</strong> {$firstName}</p>
                    <p><strong>Email:</strong> {$email}</p>
                    <p><strong>Message:</strong></p>
                    <div class='message'>" . nl2br(htmlspecialchars($message)) . "</div>
                    <hr>
                    <p><em>This message was sent from the " . SITE_NAME . " contact form.</em></p>
                </div>
            </body>
            </html>
            ";

            $mail->Body = $emailMessage;
            $mail->AltBody = strip_tags(str_replace('<br>', "\n", $emailMessage));

            $mail->send();
            $_SESSION['contact_success'] = $result['message'] . ' Email notification sent successfully!';
        } catch (Exception $e) {
            $_SESSION['contact_success'] = $result['message'] . ' (Note: Email notification failed: ' . $mail->ErrorInfo . ')';
        }
    } else {
        $_SESSION['contact_error'] = $result['message'];
        // Preserve form data for re-display
        $_SESSION['contact_form_data'] = [
            'fname' => $firstName,
            'email' => $email,
            'message' => $message
        ];
    }

    // Redirect back to contact page
    header('Location: ../contact.php');
    exit();
} else {
    // If not POST, redirect to contact page
    header('Location: ../contact.php');
    exit();
}
?>