<?php
include("dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tid = mysqli_real_escape_string($connect, $_POST['tid'] ?? '');
    $student_email = mysqli_real_escape_string($connect, $_POST['student_email'] ?? '');
    $rating = intval($_POST['rating'] ?? 0);
    $feedback = mysqli_real_escape_string($connect, $_POST['feedback'] ?? '');

    if ($tid && $student_email && $rating >= 1 && $rating <= 5) {
        $sql = "INSERT INTO ratings (tutor_id, student_email, rating, review) VALUES ('$tid', '$student_email', '$rating', '$feedback')";
        if (mysqli_query($connect, $sql)) {
            echo "Success";
        } else {
            echo "Error saving rating.";
        }
    } else {
        echo "Invalid data submitted.";
    }
    
}
?>
