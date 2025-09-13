<?php

include "../DB/apply_room_DB.php";

include "../php/track_room_validate.php";

?>
<!DOCTYPE html>
<html>
<head>

    <title>Track Room Application Status</title>

    <link rel="stylesheet" href="../CSS/Header.css">

    <link rel="stylesheet" href="../CSS/TrackRoom.css">

</head>
<body>

<?php include 'header.php'; ?> <!-- Header -->

<main class="dashboard">

    <h1>Track Room Application Status</h1>

    <form method="post" class="status-form">

        <label for="studentID">Student ID:</label>

        <input type="text" name="studentID" id="studentID" value="<?php echo $studentID; ?>">

        <span class="error"><?php echo $error; ?></span><br>

        <input type="submit" value="Check Status">

    </form>

    <?php if (!empty($status)): ?>

        <p class="result"><?php echo $status; ?></p>

    <?php endif; ?>

    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    
</main>

</body>
</html>
