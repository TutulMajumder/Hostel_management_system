<?php

session_start();

include "../DB/apply_room_DB.php";

if (!isset($_SESSION['id'])) {

    header("Location: ../View/login.php");

    exit();
}

$student_id = $_SESSION['id'];


if (isset($_POST['delete'])) {

    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");

    $stmt->bind_param("i", $student_id);

    $stmt->execute();

    session_destroy();

    header("Location: ../View/login.php?success=Profile deleted successfully");
    
    exit();
}
?>
