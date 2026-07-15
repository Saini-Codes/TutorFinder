<?php
session_start();
include("dbconnect.php");

// ---------- Handle Rating Submission ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tid'])) {
    $tutor = $_POST['tid'];
    $student = $_POST['student_email'];
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $feedback = $_POST['feedback'] ?? '';

    if (empty($tutor) || empty($student)) {
        echo "❌ Missing tutor or student info.";
    } elseif ($rating >= 1 && $rating <= 5) {
        
        $stmt = $connect->prepare("SELECT id FROM ratings WHERE tutor_id = ? AND student_email = ?");
        $stmt->bind_param("is", $tutor, $student);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            
            $stmt->close();
            $update = $connect->prepare("UPDATE ratings SET rating = ?, review = ? WHERE tutor_id = ? AND student_email = ?");
            $update->bind_param("ssis", $rating, $feedback, $tutor, $student);
            if ($update->execute()) {
                echo "✅ Rating updated successfully!";
            } else {
                echo "❌ Failed to update rating.";
            }
            $update->close();
        } else {
          
            $stmt->close();
            $insert = $connect->prepare("INSERT INTO ratings (tutor_id, student_email, rating, review) VALUES (?, ?, ?, ?)");
            $insert->bind_param("isss", $tutor, $student, $rating, $feedback);
            if ($insert->execute()) {
                echo "✅ Rating submitted successfully!";
            } else {
                echo "❌ Failed to submit rating.";
            }
            $insert->close();
        }
    } else {
        echo "❌ Invalid rating value.";
    }

    exit;
}

// ---------- Serve Rating Form ----------
if (isset($_GET['ajax']) && $_GET['ajax'] == 1 && isset($_GET['tid'])) {
    $tid = mysqli_real_escape_string($connect, $_GET['tid']);
    $student_email = $_SESSION['email'] ?? '';
    $tutor_name = '';
    $existing_rating = null;
    $existing_feedback = '';

    // Fetch tutor name
    $result = mysqli_query($connect, "SELECT name FROM tutor WHERE tid = '$tid' LIMIT 1");
    if ($row = mysqli_fetch_assoc($result)) {
        $tutor_name = $row['name'];
    }

    // Check for existing rating
    if (!empty($student_email)) {
        $stmt = $connect->prepare("SELECT rating, review FROM ratings WHERE tutor_id = ? AND student_email = ? LIMIT 1");
        $stmt->bind_param("is", $tid, $student_email);
        $stmt->execute();
        $stmt->bind_result($existing_rating, $existing_feedback);
        $stmt->fetch();
        $stmt->close();
    }

    $alreadyRated = ($existing_rating !== null);
?>
<div class="rating-card">
    <h3 class="text-center mb-4"><?= $alreadyRated ? 'Update Your Rating' : 'Rate Your Tutor'; ?></h3>
    <?php if (!empty($tutor_name)): ?>
        <p class="text-center">Tutor: <strong><?= htmlspecialchars($tutor_name); ?></strong></p>
        <?php if ($alreadyRated): ?>
            <p class="text-warning text-center">⚠️ You have already rated. You can update your rating below.</p>
        <?php endif; ?>
        <form id="ratingForm" method="POST">
            <input type="hidden" name="tid" value="<?= $tid ?>">
            <input type="hidden" name="student_email" value="<?= htmlspecialchars($student_email); ?>">
            <div class="star-rating mb-3 text-center">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                    <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?= ($existing_rating == $i) ? 'checked' : '' ?> required>
                    <label for="star<?= $i ?>">&#9733;</label>
                <?php endfor; ?>
            </div>
            <textarea name="feedback" rows="4" class="form-control" placeholder="Optional feedback..."><?= htmlspecialchars($existing_feedback) ?></textarea>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-submit"><?= $alreadyRated ? 'Update Rating' : 'Submit Rating'; ?></button>
            </div>
        </form>
    <?php else: ?>
        <p class="text-center text-danger">❌ Tutor not found.</p>
    <?php endif; ?>
</div>

<div id="ratingPopup" class="popup-overlay" style="display:none;">
  <div class="popup-content">
    <span class="close-btn" onclick="this.parentElement.parentElement.style.display='none'">&times;</span>
    <div id="popupMessage" class="text-center"></div>
  </div>
</div>

<style>
.rating-card { padding: 30px 20px; border-radius: 20px; background: #fff; max-width: 500px; margin: auto; font-family: 'Poppins', sans-serif; }
.star-rating {
    direction: rtl;
    font-size: 38px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}
.star-rating input { display: none; }
.star-rating label { color: #ccc; cursor: pointer; padding: 0 5px; transition: color 0.3s ease; }
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label { color: gold; }
textarea { border-radius: 10px; resize: none; width: 100%; padding: 10px; }
.btn-submit { background: linear-gradient(135deg, #6a11cb, #2575fc); color: white; font-weight: 600; border: none; border-radius: 12px; padding: 10px 20px; }
.popup-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 9999; }
.popup-content { background: #fff; padding: 25px 30px; border-radius: 10px; max-width: 400px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2); position: relative; font-family: 'Poppins', sans-serif; }
.close-btn { position: absolute; top: 8px; right: 15px; font-size: 20px; font-weight: bold; cursor: pointer; color: #888; }
</style>

<script>
setTimeout(() => {
    const form = document.getElementById("ratingForm");
    const popup = document.getElementById("ratingPopup");
    const popupMessage = document.getElementById("popupMessage");

    if (!form) return;

    form.onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch("RatingTutor.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            popupMessage.innerHTML = response;
            popup.style.display = "flex";

            if (response.includes("✅")) {
                [...form.elements].forEach(el => el.disabled = true);
                setTimeout(() => {
                    popup.style.display = "none";
                    location.reload(); 
                }, 3000);
            }
        })
        .catch(() => {
            popupMessage.innerHTML = "❌ Network error. Try again.";
            popup.style.display = "flex";
        });
    };
}, 200);
</script>
<?php
exit;
}
?>
