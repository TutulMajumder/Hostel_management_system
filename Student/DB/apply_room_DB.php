<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname =  "hostel_management_system";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the code reaches this point, the connection was successful
//echo "Connected successfully to the database.";

// You can now proceed with your database operations
?>