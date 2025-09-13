<?php
include '../db/config.php';

$errors = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id    = trim($_POST['service_id'] ?? '');
    $assign_date = trim($_POST['assign_date'] ?? '');
    $status        = trim($_POST['status'] ?? 'Pending');
    $feedback      = trim($_POST['feedback'] ?? '');


    // Validate form fields

    $allowed_status = ['Scheduled', 'Completed','In Progress'];
    if (empty($service_id) || empty($assign_date) || empty($feedback) || !in_array($status, $allowed_status, true)) {
        $errors = "All fields are required and Status must be 'Scheduled', , 'Completed','In Progress'.";
        return;
    }
    $today = date('Y-m-d');
    if ($assign_date < $today) {
        $errors = "Assigned date cannot be in the past. It must be today or a future date.";
        return;
    }
    if (!ctype_digit($service_id)) {
        $errors = "Service ID can be only numbers";
        return;
    }

    if (!preg_match('/^[a-zA-Z]/', $feedback)) {
        $errors = "Feedback must start with a letter and cannot start with a number.";
        return;
    }
    // Validate feedback length
    if (strlen($feedback) > 200) {
        $errors = "Feedback must not exceed 200 characters.";
        return;
    } else {
        $service_query = "SELECT COUNT(*) as count From services WHERE id=?";
        $service_stmt = $conn->prepare($service_query);
        $service_stmt->bind_param("s", $service_id);
        $service_stmt->execute();
        $check_result = $service_stmt->get_result();
        $row = $check_result->fetch_assoc();
        $service_stmt->close();
        if ($row['count'] == 0) {
            $errors = "Service ID not Found.Please Enter a valid Service ID.";
        } else {
            $sql = "UPDATE services
               SET assign_date = ?, `status` = ?, feedback = ?
             WHERE id = ?";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                $errors = "Database prepare error: " . $conn->error;
                return;
            } else {

                $stmt->bind_param("sssi", $assign_date, $status, $feedback, $service_id);

                if ($stmt->execute()) {
                    $query = "SELECT * FROM services";
                    $result = $conn->query($query);
                    $updated_service = '';
                    while ($row = $result->fetch_assoc()) {
                        $updated_service .= '<tr>';
                        $updated_service .= '<td>' . $row['id'] . '</td>';
                        $updated_service .= '<td>' . $row['student_id'] . '</td>';
                        $updated_service .= '<td>' . $row['fullname'] . '</td>';
                        $updated_service .= '<td>' . $row['service_type'] . '</td>';
                        $updated_service .= '<td>' . $row['details'] . '</td>';
                        $updated_service .= '<td>' . $row['preferred_date'] . '</td>';
                        $updated_service .= '<td>' . $row['assign_date'] . '</td>';
                        $updated_service .= '<td>' . $row['status'] . '</td>';
                        $updated_service .= '<td>' . $row['feedback'] . '</td>';
                        $updated_service .= '</tr>';
                    }
                    // Store success message and the updated complaints data
                    $success = "Service Request updated successfully.";
                    $complaints_data = $updated_service;
                } else {
                    $errors = "Database error: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}
?>
