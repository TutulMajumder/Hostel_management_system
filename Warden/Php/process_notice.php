<?php
include "../Db/config.php";

$errors = $success = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notice_title = trim($_POST['notice_title'] ?? '');
    $notice_recipients = $_POST['recipients'] ?? [];
    $note = trim($_POST['note'] ?? '');
    $notice_file = $_FILES['notice_file'] ?? null;
    // $notice_path = null;

    // Required fields validation
    if (empty($notice_title) || empty($notice_recipients) || empty($note)) {
        $errors .= "All fields are required. ";
    }

    // Length checks
    if (strlen($notice_title) > 150) {
        $errors .= "Notice title cannot exceed 150 characters. ";
    }
    if (strlen($note) > 500) {
        $errors .= "Additional information must not exceed 500 characters. ";
    }

    // Recipient validation (check if all recipients are valid)
    $allowed_recipients = ['Student', 'Health Officer', 'Accountant'];
    foreach ($notice_recipients as $r) {
        if (!in_array($r, $allowed_recipients, true)) {
            $errors .= "Invalid recipient selected. ";
        }
    }

    // File validation + upload
    if ($notice_file && $notice_file['error'] === UPLOAD_ERR_OK) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
        $ext = strtolower(pathinfo($notice_file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext)) {
            $errors .= "Invalid file type. Only JPG, PNG, and PDF are allowed. ";
        }
        if ($notice_file['size'] > 2 * 1024 * 1024) {
            $errors .= "File size cannot exceed 2 MB. ";
        }

        // Proceed only if there are no errors so far
        if (empty($errors)) {
            // Directory setup for uploads
            $upload_dir = "../uploads/notices/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); 
            }

            $new_name = uniqid("notice_", true) . "." . $ext;
            $target = $upload_dir . $new_name;

            if (move_uploaded_file($notice_file['tmp_name'], $target)) {
                $notice_path = $target;  
            } else {
                $errors .= "Failed to save uploaded file. ";
            }
        }
    }
    if (empty($errors)) {
        $sql = "INSERT INTO notices (title, note, notice_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $notice_title, $note, $notice_path);

        if ($stmt->execute()) {
            $notice_id = $stmt->insert_id;
            $rec_query = "INSERT INTO notice_recipients (notice_id, recipient) VALUES (?, ?)";
            $rec_stmt = $conn->prepare($rec_query);

            foreach ($notice_recipients as $r) {
                $rec_stmt->bind_param("is", $notice_id, $r);
                $rec_stmt->execute();
            }
            $rec_stmt->close();
            $success = "Notice posted successfully.";
        } else {
            $errors = "Database error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
