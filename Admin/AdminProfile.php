<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: AdminLogIn.php");
    exit();
}
$adminUsername = $_SESSION['admin_username'];
$admin_email = $_SESSION['admin_email'];
$_SESSION['admin_email'] = $admin_email;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: radial-gradient(circle at top left, #ff4b5c, #000000);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #fff;
        }
        .admin-card {
            background-color: #1e1e1e;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        h2 {
            color: #0ef05c;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            background: linear-gradient(135deg, #ff4b5c, #ff6a7c);
            color: white;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(255, 75, 92, 0.6);
        }
    </style>
</head>
<body>
    <div class="admin-card">
        <img src="../Images/AdminProfile.png" alt="Admin Profile Picture" class="profile-pic">
        <h2><img src="../Images/NameCard.png" alt="Admin Icon" style="height:30px; vertical-align:middle; margin-right:10px;">Logged in as: <?= htmlspecialchars($adminUsername); ?></h2>
        <a href="AddAdmin.php" class="btn"><img src="../Images/AddAdmin.png"  style="height:50px; vertical-align:middle; margin-right:10px;">Add Admin</a>
        <a href="TutorWaitingList.php" class="btn"><img src="../Images/Approve.png"  style="height:50px; vertical-align:middle; margin-right:10px;">Approve Tutors</a>
        <a href="StudentList.php" class="btn"><img src="../Images/StudentList.png"  style="height:50px; vertical-align:middle; margin-right:10px;">Student List</a>
        <a href="TutorList.php" class="btn"><img src="../Images/TutorList.png"  style="height:50px; vertical-align:middle; margin-right:10px;">Tutor List</a>
        <a href="LogOutAdmin.php" class="btn"><img src="../Images/LogOut.png"  style="height:50px; vertical-align:middle; margin-right:10px;">Log Out</a>
    </div>
</body>
</html>
