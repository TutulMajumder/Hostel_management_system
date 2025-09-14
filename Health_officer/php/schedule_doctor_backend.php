<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? '') !== "health_officer") {
    header("Location: ../view/login.php");
    exit();
}

include "../db/config.php";  // DB connection

$success = $error = "";

// Add new visit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_visit'])) {
    $doctor  = trim($_POST['doctor_name']);
    $date    = trim($_POST['visit_date']);
    $time    = trim($_POST['visit_time']);
    $purpose = trim($_POST['purpose']);
    $slots   = trim($_POST['max_slots']);

    if ($doctor === "" || $date === "" || $time === "" || $purpose === "" || $slots === "") {
        $error = "Please fill all fields!";
    } else {
        $sql = "INSERT INTO doctor_visits (doctor_name, visit_date, visit_time, purpose, max_slots) 
                VALUES ('$doctor', '$date', '$time', '$purpose', '$slots')";
        if ($conn->query($sql) === TRUE) {
            $success = "Doctor assigned successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

// Cancel visit
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (!empty($id)) {
        $sql = "DELETE FROM doctor_visits WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $success = "Doctor visit cancelled successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

// Fetch visits
$result = $conn->query("SELECT * FROM doctor_visits ORDER BY visit_date, visit_time");
?>
