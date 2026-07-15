<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['name']) || !isset($_SESSION['phone'])) {
    header("Location: StudentLogIn.php");
    exit();
}

$username = $_SESSION['name'];
$phone = $_SESSION['phone'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $file = $_FILES["photo"];

    if ($file["error"] === 0) {
        // Fetch existing profile directory and filename
        $query = "SELECT profiledir, profilepic FROM student WHERE username = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($profileDir, $oldPhoto);
        $stmt->fetch();
        $stmt->close();

        // Define upload base directory
        $uploadBase = realpath(__DIR__ . '/pfp'); // e.g., C:/xampp/htdocs/TutorFinder/pfp

        // If no profileDir or folder doesn't exist, create a new one
        if (empty($profileDir) || !is_dir($profileDir)) {
            $customName = 'user_' . str_replace(' ', '_', $username) . $phone;
            $profileDir = 'pfp/' . $customName . '/';
        }

        // Normalize profileDir to have trailing slash
        if (substr($profileDir, -1) !== '/') {
            $profileDir .= '/';
        }

        // Full path to user's upload folder
        $fullProfileDir = __DIR__ . '/' . $profileDir;

        // Create if it doesn't exist
        if (!is_dir($fullProfileDir)) {
            mkdir($fullProfileDir, 0777, true);
        }

        // DELETE old photo safely
        if (!empty($oldPhoto)) {
            $oldPath = realpath($fullProfileDir . $oldPhoto);
            if ($oldPath && strpos($oldPath, $uploadBase) === 0 && file_exists($oldPath)) {
                unlink($oldPath); 
            }
        }

        // Get original filename and build full path
        $originalName = basename($file["name"]);
        $targetPath = $fullProfileDir . $originalName;

        // Move file
        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            // Update DB
            $update = $connect->prepare("UPDATE student SET profilepic = ?, profiledir = ? WHERE username = ?");
            $update->bind_param("sss", $originalName, $profileDir, $username);
            $update->execute();
            $update->close();

            $_SESSION['toast'] = "✅ Profile photo updated successfully!";
        } else {
            $_SESSION['toast'] = "❌ Failed to upload photo.";
        }
    } else {
        $_SESSION['toast'] = "⚠️ Error during file upload.";
    }
}

header("Location: StudentProfile.php");
exit();
