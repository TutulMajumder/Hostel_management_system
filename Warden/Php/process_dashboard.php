<?php
session_start();

// Optional: block direct access if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../View/login.php");
    exit();
}
?>
