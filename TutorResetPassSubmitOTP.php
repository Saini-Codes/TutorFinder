<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'NecessaryFiles/vendor/autoload.php';

include('dbconnect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $npass=$_POST['npass'];
    $email = $_POST['email'];
    $sql = "SELECT COUNT(*) as counter FROM tutor WHERE email='$email'";
    $result = $connect->query($sql);
    if ($result) {
    $row = $result->fetch_assoc();
    if ($row['counter'] > 0) {
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 120; // OTP expires in 2 minutes
    $_SESSION['email'] = $email;
    $_SESSION['npass'] = $npass;

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
        $mail->Subject = 'Your Verification Code To Reset Your Password ';
        
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgb(248, 175, 175);'>
            <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
            <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                <h2 style='color: #fff; margin: 0;'>Your Verification Code</h2>
            </div>
            <div style='padding: 20px; background-color:rgb(0, 0, 0);'>
                <h1 style='font-size: 36px; color: #007BFF; margin: 10px 0;'> $otp </h1>
                <p style='font-size: 16px; color: #999;'>Use this OTP to complete your verification process. This code is valid for 2 minutes.</p>
                <p style='font-size: 14px; color: #999;'>Please do not share this OTP with anyone.</p>
            </div>
            <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
                <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
            </div>  
        </div>
        ";
    
        $mail->send();
        header("Location: TutorResetPassOTPVerify.php");
        exit();
    }
    catch (Exception $e) {
        echo "<h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
    } 
}
else{
    echo " <div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #d8000c; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
            <h3>No Such Email Found..!!</h3>
        </div>";
}
    }
    else {
        echo "Error in query: " . $connect->error;
    } 
    $connect->close();
}
?>

