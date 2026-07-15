<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Optional: Prevent back button after logout
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page
header("Location: TutorLogIn.php");
exit();
?>
