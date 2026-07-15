<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['selected_questions']) || !isset($_POST['answers'])) {
    die("Invalid submission.");
}

$answers = $_POST['answers'];
$questions = $_SESSION['selected_questions'];
$totalQuestions = count($questions);

// Helper: Normalize string for comparison
function normalize($text) {
    return strtolower(trim(preg_replace('/\s+/', ' ', $text)));
}

// ✅ Calculate score
$score = 0;
foreach ($answers as $index => $answer) {
    if (strlen(trim($answer)) > 0) {
        $expected = $questions[$index]['expected'] ?? '';
        if (normalize($answer) === normalize($expected)) {
            $score++;
        }
    }
}

// ✅ Get username for updating interview status
$username = $_SESSION["username"] ?? null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interview Result</title>
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            text-align: center;
            animation: slideUp 0.6s ease;
        }
        h2 {
            margin-bottom: 10px;
        }
        p {
            font-size: 18px;
        }
        .success {
            color: #28a745;
        }
        .fail {
            color: #e53935;
        }
        a.btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>
<div class="card">
<?php
if ($score < 5) {
    echo "<h2 class='fail'>Interview Not Passed</h2>";
    echo "<p>You scored <strong>$score / $totalQuestions</strong>.</p>";
    echo "<p>You need at least 5 correct answers to pass. Please try again.</p>";
    echo '<a class="btn" href="TutorLogIn.php"> Retake Interview</a>';
} else {
    if ($username) {
        $update = $connect->prepare("UPDATE tutor SET interviewStatus = 'Accepted' WHERE username = ?");
        $update->bind_param("s", $username);
        if ($update->execute()) {
            echo "<h2 class='success'>🎉 Interview Passed!</h2>";
            echo "<p>Your score: <strong>$score / $totalQuestions</strong></p>";
            echo "<p>You've been marked as <strong>Accepted</strong>. You're now a verified tutor!</p>";
            echo '<a class="btn" href="TutorProfile.php">Go to Profile</a>';
        } else {
            echo "<h2 class='fail'>Error updating status</h2>";
            echo "<p>" . $update->error . "</p>";
        }
        $update->close();
    } else {
        echo "<h2 class='fail'>User session expired</h2>";
    }
}
$connect->close();
if ($score < 5) {
    session_destroy(); // Only destroy session if failed
}
?>
</div>
</body>
</html>
