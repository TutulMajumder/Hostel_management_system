<?php
include "../Db/config.php";


// Fetch all complaints always
$query = "SELECT * FROM complaints";
$result = $conn->query($query);
$complaints = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
}
$errors = $success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint_id = trim($_POST['complaint_id'] ?? '');
    $status = trim($_POST['status'] ?? 'pending');
    $feedback = trim($_POST['feedback'] ?? '');

    // Validate form fields
    $allowed_status = ['Resolved', 'Escalated'];
    if (empty($complaint_id) || empty($feedback) || !in_array($status, $allowed_status, true)) {
        $errors = "All fields are required and status must be 'Resolved' or 'Escalated'";
        return;
    }
    if (!ctype_digit($complaint_id)) {
        $errors = "Complaint ID can only be numbers";
    }
    if (!preg_match('/^[a-zA-Z]/', $feedback)) {
        $errors = "Feedback must start with a letter and cannot start with a number.";
        return;
    }

    if (strlen($feedback) > 200) {
        $errors = "Feedback must not exceed 200 characters.";
        return;
    } else {
        $complaint_query = "SELECT COUNT(*) as count From complaints WHERE id=?";
        $complaint_stmt = $conn->prepare($complaint_query);
        $complaint_stmt->bind_param('i', $complaint_id);
        $complaint_stmt->execute();
        $check_result = $complaint_stmt->get_result();
        $row = $check_result->fetch_assoc();
        $complaint_stmt->close();

        if ($row['count'] == 0) {
            $errors = "Complaint ID not Found.Please Enter a valid Complaint ID.";
        } else {
            $sql = "UPDATE complaints SET status=?, feedback=? WHERE id=?";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                $errors = "Database prepare error: " . $conn->error;
                return;
            } else {
                $stmt->bind_param('ssi', $status, $feedback, $complaint_id);

                if ($stmt->execute()) {
                    // $query = "SELECT * FROM complaints";
                    // $result = $conn->query($query);
                    // $updated_complaint = '';
                    // while ($row = $result->fetch_assoc()) {
                    //     $updated_complaint .= '<tr>';
                    //     $updated_complaint .= '<td>' . $row['id'] . '</td>';
                    //     $updated_complaint .='<td>' . $row['student_id'] . '</td>';
                    //     $updated_complaint .= '<td>' . $row['fullname'] . '</td>';
                    //     $updated_complaint .= '<td>' . $row['category'] . '</td>';
                    //     $updated_complaint .= '<td>' . $row['details'] . '</td>';
                    //     $updated_complaint .= '<td>' . $row['status'] . '</td>';
                    //     $updated_complaint .= '<td>' . $row['feedback'] . '</td>';
                    //     $updated_complaint .= '</tr>';
                    // }

                    // Fetch all services from database
                    $query = "SELECT * FROM complaints";
                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $complaints[] = $row; // store each row in array
                        }
                    }
                    $success = "Complaints updated successfully.";
                    // $complaints_data = $complaints;
                } else {
                    $errors = 'Database error' . $stmt->error;
                }
            }

            $stmt->close();
        }
    }
}
?>
