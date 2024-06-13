<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $smtpDetails = $_POST['smtpDetails'];
    $fromEmail = $_POST['fromEmail'];
    $replyToEmail = $_POST['replyToEmail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $contentType = $_POST['contentType'];

    // Split the SMTP details
    $smtpArray = explode('|', $smtpDetails);
    if (count($smtpArray) != 4) {
        echo "Invalid SMTP details format. Expected format: host|port|username|password";
        exit;
    }
    $host = $smtpArray[0];
    $port = $smtpArray[1];
    $username = $smtpArray[2];
    $password = $smtpArray[3];

    // Read the uploaded email list file or the textarea input
    $emailList = [];
    if (isset($_FILES['emailList']) && $_FILES['emailList']['error'] == UPLOAD_ERR_OK) {
        $emailList = file($_FILES['emailList']['tmp_name'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    } elseif (!empty($_POST['emailListTextarea'])) {
        $emailList = array_map('trim', explode("\n", $_POST['emailListTextarea']));
    } else {
        echo "No email addresses provided.";
        exit;
    }

    try {
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->SMTPDebug = 0;                                       // Disable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = $host;                                  // SMTP host
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $username;                              // SMTP username
        $mail->Password   = $password;                              // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port       = $port;                                  // TCP port

        // Sender and reply-to
        $mail->setFrom($fromEmail, 'SUPPORT');
        $mail->addReplyTo($replyToEmail, 'Information');

        // Content
        $mail->Subject = $subject;
        if ($contentType == 'text/html') {
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);
        } else {
            $mail->isHTML(false);                                 // Set email format to plain text
            $mail->Body    = $message;
        }

        // Recipients and sending the email
        foreach ($emailList as $email) {
            $mail->clearAddresses(); // Clear all addresses for new email
            $mail->addAddress(trim($email)); // Add a recipient

            // Send the email
            $mail->send();
            echo 'Message has been sent to ' . htmlspecialchars($email) . '<br>';
        }

        // Redirect back to index.php
        echo '<script>alert("Emails have been sent successfully."); window.location.href = "index.php";</script>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
