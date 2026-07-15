<?php
include("../dbconnect.php");
session_start();
$admin_email = $_SESSION['admin_email'];
$_SESSION['admin_email'] = $admin_email;
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = trim($_POST['search_term']);
    $stmt = $connect->prepare("SELECT * FROM student WHERE name LIKE CONCAT('%', ?, '%') OR email LIKE CONCAT('%', ?, '%') OR phone LIKE CONCAT('%', ?, '%')" );
    $stmt->bind_param("sss", $searchTerm, $searchTerm , $searchTerm);
} else {
    $stmt = $connect->prepare("SELECT * FROM student");
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Student List</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at top left, #ff4b5c, #000000);
            font-family: 'Poppins', sans-serif;
            padding: 40px 20px;
        }
        .student-card {
            position: relative;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
            padding: 50px;
            margin-bottom: 30px;
            text-align: justify;
            transition: 0.3s;
            display: flex;
            gap: 20px;
        }
        .student-card:hover {
            background-color: #f5e0e0;
        }
        .card-buttons {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            z-index: 10;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .profile-pic {
            width: 300px;
            height: 300px;
            border-radius: 15px;
            object-fit: cover;
            border: 3px solid #ff9a9e;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .student-details {
            flex-grow: 1;
        }
        .info-line {
            font-size: 16px;
            margin-bottom: 6px;
            color: #333;
        }
        .btn-remove {
            background: linear-gradient(#d50000, #ff1744);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
            display: block;
        }
        .btn-remove:hover {
            transform: scale(1.05);
            background: linear-gradient(#b71c1c, #e53935);
        }
        h2 {
            text-align: center;
            font-weight: 700;
            color: #000000ff;
            margin-bottom: 40px;
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
<form method="post" class="d-flex justify-content-center mb-4">
    <input type="text" name="search_term" class="form-control w-50 me-2" placeholder="Search by username or email or phone..." value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : '' ?>">
    <button type="submit" name="search" class="btn btn-danger fw-bold"> Search</button>
</form>

<h2><img src="../Images/StudentList.png" style="height: 50px; vertical-align: middle; margin-right: 10px;">Student List</h2>
<div class="container">
    <?php if ($result->num_rows === 0): ?>
    <div class="alert alert-warning text-center mt-4">No students found matching your search.</div>
    <?php endif; ?>
    <?php while ($row = mysqli_fetch_assoc($result)): 
        $profilePath = (!empty($row['profilepic']) && !empty($row['profiledir'])) 
            ?"../" . htmlspecialchars($row['profiledir'] . '/' . $row['profilepic']) 
            : 'default-profile.png';
    ?>
    <div class="student-card">
        <div>
            <img src="<?= $profilePath ?>" class="profile-pic" alt="Profile Pic" onerror="this.onerror=null;this.src='default-profile.png';">
        </div>
        <div class="student-details">
            <div class="info-line"><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></div>
            <div class="info-line"><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></div>
            <div class="info-line"><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></div>
            <div class="info-line"><strong>Gender:</strong> <?= htmlspecialchars($row['gender']) ?></div>
            <div class="info-line"><strong>Semester:</strong> <?= htmlspecialchars($row['semester']) ?></div>
            <div class="info-line"><strong>Address:</strong> <?= htmlspecialchars($row['street'] . ', ' . $row['city'] . ' - ' . $row['zip'] . ', ' . $row['district'] . ', ' . $row['state']) ?></div>
        </div>
        <div class="position-absolute top-50 end-0 translate-middle-y me-3 d-flex flex-column align-items-end">
            <button class="btn btn-danger mb-2 w-100" 
                    data-bs-toggle="modal" 
                    data-bs-target="#removeModal" 
                    data-student="<?= htmlspecialchars($row['email']) ?>" 
                    data-name="<?= htmlspecialchars($row['name']) ?>">Remove</button>
            <button class="btn btn-warning fw-bold w-100" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal" 
                    data-original_email="<?= htmlspecialchars($row['email']) ?>">Edit Email</button>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<!-- Remove Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-light">
      <form id="removeForm" action="RemoveStudent.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Remove Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="student_email" id="modalEmail">
          <div class="mb-3">
            <label class="form-label"><strong>Email Subject:</strong></label>
            <input type="text" name="mail_subject" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Reason for Removal:</strong></label>
            <textarea name="reason" class="form-control" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Confirm Remove & Send Email</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Email Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-light">
      <form id="editForm" method="POST" action="EditStudent.php">
        <div class="modal-header">
          <h5 class="modal-title">Edit Student Email</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- Hidden original email -->
          <input type="hidden" name="original_email" id="original_email">

          <div class="mb-3">
            <label><strong>New Email:</strong></label>
            <input type="text" name="new_email" class="form-control" id="new_email" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const removeModal = document.getElementById('removeModal');
  removeModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const email = button.getAttribute('data-student');
    const name = button.getAttribute('data-name');
    document.getElementById('modalEmail').value = email;
    document.getElementById('modalTitle').textContent = `Remove ${name}`;
  });

  const editModal = document.getElementById('editModal');
  if (editModal) {
    editModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const originalEmail = button.getAttribute('data-original_email');
      const originalEmailInput = document.getElementById('original_email');
      if (originalEmail && originalEmailInput) {
        originalEmailInput.value = originalEmail;
      }
    });
  }
});
</script>
</body>
</html>
