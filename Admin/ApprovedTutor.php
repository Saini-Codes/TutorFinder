<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require(__DIR__ . '/NecessaryFiles/vendor/autoload.php');

include('../dbconnect.php'); 
echo "<div style='font-family: Arial, sans-serif; background-color: #ddffdd; color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>Approved!</h3></div>";

$email1 = $_POST['email'];
$name1 = $_POST['name'];
$sql1 = "SELECT username, password FROM tutor_waitlist WHERE email = '$email1'";
$result1 = $connect->query($sql1);

if ($result1->num_rows > 0) {
    $userData = $result1->fetch_assoc();
    $loginusername = $userData['username'];
    $loginpassword = $userData['password'];

    $sql2 = "SELECT * FROM tutor_waitlist";
    $result2 = $connect->query($sql2);
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $name = htmlspecialchars($row['name']);
            $street = htmlspecialchars($row['street']);
            $city = htmlspecialchars($row['city']);
            $pin = htmlspecialchars($row['pin']);
            $dist = htmlspecialchars($row['district']);
            $state = htmlspecialchars($row['state']);
            $email = htmlspecialchars($row['email']);
            $phone = htmlspecialchars($row['phone']);
            $gender = htmlspecialchars($row['gender']);
            $sub1 = htmlspecialchars($row['subject1']);
            $sub2 = htmlspecialchars($row['subject2']);
            $sub3 = htmlspecialchars($row['subject3']);
            $fees1 = htmlspecialchars($row['fees1']);
            $fees2 = htmlspecialchars($row['fees2']);
            $fees3 = htmlspecialchars($row['fees3']);
            $qualifications = htmlspecialchars($row['qualifications']);
            $profession = htmlspecialchars($row['profession']);
            $logoName = htmlspecialchars($row['logo']);
            $logoDir = htmlspecialchars($row['logoDir']);
            $cvDir = htmlspecialchars($row['cvDir']);
            $username = htmlspecialchars($row['username']);
            $password = htmlspecialchars($row['password']);
            $latitude = htmlspecialchars($row['latitude']);
            $longitude = htmlspecialchars($row['longitude']);

            if ($email1 == $email) {
                $sql3 = "INSERT INTO tutor(name, street, city, pin, district, state, email, phone, gender, subject1, subject2, subject3, fees1, fees2, fees3, qualifications, profession,logo, logoDir, username, password,latitude, longitude) VALUES ('$name', '$street', '$city', '$pin', '$dist', '$state', '$email', '$phone', '$gender', '$sub1', '$sub2', '$sub3', '$fees1', '$fees2', '$fees3','$qualifications','$profession', '$logoName', '$logoDir', '$username', '$password', '$latitude', '$longitude')";

                $mail = new PHPMailer(true);

                try {
                $mail->isSMTP();
                $mail->isHTML(true);
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username   = 'tutor.finder.js@gmail.com';  
                $mail->Password   = 'fhtfncpjiypqvqud';  
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('tutor.finder.js@gmail.com', 'TutorFinder');
                $mail->addAddress($email1);
                $mail->Subject = 'APPROVED!! Your Log In Credentials Are Here..';
                $mail->Body =  "
            <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
                    <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
                        <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                        <h2 style='color: #fff; margin: 0;'>NOTIFICATION</h2>
                        </div>
                    <div style='padding: 20px; background-color: black'>
                        <div style='background-color:rgba(95, 7, 95, 1); padding: 15px; border-radius: 10px; margin-top: 20px;'>
                        <h2 style='font-size: 24px; color:rgb(233, 32, 25); margin: 10px 0;'>Congratulations,</h2><h2 style='font-size: 24px; color: #0ef0e5;; margin: 10px 0;'>$name1,</h2>
                        <p style='font-size: 18px; color: rgb(255, 255, 255);'>You are aproved on <strong>TutorFinder</strong>.</p>
                        <p style='font-size: 18px; color:rgb(255, 255, 255);'> Please use the below credentials to Log In as Tutor.</p>
                        <p style='font-size: 18px; color: #0ef0e5;'>Your Username:</p>
                        <p style='font-size: 18px; color: #333; font-weight: bold;'>$loginusername</p>
                        <p style='font-size: 18px; color: #0ef0e5;'>Your Password:</p>
                        <p style='font-size: 18px; color: #333; font-weight: bold;'>$loginpassword</p>
                        <p style='font-size: 18px; color: #0ef0e5;'>Thank You for joining us!</p>
                    </div>
                </div>
            <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
                <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
            </div>  
        </div>";
        $mail->send();
        echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>Approval email is sent to $email1.</h3></div>";
        echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color:rgb(255, 166, 0); padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto;'><h3><a href='/TutorFinder/Admin/TutorWaitingList.php'>Back To Tutor List</a></h3></div>";

        } catch (Exception $e) {
        echo "<h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
        }

                if ($connect->query($sql3) === false) {
                    echo "<p class='message error'>Error: Unable to insert record into tutor.</p>";
                }

                $filePath = $_SERVER['DOCUMENT_ROOT'] . '/TutorFinder/' . $cvDir;
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
                    echo "File does not exist.";
                }
            }
        }
    } else {
        echo "<tr><td colspan='12'>No records found</td></tr>";
    }
    $connect->close();
} else {
    echo "<div style='font-family: Arial, sans-serif; background-color: #ffdddd; color: #d8000c; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>No user found with this email!</h3></div>";
    exit();
}
?>
