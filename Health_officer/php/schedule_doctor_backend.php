<?php
// SIMPLE SALARY HISTORY BACKEND
session_start();

// check login + role
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? '') !== "health_officer") {
    header("Location: ../view/login.php");
    exit();
}

// db connect (from /Health_officer/php/ to /db/config.php)
include "../db/config.php";

// get username from session (to filter salary history)
$officer_username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";

// protect username
$officer_username_esc = mysqli_real_escape_string($conn, $officer_username);

// fetch salary history for this username (do NOT select processed_by)
$sql = "SELECT salary_id, username, month_year, basic_salary, allowances, deductions, net_salary, payment_status, payment_date
        FROM salary_history
        WHERE username = '$officer_username_esc'
        ORDER BY payment_date DESC, salary_id DESC";
$salary_result = mysqli_query($conn, $sql);

// you can use:
//   $officer_username  → show on page
//   $salary_result     → loop rows in the view
