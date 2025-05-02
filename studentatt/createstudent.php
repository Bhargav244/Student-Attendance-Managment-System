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
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $parent_name = $_POST['parent_name'];
    $parent_phone_number = $_POST['parent_phone_number'];
    $student_phone_number = $_POST['student_phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $class = $_POST['class'];

    // Insert student details into the student table
    $sql = "INSERT INTO student (name, gender, roll_no, email, parent_name, parent_phone_number, student_phone_number, date_of_birth, class) 
            VALUES ('$name', '$gender', '$roll_no', '$email', '$parent_name', '$parent_phone_number', '$student_phone_number', '$date_of_birth', '$class')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <link rel="stylesheet" href="cs.css">
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
<div class="back-to-dashboard">
        <a href="principaldashboard.php">Back to Dashboard</a>
    </div>
<div class="main-content">
    <div class="content">
        <div class="form-container">
            <h2>Create Student</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Student Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="roll_no">Roll No</label>
                    <input type="text" id="roll_no" name="roll_no" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="parent_name">Parent Name</label>
                    <input type="text" id="parent_name" name="parent_name" required>
                </div>
                <div class="form-group">
                    <label for="parent_phone_number">Parent Phone Number</label>
                    <input type="text" id="parent_phone_number" name="parent_phone_number" required>
                </div>
                <div class="form-group">
                    <label for="student_phone_number">Student Phone Number</label>
                    <input type="text" id="student_phone_number" name="student_phone_number" required>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label for="class">Class</label>
                    <select id="class" name="class" required>
                        <option value="FYBCA">FYBCA</option>
                        <option value="SYBCA">SYBCA</option>
                        <option value="TYBCA">TYBCA</option>
                    </select>
                </div>
                <button type="submit">Add Student</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
