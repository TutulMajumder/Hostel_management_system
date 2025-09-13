<?php

include "../DB/apply_room_DB.php"; 

$success = "";

$fullname = $student_id = $category = $details = "";

$fullnameErr = $studentIdErr = $categoryErr = $detailsErr = "";


//
function clean($data) {

    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    if (empty($_POST["fullname"])) {

        $fullnameErr = "Full Name is required";

    } else {

        $fullname = clean($_POST["fullname"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {

            $fullnameErr = "Only letters and spaces are allowed in Full Name";

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

    
    if (empty($_POST["category"])) {

        $categoryErr = "Please select a category";

    } else {

        $category = clean($_POST["category"]);

    }

    
    if (empty($_POST["details"])) {

        $detailsErr = "Please provide complaint details";

    } else {

        $details = clean($_POST["details"]);

    }

  
    if (!$fullnameErr && !$studentIdErr && !$categoryErr && !$detailsErr) {

       //
        $fullname_safe   = mysqli_real_escape_string($conn, $fullname);

        $student_id_safe = mysqli_real_escape_string($conn, $student_id);

        $category_safe   = mysqli_real_escape_string($conn, $category);

        $details_safe    = mysqli_real_escape_string($conn, $details);

        $sql = "INSERT INTO complaints (fullname, student_id, category, details)

                VALUES ('$fullname_safe', '$student_id_safe', '$category_safe', '$details_safe')";

        if (mysqli_query($conn, $sql)) {

            $success = " Complaint submitted successfully!";

            $fullname = $student_id = $category = $details = "";

        } else {

            $success = " Error: " . mysqli_error($conn);
        }
    }
}

?>
