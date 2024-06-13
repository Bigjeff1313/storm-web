<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Sender</title>
    <link rel="stylesheet" href="storm.css">
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
        }
        .results {
            background-color: #1e1e1e;
            color: #e0e0e0;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            white-space: pre-line;
            height: 200px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <div class="allcarsmoving">
        <div>
           <h1 class="allcars">STORM-WEB-BULK-EMAIL-SENDER</h1>
        </div>
    </div>
    <div class="blancbox"></div>
    <div class="container">
        <div class="containers">
            <div class="box">
                <div class="card" id="front"><img class="jeffsms" src="picture/jeff sms.jpg" alt=""></div>
                <div class="card" id="back"><img class="jeffsms" src="picture/jeff sms.jpg" alt=""></div>
                <div class="card" id="right"><img class="jeffsms" src="picture/jeff sms.jpg" alt=""></div>
                <div class="card" id="left"><img class="jeffsms" src="picture/jeff sms.jpg" alt=""></div>
                <div class="card" id="top"><img class="jeffsms" src="picture/jeff sms.jpg" alt=""></div>
                <div class="card" id="bottom"><img class="jeffsms" src="picture/jeff sms.jpg" alt=""></div>
            </div>
        </div>
        <div class="logo">
            <img src="picture/jeff sms.jpg" alt="STORM-MAILER">
        </div>
        <h1>STORM-WEB-BULK-EMAIL-SENDER</h1>
        <form action="send_email.php" method="post" enctype="multipart/form-data">
            <div class="form-section">
                <h2>SMTP Configuration</h2>
                <label for="smtpDetails">SMTP Details (format: host|port|username|password):</label>
                <input type="text" id="smtpDetails" name="smtpDetails" placeholder="smtp.example.com|587|user@example.com|password" required>
            </div>

            <div class="form-section">
                <h2>Email Details</h2>
                <label for="fromEmail">Sender Email:</label>
                <input type="email" id="fromEmail" name="fromEmail" required>

                <label for="replyToEmail">Reply-To Email:</label>
                <input type="email" id="replyToEmail" name="replyToEmail" required>

                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="10" required></textarea>
            </div>

            <div class="form-section">
                <h2>Recipient Emails</h2>
                <label for="emailList">Upload Email List:</label>
                <input type="file" id="emailList" name="emailList" accept=".txt">
                <div class="alternate-input">
                    <span>OR</span>
                </div>
                <label for="emailListTextarea">Enter Email Addresses:</label>
                <textarea id="emailListTextarea" name="emailListTextarea" rows="5" placeholder="Enter email addresses, one per line"></textarea>
            </div>

            <div class="form-section">
                <h2>Email Format</h2>
                <label for="contentType">Content Type:</label>
                <select id="contentType" name="contentType" required>
                    <option value="text/plain">Plain Text</option>
                    <option value="text/html">HTML</option>
                </select>
            </div>

            <input type="submit" value="Send Email">
        </form>
    </div>
</body>
</html>
