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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];

    $sql = "UPDATE teacher SET 
            username='$username', 
            password='$password', 
            name='$name',
            email='$email',
            phone_number='$phone_number',
            gender='$gender',
            date_of_birth='$date_of_birth'
            WHERE teacher_id='$teacher_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher updated successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Fetch teacher details
$teacher_id = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : null;
$teacher = null;

if ($teacher_id) {
    $sql = "SELECT * FROM teacher WHERE teacher_id='$teacher_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
    } else {
        echo "<script>alert('Teacher not found');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Teacher</title>
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
        <h2>Update Teacher</h2>
        <form method="GET" action="">
            <label for="teacher_id">Enter Teacher ID to Update:</label>
            <input type="text" id="teacher_id" name="teacher_id" required>
            <button type="submit">Select Teacher</button>
        </form>

        <?php if ($teacher): ?>
        <form method="POST">
            <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>">

            <label for="username">Teacher Username</label>
            <input type="text" id="username" name="username" value="<?php echo $teacher['username']; ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo $teacher['password']; ?>" required>

            <label for="name">Teacher Name</label>
            <input type="text" id="name" name="name" value="<?php echo $teacher['name']; ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $teacher['email']; ?>" required>

            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $teacher['phone_number']; ?>" required>

            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if($teacher['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($teacher['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if($teacher['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $teacher['date_of_birth']; ?>" required>

            <button type="submit">Update Teacher</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>