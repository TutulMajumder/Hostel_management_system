<?php
session_start();
include "../db/config.php"; // Database connection

$success = $error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $report_date = $_POST['report_date'];
    $diagnosis = $_POST['diagnosis'];
    $treatment = $_POST['treatment'];
    $doctor_name = $_POST['doctor_name'];
    $notes = $_POST['notes'];

    if (empty($student_id) || empty($report_date) || empty($diagnosis) || empty($treatment) || empty($doctor_name)) {
        $error = "Please fill in all required fields";
    } else {
        $stmt = $conn->prepare("INSERT INTO health_reports (student_id, report_date, diagnosis, treatment, doctor_name, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $student_id, $report_date, $diagnosis, $treatment, $doctor_name, $notes);
        if ($stmt->execute()) {
            $success = "Health report added successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}

// Fetch students for dropdown
$students_result = $conn->query("SELECT student_id, name FROM students ORDER BY name ASC");

// Fetch all health reports
$reports_result = $conn->query("SELECT hr.*, s.name FROM health_reports hr LEFT JOIN students s ON hr.student_id = s.id ORDER BY hr.report_date DESC");
?>
