<?php
// mess_validate.php
include "../DB/apply_room_DB.php"; // Include DB connection

$success = "";
$feedback = "";
$feedbackErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate feedback
    if (empty($_POST["feedback"])) {
        $feedbackErr = "Feedback cannot be empty";
    } else {
        $feedback = trim($_POST["feedback"]);

        // Optional: ensure feedback contains only letters, numbers, and basic punctuation
        if (!preg_match("/^[a-zA-Z0-9 .,!?'-]+$/", $feedback)) {
            $feedbackErr = "Feedback contains invalid characters";
        }
    }

    // Insert into database if no error
    if ($feedbackErr == "") {
        $feedback_safe = mysqli_real_escape_string($conn, $feedback);
        $sql = "INSERT INTO mess_feedback (feedback) VALUES ('$feedback_safe')";

        if (mysqli_query($conn, $sql)) {
            $success = " Feedback submitted successfully!";
            $feedback = ""; // clear textarea
        } else {
            $success = " Error: " . mysqli_error($conn);
        }
    }
}
?>
