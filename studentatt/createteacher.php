<?php
session_start();

if (!isset($_SESSION['principal_logged_in']) || $_SESSION['principal_logged_in'] !== true) {
    header('Location: principal_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'attendance_system');
    
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    // Get teacher data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    
    // Insert teacher into the database
    $sql = "INSERT INTO teacher (username, password, name, email, phone_number, gender, date_of_birth) 
            VALUES ('$username', '$password', '$name', '$email', '$phone_number', '$gender', '$date_of_birth')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher added successfully!');</script>";
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
    <title>Create Teacher</title>
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
    <div class="back-to-dashboard">
        <a href="principaldashboard.php">Back to Dashboard</a>
    </div>
    <div class="form-container">
        <h2>Create Teacher</h2>
        <form method="POST">
            <label for="username">Teacher Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="name">Teacher Name</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" required>
            
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>

            <button type="submit">Create Teacher</button>
        </form>
    </div>
</body>
</html>
