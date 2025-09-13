<?php
session_start();
include "../DB/apply_room_DB.php";

// Make sure the user is logged in and is a student
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student' || !isset($_SESSION['user_id'])) {
    header("Location: ../View/login.php");
    exit();
}

// Get the student ID from session
$student_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize input
    $phone = trim($_POST['phone'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Optional: validate input
    if (empty($phone) || empty($dob) || empty($address)) {
        header("Location: ../View/profile.php?error=Please fill in all required fields");
        exit();
    }

    // Update query
    $stmt = $conn->prepare("UPDATE students SET phone=?, dob=?, address=? WHERE id=?");
    $stmt->bind_param("sssi", $phone, $dob, $address, $student_id);

    if ($stmt->execute()) {
        header("Location: ../View/profile.php?success=Profile updated successfully");
    } else {
        header("Location: ../View/profile.php?error=Error updating profile");
    }
    exit();
}
?>
