<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Developers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        .logo-container {
            position: absolute;
            top: 20px;
            text-align: center;
            width: 100%;
        }

        .logo {
            height: 250px;
            width: 250px;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        h1.page-title {
            font-size: 36px;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .container-wrapper {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            max-width: 300px;
            text-align: center;
            border-top: 4px solid rgb(0, 0, 0);
        }

        .container:hover {
            transform: translateY(-10px);
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .info p {
            font-size: 15px;
            margin: 5px 0;
            color: #555;
        }

        .info p i {
            color: rgb(0, 0, 0);
            margin-right: 8px;
        }

        .contact a {
            display: inline-block;
            margin: 10px;
            font-size: 22px;
            color: rgb(0, 0, 0);
            transition: 0.3s;
        }

        .contact a:hover {
            color: rgb(0, 0, 0);
            transform: scale(1.2);
        }

        @media (max-width: 800px) {
            .container-wrapper {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

        <div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
    <a href="Main.php" style="
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
        Back to Home
    </a>
</div>

    <div class="logo-container">
        <img src="Images/TutorFinder1.png" alt="Logo" class="logo">
    </div>
    <div class="content-wrapper">
        <h1 class="page-title">About Developers</h1>
        <div class="container-wrapper">
            <div class="container">
                <img src="Images/Developer.jpg" alt="Developer" class="profile-pic">
                <div class="info">
                    <p><i class="fas fa-user"></i> <b>Name:</b> Jit Hazra</p>
                    <p><i class="fas fa-map-marker-alt"></i> <b>Address:</b> Kankinara</p>
                    <p><i class="fas fa-envelope"></i> <b>Email:</b> jithazraedu@gmail.com</p>
                </div>
                <div class="contact">
                    <a href="mailto:jithazraedu@gmail.com"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.instagram.com/ig__jit" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="container">
                <img src="Images/SainiPaul.jpg" alt="Developer" class="profile-pic">
                <div class="info">
                    <p><i class="fas fa-user"></i> <b>Name:</b> Saini Paul</p>
                    <p><i class="fas fa-map-marker-alt"></i> <b>Address:</b> Halisahar</p>
                    <p><i class="fas fa-envelope"></i> <b>Email:</b> sainipaul000@gmail.com</p>
                </div>
                <div class="contact">
                    <a href="mailto:sainipaul39@gmail.com"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.instagram.com/sainipaul7_official" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
