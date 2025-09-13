<?php

$success = "";

$fullname = $student_id = $service_type = $service_details = $preferred_date = "";

$fullnameErr = $studentIdErr = $serviceTypeErr = $serviceDetailsErr = $preferredDateErr = "";



$conn = new mysqli("localhost", "root", "", "hostel_management_system");

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    
    if (empty($_POST["fullname"])) {

        $fullnameErr = "Full Name is required";

    } else {

        $fullname = clean_input($_POST["fullname"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {

            $fullnameErr = "Only letters and spaces allowed";

        }
    }

    
    if (empty($_POST["student_id"])) {

        $studentIdErr = "Student ID is required";

    } else {
        $student_id = clean_input($_POST["student_id"]);

        if (!preg_match("/^[0-9-]*$/", $student_id)) {

            $studentIdErr = "Only numbers and dashes allowed";

        }
    }

   
    if (empty($_POST["service_type"])) {

        $serviceTypeErr = "Please select a service type";


    } else {

        $service_type = clean_input($_POST["service_type"]);

    }

   
    if (empty($_POST["service_details"])) {

        $serviceDetailsErr = "Please provide service details";

    } else {

        $service_details = clean_input($_POST["service_details"]);

    }

    
    if (empty($_POST["preferred_date"])) {

        $preferredDateErr = "Please select a preferred date";

    } else {

        $preferred_date = $_POST["preferred_date"]; 
    }

   
    if ($fullnameErr == "" && $studentIdErr == "" && $serviceTypeErr == "" && $serviceDetailsErr == "" && $preferredDateErr == "") {

        $query = "INSERT INTO services (fullname, student_id, service_type, details, preferred_date) 

                  VALUES ('$fullname','$student_id','$service_type','$service_details','$preferred_date')";


        if (mysqli_query($conn, $query)) {

            $success = " Your service request has been submitted successfully!";

            $fullname = $student_id = $service_type = $service_details = $preferred_date = "";

        } else {
            $success = " Error: " . mysqli_error($conn);
        }
    }
}


function clean_input($data) {

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    return $data;

}

?>
