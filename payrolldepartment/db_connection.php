<?php
// Database configuration
$servername = "localhost";  
$username = "sbit3i";  
$password = "!SIA102Escapes";  
$database = "enchantedescapes";  
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Close connection (when done with database operations)
// $conn->close();
?>
