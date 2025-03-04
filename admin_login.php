<?php
session_start();
include('dbconn.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password are correct (this is a simple example)
    // In a real application, you should hash passwords and check against a database
    if ($username === 'admin' && $password === 'admin123') { // Example credentials
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'admin'; // Set user role
        header('Location: view_visitors.php'); // Redirect to view visitors page
        exit();
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='admin_login.html';</script>";
    }
}
?>