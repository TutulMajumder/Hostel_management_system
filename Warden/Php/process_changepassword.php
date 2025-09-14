<?php
session_start();
include "../Db/config.php";


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_table'])) {
    header("Location: ../View/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$table   = $_SESSION['user_table'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password     = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Validation
    if (empty($new_password) || empty($confirm_password)) {
        $_SESSION['errors'] = "Both fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $_SESSION['errors'] = "Passwords do not match.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $new_password)) {
        $_SESSION['errors'] = "Password must be at least 8 characters long, include one uppercase, one lowercase, one number, and one special character.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql = "UPDATE $table SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Password changed successfully!";
        } else {
            $_SESSION['errors'] = "Error updating password: " . $stmt->error;
        }
        $stmt->close();
    }

    header("Location: ../View/change_password.php");
    exit();
}

?>
