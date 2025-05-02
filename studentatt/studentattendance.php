<?php
session_start();

if (!isset($_SESSION['teacher_logged_in']) || $_SESSION['teacher_logged_in'] !== true) {
    header('Location: teacher_login.php');
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'attendance_system');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Initialize class filter
$class_filter = isset($_GET['class']) ? $_GET['class'] : '';

// Build SQL query based on class filter
$sql = "SELECT * FROM student";
if (!empty($class_filter)) {
    $sql .= " WHERE class = '$class_filter'";
}

$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get selected student and attendance status from the form
    $student_id = $_POST['student_id'];
    $status = $_POST['status'];

    // Record attendance for the student
    $date = date('Y-m-d'); // Current date
    $sql_insert = "INSERT INTO attendance (student_id, date, status) VALUES ('$student_id', '$date', '$status')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('Attendance marked successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Attendance</title>
    <link rel="stylesheet" href="statt.css">
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
 
    <div class="attendance-form">
        <h2>Take Attendance</h2>
        <div class="class-buttons">
        <a href="studentattendance.php?class=FYBCA">FYBCA</a>
        <a href="studentattendance.php?class=SYBCA">SYBCA</a>
        <a href="studentattendance.php?class=TYBCA">TYBCA</a>
    </div>
        <form method="POST">
            <label for="student_id">Select Student</label>
            <select id="student_id" name="student_id" required>
                <option value="">Select a student</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['student_id']}'>{$row['name']} (Roll No: {$row['roll_no']})</option>";
                    }
                }
                ?>
            </select>

            <label for="status">Attendance Status</label>
            <select id="status" name="status" required>
                <option value="">Select status</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
            </select>

            <button type="submit">Submit Attendance</button>
        </form>
    </div>
</body>
</html>
