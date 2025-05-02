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
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $parent_name = $_POST['parent_name'];
    $parent_phone_number = $_POST['parent_phone_number'];
    $student_phone_number = $_POST['student_phone_number'];
    $dob = $_POST['date_of_birth'];
    $class = $_POST['class'];

    $sql = "UPDATE student SET 
            name='$name', 
            gender='$gender', 
            roll_no='$roll_no', 
            email='$email', 
            parent_name='$parent_name', 
            parent_phone_number='$parent_phone_number', 
            student_phone_number='$student_phone_number', 
            date_of_birth='$dob',
            class='$class'
            WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student updated successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Fetch student details
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
$student = null;

if ($student_id) {
    $sql = "SELECT * FROM student WHERE student_id='$student_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "<script>alert('Student not found');</script>";
    }
} else {
    echo "<script>alert('No student ID provided');</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="us.css">
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
            <h2>Update Student</h2>
            <form method="GET" action="">
                <div class="form-group">
                    <label for="student_id">Select Student ID</label>
                    <input type="text" id="student_id" name="student_id" required>
                    <button type="submit">Select Student</button>
                </div>
            </form>
            <?php if ($student): ?>
            <form method="POST">
                <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                <div class="form-group">
                    <label for="name">Student Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $student['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="Male" <?php if ($student['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($student['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if ($student['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="roll_no">Roll No</label>
                    <input type="text" id="roll_no" name="roll_no" value="<?php echo $student['roll_no']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="parent_name">Parent Name</label>
                    <input type="text" id="parent_name" name="parent_name" value="<?php echo $student['parent_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="parent_phone_number">Parent Phone Number</label>
                    <input type="text" id="parent_phone_number" name="parent_phone_number" value="<?php echo $student['parent_phone_number']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="student_phone_number">Student Phone Number</label>
                    <input type="text" id="student_phone_number" name="student_phone_number" value="<?php echo $student['student_phone_number']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $student['date_of_birth']; ?>" required>
                </div>
                 <div class="form-group">
                    <label for="class">Class</label>
                    <select id="class" name="class" required>
                        <option value="FYBCA" <?php if ($student['class'] == 'FYBCA') echo 'selected'; ?>>FYBCA</option>
                        <option value="SYBCA" <?php if ($student['class'] == 'SYBCA') echo 'selected'; ?>>SYBCA</option>
                        <option value="TYBCA" <?php if ($student['class'] == 'TYBCA') echo 'selected'; ?>>TYBCA</option>
                    </select>
                </div>
                <button type="submit">Update Student</button>
            </form>
            <?php else: ?>
            <p>Student not found or no student ID provided.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>