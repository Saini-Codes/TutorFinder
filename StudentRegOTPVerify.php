<?php
session_start();
$otp_expiry_time = isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] : time();
$remaining_time = max(0, $otp_expiry_time - time()); // Calculate remaining time in seconds
?>
<html>
<head>
    <title>OTP Verification</title>
    <script>
        function startTimer(duration) {
            let timer = duration, minutes, seconds;
            let countdownElement = document.getElementById('countdown');
            let otpInput = document.getElementById('otp');
            let submitBtn = document.getElementById('submitBtn');
            let interval = setInterval(function () {
                minutes = Math.floor(timer / 60);
                seconds = timer % 60;
                countdownElement.textContent = `Time left: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                if (--timer < 0) {
                    clearInterval(interval);
                    countdownElement.textContent = "OTP Expired!";
                    otpInput.disabled = true;
                    submitBtn.disabled = true;
                }
            }, 1000);
        }
        window.onload = function () {
            let remainingTime = <?php echo $remaining_time; ?>;
            startTimer(remainingTime);
        };
    </script>
</head>
<body>
    <div class="otp-container">
        <h2>OTP Verification</h2>

        <?php
        $name = $_SESSION["name"];
        $street = $_SESSION["street"];
        $city = $_SESSION["city"];
        $zip = $_SESSION["zip"];
        $dist = $_SESSION["dist"];
        $state = $_SESSION["state"];
        $email = $_SESSION["email"];
        $gender = $_SESSION["gender"];
        $phone = $_SESSION["phone"];
        $sem = $_SESSION["sem"];
        $loginusername = $_SESSION["loginusername"];
        $loginpassword = $_SESSION["loginpassword"];
        $pfpName = $_SESSION["pfpName"];
        $pfpDir = $_SESSION["pfpDir"];
        $latitude = $_SESSION["latitude"];
        $longitude = $_SESSION["longitude"];
        ?>

        <p class="otp-info">A verification code has been sent to <strong><?php echo htmlspecialchars($email); ?></strong></p>
        <p id="countdown" class="otp-timer">OTP expires in: <span id="timer">120</span> seconds</p>

        <form action="StudentRegOTPVerifySubmit.php" method="POST">
            <div class="input-group">
                <input type="text" id="otp" name="otp" class="otp-input" required placeholder="Enter OTP">
            </div>
            <button type="submit" class="otp-btn" id="submitBtn">Verify OTP</button>
        </form>
    </div>

    <script>
        let timeLeft = 120;
        const timerDisplay = document.getElementById("timer");

        const countdown = setInterval(() => {
            timeLeft--;
            timerDisplay.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerDisplay.textContent = "Expired!";
                document.getElementById("submitBtn").disabled = true;
                document.getElementById("submitBtn").classList.add("disabled");
            }
        }, 1000);
    </script>

    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .otp-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        .otp-container h2 {
            color: #ff4b5c;
            margin-bottom: 15px;
        }

        .otp-info {
            color: #555;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .otp-timer {
            color: #ff4b5c;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            background: #f9f9f9;
        }

        .otp-input {
            border: none;
            outline: none;
            flex: 1;
            background: transparent;
            font-size: 16px;
            padding: 5px;
            text-align: center;
        }

        .otp-btn {
            background: #ff4b5c;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .otp-btn:hover {
            background: #d43f50;
        }

        .otp-btn.disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</body>

</html>



