<?php
session_start();
include('../dbconnect.php'); 

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
                background: radial-gradient(circle at center, #ff4b5c, #000000);
            }
            .container {
                background: #1e1e1e;
                padding: 40px;
                border-radius: 16px;
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
                text-align: center;
                max-width: 500px;
                width: 90%;
                animation: slideIn 0.6s ease;
                color: white;
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
                color: #ccc;
                margin-top: 10px;
            }
            .countdown {
                font-weight: 700;
                font-size: 20px;
                color: #0ef05c;
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

$sql = "SELECT * FROM admin WHERE username=? AND password=?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ss", $name, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['admin_username'] = $row['username'];
    $_SESSION['admin_password'] = $row['password'];
    $_SESSION['admin_email'] = $row['email'];
    showMessage("✅ Admin Logged In Successfully!", "#0ef05c", "AdminProfile.php");
} else {
    showMessage("❌ Invalid Admin Credentials!", "#ff4b5c", "Home.php");
}

$stmt->close();
$connect->close();
?>
