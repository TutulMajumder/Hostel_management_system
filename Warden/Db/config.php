<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hostel_management_system";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection Fail" . $conn->connect_error);
}
