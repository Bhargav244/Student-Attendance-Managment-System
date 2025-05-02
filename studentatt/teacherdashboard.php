<?php
session_start();

if (!isset($_SESSION['teacher_logged_in']) || $_SESSION['teacher_logged_in'] !== true) {
    header('Location: teacher_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="tdash.css">
</head>
<body>
    <div class="dashboard">
        <h1>Welcome Teacher <?php echo $_SESSION['teacher_username']; ?></h1>
        <nav>
            <ul>
                <li><a href="studentattendance.php">Take Student Attendance</a></li>
                <li><a href="tviewstudent.php">View Attendance</a></li>
                <li><a href="tlogout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
