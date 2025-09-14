<?php
session_start();
include "../DB/config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'health_officer') {
    header("Location: ../View/login.php");
    exit();
}

$officer_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $semester = $_POST['semester'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE students SET phone=?, semester=?, department=?, dob=?, address=? WHERE id=?");
    $stmt->bind_param("sssssi", $phone, $semester, $department, $dob, $address, $student_id);

    if ($stmt->execute()) {
        header("Location: ../View/manage_profile.php?success=Profile updated successfully");
    } else {
        header("Location: ../View/manage_profile.php?error=Error updating profile");
    }
    exit();
}
?>
