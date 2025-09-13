<?php
include '../DB/config.php';

$error = "";
$update_mode = false;
$id = "";
$studentid = "";
$studentname = "";
$amount = "";
$date = "";
$status = "";


if (isset($_POST['update'])) {
    $id          = $_POST["id"];
    $studentid   = $_POST["student_id"];
    $studentname = $_POST["student_name"];
    $amount      = $_POST["amount"];
    $date        = $_POST["date"];
    $status      = $_POST["status"];

    if (empty($studentid) || empty($studentname) || empty($amount) || empty($date)) {
        $error = "⚠️ All fields are required!";
    } elseif (!is_numeric($amount)) {
        $error = "⚠️ Amount must be a number!";
    } else {
        $sql = "UPDATE student_fees 
                SET student_id='$studentid', student_name='$studentname', amount='$amount', payment_date='$date', status='$status'
                WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $error = "✅ Fee record updated!";
        } else {
            $error = "❌ Error: " . $conn->error;
        }
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM student_fees WHERE id=$id");
    header("Location: view_studentfee.php?msg=deleted");
    exit;
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM student_fees WHERE id=$id");
    $row = $result->fetch_assoc();
    $studentid   = $row['student_id'];
    $studentname = $row['student_name'];
    $amount      = $row['amount'];
    $date        = $row['payment_date'];
    $status      = $row['status'];
    $update_mode = true;
}

if (isset($_GET['msg']) && $_GET['msg'] == "deleted") {
    $error = "🗑️ Record deleted!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Student Fees</title>
    <link rel="stylesheet" href="../CSS/style1.css">
</head>
<body>
<div class="container">
    <h2>Student Fee Records</h2>

    <?php if ($update_mode): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $id ?>">

            <label>Student ID:</label>
            <input type="text" name="student_id" value="<?= $studentid ?>">

            <label>Student Name:</label>
            <input type="text" name="student_name" value="<?= $studentname ?>">

            <label>Amount:</label>
            <input type="text" name="amount" value="<?= $amount ?>">

            <label>Date:</label>
            <input type="date" name="date" value="<?= $date ?>">

            <label>Status:</label>
            <select name="status">
                <option value="Paid" <?= ($status=="Paid")?"selected":"" ?>>Paid</option>
                <option value="Pending" <?= ($status=="Pending")?"selected":"" ?>>Pending</option>
            </select>

            <input type="submit" name="update" value="Update Record">
        </form>
    <?php endif; ?>

    <p class="error"><?= $error ?></p>

    <table border="1">
        <tr><th>ID</th><th>Student ID</th><th>Name</th><th>Amount</th><th>Date</th><th>Status</th><th>Action</th></tr>
        <?php
        $result = $conn->query("SELECT * FROM student_fees ORDER BY payment_date DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['student_id']}</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['payment_date']}</td>
                    <td>{$row['status']}</td>
                    <td>
                        <a href='?edit={$row['id']}'>Edit</a> | 
                        <a href='?delete={$row['id']}' onclick=\"return confirm('Delete this record?')\">Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <p><a href="studentfee.php">⬅️ Back to Add Form</a></p>
</div>
</body>
</html>
