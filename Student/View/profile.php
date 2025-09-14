<?php

if (session_status() == PHP_SESSION_NONE) {

    session_start();

}


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {

    header("Location: ../Warden/View/login.php");

    exit();

}


$student_id = $_SESSION['user_id'];


include "../DB/apply_room_DB.php";


$success = isset($_GET['success']) ? $_GET['success'] : "";


$error   = isset($_GET['error']) ? $_GET['error'] : "";



$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");


$stmt->bind_param("i", $student_id);



$stmt->execute();


$result = $stmt->get_result();


$student = $result->fetch_assoc();



if (!$student) {

    $_SESSION['error'] = "Student not found!";



    header("Location: ../Warden/View/login.php");
    
    exit();


}

?>




<!DOCTYPE html>

<html lang="en">

<head>


    <meta charset="UTF-8">

    <title>Student Profile</title>

    <link rel="stylesheet" href="../CSS/Header.css">

    <link rel="stylesheet" href="../CSS/profile.css">

</head>

<body>
    

    <?php include 'header.php'; ?>

    <div class="container">


        <h2>Student Profile</h2>


        <?php if ($success) echo "<p class='success'>$success</p>"; ?>

        <?php if ($error) echo "<p class='error'>$error</p>"; ?>

        

        <form action="../php/update_profile.php" method="POST">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">


            <label>ID:</label>

            <input type="text" value="<?php echo htmlspecialchars($student['id']); ?>" disabled><br><br>


            <label>Full Name:</label>

            <input type="text" value="<?php echo htmlspecialchars($student['fullname']); ?>" disabled><br><br>


            <label>Email:</label>

            <input type="email" value="<?php echo htmlspecialchars($student['email']); ?>" disabled><br><br>


            <label>Phone:</label>

            <input type="text" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required><br><br>


            <label>Semester:</label>

            <input type="text" value="<?php echo htmlspecialchars($student['semester']); ?>" disabled><br><br>

            <label>Department:</label>
            
            <input type="text" value="<?php echo htmlspecialchars($student['department']); ?>" disabled><br><br>

            <label>Date of Birth:</label>

            <input type="date" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" required><br><br>

            <label>Address:</label>

            <textarea name="address" required><?php echo htmlspecialchars($student['address']); ?></textarea><br><br>

            <button type="submit" class="btn">Update Profile</button>

        </form>

        
        <h3>Change Password</h3>

        <form action="../php/change_password.php" method="POST">

            <label>Current Password:</label>


            <input type="password" name="current_password" required><br><br>

            <label>New Password:</label>

            <input type="password" name="new_password" required><br><br>


            <label>Confirm Password:</label>

            <input type="password" name="confirm_password" required><br><br>


            <button type="submit" class="btn">Change Password</button>
        </form>


    </div>

</body>


</html>
