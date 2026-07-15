<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: left;
            align-items: center;
            height: 110px;
            margin: 0;
        }

        .navbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            width: 100%;
            gap: 20px;
            padding: 0 20px;
        }

        .navbar a {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 15px;
            background-color: rgb(255, 5, 5);
        }

        .navbar a:hover {
            transform: scale(1.1);
            background-color: rgb(255, 100, 100);
            color: white;
        }

        .navbar a i {
            font-size: 22px;
            align-items: center;
            color: rgb(255, 5, 5); 
            transition: 0.3s;
        }

        .navbar a:hover i {
            color: rgb(255, 100, 100); 
        }

        .logo img {
            margin-right: auto;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            transition: 0.3s;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .navbar1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 32%;
            padding: 0 30px;
        }

        .navbar1 .logo {
            margin-right: auto;
        }

        .navbar1 a:not(.logo) {
            margin-left: 20px;
        }

        .partition {
            border-left: 2px solid white;
            height: 30px;
            margin: 0 15px;
        }
    </style>
</head>
<body>
    <div class="navbar1">
        <a href="frontPage.php" target="_parent" class="logo">
            <img src="Images/TutorFinder1.png" alt="Logo">
        </a>
        <a href="frontPage.php" target="_parent" class="logo">
            <span style="color: black; font-size: 20px; font-weight: bold; display: flex;">
                TutorFinder:<br> Making Your Student Life Easy
            </span>
        </a>
    </div>

    <div class="navbar">
        <a href="TutorRegistration.php" target="Main"><img src="Images/TutorSignUp.png" alt="Sign Up" style="width:30px; height:30px; vertical-align:middle; margin-right:5px;">Tutor Sign-Up</a>
        <a href="TutorLogIn.php" target="Main"><img src="Images/TutorLogIn.png" alt="Log In" style="width:30px; height:30px; vertical-align:middle; margin-right:5px;">Log In As Tutor</a>

        <div class="partition"></div>

        <a href="StudentRegistration.php" target="Main"><img src="Images/StudentSignUp.png" alt="Sign Up" style="width:30px; height:30px; vertical-align:middle; margin-right:5px;">Student Sign-Up</a>
        <a href="StudentLogIn.php" target="Main"><img src="Images/StudentLogIn.png" alt="Log In" style="width:30px; height:30px; vertical-align:middle; margin-right:5px;">Log In As Student</a>
    </div>
</body>
</html>
