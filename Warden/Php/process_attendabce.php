<?php
include "../Db/config.php";


// Fetch all attendance always
$query = "SELECT * FROM attendance";
$result = $conn->query($query);
$attendance = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
}
$errors = $success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $attendance_date = trim($_POST['attendance_date'] ?? '');
    $student_id = trim($_POST['student_id'] ?? '');
    $status = trim($_POST['status'] ?? 'absent');

    // Validate form fields
    $allowed_status = ['Present', 'Absent'];
    if (empty($attendance_date) || empty($student_id) ||!in_array($status, $allowed_status, true)) {
        $errors = "All fields are required.";
        return;
    }
    if (!ctype_digit($student_id)) {
        $errors = "Student ID can only be numbers";
    }
    $today = date('Y-m-d');
    if ($attendance_date != $today) {
        $errors = "You can only mark attendance for today.";
        return;
    } else {
        $attendance_query = "SELECT COUNT(*) as count From attendance WHERE student_id=?";
        $attendance_stmt = $conn->prepare($attendance_query);
        $attendance_stmt->bind_param('i', $student_id);
        $attendance_stmt->execute();
        $check_result = $attendance_stmt->get_result();
        $row = $check_result->fetch_assoc();
        $attendance_stmt->close();

        if ($row['count'] == 0) {
            $errors = "Student ID not Found.Please Enter a valid Student ID.";
        } else {
            $sql = "UPDATE attendance SET date=?, status=? WHERE student_id=?";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                $errors = "Database prepare error: " . $conn->error;
                return;
            } else {
                $stmt->bind_param('ssi', $attendance_date,$status, $student_id);

                if ($stmt->execute()) {
                    // Fetch all services from database
                    $query = "SELECT * FROM attendance";
                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $attendance[] = $row; // store each row in array
                        }
                    }
                    $success = "Attendance updated successfully.";
                    // $attendance_data = $attendance;
                } else {
                    $errors = 'Database error' . $stmt->error;
                }
            }

            $stmt->close();
        }
    }
}
?>
