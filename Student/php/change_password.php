<?php

session_start();

include "../DB/apply_room_DB.php";

if (!isset($_SESSION['id'])) {

    header("Location: ../View/login.php");

    exit();
}

$student_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $current = $_POST['current_password'];

    $new = $_POST['new_password'];

    $confirm = $_POST['confirm_password'];


    $stmt = $conn->prepare("SELECT password FROM students WHERE id=?");

    $stmt->bind_param("i", $student_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $student = $result->fetch_assoc();

    if (!password_verify($current, $student['password'])) {

        header("Location: ../View/profile.php?error=Current password is incorrect");

    } elseif ($new !== $confirm) {

        header("Location: ../View/profile.php?error=Passwords do not match");

    } else {

        $new_hash = password_hash($new, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE students SET password=? WHERE id=?");

        $stmt->bind_param("si", $new_hash, $student_id);

        $stmt->execute();

        header("Location: ../View/profile.php?success=Password changed successfully");
    }
    exit();
}

?>
