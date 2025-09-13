<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include "../db/config.php"; // DB connection

$success = $error = "";

// ------------------- PHP VALIDATION -------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_request'])) {
    $request_id = trim($_POST['request_id']);
    $status     = trim($_POST['status']);
    $notes      = trim($_POST['notes']);

    // Validate inputs
    if ($request_id === "" || $status === "") {
        $error = "Request ID and Status are required!";
    } elseif (!is_numeric($request_id) || $request_id <= 0) {
        $error = "Request ID must be a positive number!";
    } elseif (!in_array($status, ["Pending", "In Progress", "Resolved"])) {
        $error = "Invalid status selected!";
    } else {
        // Update DB
        $stmt = $conn->prepare("UPDATE health_requests SET status=?, notes=? WHERE id=?");
        $stmt->bind_param("ssi", $status, $notes, $request_id);

        if ($stmt->execute()) {
            $success = "Request #$request_id updated successfully!";
        } else {
            $error = "Database error: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch all requests with student info
$sql = "
    SELECT hr.id, hr.status, hr.notes, s.name, s.student_id, s.symptoms, s.request_date
    FROM health_requests hr
    LEFT JOIN students s ON hr.student_id = s.student_id
    ORDER BY hr.id DESC
";
$result = $conn->query($sql);
?>
