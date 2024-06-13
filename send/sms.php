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
        .send-button {
            background-color: red;
            color: white;
            font-size: 20px; /* Increase the font size for better visibility */
            padding: 15px 30px; /* Increase padding for a larger button */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="logo.jpg" alt="STORM-MAILER">
        </div>
        <h1>STORM-WEB-BULK-SMS-SENDER</h1>
        <form id="smsForm" method="post" enctype="multipart/form-data">
            <div class="form-section">
                <h2>SMTP Configuration</h2>
                <label for="smtpDetails">SMTP Details (format: host|port|username|password):</label>
                <input type="text" id="smtpDetails" name="smtpDetails" placeholder="smtp.example.com|587|user@example.com|password" required>
            </div>
            <div class="form-section">
                <h2>Email Details</h2>
                <label for="fromEmail">Sender Email:</label>
                <input type="email" id="fromEmail" name="fromEmail" required>
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-section">
                <h2>SMS Details</h2>
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="10" required></textarea>
            </div>
            <div class="form-section">
                <h2>Phone Numbers</h2>
                <label for="carrier">Carrier:</label>
                <select id="carrier" name="carrier" required>
                    <option value="vtext.com">Verizon</option>
                    <option value="txt.att.net">AT&T</option>
                    <option value="messaging.sprintpcs.com">Sprint</option>
                    <option value="tmomail.net">T-Mobile</option>
                    <option value="numbersWithDomain">Numbers with Domain</option>
                </select>
                <label for="phoneList">Upload phone list:</label>
                <input type="file" id="phoneList" name="phoneList" accept=".txt">
                <div class="alternate-input">or</div>
                <label for="phoneListTextarea">Enter phone numbers (one per line):</label>
                <textarea id="phoneListTextarea" name="phoneListTextarea" rows="10"></textarea>
            </div>
            <input type="button" class="send-button" value="Send SMS" onclick="sendSMS();">
        </form>
        <div id="results" class="results"></div>
    </div>
    <script>
        function sendSMS() {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = "Message sending, please wait!!\n\n";
            const form = document.getElementById('smsForm');
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_sms.php', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Set X-Requested-With header for AJAX detection
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resultsDiv.innerHTML += xhr.responseText + '\n';
                    resultsDiv.scrollTop = resultsDiv.scrollHeight;
                    if (xhr.responseText.trim() === 'All messages sent successfully.') {
                        setTimeout(() => {
                            window.location.href = 'sms_confirmation.php';
                        }, 2000);
                    }
                }
            };
            xhr.send(formData);
        }
    </script>
</body>
</html>
