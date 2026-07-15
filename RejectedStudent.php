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
$s_email  = $_POST['s_email'] ?? null;
$t_email  = $_POST['t_email'] ?? null;
$sub      = $_POST['sub'] ?? null;
$s_name   = $_POST['name'] ?? null;

echo "<div style='font-family: Arial, sans-serif; background-color:rgb(253, 104, 78); color:rgb(255, 5, 5); padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>Rejected!</h3></div>";

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
    $mail->Subject = 'Rejected!! Kindly Try another Tutor!!';
    $mail->Body = "
    <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
        <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
        <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
            <h2 style='color: #fff; margin: 0;'>NOTIFICATION</h2>
        </div>
        <div style='padding: 20px; background-color: black'>
            <div style='background-color:rgba(95, 7, 95, 1); padding: 15px; border-radius: 10px; margin-top: 20px;'>
               <h2 style='font-size: 24px; color:rgb(233, 32, 25); margin: 10px 0;'>Sorry to say,</h2>
               <h2 style='font-size: 24px; color: #0ef0e5; margin: 10px 0;'>$s_name</h2>
                <p style='font-size: 18px; color: rgb(255, 255, 255);'>
                    You were declined by the tutor you applied for <strong>$sub</strong>. You may contact the tutor at <strong>$t_email</strong> or try another tutor.
                </p>
                <p style='font-size: 18px; color: #0ef0e5;'>Team TutorFinder!</p>
            </div>
        </div>
        <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
            <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
        </div>  
    </div>";

    $mail->send();

    echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto;'><h3>Rejection email is sent to $s_email.</h3></div>";
    echo "<div style='font-family: Arial, sans-serif; background-color: #fff3cd; color: rgb(255, 166, 0); padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 20px auto;'><h3><a href='/TutorFinder/StudentSelectionByTutor.php'>Back To Student List</a></h3></div>";

    $stmt = $connect->prepare("DELETE FROM student_waitlist WHERE sid = ?");
    $stmt->bind_param("i", $sid);
    if (!$stmt->execute()) {
        echo "<p style='color:red; text-align:center;'>Error: Unable to delete student from waitlist.</p>";
    }
    $stmt->close();

} catch (Exception $e) {
    echo "<h1 style='color: red; text-align:center;'>Mailer Error: " . $mail->ErrorInfo . "</h1>";
}

$connect->close();
?>
