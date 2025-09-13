<?php
include '../DB/config.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentid   = trim($_POST["student_id"]);
    $studentname = trim($_POST["student_name"]);
    $email       = trim($_POST["email"]);
    $duedate     = trim($_POST["due_date"]);
    $message     = trim($_POST["message"]);

    if (empty($studentid) || empty($studentname) || empty($email) || empty($duedate) || empty($message)) {
        $error = "⚠️ All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠️ Invalid email format!";
    } else {
        $check_sql = "SELECT * FROM student_fees 
                      WHERE student_id = '$studentid' 
                      AND student_name = '$studentname' 
                      AND status = 'Pending'";
        $result = $conn->query($check_sql);

        if ($result && $result->num_rows > 0) {
           
            $sql = "INSERT INTO payment_reminders (student_id, student_name, email, due_date, message) 
                    VALUES ('$studentid', '$studentname', '$email', '$duedate', '$message')";
            
            if ($conn->query($sql) === TRUE) {
                $success = "✅ Reminder added successfully for $studentname ($email)";
            } else {
                $error = "❌ Query failed: " . $conn->error;
            }
        } else {
            $error = "⚠️ This student does not exist or does not have Pending fees!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Reminder</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style5.css">
</head>
<body>
    <div class="container">
        <h2>Add Payment Reminder</h2>

        <form method="post" action="">
            <label>Student ID</label>
            <input type="text" name="student_id" placeholder="Enter Student ID">

            <label>Student Name</label>
            <input type="text" name="student_name" placeholder="Enter Student Name">

            <label>Email</label>
            <input type="text" name="email" placeholder="Enter Student Email">

            <label>Due Date</label>
            <input type="date" name="due_date">

            <label>Message</label>
            <textarea name="message" placeholder="Enter Reminder Message"></textarea>

            <input type="submit" value="Save Reminder">
        </form>

        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>

        <a href="view_reminder.php">View Reminders</a>
        <p><a href="studentfee.php">⬅️ Back to Dashboard</a></p>
    </div>
</body>
</html>
