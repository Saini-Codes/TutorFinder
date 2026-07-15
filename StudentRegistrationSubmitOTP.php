<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'NecessaryFiles/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip = $_POST['pin'];
    $dist = $_POST['district'];
    $state = $_POST['state'];
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'] ?? '';
    $sem = $_POST['sem'] ?? '';
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    include("dbconnect.php");
    $sql = "SELECT COUNT(*) as counter FROM student WHERE email='$email1'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    if ($row['counter'] > 0) {
        echo "<center><h3>Already have an account with $email1..</h3></center><br><br>";
        echo "<h3><a href='StudentLogIn.php'>Log In </a></h3>";
        exit;
    }

    // Profile picture handling
    $uploadDir = 'pfp/';
    $customName = 'user_' . str_replace(' ', '_', $name) . $phone;
    $userFolder = $uploadDir . $customName . '/';

    if (!is_dir($userFolder)) {
        mkdir($userFolder, 0777, true);
    }

    chmod($userFolder, 0777); // Ensure folder is writable

    if (isset($_FILES['pfp'])) {
        $uploadError = $_FILES['pfp']['error'];

        if ($uploadError === 0) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $fileType = mime_content_type($_FILES['pfp']['tmp_name']);

            if (!in_array($fileType, $allowedTypes)) {
                die("Invalid file type. Only JPG, PNG, and GIF allowed. Uploaded type: $fileType");
            }

            $pfpName = basename($_FILES["pfp"]["name"]);
            $pfpPath = $userFolder . $pfpName;

            if (move_uploaded_file($_FILES["pfp"]["tmp_name"], $pfpPath)) {
                $_SESSION['pfpName'] = $pfpName;
                $_SESSION['pfpDir'] = $userFolder;
            } else {
                die("Error moving uploaded profile picture.");
            }
        } else {
            $errorMessages = [
                1 => 'File exceeds upload_max_filesize in php.ini.',
                2 => 'File exceeds MAX_FILE_SIZE in form.',
                3 => 'File only partially uploaded.',
                4 => 'No file was uploaded.',
                6 => 'Missing temporary folder.',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
            ];
            $msg = $errorMessages[$uploadError] ?? 'Unknown error.';
            die("Upload failed with error [$uploadError]: $msg");
        }
    } else {
        die("No profile picture uploaded. Check input field name and form enctype.");
    }

    // Create login credentials
    $num = rand(100, 999);
    $cleanedName = str_replace(' ', '', $name);
    $loginusername = $cleanedName . $num;
    $plainPassword = $phone . "@" . $cleanedName;
    $loginpassword = $plainPassword; // You can hash this later

    // Email match check
    if (strcmp($email1, $email2) != 0) {
        die("<h1>Enter the same email ID</h1>");
    }

    // Store in session for OTP verification
    $_SESSION['name'] = $name;
    $_SESSION['street'] = $street;
    $_SESSION['city'] = $city;
    $_SESSION['zip'] = $zip;
    $_SESSION['dist'] = $dist;
    $_SESSION['state'] = $state;
    $_SESSION['phone'] = $phone;
    $_SESSION['gender'] = $gender;
    $_SESSION['sem'] = $sem;
    $_SESSION['loginusername'] = $loginusername;
    $_SESSION['loginpassword'] = $plainPassword;
    $_SESSION['latitude'] = $latitude;
    $_SESSION['longitude'] = $longitude;

    $_SESSION['email'] = $email1;

    // Generate and store OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 120;

    // Send OTP via email
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
        header("Location: StudentRegOTPVerify.php");
        exit();
    } catch (Exception $e) {
        echo "<h1>Mailer Error: " . $mail->ErrorInfo . "</h1>";
    }
}
?>
