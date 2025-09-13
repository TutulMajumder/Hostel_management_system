<?php
include '../DB/config.php';  

$error = "";
$edit_mode = false;
$edit_id = 0;
$fullname = $role = $amount = $payment_date = $status = "";


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("DELETE FROM staff_salary WHERE id=$id") === TRUE) {
        $error = "✅ Salary record deleted successfully.";
    } else {
        $error = "❌ Error deleting: " . $conn->error;
    }
}


if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_mode = true;

    $sql = "SELECT * FROM staff_salary WHERE id=$edit_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $fullname     = $row['fullname'];
    $role         = $row['role'];
    $amount       = $row['amount'];
    $payment_date = $row['payment_date'];
    $status       = $row['status'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id           = $_POST['id'];
    $fullname     = $_POST['fullname'];
    $role         = $_POST['role'];
    $amount       = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $status       = $_POST['status'];

    if (empty($fullname) || empty($amount) || empty($payment_date)) {
        $error = "⚠️ Full Name, Amount, and Payment Date are required!";
    } else if (!is_numeric($amount)) {
        $error = "⚠️ Amount must be a number!";
    } else {
        $sql = "UPDATE staff_salary 
                SET fullname='$fullname', role='$role', 
                    amount='$amount', payment_date='$payment_date', status='$status'
                WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $error = "✅ Salary record updated successfully!";
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
    <title>View Staff Salaries</title>
    <link rel="stylesheet" href="../CSS/style1.css">
</head>
<body>
    <div class="container table-container">
        <h2>All Staff Salaries</h2>
        <p class="error"><?php echo $error; ?></p>

        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM staff_salary ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['fullname']}</td>
                            <td>{$row['role']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['payment_date']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <a href='view_salary.php?edit={$row['id']}'>Edit</a> | 
                                <a href='view_salary.php?delete={$row['id']}' onclick=\"return confirm('Are you sure?');\">Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No salary records available.</td></tr>";
            }
            ?>
        </table>

        <?php if ($edit_mode) { ?>
            <h2>Edit Salary Record</h2>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">

                <label>Full Name:</label>
                <input type="text" name="fullname" value="<?php echo $fullname; ?>">

                <label>Role:</label>
                <select name="role">
                    <option value="">-- Select Role --</option>
                    <option value="Teacher" <?php if($role=="Teacher") echo "selected"; ?>>Teacher</option>
                    <option value="Warden" <?php if($role=="Warden") echo "selected"; ?>>Warden</option>
                    <option value="Librarian" <?php if($role=="Librarian") echo "selected"; ?>>Librarian</option>
                    <option value="Cleaner" <?php if($role=="Cleaner") echo "selected"; ?>>Cleaner</option>
                    <option value="Guard" <?php if($role=="Guard") echo "selected"; ?>>Guard</option>
                    <option value="Admin" <?php if($role=="Admin") echo "selected"; ?>>Admin</option>
                    <option value="Health Officer" <?php if($role=="Health Officer") echo "selected"; ?>>Health Officer</option>
                </select>

                <label>Salary Amount:</label>
                <input type="text" name="amount" value="<?php echo $amount; ?>">

                <label>Payment Date:</label>
                <input type="date" name="payment_date" value="<?php echo $payment_date; ?>">

                <label>Status:</label>
                <input type="text" name="status" value="<?php echo $status; ?>">

                <input type="submit" name="update" value="Update Salary">
            </form>
        <?php } ?>

        <p><a href="paysalary.php">⬅️ Back to Pay Salary</a></p>
    </div>
</body>
</html>
