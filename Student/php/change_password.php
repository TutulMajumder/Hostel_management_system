<?php

session_start();

include "../DB/apply_room_DB.php";



if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student' || !isset($_SESSION['user_id'])) {

    header("Location: ../View/login.php");

    exit();

}

$student_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    
    $current = trim($_POST['current_password'] ?? '');

    $new = trim($_POST['new_password'] ?? '');

    $confirm = trim($_POST['confirm_password'] ?? '');


    
    if (empty($current) || empty($new) || empty($confirm)) {

        header("Location: ../View/profile.php?error=Please fill in all password fields");

        exit();

    }

    
    $stmt = $conn->prepare("SELECT password FROM students WHERE id=?");


    $stmt->bind_param("i", $student_id);


    $stmt->execute();

    $result = $stmt->get_result();

    $student = $result->fetch_assoc();


    if (!$student) {

        header("Location: ../View/profile.php?error=Student not found");

        exit();
    }

    
    if (!password_verify($current, $student['password'])) {

        header("Location: ../View/profile.php?error=Current password is incorrect");

        exit();
    }

    
    if ($new !== $confirm) {


        header("Location: ../View/profile.php?error=New passwords do not match");

        exit();

    }


    $new_hash = password_hash($new, PASSWORD_DEFAULT);


    $stmt = $conn->prepare("UPDATE students SET password=? WHERE id=?");

    $stmt->bind_param("si", $new_hash, $student_id);


    if ($stmt->execute()) {

        header("Location: ../View/profile.php?success=Password changed successfully");

    } else {

        header("Location: ../View/profile.php?error=Error updating password");

    }

    exit();
}

?>
