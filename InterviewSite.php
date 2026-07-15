<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include("dbconnect.php");
if (!isset($_SESSION["username"])) {
    header("Location: TutorProfile.php");
    exit();
}
$username = $_SESSION["username"];
$stmt = $connect->prepare("SELECT subject1, subject2, subject3 FROM tutor WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    die("<h3 style='color:red; text-align:center;'>❌ Tutor subjects not found.</h3>");
}

$row = $result->fetch_assoc();

$sub1 = $row['subject1'] ?? '';
$sub2 = $row['subject2'] ?? '';
$sub3 = $row['subject3'] ?? '';

$_SESSION['sub1'] = $sub1;
$_SESSION['sub2'] = $sub2;
$_SESSION['sub3'] = $sub3;

$subjects = array_map(function($s) {
    return strtolower(trim($s));
}, array_filter([$sub1, $sub2, $sub3]));

if (isset($_GET['timeout']) && $_GET['timeout'] == 1) {
    unset($_SESSION['selected_questions']);
}

if (!isset($_SESSION["selected_questions"]) || empty($_SESSION["selected_questions"])) {

    $jsonPath = __DIR__ . "/Questions.json";
    if (!file_exists($jsonPath)) {
        die("<h3 style='color:red; text-align:center;'>❌ Questions.json not found.</h3>");
    }

    $allQuestions = json_decode(file_get_contents($jsonPath), true);
    if (!is_array($allQuestions)) {
        die("<h3 style='color:red; text-align:center;'>❌ Failed to decode Questions.json</h3>");
    }

    $subjects = array_map('strtolower', $subjects);
    $filtered = array_filter($allQuestions, function ($q) use ($subjects) {
        return isset($q['subject']) && in_array(strtolower(trim($q['subject'])), $subjects);
    });

    $filtered = array_values($filtered);
    if (empty($filtered)) {
        die("<h3 style='color:red; text-align:center;'>⚠️ No matching questions found for your subjects.</h3>");
    }

    shuffle($filtered);
    $selected = array_slice($filtered, 0, 10);
    $_SESSION["selected_questions"] = $selected;
} else {
    $selected = $_SESSION["selected_questions"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subject-Based Interview</title>
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            font-family: Arial, sans-serif;
            padding: 40px;
            margin: 0;
        }
        .container {
            max-width: 850px;
            margin: auto;
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 16px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
        }
        h2 {
            color: #e91e63;
            text-align: center;
            margin-bottom: 25px;
        }
        #timer {
            font-size: 18px;
            color: #d32f2f;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .message {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .question {
            margin-bottom: 28px;
        }
        .question p {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 8px;
        }
        textarea {
            width: 100%;
            height: 90px;
            padding: 10px;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .submit-btn {
            background-color: #4caf50;
            color: white;
            padding: 14px 24px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 25px;
            display: block;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #388e3c;
        }
    </style>
<script>
    let duration = 8 * 60; // 8 minutes

    function startTimer() {
        const timerText = document.getElementById('timer-text');
        const interval = setInterval(() => {
            let minutes = Math.floor(duration / 60);
            let seconds = duration % 60;
            timerText.textContent = `Time Remaining: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            if (--duration < 0) {
                clearInterval(interval);
                window.location.href = "interview.php?timeout=1";
            }
        }, 1000);
    }

    window.onload = startTimer;
</script>

</head>
<body>

<div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
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
        <img src="Images/Back.png" alt="Back" style="height: 20px; margin-right: 10px;">
        Back to Profile
    </a>
</div>

<div class="container">
    <h2 style="display: flex; align-items: center; justify-content: center; gap: 10px;">
    <img src="Images/Interview.png" alt="Interview Icon" style="height: 50px;">
     Tutor Interview: Subject-Based Questions
</h2>


    <?php if (isset($_GET['timeout'])): ?>
        <div class="message" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
    <img src="Images/Time.png" alt="Time Over" style="height: 28px;">
     Your time is over. Please complete the interview again with new questions.
</div>

    <?php endif; ?>

 <div id="timer" style="text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px;">
    <img src="Images/Time.png" alt="Clock" style="height: 40px; vertical-align: middle; margin-right: 8px;">
    <span id="timer-text">Time Remaining: 8:00</span>
</div>



    <form action="InterviewSubmit.php" method="POST">
        <?php foreach ($selected as $index => $q): ?>
            <div class="question">
                <p>Q<?= $index + 1 ?> (<?= htmlspecialchars($q['subject']) ?>): <?= htmlspecialchars($q['question']) ?></p>
                <textarea name="answers[<?= $index ?>]" required placeholder="Type your answer here..."></textarea>
            </div>
        <?php endforeach; ?>

        <button class="submit-btn" type="submit">Submit Interview</button>
    </form>
</div>

</body>
</html>
