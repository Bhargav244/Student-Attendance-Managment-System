<?php
session_start();

if (!isset($_SESSION['principal_logged_in']) || $_SESSION['principal_logged_in'] !== true) {
    header('Location: principalogin.php');
    exit;
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];

    $sql = "DELETE FROM student WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting student: " . $conn->error . "');</script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link rel="stylesheet" href="ds.css">
</head>
<body>
<div class="dashboard">
        <h1> Admin Dashboard</h1>
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
    <div class="main-content">
        <div class="content">
            <div class="form-container">
                <h2>Delete Student</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="student_id">Student ID to Delete:</label>
                        <input type="text" id="student_id" name="student_id" required>
                    </div>
                    <button type="submit">Delete Student</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>