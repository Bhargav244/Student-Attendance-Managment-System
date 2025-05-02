<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'attendance_system');
    
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the teacher exists in the database
    $sql = "SELECT * FROM teacher WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['teacher_logged_in'] = true;
        $_SESSION['teacher_username'] = $username;
        header('Location: teacherdashboard.php'); // Redirect to teacher dashboard
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <link rel="stylesheet" href="tlogin2.css">
</head>
<body>
    <div class="back-to-home">
        <a href="home.html">Back to Home</a>
    </div>
    <div class="login-form">
        <h2>Teacher Login</h2>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
