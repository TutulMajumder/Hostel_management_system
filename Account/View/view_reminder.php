<?php
include '../DB/config.php'; 

$error = "";
$edit_mode = false;
$edit_id = 0;
$studentid = $studentname = $email = $duedate = $message = "";


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("DELETE FROM payment_reminders WHERE id=$id") === TRUE) {
        $error = "✅ Reminder deleted successfully.";
    } else {
        $error = "❌ Error deleting: " . $conn->error;
    }
}


if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_mode = true;

    $sql = "SELECT * FROM payment_reminders WHERE id=$edit_id";
    $result = $conn->query($sql);
    $row = $result->fetch_row(); 

    $studentid   = $row[1];
    $studentname = $row[2];
    $email       = $row[3];
    $duedate     = $row[4];
    $message     = $row[5];
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id          = $_POST['id'];
    $studentid   = $_POST["student_id"];
    $studentname = $_POST["student_name"];
    $email       = $_POST["email"];
    $duedate     = $_POST["due_date"];
    $message     = $_POST["message"];

    if (empty($studentid) || empty($studentname) || empty($email) || empty($duedate) || empty($message)) {
        $error = "⚠️ All fields are required!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠️ Invalid email format!";
    } else {
        $sql = "UPDATE payment_reminders 
                SET student_id='$studentid', student_name='$studentname', email='$email', due_date='$duedate', message='$message'
                WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $error = "✅ Reminder updated successfully!";
            $edit_mode = false;
        } else {
            $error = "❌ Error updating: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Reminders</title>
    <link rel="stylesheet" href="../CSS/style1.css">
</head>
<body>
    <div class="main-container">
        <div class="container table-container">
            <h2>All Reminders</h2>
            <p class="error"><?php echo $error; ?></p>

            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Due Date</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
                <?php
                $sql = "SELECT * FROM payment_reminders ORDER BY id DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_row()) {
                        echo "<tr>
                                <td>$row[0]</td>
                                <td>$row[1]</td>
                                <td>$row[2]</td>
                                <td>$row[3]</td>
                                <td>$row[4]</td>
                                <td>$row[5]</td>
                                <td>
                                    <a href='view_reminder.php?edit=$row[0]'>Edit</a> | 
                                    <a href='view_reminder.php?delete=$row[0]' onclick=\"return confirm('Are you sure?');\">Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No reminders available.</td></tr>";
                }
                ?>
            </table>

            <?php if ($edit_mode) { ?>
                <h2>Edit Reminder</h2>
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?php echo $edit_id; ?>">

                    <label>Student ID:</label>
                    <input type="text" name="student_id" value="<?php echo $studentid; ?>">

                    <label>Student Name:</label>
                    <input type="text" name="student_name" value="<?php echo $studentname; ?>">

                    <label>Email:</label>
                    <input type="text" name="email" value="<?php echo $email; ?>">

                    <label>Due Date:</label>
                    <input type="date" name="due_date" value="<?php echo $duedate; ?>">

                    <label>Message:</label><br>
                    <textarea name="message"><?php echo $message; ?></textarea>

                    <input type="submit" name="update" value="Update Reminder">
                </form>
            <?php } ?>

            <p><a href="reminder.php">Back to Send Reminder</a></p>
        </div>
    </div>
</body>
</html>
