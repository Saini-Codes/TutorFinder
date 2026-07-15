<?php
session_start();
include("dbconnect.php");

// Check if password is set in session
if (!isset($_SESSION['password'])) {
    die("<div style='color:red; text-align:center;'>Error: Session expired. Please login again.</div>");
}

$pass = mysqli_real_escape_string($connect, $_SESSION['password']);

// Get tutor's id, email, and name
$tutorQuery = "SELECT tid, email, name FROM tutor WHERE password='$pass'";
$tutorResult = mysqli_query($connect, $tutorQuery);

if (!$tutorResult || mysqli_num_rows($tutorResult) === 0) {
    die("<div style='color:red; text-align:center;'>Tutor not found. Please login again.</div>");
}

$tutor = mysqli_fetch_assoc($tutorResult);
$tutor_id = $tutor['tid']; // use numeric id here
$tutor_name = $tutor['name'];

// Fetch ratings for this tutor id
$ratingQuery = "SELECT * FROM ratings WHERE tutor_id='$tutor_id' ORDER BY created_at DESC";
$ratingResult = mysqli_query($connect, $ratingQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Ratings & Reviews</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .container {
            background: white;
            border-radius: 16px;
            padding: 30px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .review-card {
            background: #f9f9f9;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .review-card h4 {
            margin: 0 0 8px 0;
            color: #fd0000ff;
        }
        .review-card p {
            margin: 4px 0;
            font-size: 14px;
            color: #555;
        }
        .stars {
            color: gold;
            font-size: 18px;
        }

    </style>
</head>
<body>

<div style="
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1000;
">
    <a href="TutorProfile.php" style="
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
        <img src="Images\Back.png" alt="Back" style="height: 20px; margin-right: 10px;">
        Back to Profile
    </a>
</div>

<div class="container">
    <h2>⭐ Ratings & Reviews for <?= htmlspecialchars($tutor_name); ?></h2>

    <?php
    if ($ratingResult && mysqli_num_rows($ratingResult) > 0) {
        while ($row = mysqli_fetch_assoc($ratingResult)) {
            $student_email = htmlspecialchars($row['student_email']);
            $rating = intval($row['rating']);
            $review = htmlspecialchars($row['review']);
            $created_at = htmlspecialchars($row['created_at']);

            echo "<div class='review-card'>
                <h4>From: $student_email</h4>
                <div class='stars'>" . str_repeat("★", $rating) . str_repeat("☆", 5 - $rating) . "</div>
                <p><strong>Review Messsage:</strong> $review</p>
                <p><em>Date: $created_at</em></p>
            </div>";
        }
    } else {
        echo "<p style='text-align:center;'>No ratings or reviews found yet.</p>";
    }
    ?>
</div>
</div>
</body>
</html>
