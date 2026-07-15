<?php
session_start();
include("dbconnect.php");

// Ensure session is set
if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    header("Location: TutorLogIn.php");
    exit();
}

// Get tutor's info from session
$tutorName = $_SESSION['name'];
$t_email1 = $_SESSION['email'];

// Fetch students who have selected this tutor
$sql2 = "SELECT * FROM student_waitlist WHERE t_email = ?";
$stmt = $connect->prepare($sql2);
$stmt->bind_param("s", $t_email1);
$stmt->execute();
$result2 = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Waitlist</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            margin: 0;
            padding: 40px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #e60023;
        }
        .logged-in {
            text-align: center;
            margin-bottom: 30px;
            font-size: 16px;
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #fff0f3;
            color: #e60023;
        }
        tr:hover {
            background-color: #ffe4e6;
        }
        .approve-btn, .reject-btn {
            padding: 7px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            transition: background 0.3s ease;
        }
        .approve-btn {
            background-color: #28a745;
        }
        .approve-btn:hover {
            background-color: #218838;
        }
        .reject-btn {
            background-color: #dc3545;
        }
        .reject-btn:hover {
            background-color: #c82333;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            color: #777;
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
    <h2>Student Waitlist</h2>
    <div class="logged-in">
        Logged in as: <strong><?php echo "$tutorName ($t_email1)"; ?></strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>Student No.</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Email</th>
                <th>Semester</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    $sid = htmlspecialchars($row['sid']);
                    $name = htmlspecialchars($row['name']);
                    $sub = htmlspecialchars($row['subject']);
                    $s_email = htmlspecialchars($row['s_email']);
                    $sem = htmlspecialchars($row['semester']);
                    $s_phone = htmlspecialchars($row['s_phone']);
                    $t_email2 = htmlspecialchars($row['t_email']);

                    echo "<tr>
                        <td>$sid</td>
                        <td>$name</td>
                        <td>$sub</td>
                        <td>$s_email</td>
                        <td>$sem</td>
                        <td>$s_phone</td>
                        <td>
                            <form action='ApprovedStudent.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='sid' value='$sid'>
                                <input type='hidden' name='s_email' value='$s_email'>
                                <input type='hidden' name='name' value='$name'>
                                <input type='hidden' name='t_email' value='$t_email2'>
                                <input type='hidden' name='sub' value='$sub'>
                                <button type='submit' class='approve-btn'>Approve</button>
                            </form>
                            <form action='RejectedStudent.php' method='POST' style='display:inline; margin-left: 6px;'>
                                <input type='hidden' name='sid' value='$sid'>
                                <input type='hidden' name='s_email' value='$s_email'>
                                <input type='hidden' name='name' value='$name'>
                                <input type='hidden' name='t_email' value='$t_email2'>
                                <input type='hidden' name='sub' value='$sub'>
                                <button type='submit' class='reject-btn'>Reject</button>
                            </form>

                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='no-records'>No students in waitlist</td></tr>";
            }
            $stmt->close();
            $connect->close();
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
