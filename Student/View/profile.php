<?php

session_start();

if (!isset($_SESSION['id'])) {

    header("Location: login.php");

    exit();
}

include "../DB/apply_room_DB.php";

$student_id = $_SESSION['id'];

$success = isset($_GET['success']) ? $_GET['success'] : "";

$error   = isset($_GET['error']) ? $_GET['error'] : "";



$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");

$stmt->bind_param("i", $student_id);

$stmt->execute();

$result = $stmt->get_result();

$student = $result->fetch_assoc();

?>

<!DOCTYPE html>

<html lang="en">

<head>
    

    <title>Student Profile</title>

    
    <link rel="stylesheet" href="../CSS/Header.css">

    <link rel="stylesheet" href="../CSS/profile.css">
</head>

<body>


<?php include 'header.php'; ?>


<div class="container">

    <h2>Student Profile</h2>


    <?php if($success) echo "<p class='success'>$success</p>"; ?>

    <?php if($error) echo "<p class='error'>$error</p>"; ?>


    <!-- Update Profile -->
    <form action="../php/update_profile.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">


        <label>ID:</label>

        <input type="text" value="<?php echo $student['id']; ?>" disabled><br><br>


        <label>Full Name:</label>

        <input type="text" value="<?php echo $student['fullname']; ?>" disabled><br><br>

        <label>Email:</label>

        <input type="email" value="<?php echo $student['email']; ?>" disabled><br><br>

        <label>Phone:</label>

        <input type="text" name="phone" value="<?php echo $student['phone']; ?>" required><br><br>

        <label>Semester:</label>

        <input type="text" name="semester" value="<?php echo $student['semester']; ?>"disabled ><br><br>

        <label>Department:</label>

        <input type="text" name="department" value="<?php echo $student['department']; ?>" disabled><br><br>

        <label>Date of Birth:</label>

        <input type="date" name="dob" value="<?php echo $student['dob']; ?>" required><br><br>

        <label>Address:</label>

        <textarea name="address" required><?php echo $student['address']; ?></textarea><br><br>

        <button type="submit" class="btn">Update Profile</button>
        
    </form>



    <!-- Change Password -->

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

    <!-- Delete Profile -->
 <!--   <form action="../php/delete_profile.php" method="POST">
        <button type="submit" name="delete" class="btn delete-btn">Delete Profile</button>
    </form>-->
    
</div>

</body>
</html>
