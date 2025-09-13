<?php
session_start();
include "../db/config.php"; // DB connection

// Session check
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

// Handle password change
if (isset($_POST['change_password'])) {

    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    //  Validation: empty fields
    if (empty($new) || empty($confirm)) {
        $_SESSION['error'] = "All password fields are required!";
    }
    // Validation: match
    elseif ($new !== $confirm) {
        $_SESSION['error'] = "Passwords do not match!";
    }
    // Validation: length
    elseif (strlen($new) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long!";
    }
    else {
        //  Check current password to prevent same password
        $stmt = $conn->prepare("SELECT password FROM health_officers WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($current_hash);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($new, $current_hash)) {
            $_SESSION['error'] = "New password cannot be the same as current password!";
        } else {
            // Update password in DB
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE health_officers SET password=? WHERE username=?");
            $stmt->bind_param("ss", $hash, $username);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Password updated successfully!";
            } else {
                $_SESSION['error'] = "Database error: " . $conn->error;
            }
            $stmt->close();
        }
    }

    // Redirect to frontend to show alert
    header("Location: manage_profile.php");
    exit();
}

// Fetch officer info
$officer_result = $conn->query("SELECT username, email FROM health_officers WHERE username='$username'");
$officer = $officer_result->fetch_assoc();
if (!$officer) $officer = ['username'=>'N/A','email'=>'N/A'];
?>
