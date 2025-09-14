<?php

include "../DB/apply_room_DB.php"; 

$success = "";

$feedback = "";

$feedbackErr = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    if (empty($_POST["feedback"])) {

        $feedbackErr = "Feedback cannot be empty";

    } else {

        $feedback = trim($_POST["feedback"]);


        
        if (!preg_match("/^[a-zA-Z0-9 .,!?'-]+$/", $feedback)) {

            $feedbackErr = "Feedback contains invalid characters";

        }
    }

    
    if ($feedbackErr == "") {

        $feedback_safe = mysqli_real_escape_string($conn, $feedback);

        $sql = "INSERT INTO mess_feedback (feedback) VALUES ('$feedback_safe')";


        if (mysqli_query($conn, $sql)) {

            $success = " Feedback submitted successfully!";

            $feedback = ""; 
        } else {

            $success = " Error: " . mysqli_error($conn);

        }
    }

}


?>
