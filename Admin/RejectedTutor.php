<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require(__DIR__ . '/NecessaryFiles/vendor/autoload.php');

include('../dbconnect.php'); 
echo "<div style='font-family: Arial, sans-serif; background-color: #ddffdd; color:rgb(255, 0, 0); padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>Rejected!</h3></div>";

$email = $_POST['email'];
$name = $_POST['name'];
$sql = "SELECT username, password FROM tutor_waitlist WHERE email = '$email'";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    $loginusername = $userData['username'];
    $loginpassword = $userData['password'];
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
        $mail->Subject = 'Rejected! Hope to see you soon';
        $mail->Body = "
                <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
                    <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
                    <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                        <h2 style='color: #fff; margin: 0;'>NOTIFICATION</h2>
                    </div>
                    <div style='padding: 20px; background-color: black'>
                        <div style='background-color:rgb(250, 222, 250); padding: 15px; border-radius: 10px; margin-top: 20px;'>
                           <h2 style='font-size: 24px; color:rgb(233, 32, 25); margin: 10px 0;'>We are sorry to say ,</h2><h2 style='font-size: 24px; color: #0ef0e5;; margin: 10px 0;'>$name,</h2>
                            <p style='font-size: 18px; color: rgb(255, 255, 255);'>You are not approved on <strong>TutorFinder</strong>. No need to worry, upskill yourself and enhance your CV and register again.</p>
                            <p style='font-size: 18px; color: #0ef0e5;'>We hope to see you soon!</p>
                        </div>
                    </div>
                    <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
                        <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
                    </div>  
                </div>";
        $mail->send();
        echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>Rejection email is sent to $email.</h3></div>";
        echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color:rgb(255, 166, 0); padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto;'><h3><a href='/TutorFinder/Admin/TutorWaitingList.php'>Back To Tutor List</a></h3></div>";
    } catch (Exception $e) {
        echo "<h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
    }

    $sqlFetch = "SELECT name, phone FROM tutor_waitlist WHERE email='$email'";
    $resultFetch = $connect->query($sqlFetch);
    if ($resultFetch->num_rows > 0) {
        $row = $resultFetch->fetch_assoc();
        $name = $row['name'];
        $phone = $row['phone'];

        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/TutorFinder/uploads/' . 'user_' . str_replace(' ', '_', $name) . $phone;
        if (file_exists($filePath)) {
            function deleteDir($dirPath) {
                if (!is_dir($dirPath)) {
                    return false;
                }
                $files = scandir($dirPath);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $filePath = $dirPath . DIRECTORY_SEPARATOR . $file;
                        if (is_dir($filePath)) {
                            deleteDir($filePath);
                        } else {
                            unlink($filePath);
                        }
                    }
                }
                return rmdir($dirPath);
            }

            if (deleteDir($filePath)) {
                $sql4 = "DELETE FROM tutor_waitlist WHERE email='$email'";
                if ($connect->query($sql4) === false) {
                    echo "<p class='message error'>Error: Unable to delete record from waitlist.</p>";
                }
            } else {
                echo "Error deleting directory.";
            }
        } else {
            echo "Directory does not exist.";
        }
    } else {
        echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #d8000c; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>No user found with this email!</h3></div>";
        exit();
    }
} else {
    echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #d8000c; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>No user found with this email!</h3></div>";
    exit();
}
?>
