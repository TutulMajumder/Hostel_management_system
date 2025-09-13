<?php
session_start();
include "../db/config.php"; // DB connection

// Redirect if not logged in
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

// Fetch officer info
$officer = ['username'=>'N/A','email'=>'N/A'];
$officer_result = $conn->query("SELECT username, email FROM health_officers WHERE username='$username' LIMIT 1");
if ($officer_result && $officer_result->num_rows > 0) {
    $officer = $officer_result->fetch_assoc();
}

// Fetch salary history
$salary_records = [];
$salary_result = $conn->query("SELECT * FROM salary_history WHERE username='$username' ORDER BY month_year DESC");
if ($salary_result && $salary_result->num_rows > 0) {
    while ($row = $salary_result->fetch_assoc()) {
        $salary_records[] = $row;
    }
}
?>
