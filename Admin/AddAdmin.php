<?php
session_start();
include("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $connect->prepare("INSERT INTO admin (username, password) VALUES ( ?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $_SESSION['admin_success'] = "✅ New admin added successfully!";
        header("Location: AddAdmin.php");
        exit();
    } else {
        $_SESSION['admin_error'] = "❌ Failed to add admin. Error: " . $stmt->error;;
        header("Location: AddAdmin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Admin</title>
    <style>
        body {
            background: radial-gradient(circle, rgb(63, 0, 0), black);
            color: white;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.4);
            width: 350px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }
        input[type="text"], input[type="password"] {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
            background: #333;
            border: 1px solid #ff4b5c;
            color: white;
            border-radius: 8px;
        }
        input[type="submit"] {
            background-color: #ff4b5c;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #d43f50;
        }
        .popup {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background-color: #0ef05c;
            color: #000;
            font-weight: bold;
            border-radius: 10px;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            animation: fadeOut 5s forwards;
        }
        .popup.error {
            background-color: #ff4b5c;
            color: white;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; display: none; }
        }
    </style>
</head>
<body>

<div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
    <a href="AdminProfile.php" style="
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg,rgb(253, 7, 7),rgb(255, 86, 81));
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 8px 16px;
        text-decoration: none;
        color: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
        <img src="../Images/Back.png" alt="Back" style="height: 20px; margin-right: 10px;">
        Back to Profile
    </a>
</div>
        <?php
if (isset($_SESSION['admin_success']) || isset($_SESSION['admin_error'])) {
    $popupMessage = isset($_SESSION['admin_success']) ? $_SESSION['admin_success'] : $_SESSION['admin_error'];
    $popupColor = isset($_SESSION['admin_success']) ? '#0ef05c' : '#ff4b5c';
    unset($_SESSION['admin_success'], $_SESSION['admin_error']);
    echo "
    <div id='popup-msg' style='
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: $popupColor;
        color: white;
        padding: 20px 30px;
        font-size: 18px;
        font-weight: bold;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.5);
        z-index: 9999;
        text-align: center;
        animation: fadeOut 3s ease-out forwards;
    '>$popupMessage</div>

    <script>
        setTimeout(function() {
            var popup = document.getElementById('popup-msg');
            if (popup) popup.remove();
        }, 3000);
    </script>

    <style>
        @keyframes fadeOut {
            0% {opacity: 1;}
            70% {opacity: 1;}
            100% {opacity: 0;}
        }
    </style>
    ";
}
?>

    <div class="container">
        <h2>Add New Admin</h2>
        <form method="post" action="AddAdmin.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Add Admin">
        </form>
    </div>

    <?php
    if (isset($_SESSION['admin_success'])) {
        echo "<div class='popup'>" . $_SESSION['admin_success'] . "</div>";
        unset($_SESSION['admin_success']);
    } elseif (isset($_SESSION['admin_error'])) {
        echo "<div class='popup error'>" . $_SESSION['admin_error'] . "</div>";
        unset($_SESSION['admin_error']);
    }
    ?>
</body>
</html>
