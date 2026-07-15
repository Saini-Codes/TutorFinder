<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('NecessaryFiles/vendor/autoload.php');
include('dbconnect.php');

if (!isset($_POST['sid'])) {
    die("Error: No student ID provided.");
}

$sid      = intval($_POST['sid']);
$s_email  = isset($_POST['s_email']) ? $_POST['s_email'] : null;
$t_email  = isset($_POST['t_email']) ? $_POST['t_email'] : null;
$sub      = isset($_POST['sub']) ? $_POST['sub'] : null;
$s_name   = isset($_POST['name']) ? $_POST['name'] : null;

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
    $mail->addAddress($s_email);
    $mail->Subject = 'APPROVED!! You have got yourself a Tutor!!';
    $mail->Body = "
        <div style='font-family: Arial, sans-serif; background-color: rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
            <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
            <div style='background-color: rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                <h2 style='color: #fff; margin: 0;'>NOTIFICATION</h2>
            </div>
            <div style='padding: 20px; background-color: black;'>
                <div style='background-color: rgba(95, 7, 95, 1); padding: 15px; border-radius: 10px; margin-top: 20px;'>
                   <h2 style='font-size: 24px; color: rgb(233, 32, 25); margin: 10px 0;'>Congratulations,</h2>
                   <h2 style='font-size: 24px; color: #0ef0e5; margin: 10px 0;'>$s_name</h2>
                    <p style='font-size: 18px; color: rgb(255, 255, 255);'>
                        You are approved and got yourself a <strong>$sub</strong> tutor. You can contact your tutor at: $t_email for more information. Study hard. Good luck for your future.
                    </p>
                    <p style='font-size: 18px; color: #0ef0e5;'>Team TutorFinder!</p>
                </div>
            </div>
            <div style='background-color: rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
                <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
            </div>  
        </div>";

    $mail->send();
    echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
            <h3>Approval email is sent to $s_email.</h3>
          </div>";
    echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: rgb(255, 166, 0); padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto;'>
            <h3><a href='/TutorFinder/StudentSelectionByTutor.php'>Back To Student List</a></h3>
          </div>";
    $deleteStmt = $connect->prepare("DELETE FROM student_waitlist WHERE sid = ?");
    $deleteStmt->bind_param("i", $sid);
    if ($deleteStmt->execute()) {
    } else {
        echo "<p style='font-family: Arial, sans-serif; color: red; text-align: center;'>Error: Unable to delete record from waitlist.</p>";
    }
    $deleteStmt->close();
} catch (Exception $e) {
    echo "<h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
}

$connect->close();
?>
