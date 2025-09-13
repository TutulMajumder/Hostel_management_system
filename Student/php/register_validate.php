<?php
include("../DB/apply_room_DB.php"); // Make sure this contains $conn
$success = "";

// Initialize variables
$fullname = $email = $phone = $gender = $dob = $semester = $department = $address = $password = $confirm_password = "";
$fullnameErr = $emailErr = $phoneErr = $genderErr = $dobErr = $semesterErr = $deptErr = $addressErr = $passwordErr = $confirmErr = "";

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ------------------ Full Name ------------------
    if (empty($_POST["fullname"])) {
        $fullnameErr = "Full Name is required";
    } else {
        $fullname = trim($_POST["fullname"]);
        if (!preg_match("/^[a-zA-Z-' ]+$/", $fullname)) {
            $fullnameErr = "Full Name can only contain letters and spaces";
        }
    }

    // ------------------ Email ------------------
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format (example: a@gmail.com)";
        }
    }

    // ------------------ Phone ------------------
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = trim($_POST["phone"]);
        if (!preg_match("/^[0-9]{10,15}$/", $phone)) {
            $phoneErr = "Phone must be digits only (10-15 numbers)";
        }
    }

    // ------------------ Gender ------------------
    if (empty($_POST["gender"])) {
        $genderErr = "Please select your gender";
    } else {
        $gender = $_POST["gender"];
        if (!in_array($gender, ["Male", "Female", "Other"])) {
            $genderErr = "Invalid gender selected";
        }
    }

    // ------------------ DOB ------------------
    if (empty($_POST["dob"])) {
        $dobErr = "Date of Birth is required";
    } else {
        $dob = $_POST["dob"];
        $dobDate = date_create($dob);
        if (!$dobDate) {
            $dobErr = "Invalid Date of Birth";
        }
    }

    // ------------------ Semester ------------------
    if (empty($_POST["semester"])) {
        $semesterErr = "Please select your semester";
    } else {
        $semester = $_POST["semester"];
        $validSemesters = ["1st", "2nd", "3rd", "4th"];
        if (!in_array($semester, $validSemesters)) {
            $semesterErr = "Invalid semester selected";
        }
    }

    // ------------------ Department ------------------
    if (empty($_POST["department"])) {
        $deptErr = "Please select your department";
    } else {
        $department = $_POST["department"];
        $validDepartments = ["CSE", "EEE", "BBA", "Others"];
        if (!in_array($department, $validDepartments)) {
            $deptErr = "Invalid department selected";
        }
    }

    // ------------------ Address ------------------
    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = trim($_POST["address"]);
    }

    // ------------------ Password ------------------
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters";
        }
    }

    // ------------------ Confirm Password ------------------
    if (empty($_POST["confirm_password"])) {
        $confirmErr = "Confirm Password is required";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            $confirmErr = "Passwords do not match";
        }
    }

    // ------------------ Insert into DB ------------------
    if ($fullnameErr=="" && $emailErr=="" && $phoneErr=="" && $genderErr=="" && $dobErr=="" &&
        $semesterErr=="" && $deptErr=="" && $addressErr=="" && $passwordErr=="" && $confirmErr=="") {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check for existing email
        $check = $conn->prepare("SELECT id FROM students WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $emailErr = "Email already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO students (fullname, email, phone, gender, dob, semester, department, address, password) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $fullname, $email, $phone, $gender, $dob, $semester, $department, $address, $hashedPassword);
            if ($stmt->execute()) {
                $success = "✅ Registration successful! <a href='../PHP/login.php'>Click here to login</a>";
                $fullname = $email = $phone = $gender = $dob = $semester = $department = $address = $password = $confirm_password = "";
            } else {
                $emailErr = "❌ Something went wrong. Try again!";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
