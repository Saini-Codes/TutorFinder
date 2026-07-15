<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['name'])) {
    header("Location: StudentLogIn.php");
    exit();
}

$username = $_SESSION['name'];
$sql = "SELECT * FROM student WHERE username='$username'";
$result = $connect->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "<h3 style='color: red; text-align:center;'>⚠️ No profile data found!</h3>";
    exit();
}

$data = $result->fetch_assoc();
$photo = $data['profilepic'] ;
$photoDir = $data['profiledir'];
$_SESSION['phone'] = $data['phone'];
$_SESSION['email'] = $data['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 30px;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
            padding: 40px 30px;
            text-align: center;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ff5c7a;
            box-shadow: 0 4px 12px rgba(255, 92, 122, 0.5);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .profile-pic:hover {
            transform: scale(1.05);
        }

        h2 {
            margin-top: 20px;
            color: #ff4b5c;
        }

        p {
            color: #555;
            margin-bottom: 10px;
        }

        .upload-form {
            margin-top: 15px;
        }

        .upload-label {
            background: linear-gradient(135deg, #ff4b5c, #ff6381);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
        }

.upload-label:hover {
    transform: scale(1.5);
    filter: brightness(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

        .upload-form input[type="file"] {
            display: none;
        }

        .btn, .subject-btn, .search-btn, .logout-btn {
            margin: 12px 6px;
            padding: 10px 22px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            color: white;
            display: inline-block;
        }

        .btn { background: linear-gradient(135deg, #28a745, #218838); }
        .subject-btn { background: linear-gradient(135deg, #ff4b5c, #ff6d7a); }
        .search-btn { background: linear-gradient(135deg, #17a2b8, #138496); }
        .logout-btn { background: linear-gradient(135deg, #dc3545, #c82333); }

        .details {
            display: none;
            margin-top: 25px;
            text-align: left;
            background: #fef6f6;
            padding: 20px;
            border-radius: 16px;
        }

        .edit-form label {
            display: block;
            font-weight: 600;
            margin-top: 12px;
            font-size: 13px;
            color: #444;
        }

        .edit-form input {
            width: 100%;
            padding: 9px 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal img {
            max-width: 90%;
            max-height: 80vh;
            border-radius: 12px;
            box-shadow: 0 0 15px #fff;
        }
.btn:hover, .subject-btn:hover, .search-btn:hover, .logout-btn:hover {
 transform: scale(1.05);
}


    </style>
</head>
<body>

<div class="profile-card">
<img src="<?= htmlspecialchars($photoDir . $photo); ?>" class="profile-pic" id="studentPhoto" onclick="openModal()">

<form class="upload-form" method="POST" action="upload_photo_student.php" enctype="multipart/form-data">
    <label class="upload-label" for="photoInput">Change Photo</label>
    <input type="file" name="photo" id="photoInput" onchange="this.form.submit()">
</form>


    <h2><?= htmlspecialchars($data['name']); ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($data['email']); ?></p>

    <button class="btn" onclick="toggleDetails(this)">See Details</button>

    <div class="details" id="detailsBox">
        <form action="update_profile_student.php" method="POST" class="edit-form">
            <?php
            $fields = [
                'name' => 'Name', 'gender' => 'Gender', 'street' => 'Street', 'city' => 'City',
                'zip' => 'Pin', 'district' => 'District', 'state' => 'State',
                'semester' => 'Semester', 'phone' => 'Phone'
            ];
            foreach ($fields as $field => $label): ?>
                <label><?= $label; ?>:</label>
                <input type="text" name="<?= $field; ?>" value="<?= htmlspecialchars($data[$field]); ?>" required>
            <?php endforeach; ?>
            <div style="text-align:center; margin-top: 20px;">
                <button type="submit" class="btn">Update Profile</button>
            </div>
        </form>
    </div>

    <div>
    <a href="StudentSubjectSelection.php" class="subject-btn" style="font-size: 15px">
        <img src="Images\SearchBooks.png" alt="Subject" style="width:30px; vertical-align: middle; margin-right: 8px;">
        Search Tutor by Subject
    </a>
    <a href="SearchTutorByName.php" class="search-btn" style="font-size: 15px">
        <img src="Images\SearchTutor.png" alt="Search" style="width: 35px; vertical-align: middle; margin-right: 6px;">
        Search Tutor by Name
    </a>
    <a href="TutorListAccordingLocation.php" class="search-btn" style="font-size: 15px">
        <img src="Images\SearchLocation.png" alt="Search" style="width: 30px; vertical-align: middle; margin-right: 6px;">
        Search Tutor by Location
    </a><br>
    <a href="LogOutStudent.php" class="logout-btn" style="font-size: 15px">
        <img src="Images\LogOut.png" alt="Logout" style="width: 30px; vertical-align: middle; margin-right: 6px;">
        Logout
    </a>
</div>

</div>

<div class="modal" id="photoModal" onclick="closeModal()">
    <img id="modalImg" src="">
</div>

<script>
function toggleDetails(button) {
    const box = document.getElementById('detailsBox');
    const visible = box.style.display === 'block';
    box.style.display = visible ? 'none' : 'block';
    button.textContent = visible ? 'See Details' : 'Hide Details';
}

function openModal() {
    const modal = document.getElementById('photoModal');
    const modalImg = document.getElementById('modalImg');
    modalImg.src = document.getElementById('studentPhoto').src;
    modal.style.display = 'flex';
}
function closeModal() {
    document.getElementById('photoModal').style.display = 'none';
}
</script>

</body>
</html>
