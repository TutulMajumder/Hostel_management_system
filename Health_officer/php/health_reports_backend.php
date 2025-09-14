<?php
session_start();

// simple auth check
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? '') !== "health_officer") {
    header("Location: ../view/login.php");
    exit();
}

// DB connect (from /Health_officer/php to /db/config.php)
include "../db/config.php";

$success = "";
$error   = "";

/* ================== INSERT NEW REPORT (simple) ================== */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // read inputs
    $student_id  = isset($_POST['student_id'])  ? trim($_POST['student_id'])  : "";
    $report_date = isset($_POST['report_date']) ? trim($_POST['report_date']) : "";
    $diagnosis   = isset($_POST['diagnosis'])   ? trim($_POST['diagnosis'])   : "";
    $treatment   = isset($_POST['treatment'])   ? trim($_POST['treatment'])   : "";
    $doctor_name = isset($_POST['doctor_name']) ? trim($_POST['doctor_name']) : "";
    $notes       = isset($_POST['notes'])       ? trim($_POST['notes'])       : "";

    // basic validation (teacher tone)
    if ($student_id === "" || $report_date === "" || $diagnosis === "" || $treatment === "" || $doctor_name === "") {
        $error = "Please fill in all required fields.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $report_date)) {
        $error = "Report date must be YYYY-MM-DD.";
    } else {
        // escape
        $student_id_esc  = mysqli_real_escape_string($conn, $student_id); // varchar in DB
        $report_date_esc = mysqli_real_escape_string($conn, $report_date);
        $diagnosis_esc   = mysqli_real_escape_string($conn, $diagnosis);
        $treatment_esc   = mysqli_real_escape_string($conn, $treatment);
        $doctor_name_esc = mysqli_real_escape_string($conn, $doctor_name);
        $notes_sql       = ($notes === "") ? "NULL" : "'" . mysqli_real_escape_string($conn, $notes) . "'";

        // insert
        $sql = "INSERT INTO health_reports (student_id, report_date, diagnosis, treatment, doctor_name, notes)
                VALUES ('$student_id_esc', '$report_date_esc', '$diagnosis_esc', '$treatment_esc', '$doctor_name_esc', $notes_sql)";
        if (mysqli_query($conn, $sql)) {
            $success = "Health report added successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

/* ================== FETCH STUDENTS (for dropdown) ================== */
/* Frontend expects: $row['student_id'] and $row['name'] */
$students_sql = "SELECT id AS student_id, fullname AS name FROM students ORDER BY fullname ASC";
$students_result = mysqli_query($conn, $students_sql);

/* ================== FETCH REPORTS (for table) ================== */
/* Frontend expects: report_date, name, diagnosis, treatment, doctor_name, notes, student_id
   Join string student_id (health_reports) to int id (students) using CAST  */
$reports_sql = "
    SELECT
        hr.id,
        hr.student_id,
        hr.report_date,
        hr.diagnosis,
        hr.treatment,
        hr.doctor_name,
        hr.notes,
        /* show student's real name if found; else leave blank or use student_id */
        COALESCE(s.fullname, '') AS name
    FROM health_reports hr
    LEFT JOIN students s ON s.id = CAST(hr.student_id AS UNSIGNED)
    ORDER BY hr.report_date DESC, hr.id DESC
";
$reports_result = mysqli_query($conn, $reports_sql);
