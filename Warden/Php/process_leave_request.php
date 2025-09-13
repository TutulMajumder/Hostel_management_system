<?php
include "../Db/config.php";


// Fetch all leave_requests always
$query = "SELECT * FROM leave_requests";
$result = $conn->query($query);
$leave_requests = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leave_requests[] = $row;
    }
}
$errors = $success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $status = trim($_POST['status'] ?? 'pending');
    $feedback = trim($_POST['feedback'] ?? '');

    // Validate form fields
    $allowed_status = ['Approved', 'Rejected'];
    if (empty($student_id) || empty($feedback) || !in_array($status, $allowed_status, true)) {
        $errors = "All fields are required and status must be 'Approved ' or 'Rejected'";
        return;
    }
    if (!ctype_digit($student_id)) {
        $errors = "Student ID can only be numbers";
    }
    if (!preg_match('/^[a-zA-Z]/', $feedback)) {
        $errors = "Feedback must start with a letter and cannot start with a number.";
        return;
    }

    if (strlen($feedback) > 200) {
        $errors = "Feedback must not exceed 200 characters.";
        return;
    } else {
        $leave_request_query = "SELECT COUNT(*) as count From leave_requests WHERE student_id=?";
        $leave_request_stmt = $conn->prepare($leave_request_query);
        $leave_request_stmt->bind_param('i', $student_id);
        $leave_request_stmt->execute();
        $check_result = $leave_request_stmt->get_result();
        $row = $check_result->fetch_assoc();
        $leave_request_stmt->close();

        if ($row['count'] == 0) {
            $errors = "Student ID not Found.Please Enter a valid Complaint ID.";
        } else {
            $sql = "UPDATE leave_requests SET status=?, feedback=? WHERE Student_id=?";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                $errors = "Database prepare error: " . $conn->error;
                return;
            } else {
                $stmt->bind_param('ssi', $status, $feedback, $student_id);

                if ($stmt->execute()) {
                    // Fetch all services from database
                    $query = "SELECT * FROM leave_requests";
                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $leave_requests[] = $row; // store each row in array
                        }
                    }
                    $success = "Leave Request updated successfully.";
                } else {
                    $errors = 'Database error' . $stmt->error;
                }
            }

            $stmt->close();
        }
    }
}
