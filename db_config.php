<?php
$host = "localhost"; // Database host
$password = ""; // Database password (empty for default XAMPP setup)
$username = "root"; // Database username
$dbname = "smartcareers_db"; // Database name

$conn = mysqli_connect($host, $username, $password, $dbname); // Establish connection to the MySQL database

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());  // Handle connection errors gracefully
}
?>