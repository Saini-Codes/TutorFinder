<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['name'])) {
    header("Location: TutorLogIn.php");
    exit();
}

$username = $_SESSION['username'];


// Get all form values
$name = $_POST['name'];
$gender = $_POST['gender'];
$street = $_POST['street'];
$city = $_POST['city'];
$pin = $_POST['pin'];
$district = $_POST['district'];
$state = $_POST['state'];
$phone = $_POST['phone'];
$sub1 = $_POST['subject1'];
$fees1 = $_POST['fees1'];
$sub2 = $_POST['subject2'];
$fees2 = $_POST['fees2'];
$sub3 = $_POST['subject3'];
$fees3 = $_POST['fees3'];
$qualifications = $_POST['qualifications'];
$profession = $_POST['profession'];

// Update query
$sql = "UPDATE tutor SET name=?, gender=?, street=?, city=?, pin=?, district=?, state=?, phone=?, subject1=?, subject2=?, subject3=?, fees1=?, fees2=?, fees3=?, qualifications=?, profession=? WHERE username=?";
$stmt = $connect->prepare($sql);
$stmt->bind_param(
    "sssssssssssssssss",
    $name, $gender, $street, $city, $pin, $district, $state, $phone,
    $sub1, $sub2, $sub3, $fees1, $fees2, $fees3, $qualifications, $profession, $username
);

$success = $stmt->execute();
$message = $success ? "✅ Profile updated successfully!" : "❌ Failed to update profile!";
$color = $success ? "#28a745" : "#dc3545";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Updating Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .message-box {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            text-align: center;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 24px;
            color: <?= $color ?>;
            margin-bottom: 15px;
        }

        .countdown {
            font-size: 16px;
            color: #555;
            margin-top: 10px;
        }

        .loader {
            margin: 25px auto 0;
            width: 45px;
            height: 45px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid <?= $color ?>;
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
    <div class="message-box">
        <h1><?= $message ?></h1>
        <div class="loader"></div>
        <p class="countdown">Redirecting in <span id="timer">3</span> seconds...</p>
    </div>

    <script>
        let seconds = 3;
        const timer = document.getElementById("timer");
        const interval = setInterval(() => {
            seconds--;
            timer.textContent = seconds;
            if (seconds === 0) {
                clearInterval(interval);
                window.location.href = "TutorProfile.php";
            }
        }, 1000);
    </script>
</body>
</html>
