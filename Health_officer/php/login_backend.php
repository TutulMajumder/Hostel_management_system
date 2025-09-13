<?php
session_start();
include "../db/config.php";

// If form not submitted → back to login
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../view/login.php");
    exit();
}

$user = trim($_POST["username"] ?? "");
$pass = trim($_POST["password"] ?? "");
$remember = isset($_POST["remember"]);

// Basic validation
if (empty($user) || empty($pass)) {
    header("Location: ../view/login.php?error=" . urlencode("Please fill in all fields"));
    exit();
}

// Query DB for user
$stmt = $conn->prepare("SELECT * FROM health_officers WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // 🔑 Plain password check (change to password_verify if using hashing)
    if ($row['password'] === $pass) {
        $_SESSION["username"] = $user;

        if ($remember) {
            setcookie("username", $user, time() + (86400*30), "/");
        }

        header("Location: ../view/dashboard.php");
        exit();
    } else {
        header("Location: ../view/login.php?error=" . urlencode("Invalid password!"));
        exit();
    }
} else {
    header("Location: ../view/login.php?error=" . urlencode("User not found!"));
    exit();
}
