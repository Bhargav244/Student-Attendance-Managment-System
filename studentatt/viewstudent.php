<?php
session_start();

if (!isset($_SESSION['principal_logged_in']) || $_SESSION['principal_logged_in'] !== true) {
    header('Location: principal_login.php');
    exit;
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch all students
$sql = "SELECT * FROM student";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="aa2.css">
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

    <div class="main-content">
        <div class="content">
            <div class="form-container">
                <h2>List of Students</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Roll No</th>
                            <th>Email</th>
                            <th>Parent Name</th>
                            <th>Parent Phone</th>
                            <th>Student Phone</th>
                            <th>Birth Date</th>
                            <th>Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['roll_no']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['parent_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['parent_phone_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['student_phone_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['class']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No students found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
