<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to TUTORFINDER</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            text-align: center;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            font-size: 15px;
        }

        .wrapper {
            width: 100%; 
        }

        .container {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 20px;
        }

        h1 {
            color: #ff5e5e;
            font-weight: bold;
        }

        .highlight {
            color: rgb(248, 0, 0);
        }

        .image-container,
        .image-container1 {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .image-container img {
            height: 400px;
            width: 400px;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .image-container1 img {
            height: 300px;
            width: 500px;
            transition: transform 0.3s;
        }

        .image-container img:hover,
        .image-container1 img:hover {
            transform: scale(1.1);
        }

        p {
            font-size: 20px;
            line-height: 1.6;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            background: #ffeaea;
            font-size: 20px;
            padding: 15px;
            border-radius: 15px;
            margin: 10px 0;
            color: rgb(248, 0, 0);
        }

        .container ul li {
            background: #fff;
            color: #333;
            border: 1px solid rgb(255, 5, 14);
            transition: transform 0.3s;
        }

        .container ul li:hover {
            transform: scale(1.005);
            background: rgb(253, 227, 227);
        }

        .benefits {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            width: 100%;
        }

        .benefits .container {
            width: 45%;
        }

        .important-links {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            border-radius: 20px;
            padding: 15px;
            width: 90%;
            margin: 20px auto;
        }

        .important-links a {
            display: inline-block;
            margin: 10px 15px;
            color: #fff;
            background-color: #ff5e5e;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .important-links a:hover {
            background-color: #ff3333;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .benefits {
                flex-direction: column;
                align-items: center;
            }

            .benefits .container {
                width: 90%;
            }

            .image-container img,
            .image-container1 img {
                width: 90%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="image-container">
                <img src="Images/TutorFinder1.png" alt="Tutor Finder">
            </div>
            <h1><span class="highlight">Welcome to TUTORFINDER!</span></h1>
            <p>Your Gateway to Academic Success</p>
            <p>At <span class="highlight">FindTutor</span>, we bridge the gap between passionate tutors and eager learners. Whether you're looking to <strong>share your knowledge</strong> or <strong>enhance your skills</strong>, you've come to the right place!</p>
            <ul>
                <li><strong>Students:</strong> Discover expert tutors to guide you on your educational journey.</li>
                <li><strong>Tutors:</strong> Join our community to inspire and educate the next generation.</li>
            </ul>
            <p><strong><span class="highlight">Sign up today</span></strong> and take the first step towards a brighter future!</p>
        </div>

        <div class="benefits">
            <div class="container">
                <div class="image-container1">
                    <img src="Images/Students.png" alt="Students">
                </div>
                <h1 class="highlight">What We Provide To Students</h1>
                <ul>
                    <li>Access to a wide range of expert tutors</li>
                    <li>Flexible scheduling to fit your needs</li>
                    <li>Personalized learning experiences</li>
                    <li>Boost your academic performance</li>
                </ul>
            </div>

            <div class="container">
                <div class="image-container1">
                    <img src="Images/Teachers.png" alt="Teachers">
                </div>
                <h1 class="highlight">What We Provide To Teachers</h1>
                <ul>
                    <li>Expand your reach to eager learners</li>
                    <li>Flexible teaching schedules</li>
                    <li>Share your expertise and inspire others</li>
                    <li>Earn extra income by teaching subjects you love</li>
                </ul>
            </div>
        </div>

        <div class="important-links">
            <h1 class="highlight"> Other Important Links</h1>
                <a href="FrontPage.php" target="_parent"><img src="Images/Home.png" alt="Home" style="width:40px; height:40px; vertical-align:middle; margin-right:8px;">Home</a>
                <a href="Gallery.php" target="Main"><img src="Images/Gallery.png" alt="Gallery" style="width:40px; height:40px; vertical-align:middle; margin-right:8px;">Gallery</a>
                <a href="ContactUs.php" target="Main"><img src="Images/ContactUs.png" alt="Contact_us" style="width:40px; height:40px; vertical-align:middle; margin-right:8px;">Contact Us</a>
                <a href="AboutDevelopers.php" target="Main"><img src="Images/Developer_icon.png" style="width:40px; height:40px; vertical-align:middle; margin-right:8px;"> About Developers</a>
        </div>
    </div>
    <?php include 'chatbot.php'; ?>
</body>
</html>
