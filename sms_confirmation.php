<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Simulate sending SMS (you would replace this with actual SMS sending logic)
$message = $_POST['message'];
$phoneList = [];
if (!empty($_FILES['phoneList']['tmp_name'])) {
    $phoneList = file($_FILES['phoneList']['tmp_name'], FILE_IGNORE_NEW_LINES);
} elseif (!empty($_POST['phoneListTextarea'])) {
    $phoneList = explode("\n", str_replace("\r", "", $_POST['phoneListTextarea']));
}

$carrier = $_POST['carrier'];
$smsSent = [];

// Simulating SMS send and creating confirmation list
foreach ($phoneList as $phone) {
    $smsSent[] = "Sent to: " . trim($phone) . "@" . $carrier;
}

// You would replace this with actual SMS sending logic and handle any errors
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            padding: 30px;
            background-color: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .container h1 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .sms-list {
            margin-top: 20px;
            padding: 10px;
            background-color: #2e2e2e;
            border-radius: 5px;
            list-style: none;
        }
        .sms-list li {
            margin-bottom: 10px;
        }
        .sms-list li:last-child {
            margin-bottom: 0;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = 'sms.php';
        }, 5000);
    </script>
</head>
<body>
    <div class="container">
        <h1>SMS Sent Successfully!</h1>
        <ul class="sms-list">
            <?php foreach ($smsSent as $sms) : ?>
                <li><?php echo htmlspecialchars($sms); ?></li>
            <?php endforeach; ?>
        </ul>
        <p class="text-center">You will be redirected back to the SMS sender in 5 seconds...</p>
    </div>
</body>
</html>
