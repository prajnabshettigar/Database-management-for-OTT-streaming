<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to NeonFlix</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/back.jpg'); /* Replace 'background_image.png' with your image path */
            background-size: cover;
            background-repeat: no-repeat;
            color: #fff;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(26, 26, 26, 0.8); /* Transparent gray overlay */
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 30px;
            z-index: 2;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 2;
        }
        .option {
            margin-bottom: 20px;
            font-size: 18px;
        }
        button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #ff4500;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #ff5722;
        }
        .tabs-wrapper {
            background-color: rgba(26, 26, 26, 0.8); /* Transparent gray background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }
        .tabs-container {
            display: flex;
            justify-content: center;
        }
        .tab {
            margin: 0 10px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #2a2a2a;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .tab:hover {
            background-color: #3a3a3a;
        }
        .tab.active {
            background-color: #ff4500;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="container">
            <h1>Welcome to Cinematica</h1>

            <div class="tabs-wrapper">
                <div class="tabs-container">
                    <div class="tab active" id="subscriptionTab" onclick="showTab('subscription')">Subscription</div>
                    <div class="tab" id="freeStreamingTab" onclick="showTab('free')">Free Streaming</div>
                </div>
            </div>

            <div id="subscriptionContainer" style="display: block;">
                <div class="option">
                    Subscription options go here...
                </div>
                <button onclick="submitOption('subscription')">Subscribe</button>
            </div>

            <div id="freeStreamingContainer" style="display: none;">
                <div class="option">
                    Free streaming options go here...
                </div>
                <button onclick="submitOption('free')">Start Streaming</button>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
        if (tabName === 'subscription') {
            document.getElementById('subscriptionTab').classList.add('active');
            document.getElementById('freeStreamingTab').classList.remove('active');
            document.getElementById('subscriptionContainer').style.display = 'block';
            document.getElementById('freeStreamingContainer').style.display = 'none';
        } else if (tabName === 'free') {
            document.getElementById('subscriptionTab').classList.remove('active');
            document.getElementById('freeStreamingTab').classList.add('active');
            document.getElementById('subscriptionContainer').style.display = 'none';
            document.getElementById('freeStreamingContainer').style.display = 'block';
        }
    }

    function submitOption(option) {
        if (option === "subscription") {
            window.location.href = "payment.php"; // Redirect to payment.php for subscription
        } else if (option === "free") {
            window.location.href = "catalogue.php"; // Redirect to catalog.php for free streaming
        }
    }
    </script>
</body>
</html>
