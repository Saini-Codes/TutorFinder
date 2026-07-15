<html>
<head>
    <title>OTP Verification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        h2 {
            color: #ff4b5c;
            margin-bottom: 20px;
        }

        .message {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .success {
            color: #0ef05c;
        }

        .error {
            color: #ff4b5c;
        }

        .otp-input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .verify-btn {
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

        .verify-btn:hover {
            background: #d43f50;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            color: #555;
            font-size: 14px;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

        <div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
    <a href="Main.php" style="
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg,rgb(253, 7, 7),rgb(255, 86, 81));
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 8px 16px;
        text-decoration: none;
        color: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
        <img src="Images/Back.png" alt="Back" style="height: 20px; margin-right: 10px;">
        Back to Home
    </a>
</div>

    <div class="container">
        <?php
        date_default_timezone_set('Asia/Kolkata');
        session_start();
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'NecessaryFiles/vendor/autoload.php';


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

        if(isset($_SESSION['pfpName']) && isset($_SESSION['pfpDir'])) {
            $pfpName = $_SESSION['pfpName'];
            $pfpDir = $_SESSION['pfpDir'];
        } else {
            echo "<p class='message error'>Profile picture not uploaded.</p>";
            exit;
        }

      

        $confirm = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_otp = $_POST['otp'];
            if (isset($_SESSION['otp'], $_SESSION['otp_expiry']) && time() < $_SESSION['otp_expiry']) {
                if ($user_otp == $_SESSION['otp']) {
                    $confirm = true;
                    unset($_SESSION['otp'], $_SESSION['otp_expiry']);
                    echo "<center>
                    <h2 style='color: green; font-size: 24px; font-weight: bold;'> OTP Verified Successfully! Registration Completed.</h2>
                    <p style='font-size: 18px; color: #444; margin-bottom: 20px;'>You can now log in using your credentials sent to $email.</p>
                    <a href='StudentLogIn.php' style='display: inline-block; padding: 15px 30px; font-size: 20px; color: white; background-color: #d9534f; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.3s; box-shadow: 2px 2px 10px rgba(0,0,0,0.2);'>
                         Go To Log In Page
                    </a>
                  </center>";
                } else {
                    echo "<p class='message error'>Invalid OTP!</p>";
                }
            } else {
                echo "<p class='message error'>OTP Expired! <a href='StudentRegistrationSubmitOTP.php' class='back-link'>Request a new one</a></p>";
            }
        }

        if ($confirm) {
            include('dbconnect.php');
            $sql = "INSERT INTO student(name,street , city, zip,district,state, email, phone, gender,semester,profilepic,profiledir, username, password,latitude, longitude) 
                    VALUES('$name', '$street', '$city', '$zip','$dist','$state', '$email', '$phone', '$gender', '$sem', '$pfpName', '$pfpDir','$loginusername', '$loginpassword',  '$latitude', '$longitude')";
            if ($connect->query($sql) === false) {
                echo "<p class='message error'>Error: Unable to insert record.</p>";
            }

             $mail = new PHPMailer(true);
    try {

        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tutor.finder.js@gmail.com';  
        $mail->Password   = 'fhtfncpjiypqvqud';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('tutor.finder.js@gmail.com', 'TutorFinder');
        $mail->addAddress($email);
        $mail->Subject = 'You are Verified !!';
        
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
        <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
    <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
        <h2 style='color: #fff; margin: 0;'>Your Log In Credentials </h2>
        </div>
        <div style='padding: 20px; background-color:rgb(0, 0, 0);'>
            <p style='font-size: 18px; color: #0ef0e5;'>Your Username:</p>
            <p style='font-size: 18px; color: white; font-weight: bold;'> $loginusername </p>
            <p style='font-size: 18px; color: #0ef0e5;'>Your Password:</p>
            <p style='font-size: 18px; color: white; font-weight: bold;'> $loginpassword </p>
        </div>                  
    <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
        <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
    </div>
</div>";
    
        $mail->send();
    } catch (Exception $e) {
        echo "<h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
    }

        }
        ?>
    </div>
</body>
</html>
