<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$admin_email = $_SESSION['admin_email'];

require 'NecessaryFiles/vendor/autoload.php';
include('../dbconnect.php');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tutor_email = $_POST['tutor_email'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $mail_subject = $_POST['mail_subject'] ?? '';

    if (empty($tutor_email) || empty($reason) || empty($mail_subject)) {
        echo 'Error: Missing required fields.';
        exit;
    }

    $stmt = $connect->prepare("DELETE FROM tutor WHERE email = ?");
    $stmt->bind_param("s", $tutor_email);
    $success = $stmt->execute();

    if ($success) {
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
        $mail->addAddress($tutor_email);
        $mail->Subject = $mail_subject;
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
            <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
            <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                <h2 style='color: #fff; margin: 0;'>NOTIFICATION</h2>
            </div>
            <div style='padding: 20px; background-color: black;'>
                <div style='background-color:rgba(95, 7, 95, 1);  padding: 15px; border-radius: 10px; margin-top: 20px;'>
                    <h2 style='font-size: 24px; color:rgb(233, 32, 25); margin: 10px 0;'>You Are Removed !!</h2><h2 style='font-size: 24px; color: #0ef0e5;; margin: 10px 0;'> - REASON - </h2>
                    <p style='font-size: 18px; color: rgb(255, 255, 255);'>$reason.</p>
                    <p style='font-size: 18px; color:rgb(255, 255, 255);'> Contact Admin at: $admin_email for your queries.</p>
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
    echo "
        <div style='
            font-family: Arial, sans-serif;
            background: radial-gradient(circle, #1e1e1e, #000);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,255,0,0.3);
            max-width: 500px;
            margin: 50px auto;
            border: 2px solid #0ef05c;
        '>
            <h2 style='color: #0ef05c; margin-bottom: 20px;'>✅ Tutor Removed Successfully</h2>
            <p style='font-size: 18px;'>An email notification has been sent to: <strong style='color: #0ef0e5;'>$tutor_email</strong></p>
            <br>
            <a href='TutorList.php' style='
                display: inline-block;
                padding: 10px 20px;
                background-color: #0ef05c;
                color: black;
                font-weight: bold;
                text-decoration: none;
                border-radius: 6px;
                transition: background 0.3s;
            ' onmouseover=\"this.style.backgroundColor='#0cbf4a'\" onmouseout=\"this.style.backgroundColor='#0ef05c'\">
                🔙 Back to Tutor List
            </a>
        </div>
        ";
    } else {
        echo "<div style='color: #ff4b5c; font-weight: bold; text-align: center; margin-top: 50px;'>❌ Failed to remove tutor.</div>";
    }
} else {
    echo "<div style='color: #ff4b5c; font-weight: bold; text-align: center; margin-top: 50px;'>⚠️ Invalid request method.</div>";
}
?>
