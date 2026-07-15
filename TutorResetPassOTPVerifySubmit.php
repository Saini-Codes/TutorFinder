<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'NecessaryFiles/vendor/autoload.php';

include('dbconnect.php');

$email = $_SESSION['email'];
$npass = $_SESSION['npass'];

if (!$email) {
    echo "
    <body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #d8000c; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
        <h3>No email found in session. Please try again.</h3>
    </div>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['otp'];

    if (isset($_SESSION['otp'], $_SESSION['otp_expiry']) && time() < $_SESSION['otp_expiry']) {
        if ($user_otp == $_SESSION['otp']) {
            unset($_SESSION['otp'], $_SESSION['otp_expiry']);
            $sql = "UPDATE tutor set password = '$npass' WHERE email = '$email'";
            $result=$connect->query($sql);
            if($result === true){
                echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='font-family: Arial, sans-serif; background-color: #ddffdd; color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>Password updated successfully!</h3></div>";
                echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='font-family: Arial, sans-serif; background-color: #ddffdd; color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>New Password is Sent to $email.</h3>
                <h3><a href='TutorLogIn.php' style='text-decoration: none; color: #007BFF;'>Go To Log In Page</a></h3></div>";
            } else {
            echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #d8000c; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>No user found with this email!</h3></div>";
            exit();
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
                $mail->Subject = 'Your New Password is Here..';
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgb(248, 175, 175);'>
                    <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
                    <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                        <h2 style='color: #fff; margin: 0;'>New Password</h2>
                    </div>
                    <div style='padding: 20px; background-color: rgb(0, 0, 0);'>
                        <div style='background-color:rgba(95, 7, 95, 1);  padding: 15px; border-radius: 10px; margin-top: 20px;'>
                            <h2 style='font-size: 24px; color:rgb(233, 32, 25); margin: 10px 0;'>Password Reset!</h2>
                            <p style='font-size: 18px; color: #0ef0e5;'>Your New Password:</p>
                            <p style='font-size: 18px; color: #fff; font-weight: bold;'>$npass</p>
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
        } else {
            echo "
            <body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #d8000c; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
                <h3>Invalid OTP!</h3>
            </div>";
        }
    } else {
        echo "
        <body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #d8000c; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
            <h3>OTP Expired! <a href='StudentRegistrationSubmitOTP.php' style='text-decoration: none; color: #007BFF;'>Request a new one</a></h3>
        </div>";
    }
}

$connect->close();
?>
