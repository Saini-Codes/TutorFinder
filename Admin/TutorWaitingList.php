<?php
include("../dbconnect.php");

$sql = "SELECT * FROM tutor_waitlist";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Tutor Waitlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: #c3c4c7;
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .main-content h2 {
            color: #ffcb6b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #2b2b3d;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid #3a3a4f;
        }
        th {
            background-color: #32324a;
            color: #ffcb6b;
        }
        tr:hover {
            background-color: #3d3d52;
        }

        .approve-btn, .reject-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 8px;
            transition: background 0.3s ease;
            color: #fff;
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
    </style>
</head>
<body>

    <div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
    <a href="AdminProfile.php" style="
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
        <img src="../Images/Back.png" alt="Back" style="height: 20px; margin-right: 10px;">
        Back to Profile
    </a>
</div>
    <div class="main-content" style="padding-top: 50px;">
        <h2>Tutor Waitlist</h2>
        <table>
            <thead>
                <tr>
                    <th>T No.</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Subjects & Fees</th>
                    <th>Qualifications</th>
                    <th>Current Profession</th>
                    <th>Logo</th>
                    <th>CV</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $name = htmlspecialchars($row['name']);
                    $email = htmlspecialchars($row['email']);

                    echo "<tr>
                        <td>{$row['tid']}</td>
                        <td>{$name}</td>
                        <td>{$row['city']},{$row['pin']},{$row['district']}</td>
                        <td>{$email}</td>
                        <td>{$row['subject1']}(Rs.{$row['fees1']}),<br>{$row['subject2']}(Rs.{$row['fees2']}),<br>{$row['subject3']}(Rs.{$row['fees3']})</td>
                        <td>{$row['qualifications']}</td>
                        <td>{$row['profession']}</td>
                        <td>{$row['logoDir']}{$row['logo']}</td>
                        <td>{$row['cvDir']}{$row['cv']}</td>
                        <td>
                            <form action='ApprovedTutor.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='email' value='$email'>
                                <input type='hidden' name='name' value='$name'>
                                <button type='submit' class='approve-btn'>Approve</button>
                            </form>
                            <form action='RejectedTutor.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='email' value='$email'>
                                <input type='hidden' name='name' value='$name'>
                                <button type='submit' class='reject-btn'>Reject</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No records found</td></tr>";
            }
            $connect->close();
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>