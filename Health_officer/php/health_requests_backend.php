<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Ensure only logged-in health_officer can access
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? '') !== "health_officer") {
    header("Location: ../view/login.php");
    exit();
}

include "../db/config.php"; // relative path to DB config

$success = $error = "";

/* ------------------- Handle Update Request ------------------- */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_request'])) {
    $request_id = trim($_POST['request_id'] ?? '');
    $status     = trim($_POST['status'] ?? '');
    $notes      = trim($_POST['notes'] ?? '');

    // Validate inputs
    if ($request_id === "" || !ctype_digit($request_id) || (int)$request_id <= 0) {
        $error = "Valid Request ID is required!";
    } elseif (!in_array($status, ["Pending", "In Progress", "Resolved"], true)) {
        $error = "Invalid status selected!";
    } else {
        $rid = (int)$request_id;

        // ✅ Ensure request exists in health_applications
        $check = $conn->prepare("SELECT id FROM health_applications WHERE id = ?");
        $check->bind_param("i", $rid);
        $check->execute();
        $check->store_result();
        if ($check->num_rows === 0) {
            $error = "Request #$rid does not exist!";
        } else {
            // ✅ Ensure row exists in health_requests
            $stmt = $conn->prepare("INSERT IGNORE INTO health_requests (id, status, notes) VALUES (?, 'Pending', NULL)");
            $stmt->bind_param("i", $rid);
            $stmt->execute();
            $stmt->close();

            // ✅ Update status + notes
            $stmt = $conn->prepare("UPDATE health_requests SET status=?, notes=? WHERE id=?");
            $stmt->bind_param("ssi", $status, $notes, $rid);

            if ($stmt->execute()) {
                $success = "Request #$rid updated successfully!";
            } else {
                $error = "Database error: " . $conn->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}

/* ------------------- Fetch All Requests ------------------- */
$sql = "
    SELECT
      ha.id AS id,
      COALESCE(hr.status, 'Pending') AS status,
      hr.notes AS notes,
      COALESCE(s.fullname, ha.fullname) AS name,
      s.id AS student_id,
      ha.description AS symptoms,
      ha.submitted_at AS request_date
    FROM health_applications ha
    LEFT JOIN students s ON s.id = ha.student_id
    LEFT JOIN health_requests hr ON hr.id = ha.id
    ORDER BY ha.id DESC
";
$result = $conn->query($sql);
