<!DOCTYPE html>
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
    <div class="container">
        <?php
        date_default_timezone_set('Asia/Kolkata');
        session_start();
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        require 'NecessaryFiles/vendor/autoload.php';

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $name = $_SESSION["name"];
        $street = $_SESSION["street"];
        $city = $_SESSION["city"];
        $zip = $_SESSION["zip"];
        $dist = $_SESSION["dist"];
        $state = $_SESSION["state"];
        $email = $_SESSION["email"];
        $gender = $_SESSION["gender"];
        $phone = $_SESSION["phone"];
        $sub1 = $_SESSION["sub1"];
        $sub2 = $_SESSION["sub2"];
        $sub3 = $_SESSION["sub3"];
        $fees1 = $_SESSION["fees1"];
        $fees2 = $_SESSION["fees2"];
        $fees3 = $_SESSION["fees3"];
        $qualifications = $_SESSION["qualifications"];
        $profession = $_SESSION["profession"];
        $logoName = $_SESSION['logoName'];
        $cvName = $_SESSION['cvName'];
        $logoDir = $_SESSION['logoDir'];
        $cvDir =  $_SESSION['cvDir'];
        $loginusername = $_SESSION["loginusername"];
        $loginpassword = $_SESSION["loginpassword"];
        $latitude = $_SESSION["latitude"];
        $longitude = $_SESSION["longitude"];
        $confirm = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_otp = $_POST['otp'];
            if (isset($_SESSION['otp'], $_SESSION['otp_expiry']) && time() < $_SESSION['otp_expiry']) {
                if ($user_otp == $_SESSION['otp']) {
                    $confirm = true;
                    unset($_SESSION['otp'], $_SESSION['otp_expiry']);
                    echo "<center>
                    <h2 style='color: green; font-size: 24px; font-weight: bold;'> OTP Verified Successfully! Registration Completed.</h2>
                    <p style='font-size: 18px; color: #444; margin-bottom: 20px;'>Keep Checking Your Mail For Admin Approval.</p>
                    </center>";
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
                        $mail->Subject = 'Important Notice';
                        $mail->Body = "
                        <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
                            <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
                            <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                                <h2 style='color: #fff; margin: 0;'>NOTIFICATION</h2>
                            </div>
                            <div style='padding: 20px; background-color: black;'>
                                <div style='background-color:rgba(95, 7, 95, 1);  padding: 15px; border-radius: 10px; margin-top: 20px;'>
                                   <h2 style='font-size: 24px; color:rgb(233, 32, 25); margin: 10px 0;'>Welcome Teacher - </h2><h2 style='font-size: 24px; color: #0ef0e5;; margin: 10px 0;'>$name,</h2>
                                    <p style='font-size: 18px; color: rgb(255, 255, 255);'>You have successfully registered on <strong>TutorFinder</strong>.</p>
                                    <p style='font-size: 18px; color:rgb(255, 255, 255);'> Our Team will review your details and notify you once your profile is approved.</p>
                                    <p style='font-size: 18px; color: #0ef0e5;'>Thank You for joining us!</p>
                                </div>
                            </div>
                            <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
                                <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
                            </div>  
                        </div>";
                        $mail->send();
                    } catch (Exception $e) {
                        echo "<h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
                    }

                    if ($confirm) {
                        include('dbconnect.php');
                        $sql = "INSERT INTO tutor_waitlist (name, street, city, pin, district, state, email, phone, gender, subject1, subject2, subject3,fees1,fees2,fees3,qualifications,profession,logo,cv,logoDir,cvDir, username, password,latitude,longitude) VALUES ('$name', '$street', '$city', '$zip', '$dist', '$state', '$email', '$phone', '$gender', '$sub1', '$sub2', '$sub3','$fees1', '$fees2', '$fees3', '$qualifications','$profession','$logoName', '$cvName','$logoDir','$cvDir', '$loginusername', '$loginpassword','$latitude','$longitude')";
                             if ($connect->query($sql) === false) {
                                  echo "<p class='message error'>Error: Unable to insert record.</p>";
                                }
                    }
                } else {
                    echo "<p class='message error'>Invalid OTP!</p>";
                }
            } 
            else {
                echo "<p class='message error'>OTP Expired! <a href='TutorRegistrationSubmitOTP.php' class='back-link'>Request a new one</a></p>";
            }
        }
        ?>
    </div>
    <!-- Back Button -->
<div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
    <a href="Main.php" style="display: inline-flex; align-items: center; background: linear-gradient(135deg,rgb(253, 7, 7),rgb(255, 86, 81)); border: none; border-radius: 10px; font-weight: 600; padding: 8px 16px; text-decoration: none; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
        <img src="Images/Back.png" alt="Back" style="height: 20px; margin-right: 10px;">
        Back to Home
    </a>
</div>
</body>
</html>
