<?php
session_start();
include("../dbconnect.php");
$admin_email = $_SESSION['admin_email'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'NecessaryFiles/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $original_email = $_POST["original_email"] ?? '';
    $new_email = $_POST["new_email"] ?? '';

    if (empty($original_email) || empty($new_email)) {
        echo "<div style='color:red;text-align:center;margin-top:50px;'>⚠️ Missing email data. Operation aborted.</div>";
        exit;
    }

    // Debug output
    // echo "$new_email , $original_email";

    // Update query using prepared statement
    $stmt = $connect->prepare("UPDATE tutor SET email = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_email, $original_email);

    if ($stmt->execute()) {
        // Send email notification
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
            $mail->addAddress($original_email);
            $mail->addAddress($new_email);
            $mail->Subject = 'Email Updated !!';

            $mail->Body = "
            <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
                <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
                <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                    <h2 style='color: #fff; margin: 0;'>NOTIFICATION</h2>
                </div>
                <div style='padding: 20px; background-color: black;'>
                    <div style='background-color:rgba(95, 7, 95, 1);  padding: 15px; border-radius: 10px; margin-top: 20px;'>
                        <h2 style='font-size: 24px; color:rgb(233, 32, 25); margin: 10px 0;'>Your Email Got updated on your request !!</h2>
                        <h2 style='font-size: 24px; color: #0ef0e5;; margin: 10px 0;'> - DETAILS - </h2>
                        <p style='font-size: 18px; color: rgb(255, 255, 255);'>Old Email: $original_email.</p>
                        <p style='font-size: 18px; color: rgb(255, 255, 255);'>New Email: $new_email.</p>
                        <p style='font-size: 18px; color:rgb(255, 255, 255);'> Contact Admin at: $admin_email for your queries.</p>
                    </div>
                </div>
                <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
                    <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
                </div>  
            </div>";
            $mail->send();
        } catch (Exception $e) {
            echo "<h1>Mailer Error: " . htmlspecialchars($mail->ErrorInfo) . "</h1>";
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
            <h2 style='color: #0ef05c; margin-bottom: 20px;'>✅ Email Updated Successfully</h2>
            <p style='font-size: 18px;'>An email notification has been sent to: <strong style='color: #0ef0e5;'>$original_email , $new_email</strong></p>
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
        echo "<div style='color: #ff4b5c; font-weight: bold; text-align: center; margin-top: 50px;'>❌ Failed to update email. Possibly no changes made.</div>";
    }
} else {
    echo "<div style='color: #ff4b5c; font-weight: bold; text-align: center; margin-top: 50px;'>⚠️ Invalid request method.</div>";
}
?>
