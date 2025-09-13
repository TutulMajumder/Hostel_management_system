<?php
session_start();
include "../DB/apply_room_DB.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../View/login.php");
    exit();
}

$student_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $semester = $_POST['semester'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE students SET phone=?, semester=?, department=?, dob=?, address=? WHERE id=?");
    $stmt->bind_param("sssssi", $phone, $semester, $department, $dob, $address, $student_id);

    if ($stmt->execute()) {
        header("Location: ../View/profile.php?success=Profile updated successfully");
    } else {
        header("Location: ../View/profile.php?error=Error updating profile");
    }
    exit();
}
?>
