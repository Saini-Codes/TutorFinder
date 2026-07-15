<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('NecessaryFiles/vendor/autoload.php');

include('dbconnect.php'); 
echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='font-family: Arial, sans-serif; background-color: #ddffdd; color: #4CAF50; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'><h3>Application Submitted!</h3><p>Your request has been received and is pending approval. You will be notified once it has been reviewed.</p></div>";
$t_name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'N/A';
$t_email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'N/A';
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
        $mail->addAddress($t_email);
        $mail->Subject = 'Tringggg..!! Student Application';
        $mail->Body =  "
        <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>
            <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
            <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
                <h2 style='color: #fff; margin: 0;'>NOTIFICATION</h2>
            </div>
            <div style='padding: 20px; background-color: black'>
                <div style='background-color:rgba(95, 7, 95, 1); padding: 15px; border-radius: 10px; margin-top: 20px;'>
                    <p style='font-size: 18px; color: #0ef0e5;'>You just got a student application. Review it now!!</p>
                </div>
            </div>
            <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
                <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
            </div>  
        </div>";
        $mail->send();
        echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='font-family: Arial, sans-serif; background-color: #ffdddd; color:rgb(255, 166, 0); padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: 50px auto;'><h3><a href='/TutorFinder/SearchTutorByName.php'>Select Another Tutor</a></h3></div>";
    } catch (Exception $e) {
        echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
    }
    $pass = isset($_SESSION['password']) ? $_SESSION['password'] : null;
    if (!$pass) {
        die("<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><div style='color:red; text-align:center;'>Error: Password not found in session. Please login again.</div>");
    }    
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'N/A';
    $sql1="SELECT name,email,semester,phone FROM STUDENT WHERE password='$pass'";
    $result1 = $connect->query($sql1);
            if ($result1->num_rows > 0) {
                while ($row = $result1->fetch_assoc()) {
                    $s_name = htmlspecialchars($row['name']);
                    $s_email = htmlspecialchars($row['email']);
                    $s_phone = htmlspecialchars($row['phone']);
                    $sem = htmlspecialchars($row['semester']);
                    $s_phone = htmlspecialchars($row['phone']);
                }
                }
                else {
                    echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><tr><td colspan='12'>No records found</td></tr>";
                }
                if($pass==null)
                {
                    echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><p class='message error'>Password Not Found In This Session.</p>";
                }
                else{
                $sql2="INSERT INTO student_waitlist(name,subject,s_email,semester,s_phone,t_email) VALUES('$s_name','$subject','$s_email','$sem','$s_phone','$t_email')";
                $result2 = $connect->query($sql2);
                if($result2 === false)
                {
                    echo "<body style='background: linear-gradient(to right, #ff9a9e, #fad0c4);'><p class='message error'>Error: Unable to insert record into student_req.</p>";
                }
            }
?>
