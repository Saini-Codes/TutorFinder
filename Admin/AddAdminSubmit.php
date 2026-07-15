<?php
session_start();

if (!isset($_SESSION['admin_user'])) {
    header("Location: AddAdmin.php");
    exit();
}

include("../dbconnect.php"); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['admin_username']);
    $password = $_POST['admin_password'];

    if (empty($username) || empty($password)) {
        die("All fields are required.");
    }

    $stmt = $connect->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "<script>alert('New admin added successfully!'); window.location.href='AdminDashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connect->close();
} else {
    echo "Invalid request.";
}
?>
