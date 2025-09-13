<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prevent direct access without login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../View/login.php");
    exit();
}
