<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .navbar {
            display: flex;
            gap: 30px;
        }

        .navbar a {
            font-size: 20px;
            color:rgb(255, 5, 5);
            text-decoration: none;
            transition: 0.3s;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar a:hover {
            transform: scale(1.1);
            color: #fff4f4;
        }

        .navbar a i {
            font-size: 22px;
            color: rgb(255, 5, 5); 
            transition: 0.3s;
        }

        .navbar a:hover i {
            color: rgb(255, 100, 100); 
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="FrontPage.php" target="_parent"><i class="fas fa-home"></i> Home</a>
        <a href="ContactUs.php" target="Main"><i class="fas fa-envelope"></i> Contact Us</a>
        <a href="Gallery.php" target="Main"><i class="fas fa-images"></i> Gallery</a>
    </div>

</body>
</html>
