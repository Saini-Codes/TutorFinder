<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'NecessaryFiles/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip=$_POST['pin'];
    $dist=$_POST['district'];
    $state=$_POST['state'];
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];
    $phone = $_POST['phone'];
    if(isset($_POST['gender']))
    {
        $gender=$_POST['gender'];
    }
    $sub1 = $_POST['sub1'];
    $sub2 = $_POST['sub2'];
    $sub3 = $_POST['sub3'];
    $fees1 = $_POST['fees1'];
    $fees2 = $_POST['fees2'];
    $fees3 = $_POST['fees3'];
    $qualifications = $_POST['qualifications'];
    $profession = $_POST['profession'];
    $logo = $_FILES['logo'];
    $cv = $_FILES['cv'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    include("dbconnect.php");
    $sql1 = "SELECT COUNT(*) as counter FROM tutor_waitlist WHERE email='$email1'";
    $sql2= "SELECT COUNT(*) as counter FROM tutor WHERE email='$email1'";
    $result1 = $connect->query($sql1);
    $result2 = $connect->query($sql2);
    $row1 = $result1->fetch_assoc();
    $row2 = $result2->fetch_assoc();
    if ($row1['counter'] > 0 || $row2['counter'] > 0 ) {
        echo "<center><h3>Already have an account with $email1..</h3></center><br><br>";
        echo "<h3><a href='TutorLogIn.php'>Log In </a></h3>";
    } else {

        $uploadDir = 'uploads/';
        $customName = 'user_' . str_replace(' ', '_', $name).$phone;
        $userFolder = $uploadDir . $customName . '/';
        
        // Store directories in variables
        $logoDir = $userFolder . 'logo/';
        $cvDir = $userFolder . 'cv/';

        // Create directories if they don't exist
        if (!is_dir($userFolder)) {
            mkdir($userFolder, 0777, true);
        }
        if (!is_dir($logoDir)) {
            mkdir($logoDir, 0777, true);
        }
        if (!is_dir($cvDir)) {
            mkdir($cvDir, 0777, true);
        }

        // Logo Upload
        if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
            $logoName = pathinfo($_FILES["logo"]["name"], PATHINFO_BASENAME);
            $targetLogo = $logoDir . $logoName;
            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetLogo)) {
                $_SESSION['logoName'] = $logoName;
            } else {
                echo "Error uploading logo.";
            }
        }

        // CV Upload
        if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] == 0) {
            $cvName = pathinfo($_FILES["cv"]["name"], PATHINFO_BASENAME);
            $targetCV = $cvDir . $cvName;
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $targetCV)) {
                $_SESSION['cvName'] = $cvName;
            } else {
                echo "Error uploading CV.";
            }
}

    //Username & Password Creation
    $num = rand(100, 999); 
    if (strpos($name, ' ') !== false) 
    {
        $loginusername=str_replace(' ','',$name).$num;
    } else {
        $loginusername=$name.$num;
    }
    $loginpassword=$phone."@".str_replace(' ','',$name);

    if (strcmp($email1, $email2) != 0) {
        die("<h1>Enter the same email ID</h1>");
    }
    $_SESSION['name'] = $name;
    $_SESSION['street'] = $street;
    $_SESSION['city'] = $city;
    $_SESSION['zip'] = $zip;
    $_SESSION['dist'] = $dist;
    $_SESSION['state'] = $state;
    $_SESSION['phone'] = $phone;
    $_SESSION['gender'] = $gender;
    $_SESSION['sub1'] = $sub1;
    $_SESSION['sub2'] = $sub2;
    $_SESSION['sub3'] = $sub3;
    $_SESSION['fees1'] = $fees1;
    $_SESSION['fees2'] = $fees2;
    $_SESSION['fees3'] = $fees3;
    $_SESSION['qualifications'] = $qualifications;
    $_SESSION['profession'] = $profession;
    $_SESSION['loginusername'] = $loginusername;
    $_SESSION['loginpassword'] = $loginpassword;
    $_SESSION['logoDir'] = $logoDir;
    $_SESSION['cvDir'] = $cvDir;
    $_SESSION['latitude'] = $latitude;
    $_SESSION['longitude'] = $longitude;

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 120; // OTP expires in 2 minutes
    $_SESSION['email'] = $email1;

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
        $mail->addAddress($email1);
        $mail->Subject = 'Your Verification Code';
        
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; background-color:rgb(248, 175, 175); color: #333; padding: 20px; text-align: center; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgb(248, 175, 175);'>
        <img src='https://i.imgur.com/JCuXDmc.png' alt='Logo' style='width: 150px; height: auto;'>
    <div style='background-color:rgb(248, 80, 68); padding: 15px; border-radius: 10px 10px 0 0;'>
        <h2 style='color: #fff; margin: 0;'>Your Verification Code</h2>
    </div>
    <div style='padding: 20px; background-color: rgb(0, 0, 0);'>
        <h1 style='font-size: 36px; color: #007BFF; margin: 10px 0;'> $otp </h1>
        <p style='font-size: 16px; color: #999;'>
            Use this OTP to complete your verification process. This code is valid for 2 minutes. Hurry..!!.
        </p>
        <p style='font-size: 14px; color: #999;'>
            Please do not share this OTP with anyone. If you did not request this, please ignore this email.
        </p>
    </div>  
        <div style='background-color:rgb(248, 80, 68); padding: 10px; border-radius: 0 0 10px 10px;'>
        <p style='color: #fff; font-size: 12px;'>© CODING IS FUN</p>
</div>";

        $mail->send();
        header("Location: TutorRegOTPVerify.php");
        exit();
    } catch (Exception $e) {
        echo "<h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
    }
}
}
?>

