<?php
include '../DB/config.php'; 

$error = "";
$studentid = "";
$studentname = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reset'])) {
        $studentid = "";
        $studentname = "";
        $error = "";
    } else {
        $studentid   = trim($_POST["student_id"]);
        $studentname = trim($_POST["student_name"]);

        if (empty($studentid) || empty($studentname)) {
            $error = "⚠️ Please enter BOTH Student ID and Name!";
        } else {
            $check_sql = "SELECT * FROM student_fees 
                          WHERE student_id = '$studentid' AND student_name = '$studentname'";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows == 0) {
                $error = "❌ Student ID and Name not found in the database!";
            } else {
                $due_sql = "SELECT * FROM student_fees 
                            WHERE student_id = '$studentid' 
                            AND student_name = '$studentname' 
                            AND status = 'Pending'";
                $due_result = $conn->query($due_sql);

                if ($due_result->num_rows > 0) {
                    $row = $due_result->fetch_assoc();
                    $amount = $row['amount'];
                    $duedate = $row['payment_date'];
                    $error = "✅ Pending dues found for $studentname ($studentid). Amount: $amount, Due Date: $duedate";
                } else {
                    $error = "ℹ️ No pending dues for $studentname ($studentid)";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Track Pending Dues</title>
    <link rel="stylesheet" href="../CSS/style4.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <h2>Track Pending Dues</h2>

            <label>Student ID:</label>
            <input type="text" name="student_id" placeholder="Enter Student ID" 
                   value="<?php echo htmlspecialchars($studentid); ?>">

            <label>Student Name:</label>
            <input type="text" name="student_name" placeholder="Enter Student Name" 
                   value="<?php echo htmlspecialchars($studentname); ?>">

            <div class="button-group">
                <input type="submit" name="search" value="Check Dues">
                <input type="submit" name="reset" value="Reset Form">
            </div>
        </form>

        <?php if(!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <p><a href="dashboard.php">⬅️ Back to Dashboard</a></p>
    </div>
</body>
</html>
