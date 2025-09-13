<?php

$success = "";

$feedback = "";

$feedbackErr = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["feedback"])) {

        $feedbackErr = "Feedback cannot be empty";

    } else {

        $feedback = $_POST["feedback"];


        
        if (!preg_match("/^[a-zA-Z-' ]*$/", $feedback)) {

            $feedbackErr = "Only letters and spaces allowed in feedback";

        } else {

            $success = "Thank you for your feedback!";

            $feedback = ""; 
        }
    }

}

?>
