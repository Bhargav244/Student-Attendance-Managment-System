<?php
session_start();

if (!isset($_SESSION['principal_logged_in']) || $_SESSION['principal_logged_in'] !== true) {
    header('Location: principal_login.php');
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
    $teacher_id = $_POST['teacher_id'];

    $sql = "DELETE FROM teacher WHERE teacher_id='$teacher_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Teacher</title>
    <link rel="stylesheet" href="ct4.css">
</head>
<body>
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
    <div class="form-container">
        <h2>Delete Teacher</h2>
        <form method="POST">
            <label for="teacher_id">Enter Teacher ID to Delete:</label>
            <input type="text" id="teacher_id" name="teacher_id" required>
            <button type="submit">Delete Teacher</button>
        </form>
    </div>
</body>
</html>