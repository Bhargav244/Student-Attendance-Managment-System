<?php
session_start();

if (!isset($_SESSION['principal_logged_in']) || $_SESSION['principal_logged_in'] !== true) {
    header('Location: principalogin.php');
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'attendance_system');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch all teachers
$sql = "SELECT * FROM teacher";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Teachers</title>
    <link rel="stylesheet" href="vt.css">
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
    <div class="teachers-list">
        <h2>List of Teachers</h2>
        <table>
            <tr>
                <th>Teacher ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Gender</th>
                <th>Date of Birth</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['teacher_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone_number']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['date_of_birth']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No teachers found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
