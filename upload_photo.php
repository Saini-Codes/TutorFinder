<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['name'])) {
    header("Location: StudentLogIn.php");
    exit();
}

$username = $_SESSION['name'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $file = $_FILES["photo"];

    if ($file["error"] === 0) {
        // Fetch profiledir and old photo name
        $query = "SELECT profiledir, profilepic FROM student WHERE username = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($profileDir, $oldPhoto);
        $stmt->fetch();
        $stmt->close();

        // Use default dir if not set
        if (!$profileDir) {
            $profileDir = "pfp/";
        }

        // Ensure directory exists
        if (!is_dir($profileDir)) {
            mkdir($profileDir, 0777, true);
        }

        // Build new filename
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newName = 'user_' . $username . '.' . $ext;
        $targetPath = $profileDir . $newName;

        // Delete old photo if exists
        if (!empty($oldPhoto)) {
            $oldPath = $profileDir . $oldPhoto;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Move file and update database
        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            $update = $connect->prepare("UPDATE student SET profilepic = ?, profiledir = ? WHERE username = ?");
            $update->bind_param("sss", $newName, $profileDir, $username);
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
