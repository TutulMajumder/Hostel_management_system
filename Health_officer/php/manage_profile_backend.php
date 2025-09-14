<?php
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'health_officer') {
    header("Location: ../view/login.php");
    exit();
}

require_once "../db/config.php"; // defines $conn (MySQLi)

$officer_id = $_SESSION['user_id'];

// ---------- helpers ----------
function redirect_with($type, $message) {
    header("Location: ../view/manage_profile.php?$type=" . urlencode($message));
    exit();
}
function valid_date($date) {
    if (!$date) return false;
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}
// -----------------------------

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_with('error', 'Invalid request.');
}

$form_type = $_POST['form_type'] ?? '';

/* =====================================
   UPDATE PROFILE (phone, gender, dob, address)
   ===================================== */
if ($form_type === 'update_profile') {
    $phone   = trim($_POST['phone'] ?? '');
    $gender  = trim($_POST['gender'] ?? '');
    $dob     = trim($_POST['dob'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Required
    if ($phone === '' || $gender === '' || $dob === '' || $address === '') {
        redirect_with('error', 'All fields are required.');
    }

    // Phone: 10–15 digits
    if (!preg_match('/^\d{10,15}$/', $phone)) {
        redirect_with('error', 'Phone must be 10–15 digits.');
    }

    // Gender must match ENUM
    $allowed_genders = ['Male','Female','Other'];
    if (!in_array($gender, $allowed_genders, true)) {
        redirect_with('error', 'Invalid gender value.');
    }

    // DOB + (optional) age >= 18
    if (!valid_date($dob)) {
        redirect_with('error', 'Invalid date of birth.');
    }
    $age = (int)date_diff(date_create($dob), new DateTime('now'))->y;
    if ($age < 18) {
        redirect_with('error', 'You must be at least 18 years old.');
    }

    // Update
    $stmt = $conn->prepare("UPDATE health_officers SET phone = ?, gender = ?, dob = ?, address = ? WHERE id = ?");
    if (!$stmt) redirect_with('error', 'Server error. Please try again.');

    $stmt->bind_param("ssssi", $phone, $gender, $dob, $address, $officer_id);

    if ($stmt->execute()) {
        redirect_with('success', 'Profile updated successfully.');
    } else {
        redirect_with('error', 'Error updating profile.');
    }
}

/* =====================================
   CHANGE PASSWORD  (stores PLAINTEXT)
   ===================================== */
if ($form_type === 'change_password') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password     = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Required
    if ($current_password === '' || $new_password === '' || $confirm_password === '') {
        redirect_with('error', 'All password fields are required.');
    }

    if ($new_password !== $confirm_password) {
        redirect_with('error', 'New passwords do not match.');
    }

    if (strlen($new_password) < 6) { // optional policy
        redirect_with('error', 'New password must be at least 6 characters.');
    }

    // Get current password from DB
    $stmt = $conn->prepare("SELECT password FROM health_officers WHERE id = ?");
    if (!$stmt) redirect_with('error', 'Server error. Please try again.');
    $stmt->bind_param("i", $officer_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if (!$row) redirect_with('error', 'Account not found.');

    $stored = $row['password'];

    // Verify current (supports hash or legacy plaintext)
    $valid = false;
    if (password_get_info($stored)['algo']) {
        $valid = password_verify($current_password, $stored);
    } else {
        $valid = hash_equals($stored, $current_password);
    }

    if (!$valid) {
        redirect_with('error', 'Current password is incorrect.');
    }

    // Store new password as PLAINTEXT (as requested)
    $upd = $conn->prepare("UPDATE health_officers SET password = ? WHERE id = ?");
    if (!$upd) redirect_with('error', 'Server error. Please try again.');
    $upd->bind_param("si", $new_password, $officer_id);

    if ($upd->execute()) {
        redirect_with('success', 'Password changed successfully.');
    } else {
        redirect_with('error', 'Error changing password.');
    }
}

redirect_with('error', 'Unknown action.');
