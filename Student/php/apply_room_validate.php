<?php
include "../DB/apply_room_DB.php"; 


$success = "";

$fullname = $student_id = $semester = $department = $room_pref = $hostel_block = $notes = "";

$fullnameErr = $studentIdErr = $semesterErr = $deptErr = $roomErr = $blockErr = "";

//
function test_input($data) {

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    if (empty($_POST["fullname"])) {

        $fullnameErr = "Full Name is required";

    } else {

        $fullname = test_input($_POST["fullname"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {

            $fullnameErr = "Only letters and white space allowed";
        }
    }

    
if (empty($_POST["student_id"])) {

    $studentIdErr = "Student ID is required";

} else {

    $student_id = test_input($_POST["student_id"]);

    if (!preg_match("/^[0-9]+$/", $student_id)) {

        $studentIdErr = "Only numbers are allowed for Student ID";

    }
}


   
    if (empty($_POST["semester"])) {

        $semesterErr = "Semester is required";

    } else {

        $semester = test_input($_POST["semester"]);

    }

   
    if (empty($_POST["department"])) {

        $deptErr = "Department is required";

    } else {

        $department = test_input($_POST["department"]);
    }

    
    if (empty($_POST["room_pref"])) {

        $roomErr = "Room preference is required";

    } else {

        $room_pref = test_input($_POST["room_pref"]);
    }

    
    if (empty($_POST["hostel_block"])) {

        $blockErr = "Hostel block is required";

    } else {

        $hostel_block = test_input($_POST["hostel_block"]);
    }

    
    $notes = !empty($_POST["notes"]) ? test_input($_POST["notes"]) : "";

    
    if (!$fullnameErr && !$studentIdErr && !$semesterErr && !$deptErr && !$roomErr && !$blockErr) {

        $stmt = $conn->prepare("

            INSERT INTO room_applications 

            (fullname, student_id, semester, department, room_preference, hostel_block, additional_notes)

            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssssss", $fullname, $student_id, $semester, $department, $room_pref, $hostel_block, $notes);
        

        if ($stmt->execute()) {
            $success = " Room application submitted successfully!";
            
            $fullname = $student_id = $semester = $department = $room_pref = $hostel_block = $notes = "";

        } else {
            $success = " Error: " . $stmt->error;

        }
        $stmt->close();
    }
}

?>
