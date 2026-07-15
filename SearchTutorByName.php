<html>
<head>
    <title>Login Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .select-container {
            background: white;
            padding: 25px; 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 320px;
        }

        h3 {
            color: #ff4b5c;
            margin-bottom: 15px;
            font-size: 22px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px;
            background: #f9f9f9;
            position: relative;
        }

        .input-group input {
            border: none;
            outline: none;
            flex: 1;
            background: transparent;
            font-size: 14px;
            padding-right: 30px;
        }

        .input-group i {
            margin-right: 8px;
            color: #ff4b5c;
        }

        .submit-btn {
            background: #ff4b5c;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background: #d43f50;
        }

    </style>
</head>
<body>

<div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
    <a href="StudentProfile.php" style="
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
        <img src="Images/Back.png" alt="Back" style="height: 20px; margin-right: 10px;">
        Back to Profile
    </a>
</div>
<?php
    session_start();
    $pass = isset($_SESSION['password']) ? $_SESSION['password'] : null;
    if (!$pass) {
        die("<div style='color:red; text-align:center;'>Error: Password not found in session. Please login again.</div>");
    }     
    ?>
    <div class="select-container">
        <h3>Enter the Tutor Name precisely!!</h3>
        <form action="TutorListAccordingTutorName.php" method="POST">
            <div class="input-group">
                <input type="text" name="name" placeholder="Enter Tutor Name" required>
            </div>
            <button class="submit-btn" type="submit">Search Tutor</button>
        </form>
    </div>
</body>
</html>
