<?php
include("dbconnect.php");

$sql = "SELECT name, logo, logoDir, profession FROM tutor";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery | TutorFinder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            color: #333;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            text-align: center;
            font-size: 2.8em;
            color: #f71c1cff;
            font-weight: 700;
            animation: fadeInDown 0.9s ease forwards;
            opacity: 0;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            width: 100%;
            padding: 20px;
            animation: fadeInUp 1s ease forwards;
            opacity: 0;
        }

        .gallery-item {
            background: linear-gradient(135deg, #ffffff, #f7f9fc);
            border-radius: 22px;
            padding: 20px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            text-align: center;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .gallery-item:hover {
            transform: translateY(-12px) scale(1.05);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 320px;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
            transition: transform 0.4s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item h3 {
            margin-top: 16px;
            font-size: 1.4em;
            color: #fa0101ff;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .gallery-item p {
            margin-top: 8px;
            font-size: 1em;
            color: #555;
        }

        footer {
            text-align: center;
            background-color: #fa3434ff;
            color: #fff;
            padding: 20px;
            border-radius: 16px;
            margin-top: 50px;
            font-size: 16px;
            font-weight: 500;
            animation: fadeIn 1.2s ease forwards;
            opacity: 0;
            width: 100%;
            max-width: 1200px;
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @media (max-width: 600px) {
            h1 { font-size: 2.2em; }
            .gallery-item img { height: 240px; }
            .gallery-item h3 { font-size: 1.2em; }
            .gallery-item p { font-size: 0.95em; }
        }
    </style>
</head>
<body>

<h1>Respected Tutors of TutorFinder</h1>

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

<div class="gallery">
    <?php
    if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
            $name = htmlspecialchars($row['name']);
            $photo = htmlspecialchars($row['logo']);
            $photoDir = rtrim(htmlspecialchars($row['logoDir']), '/') . '/';
            $currentInstitute = htmlspecialchars($row['profession']);
            $fullPath = (!empty($photo) && !empty($photoDir)) ? $photoDir . $photo : 'uploads/tutors/default.jpg';
    ?>
        <div class="gallery-item">
            <img src="<?= $fullPath ?>" alt="<?= $name ?>" onerror="this.onerror=null;this.src='uploads/tutors/default.jpg';">
            <h3><?= $name ?></h3>
            <p><?= $currentInstitute ?></p>
        </div>
    <?php
        endwhile;
    else:
        echo "<p>No approved tutors available.</p>";
    endif;
    ?>
</div>

<footer>
    © 2025 TutorFinder | Making Your Student Life Easy
</footer>

</body>
</html>
