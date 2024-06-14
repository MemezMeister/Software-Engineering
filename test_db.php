<?php
$servername = "localhost";
$username = "users"; // Your actual database username
$password = ""; // Your actual database password (empty string if none)
$dbname = "games_db"; // Your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
