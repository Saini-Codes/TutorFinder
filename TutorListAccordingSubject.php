<?php
include("dbconnect.php");
session_start();
$subjectInput = isset($_POST['sub']) ? trim($_POST['sub']) : '';

$_SESSION['subject'] = $subjectInput;

if (empty($subjectInput)) {
    echo '
    <div style="..."> <!-- Your warning message stays unchanged --> </div>';
    exit;
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$_SESSION['email'] = $email; 

$sql = "SELECT * FROM tutor WHERE subject1 LIKE ? OR subject2 LIKE ? OR subject3 LIKE ?";
$stmt = $connect->prepare($sql);
$likeSub = "%$subjectInput%";
$stmt->bind_param("sss", $likeSub, $likeSub, $likeSub);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TutorFinder - Tutors List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            font-family: 'Poppins', sans-serif;
            padding: 40px 20px;
        }
        h2 {
            color: #2e7d32;
            text-align: center;
            font-weight: 800;
            margin-bottom: 40px;
        }
        .tutor-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
            padding: 24px;
            margin-bottom: 30px;
            transition: 0.3s;
        }
        .tutor-card:hover {
            background-color: #fbe3e3;
            transform: translateY(-4px);
        }

        .trusted-card {
            background: #fff0bfff !important; /* light golden */
        }

        .tutor-logo {
            width: 300px;
            height: 300px;
            border-radius: 15px;
            object-fit: cover;
            border: 3px solid #ff9a9e;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .tutor-details h4 {
            font-size: 22px;
            font-weight: 700;
            color: #e53935;
            margin-bottom: 8px;
        }
        .trusted-badge {
            display: inline-block;
            margin-left: 8px;
            vertical-align: middle;
            cursor: pointer;
        }
        .trusted-icon {
            height: 30px;
            vertical-align: middle;
            transition: transform 0.3s ease;
        }
        .trusted-badge:hover .trusted-icon {
            transform: scale(1.2);
        }
        .badge-subject {
            background-color:rgb(248, 101, 101);
            color: white;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 13px;
            margin: 3px 6px 3px 0;
            display: inline-block;
        }
        .info-line {
            font-size: 15px;
            margin-bottom: 6px;
            color: #444;
        }
        .rating-display {
            font-size: 17px;
            margin-bottom: 10px;
            color: #000;
            font-weight: 600;
        }
        .rating-display span {
            color: #f39c12;
            font-weight: bold;
        }
        .btn-set {
            text-align: right;
            margin-top: 15px;
        }
        .btn-custom {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            margin: 8px 0;
            transition: all 0.2s ease;
        }
        .btn-custom:hover {
            transform: translateY(-1px);
            filter: brightness(1.15);
        }
        .btn-rate:hover {
            background-color: #ffdc5c;
            color: black;
        }
        .btn-reviews:hover {
            background-color: #48c3d7;
            color: white;
        }
        .request-btn {
            background: linear-gradient(rgb(4, 129, 4), #4CAF50);
            color: white;
            border: none;
            width: 100%;
        }
        .btn-rate {
            background: #ffc107;
            color: black;
            border: none;
            width: 10%;
        }
        .btn-reviews {
            background: #17a2b8;
            color: white;
            border: none;
            width: 100%;
        }
        .reviews-section {
            display: none;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
            margin-top: 12px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.7);
            justify-content: center;
            align-items: center;
        }
        .modal img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 12px;
            border: 3px solid #fff;
        }
    </style>
</head>
<body>

<div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
    <a href="StudentProfile.php" style="
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
<h2><i class="fas fa-book"></i> Tutors Available for "<?= htmlspecialchars($subjectInput); ?>"</h2>

<div class="container">
<?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): 
        $logoPath = (!empty($row['logoDir']) && !empty($row['logo'])) 
            ? htmlspecialchars($row['logoDir'] . '/' . $row['logo']) 
            : 'default-logo.png';

        $tid = $row['tid'];
        $ratingQ = mysqli_query($connect, "SELECT AVG(rating) as avg_rating FROM ratings WHERE tutor_id = '$tid'");
        $ratingRow = mysqli_fetch_assoc($ratingQ);
        $avgRating = $ratingRow['avg_rating'] ? round($ratingRow['avg_rating'], 1) : "N/A";
        $stars = is_numeric($avgRating) ? str_repeat('★', round($avgRating)) . str_repeat('☆', 5 - round($avgRating)) : '☆☆☆☆☆';

        $isTrusted = (strtolower($row['interviewStatus']) === 'accepted');
    ?>
    <div class="tutor-card row align-items-center <?= $isTrusted ? 'trusted-card' : '' ?>"> 
        <div class="col-md-3 text-center">
            <img src="<?= $logoPath ?>" class="tutor-logo" alt="Tutor Photo" onclick="openModal(this.src)" onerror="this.onerror=null;this.src='default-logo.png';">
        </div>
        <div class="col-md-6">
            <div class="tutor-details">
                <h4>
                    <?= htmlspecialchars($row['name']) ?>
                    <span style="font-size:14px;">(<?= htmlspecialchars($row['gender']) ?>)</span>
                    <?php if ($isTrusted): ?>
                        <span class="trusted-badge" title="TutorFinder Trusted!!">
                            <img src="Images/TrustedBadge.png" alt="Trusted" class="trusted-icon">
                        </span>
                    <?php endif; ?>
                </h4>
                <div class="rating-display">⭐ Rating: <span><?= $stars ?></span> <?= is_numeric($avgRating) ? "($avgRating)" : "" ?>
                    <button type="button" class="btn btn-custom btn-rate"
    onclick="openRatingModal('<?= $tid ?>')">Rate</button>

                </div>
                <div>
                    <?php foreach (['subject1' => 'fees1', 'subject2' => 'fees2', 'subject3' => 'fees3'] as $s => $f): ?>
                        <?php if (!empty($row[$s])): ?>
                            <span class="badge-subject"><?= htmlspecialchars($row[$s]) ?> - ₹<?= htmlspecialchars($row[$f]) ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="info-line"><strong>Profession:</strong> <?= htmlspecialchars($row['profession']) ?></div>
                <div class="info-line"><strong>Address:</strong> <?= htmlspecialchars($row['street']) ?>, <?= htmlspecialchars($row['city']) ?> - <?= htmlspecialchars($row['pin']) ?>, <?= htmlspecialchars($row['district']) ?>, <?= htmlspecialchars($row['state']) ?></div>
                <div class="info-line"><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></div>
                <div class="info-line"><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></div>
            </div>
        </div>
        <div class="col-md-3 btn-set">
            <form action="TutorListAccordingSubjectSubmit.php" method="POST">
                <input type="hidden" name="tutor_id" value="<?= $tid ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($row['name']); ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']); ?>">
                <button type="submit" class="btn btn-custom request-btn">Apply Now</button>
                <button type="button" class="btn btn-custom btn-reviews" id="toggleBtn<?= $tid ?>" onclick="toggleReviews('rev<?= $tid ?>', this)">View Reviews</button>
            </form>
        </div>
        <div class="col-12">
            <div class="reviews-section" id="rev<?= $tid ?>">
                <?php
                $reviewQ = mysqli_query($connect, "SELECT student_email, review, rating FROM ratings WHERE tutor_id = '$tid'");
                if (mysqli_num_rows($reviewQ) > 0) {
                    while ($rev = mysqli_fetch_assoc($reviewQ)) {
                        $revStars = str_repeat('★', round($rev['rating'])) . str_repeat('☆', 5 - round($rev['rating']));
                        echo "<div style='margin-bottom:10px;'><strong>" . htmlspecialchars($rev['student_email']) . "</strong> <span style='color:#f39c12;'>$revStars ({$rev['rating']})</span><br>";
                        echo !empty($rev['review']) ? nl2br(htmlspecialchars($rev['review'])) : '<em>No review text provided.</em>';
                        echo "</div>";
                    }
                } else {
                    echo "<p>No reviews yet.</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="alert alert-warning text-center">No tutors found for "<?= htmlspecialchars($subjectInput); ?>"</div>
<?php endif; ?>
</div>
</div>
<!-- Rating Modal -->
<div id="ratingModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
    <div class="modal-content" style="max-width: 500px; background: white; padding: 20px; border-radius: 12px; position: relative;">
        <span onclick="closeRatingModal()" style="position:absolute; top:10px; right:15px; font-size: 24px; cursor: pointer;">&times;</span>
        <div id="ratingModalContent">Loading...</div>
    </div>
</div>
<script>
function toggleReviews(id, btn) {
    const reviewSection = document.getElementById(id);
    if (reviewSection.style.display === 'none' || reviewSection.style.display === '') {
        reviewSection.style.display = 'block';
        btn.textContent = 'Close Reviews';
    } else {
        reviewSection.style.display = 'none';
        btn.textContent = 'View Reviews';
    }
}
function openRatingModal(tid) {
    const modal = document.getElementById("ratingModal");
    const content = document.getElementById("ratingModalContent");
    modal.style.display = "flex";

    fetch("RatingTutor.php?ajax=1&tid=" + tid)
        .then(res => res.text())
        .then(html => {
            content.innerHTML = html;

            // After form is loaded, attach AJAX handler
            const form = content.querySelector("#ratingForm");
            const popup = content.querySelector("#ratingPopup");
            const popupMsg = content.querySelector("#popupMessage");

            if (!form) return;

            form.onsubmit = function (e) {
                e.preventDefault();
                const formData = new FormData(form);

                fetch("RatingTutor.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(response => {
                    popupMsg.innerHTML = response;
                    popup.style.display = "flex";

                    if (response.includes("✅")) {
                        [...form.elements].forEach(el => el.disabled = true);
                        setTimeout(() => {
                            popup.style.display = "none";
                            closeRatingModal();
                            location.reload(); // Optional: refresh to show new rating
                        }, 2500);
                    }
                })
                .catch(() => {
                    popupMsg.innerHTML = "❌ Network error. Please try again.";
                    popup.style.display = "flex";
                });
            };
        });
}

function closeRatingModal() {
    document.getElementById("ratingModal").style.display = "none";
}
</script>

<?php $connect->close(); ?>
</body>
</html>
