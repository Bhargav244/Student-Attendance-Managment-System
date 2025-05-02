<?php
session_start();

if (!isset($_SESSION['principal_logged_in']) || $_SESSION['principal_logged_in'] !== true) {
    header('Location: principal_login.php');
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'attendance_system');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$studentAttendance = [];
$classAttendance = [];

// Handle student attendance form submission
if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $sql = "SELECT s.name, s.roll_no, s.class, a.date, a.status 
            FROM attendance a 
            JOIN student s ON a.student_id = s.student_id 
            WHERE a.student_id = '$student_id' AND a.date >= CURDATE() - INTERVAL 6 MONTH";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $studentAttendance[] = $row;
        }
    }
}

// Handle class attendance form submission
if (isset($_POST['class'])) {
    $class = $_POST['class'];
    $sql = "SELECT s.name, s.roll_no, s.class, a.date, a.status 
            FROM attendance a 
            JOIN student s ON a.student_id = s.student_id 
            WHERE s.class = '$class' AND a.date >= CURDATE() - INTERVAL 6 MONTH";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $classAttendance[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="va2.css">
</head>
<body>
<div class="dashboard">
    <h1>Admin Dashboard</h1>
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

<div class="attendance-options">
    <h2>View Attendance</h2>
    <form method="POST">
        <label for="student_id">View Student Attendance (Enter Student ID):</label>
        <input type="text" id="student_id" name="student_id" required>
        <button type="submit">View Student Attendance</button>
    </form>

    <form method="POST">
        <label for="class">View Class Attendance (Select Class):</label>
        <select id="class" name="class" required>
            <option value="FYBCA">FYBCA</option>
            <option value="SYBCA">SYBCA</option>
            <option value="TYBCA">TYBCA</option>
        </select>
        <button type="submit">View Class Attendance</button>
    </form>
</div>

<?php if (!empty($studentAttendance)): ?>
    <div class="attendance-list">
        <h2>Student Attendance (Last 6 months)</h2>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Roll Number</th>
                <th>Class</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($studentAttendance as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                    <td><?php echo htmlspecialchars($row['class']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>

<?php if (!empty($classAttendance)): ?>
    <div class="attendance-list">
        <h2>Class Attendance (Last 6 months)</h2>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Roll Number</th>
                 <th>Class</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($classAttendance as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                     <td><?php echo htmlspecialchars($row['class']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
