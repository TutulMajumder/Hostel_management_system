<?php
session_start();

// If not logged in → redirect to login
if (!isset($_SESSION["username"])) {
    header("Location: ../view/login.php");
    exit();
}

include "../db/config.php"; // DB connection

// ------------------ Recent Health Requests (latest 5) ------------------
$recent_requests_sql = "
    SELECT hr.id, hr.status, hr.notes, s.name, s.student_id, s.symptoms, s.request_date
    FROM health_requests hr
    LEFT JOIN students s ON hr.student_id = s.student_id
    ORDER BY hr.id DESC
    LIMIT 5
";
$recent_requests = $conn->query($recent_requests_sql);

// ------------------ Doctor Visits count ------------------
$doctor_visits_sql = "SELECT COUNT(*) as total_visits FROM doctor_visits";
$doctor_visits_result = $conn->query($doctor_visits_sql);
$doctor_visits = ($doctor_visits_result->num_rows > 0) 
    ? $doctor_visits_result->fetch_assoc()['total_visits'] 
    : 0;

// ------------------ Low Stock Items count ------------------
$low_stock_sql = "SELECT COUNT(*) as low_stock FROM medicines WHERE quantity <= threshold";
$low_stock_result = $conn->query($low_stock_sql);
$low_stock = ($low_stock_result->num_rows > 0) 
    ? $low_stock_result->fetch_assoc()['low_stock'] 
    : 0;

// ------------------ New Feedback count ------------------
$new_feedback_sql = "SELECT COUNT(*) as feedback_count FROM student_health_feedback";
$new_feedback_result = $conn->query($new_feedback_sql);
$new_feedback = ($new_feedback_result->num_rows > 0) 
    ? $new_feedback_result->fetch_assoc()['feedback_count'] 
    : 0;
?>
