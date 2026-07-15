<?php
session_start();
include('dbconnect.php'); 

$name = $_POST['username'];
$pass = $_POST['password'];

function showMessage($message, $color, $redirectPage) {
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>TutorFinder - Login Status</title>
        <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap' rel='stylesheet'>
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background: linear-gradient(to right, #ff9a9e, #fad0c4);
            }
            .container {
                background: #ffffff;
                padding: 40px;
                border-radius: 16px;
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 500px;
                width: 90%;
                animation: slideIn 0.6s ease;
            }
            @keyframes slideIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            h1 {
                color: $color;
                font-size: 30px;
                font-weight: 700;
                margin-bottom: 20px;
            }
            p {
                font-size: 18px;
                color: #555;
                margin-top: 10px;
            }
            .countdown {
                font-weight: 700;
                font-size: 20px;
                color: #007BFF;
            }
            .loader {
                margin: 20px auto 0;
                width: 50px;
                height: 50px;
                border: 6px solid #f3f3f3;
                border-top: 6px solid $color;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>$message</h1>
            <div class='loader'></div>
            <p>Redirecting to Profile in <span id='countdown' class='countdown'>3</span> seconds...</p>
        </div>
        <script>
            let counter = 3;
            const countdownElement = document.getElementById('countdown');
            const interval = setInterval(() => {
                counter--;
                countdownElement.textContent = counter;
                if (counter === 0) {
                    clearInterval(interval);
                    window.location.href = '$redirectPage';
                }
            }, 1000);
        </script>
    </body>
    </html>
    ";
}

$sql = "SELECT * FROM tutor WHERE username=? AND password=?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ss", $name, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $_SESSION['name'] = $row['name']; // used in profile
    $_SESSION['email'] = $row['email'];             // used in ApplyTeacher
    $_SESSION['username'] = $row['username'];       // used in some other checks

    showMessage("✅ Logged In Successfully!", "#4CAF50", "TutorProfile.php");
} else {
    showMessage("❌ Invalid Username or Password!", "#FF5722", "TutorLogIn.php");
}

$stmt->close();
$connect->close();
?>
