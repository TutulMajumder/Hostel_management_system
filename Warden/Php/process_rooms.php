<?php
include "../Db/config.php";

// Fetch all applications always
$query = "SELECT * FROM room_applications";
$result = $conn->query($query);
$applications = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
}

// Fetch all rooms always
$query = "SELECT * FROM rooms";
$result = $conn->query($query);
$rooms = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

$errors = $success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $application_id = trim($_POST['application_id'] ?? '');
    $room_id = trim($_POST['room_id'] ?? '');


    if (empty($application_id) || empty($room_id)) {
        $errors = "Both Application ID and Room selection are required.";
        return;
    }
    if (!ctype_digit($application_id) || !ctype_digit($room_id)) {
        $errors = "IDs must be numeric.";
        return;
    }


    $app_stmt = $conn->prepare("SELECT COUNT(*) as count FROM room_applications WHERE id=? AND status='Pending'");
    $app_stmt->bind_param('i', $application_id);
    $app_stmt->execute();
    $app_result = $app_stmt->get_result();
    $row = $app_result->fetch_assoc();
    $app_stmt->close();

    if ($row['count'] == 0) {
        $errors = "Application not found or not pending.";
        return;
    }

    // Fetch room info
    $room_stmt = $conn->prepare("SELECT capacity, occupied FROM rooms WHERE id=?");
    $room_stmt->bind_param('i', $room_id);
    $room_stmt->execute();
    $room_result = $room_stmt->get_result();
    $room_row = $room_result->fetch_assoc();
    $room_stmt->close();

    if (!$room_row) {
        $errors = "Room not found.";
        return;
    }

    $capacity = (int)$room_row['capacity'];
    $occupied = (int)$room_row['occupied'];

    if ($occupied >= $capacity) {
        $errors = "Room is already full.";
        return;
    }

    $conn->begin_transaction();
    try {
        // Update application
        $update_app = $conn->prepare("UPDATE room_applications SET status='Approved', room_id=? WHERE id=?");
        $update_app->bind_param('ii', $room_id, $application_id);
        $update_app->execute();
        $update_app->close();

        // Update room: increment occupied, adjust availability
        $new_occupied = $occupied + 1;
        $new_available = ($new_occupied >= $capacity) ? 0 : 1;

        $update_room = $conn->prepare("UPDATE rooms SET occupied=?, available=? WHERE id=?");
        $update_room->bind_param('iii', $new_occupied, $new_available, $room_id);
        $update_room->execute();
        $update_room->close();

        $conn->commit();

        $success = "Room assigned successfully.";

        // Refresh tables
        $applications = [];
        $result = $conn->query("SELECT * FROM room_applications");
        while ($result && $row = $result->fetch_assoc()) {
            $applications[] = $row;
        }

        $rooms = [];
        $result = $conn->query("SELECT * FROM rooms");
        while ($result && $row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }

    } catch (Exception $e) {
        $conn->rollback();
        $errors = "Error while assigning room: " . $e->getMessage();
    }
}


if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
