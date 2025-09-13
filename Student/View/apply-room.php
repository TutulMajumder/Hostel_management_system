<?php
session_start();

if (!isset($_SESSION['username'])) {

    header("Location: login.php");

    exit();
}

?>



<?php

include "../php/apply_room_validate.php"; 

?>
<!DOCTYPE html>

<html>

<head>
    <title>Apply for Room</title>

    <link rel="stylesheet" href="../CSS/Header.css">

    <link rel="stylesheet" href="../CSS/ApplyRoom.css">

</head>

<body>

<?php include 'header.php'; ?> 


<main class="dashboard">

    <h1>Apply for Room</h1>


    <form method="post" class="room-form">

        <input type="text" name="fullname" placeholder="Full Name" value="<?php echo $fullname; ?>">

        <span class="error"><?php echo $fullnameErr; ?></span><br>

        <input type="text" name="student_id" placeholder="Student ID" value="<?php echo $student_id; ?>">

        <span class="error"><?php echo $studentIdErr; ?></span><br>

        <select name="semester">
            
            <option value="">-- Select Semester --</option>
            
            <option value="1st" <?php if($semester=="1st") echo "selected"; ?>>1st</option>

            <option value="2nd" <?php if($semester=="2nd") echo "selected"; ?>>2nd</option>

            <option value="3rd" <?php if($semester=="3rd") echo "selected"; ?>>3rd</option>

            <option value="4th" <?php if($semester=="4th") echo "selected"; ?>>4th</option>

        </select>

        <span class="error"><?php echo $semesterErr; ?></span><br>


        <select name="department">

            <option value="">-- Select Department --</option>

            <option value="CSE" <?php if($department=="CSE") echo "selected"; ?>>CSE</option>

            <option value="EEE" <?php if($department=="EEE") echo "selected"; ?>>EEE</option>

            <option value="BBA" <?php if($department=="BBA") echo "selected"; ?>>BBA</option>

            <option value="Others" <?php if($department=="Others") echo "selected"; ?>>Others</option>

        </select>

        <span class="error"><?php echo $deptErr; ?></span><br>

        <select name="room_pref">

            <option value="">-- Select Room --</option>

            <option value="Single" <?php if($room_pref=="Single") echo "selected"; ?>>Single</option>

            <option value="Double" <?php if($room_pref=="Double") echo "selected"; ?>>Double</option>

            <option value="Shared" <?php if($room_pref=="Shared") echo "selected"; ?>>Shared</option>

        </select>
        <span class="error"><?php echo $roomErr; ?></span><br>

        <select name="hostel_block">

            <option value="">-- Select Block --</option>

            <option value="A Block" <?php if($hostel_block=="A Block") echo "selected"; ?>>A Block</option>

            <option value="B Block" <?php if($hostel_block=="B Block") echo "selected"; ?>>B Block</option>

            <option value="C Block" <?php if($hostel_block=="C Block") echo "selected"; ?>>C Block</option>

        </select>

        <span class="error"><?php echo $blockErr; ?></span><br>

        <textarea name="notes" placeholder="Additional Notes (optional)"><?php echo $notes; ?></textarea><br>

        <input type="submit" value="Submit Application">

    </form>

    <p class="success"><?php echo $success; ?></p>

    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
</main>


</body>

</html>
