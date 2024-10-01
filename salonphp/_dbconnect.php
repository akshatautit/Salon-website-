<?php
// Database connection variables
$servername = "localhost";  // Usually "localhost" for local server
$username = "root";         // Default XAMPP username is "root"
$password = "";             // Default XAMPP password is empty
$dbname = "users"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
