<?php
session_start();
session_destroy(); // Destroy the session
header('Location: teacherlogin.php'); // Redirect to the login page
exit;
?>
