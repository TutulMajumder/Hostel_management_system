<?php

include "../DB/apply_room_DB.php";

include "../php/request_services_validate.php";

?>

<!DOCTYPE html>
<html>
<head>

    <title>Request Services</title>

    <link rel="stylesheet" href="../CSS/Header.css">

    <link rel="stylesheet" href="../CSS/RequestServices.css">

</head>
<body>

<?php include 'header.php'; ?> 

<main class="dashboard">

    <h1>Request Services</h1>

    <form method="post" class="services-form">

        <input type="text" name="fullname" placeholder="Full Name" value="<?php echo $fullname; ?>">

        <span class="error"><?php echo $fullnameErr; ?></span><br>


        <input type="text" name="student_id" placeholder="Student ID" value="<?php echo $student_id; ?>">

        <span class="error"><?php echo $studentIdErr; ?></span><br>

        <select name="service_type">

            <option value="">-- Select Service Type --</option>

            <option value="Room Cleaning" <?php if($service_type=="Room Cleaning") echo "selected"; ?>>Room Cleaning</option>

            <option value="Wi-Fi Issue" <?php if($service_type=="Wi-Fi Issue") echo "selected"; ?>>Wi-Fi Issue</option>

            <option value="Laundry" <?php if($service_type=="Laundry") echo "selected"; ?>>Laundry</option>

            <option value="Maintenance" <?php if($service_type=="Maintenance") echo "selected"; ?>>Maintenance</option>

            <option value="Other" <?php if($service_type=="Other") echo "selected"; ?>>Other</option>

        </select>

        <span class="error"><?php echo $serviceTypeErr; ?></span><br>

        <textarea name="service_details" placeholder="Provide details"><?php echo $service_details; ?></textarea>

        <span class="error"><?php echo $serviceDetailsErr; ?></span><br>

        <label>Preferred Date/Time:</label><br>

        <input type="datetime-local" name="preferred_date" value="<?php echo $preferred_date; ?>">

        <span class="error"><?php echo $preferredDateErr; ?></span><br><br>

        <input type="submit" value="Submit Request">

    </form>


    <p class="success"><?php echo $success; ?></p>

    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    
</main>

</body>
</html>
