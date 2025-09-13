<?php

include "../DB/apply_room_DB.php"; 

$success = "";
$fullname = $student_id = $issue_type = $description = $appointment_date = $emergency = "";

$fullnameErr = $studentIdErr = $issueTypeErr = $descriptionErr = $appointmentErr = $emergencyErr = "";


function clean($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["fullname"])) {

        $fullnameErr = "Full Name is required";

    } else {

        $fullname = clean($_POST["fullname"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {

            $fullnameErr = "Only letters and spaces allowed";

            $fullname = "";
        }
    }

   
    if (empty($_POST["student_id"])) {

        $studentIdErr = "Student ID is required";

    } elseif (!preg_match("/^[0-9]+$/", $_POST["student_id"])) {

        $studentIdErr = "Student ID must contain only numbers";

        $student_id = "";
        
    } else {
        $student_id = clean($_POST["student_id"]);
    }

    // Issue type validation
    if (empty($_POST["issue_type"])) {
        $issueTypeErr = "Please select a health issue type";
    } else {
        $issue_type = clean($_POST["issue_type"]);
    }

    // Description validation
    if (empty($_POST["description"])) {
        $descriptionErr = "Please describe the issue";
    } else {
        $description = clean($_POST["description"]);
    }

    // Appointment date validation
    if (empty($_POST["appointment_date"])) {
        $appointmentErr = "Please select a preferred appointment date";
    } else {
        $appointment_date = clean($_POST["appointment_date"]);
    }

    // Emergency validation
    if (empty($_POST["emergency"])) {
        $emergencyErr = "Please select if it is an emergency";
    } else {
        $emergency = clean($_POST["emergency"]);
    }

    // If no errors → insert into DB
    if (!$fullnameErr && !$studentIdErr && !$issueTypeErr && !$descriptionErr && !$appointmentErr && !$emergencyErr) {
        // Escape input for SQL
        $fullname_safe       = mysqli_real_escape_string($conn, $fullname);
        $student_id_safe     = mysqli_real_escape_string($conn, $student_id);
        $issue_type_safe     = mysqli_real_escape_string($conn, $issue_type);
        $description_safe    = mysqli_real_escape_string($conn, $description);
        $appointment_date_safe = mysqli_real_escape_string($conn, $appointment_date);
        $emergency_safe      = mysqli_real_escape_string($conn, $emergency);

        $sql = "INSERT INTO health_applications 
                (fullname, student_id, issue_type, description, appointment_date, emergency)
                VALUES ('$fullname_safe', '$student_id_safe', '$issue_type_safe', '$description_safe', '$appointment_date_safe', '$emergency_safe')";

        if (mysqli_query($conn, $sql)) {
            $success = " Health request submitted successfully!";
            $fullname = $student_id = $issue_type = $description = $appointment_date = $emergency = "";
        } else {
            $success = " Error: " . mysqli_error($conn);
        }
    }
}
?>
