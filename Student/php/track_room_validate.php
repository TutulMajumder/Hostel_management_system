<?php
$studentID = "";
$status = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["studentID"])) {
        $error = "Student ID cannot be empty";
    } else {
        $studentID = trim($_POST["studentID"]);

        // Use mysqli_real_escape_string to prevent SQL injection
        $studentID = mysqli_real_escape_string($conn, $studentID);

        // Fetch status from database
        $query = "SELECT status FROM room_applications WHERE student_id='$studentID' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $status = $row['status'];
        } else {
            $status = "No application found for this Student ID.";
        }
    }
}
?>
