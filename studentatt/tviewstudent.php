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

// Initialize variables
$attendance_records = [];
$student_id = '';
$class_filter = isset($_POST['class']) ? $_POST['class'] : '';

// Fetch students based on class filter
$sql_students = "SELECT * FROM student";
if (!empty($class_filter)) {
    $sql_students .= " WHERE class = '$class_filter'";
}
$students_result = $conn->query($sql_students);

// Check if a student is selected for viewing attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Fetch attendance for the selected student for the past 6 months
    $sql_attendance = "SELECT a.date, a.status, s.name, s.class
                       FROM attendance a
                       JOIN student s ON a.student_id = s.student_id
                       WHERE a.student_id = '$student_id' AND a.date >= CURDATE() - INTERVAL 6 MONTH";
    $attendance_result = $conn->query($sql_attendance);

    // Store the attendance data in an array
    if ($attendance_result->num_rows > 0) {
        while ($row = $attendance_result->fetch_assoc()) {
            $attendance_records[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Attendance</title>
    <link rel="stylesheet" href="tview.css">
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
        <h2>View Student Attendance</h2>
        <form method="POST">
            <label for="class">Select Class:</label>
            <select id="class" name="class" onchange="this.form.submit()">
                <option value="">All Classes</option>
                <option value="FYBCA" <?php if ($class_filter == 'FYBCA') echo 'selected'; ?>>FYBCA</option>
                <option value="SYBCA" <?php if ($class_filter == 'SYBCA') echo 'selected'; ?>>SYBCA</option>
                <option value="TYBCA" <?php if ($class_filter == 'TYBCA') echo 'selected'; ?>>TYBCA</option>
            </select>
            <label for="student_id">Select Student</label>
            <select id="student_id" name="student_id" required>
                <option value="">Select a student</option>
                <?php
                if ($students_result->num_rows > 0) {
                    while ($row = $students_result->fetch_assoc()) {
                        $selected = ($student_id == $row['student_id']) ? 'selected' : '';
                        echo "<option value='{$row['student_id']}' {$selected}>{$row['name']} (Roll No: {$row['roll_no']})</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">View Attendance</button>
        </form>
    </div>

    <?php if (count($attendance_records) > 0): ?>
        <div class="attendance-records">
            <h3>Attendance Records for Student</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($attendance_records as $record): ?>
                    <tr>
                        <td><?php echo $record['name']; ?></td>
                        <td><?php echo $record['class']; ?></td>
                        <td><?php echo $record['date']; ?></td>
                        <td><?php echo $record['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'])): ?>
        <p>No attendance records found for the selected student in the past 6 months.</p>
    <?php endif; ?>
</body>
</html>
