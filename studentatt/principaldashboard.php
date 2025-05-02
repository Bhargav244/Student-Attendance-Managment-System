<?php
session_start();

if (!isset($_SESSION['principal_logged_in']) || $_SESSION['principal_logged_in'] !== true) {
    header('Location: principalogin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Dashboard</title>
    <link rel="stylesheet" href="pdashboard2.css">
</head>
<body>
    <div class="dashboard1">
        <h1>Welcome to Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="createstudent.php">Create Student</a></li>
                <li><a href="viewstudent.php">View Students</a></li>
                <li><a href="viewattendance.php">View Attendance</a></li>
                <li><a href="updatestudent.php">Update Student</a></li>
                <li><a href="deletestudent.php">Delete Student</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
    <div class="dashboard2">
        <h1>Teacher Management</h1>
        <nav>
            <ul>
                <li><a href="createteacher.php">Create Teacher</a></li>
                <li><a href="viewteacher.php">View Teachers</a></li>
                <li><a href="updateteacher.php">Update Teacher</a></li>
                <li><a href="deleteteacher.php">Delete Teacher</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
