<?php
session_start();
include "../Db/config.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_table'])) {
    header("Location: ../View/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$table   = $_SESSION['user_table'];

// --- Fetch user data dynamically
$query = "SELECT id, username, email, phone, gender, dob FROM $table WHERE id = ?";
$stmt  = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name   = trim($_POST['name'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $dob    = trim($_POST['dob'] ?? '');

    // --- Validation ---
    if (empty($name) || empty($phone)) {
        $_SESSION['errors'] = "Full name and phone number are required.";
    } elseif (!preg_match("/^[A-Za-z]/", $name)) {
        $_SESSION['errors'] = "Full name must start with an alphabet.";
    } elseif (!preg_match("/^01[0-9]{9}$/", $phone)) {
        $_SESSION['errors'] = "Phone number must start with 01 and be exactly 11 digits.";
    } elseif (!empty($dob)) {
        $dob_time   = strtotime($dob);
        $today_time = strtotime(date('Y-m-d'));

        if ($dob_time === false) {
            $_SESSION['errors'] = "Invalid date of birth.";
        } elseif ($dob_time >= $today_time) {
            $_SESSION['errors'] = "Date of birth cannot be today or a future date.";
        }
    }


    if (!isset($_SESSION['errors'])) {
        $changed = false;
        if ($name !== $user['username']) $changed = true;
        if ($phone !== $user['phone']) $changed = true;
        if (!empty($dob) && $dob !== $user['dob']) $changed = true;

        if (!$changed) {
            $_SESSION['errors'] = "No changes detected. Nothing to update.";
        } else {
            // Build update query dynamically
            if (!empty($dob)) {
                $sql = "UPDATE $table SET username = ?, phone = ?, dob = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $name, $phone, $dob, $user_id);
            } else {
                $sql = "UPDATE $table SET username = ?, phone = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $name, $phone, $user_id);
            }

            if ($stmt->execute()) {
                $_SESSION['success'] = "Profile updated successfully!";
                $_SESSION['name'] = $name;
            } else {
                $_SESSION['errors'] = "Error updating profile: " . $stmt->error;
            }
            $stmt->close();
        }
    }


    header("Location: ../View/profile_information.php");
    exit();
}
?>
