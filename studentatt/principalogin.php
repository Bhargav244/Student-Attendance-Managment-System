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

    // Check if the principal exists in the database
    $sql = "SELECT * FROM principal WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['principal_logged_in'] = true;
        header('Location: principaldashboard.php'); // Redirect to principal dashboard
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="plogin2.css">
</head>
<body>
    <div class="back-to-home">
        <a href="home.html">Back to Home</a>
    </div>
    <div class="login-form">
        <h2>Admin Login</h2>
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
