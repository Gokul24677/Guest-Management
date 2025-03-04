<?php
// Database connection settings
$host = "localhost"; // Database host
$user = "root";      // Database username
$password = "";      // Database password
$dbname = "vms";     // Database name

// Create connection
$db = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>