<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['username'])) {
    header("Location: TutorLogIn.php");
    exit();
}

$username = $_SESSION['username'];

// Get phone from DB
$stmt = $connect->prepare("SELECT phone, logoDir, logo FROM tutor WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($phone, $profileDir, $oldPhoto);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $file = $_FILES["photo"];

    if ($file["error"] === 0) {
        // Generate folder path
        $customName = 'user_' . str_replace(' ', '_', $username) . $phone;
        $relativeDir = 'uploads/' . $customName . '/logo/';
        $fullDir = __DIR__ . '/' . $relativeDir;

        // Create folder if not exists
        if (!is_dir($fullDir)) {
            mkdir($fullDir, 0777, true);
        }

        // Delete old photo
        if (!empty($oldPhoto)) {
            $oldPath = $fullDir . $oldPhoto;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Sanitize and save new photo
        $originalName = basename($file["name"]);
        $targetPath = $fullDir . $originalName;

        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            // Update DB
            $update = $connect->prepare("UPDATE tutor SET logo = ?, logoDir = ? WHERE username = ?");
            $update->bind_param("sss", $originalName, $relativeDir, $username);
            $update->execute();
            $update->close();

            $_SESSION['toast'] = "✅ Profile photo updated successfully!";
        } else {
            $_SESSION['toast'] = "❌ Failed to move uploaded file.";
        }
    } else {
        $_SESSION['toast'] = "⚠️ Upload error code: " . $file["error"];
    }
}

header("Location: TutorProfile.php");
exit();
