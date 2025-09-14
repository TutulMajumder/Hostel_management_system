<?php
// Health_officer/php/salary_history_backend.php
session_start();

include_once __DIR__ . '/../db/config.php'; // expects $conn (mysqli)

/*
This backend:
- Requires logged-in health_officer
- Resolves officer (prefer EMAIL from session, fallback USERNAME)
- Uses prepared statements
- Exposes SAME variables to the view:
  $success (string), $error (string), $officer (array), $salary_records (array)
*/

// -------------------- Stable view vars --------------------
$success        = '';
$error          = '';
$officer        = ['username' => 'N/A', 'email' => 'N/A'];
$salary_records = [];

// -------------------- Auth Guard --------------------
if (empty($_SESSION['user_id']) || (($_SESSION['role'] ?? '') !== 'health_officer')) {
    header('Location: login.php');
    exit();
}

// -------------------- Session values --------------------
$sess_email    = $_SESSION['email']       ?? $_SESSION['user_email'] ?? null;
$sess_username = $_SESSION['username']    ?? null;

// -------------------- Helpers --------------------
/**
 * Fetch officer by column/value.
 * @return array{username:string,email:string}|null
 */
function findOfficer(mysqli $conn, string $column, string $value): ?array
{
    $sql = "SELECT username, email FROM health_officers WHERE {$column} = ? LIMIT 1";
    if (!$stmt = $conn->prepare($sql)) {
        return null;
    }
    $stmt->bind_param('s', $value);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = ($res && $res->num_rows === 1) ? $res->fetch_assoc() : null;
    $stmt->close();
    return $row ?: null;
}

// -------------------- 1) Resolve officer --------------------
$found_username_for_salary = null;

if (!empty($sess_email)) {
    if ($row = findOfficer($conn, 'email', $sess_email)) {
        $officer = $row;
        $found_username_for_salary = $row['username'];
    }
}

if ($found_username_for_salary === null && !empty($sess_username)) {
    if ($row = findOfficer($conn, 'username', $sess_username)) {
        $officer = $row;
        $found_username_for_salary = $row['username'];
    }
}

if ($found_username_for_salary === null) {
    $error = 'Officer not found (checked by email, then username).';
    return; // keep variables available to the view
}

// -------------------- 2) Fetch salary history --------------------
$sql = "
    SELECT month_year, basic_salary, allowances, deductions, net_salary, payment_status, payment_date
    FROM salary_history
    WHERE username = ?
    ORDER BY month_year DESC
";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('s', $found_username_for_salary);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $salary_records[] = $row; // same shape for the view
        }
        if (!$salary_records) {
            $success = 'No salary records available for this account.';
        }
    } else {
        $error = 'Failed to load salary history.';
    }
    $stmt->close();
} else {
    $error = 'Failed to prepare salary history query.';
}
