<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Set SSE headers
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $smtpDetails = $_POST['smtpDetails'];
    $fromEmail = $_POST['fromEmail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Split the SMTP details
    $smtpArray = explode('|', $smtpDetails);
    if (count($smtpArray) != 4) {
        echo "Invalid SMTP details format. Expected format: host|port|username|password\n\n";
        exit;
    }
    $host = $smtpArray[0];
    $port = $smtpArray[1];
    $username = $smtpArray[2];
    $password = $smtpArray[3];

    // Read the uploaded phone list file or the textarea input
    $phoneList = [];
    if (isset($_FILES['phoneList']) && $_FILES['phoneList']['error'] == UPLOAD_ERR_OK) {
        $phoneList = file($_FILES['phoneList']['tmp_name'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    } elseif (!empty($_POST['phoneListTextarea'])) {
        $phoneList = array_map('trim', explode("\n", $_POST['phoneListTextarea']));
    } else {
        echo "No phone numbers provided.\n\n";
        exit;
    }

    $carrierDomain = $_POST['carrier'];

    // Function to sanitize phone numbers
    function sanitizePhoneNumber($phone) {
        // Remove any spaces, dashes, parentheses, and the +1 prefix
        $phone = preg_replace('/[^0-9]/', '', $phone); // Remove all non-numeric characters
        if (substr($phone, 0, 2) === '01') {
            $phone = substr($phone, 2);
        } elseif (substr($phone, 0, 1) === '1') {
            $phone = substr($phone, 1);
        }
        return $phone;
    }

    if ($carrierDomain !== 'numbersWithDomain') {
        $phoneList = array_map('sanitizePhoneNumber', $phoneList);
    }

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $port;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom($fromEmail);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->isHTML(false);

        foreach ($phoneList as $phone) {
            if ($carrierDomain === 'numbersWithDomain') {
                $emailAddress = trim($phone);
            } else {
                $emailAddress = trim($phone) . '@' . $carrierDomain;
            }

            $mail->clearAddresses();
            $mail->addAddress($emailAddress);

            try {
                $mail->send();
                echo "Message has been sent to " . htmlspecialchars($emailAddress) . "\n\n";
                flush();
            } catch (Exception $e) {
                echo "Failed to send message to " . htmlspecialchars($emailAddress) . ". Error: " . $mail->ErrorInfo . "\n\n";
                flush();
            }
        }

        echo "All messages sent successfully.\n\n";
        flush();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n\n";
        flush();
    }
} else {
    echo "Invalid request method.\n\n";
    exit;
}
?>
