<?php
include '../DB/config.php'; 

$error = "";
$edit_mode = false;
$edit_id = 0;
$expensetype = $amount = $date = $notes = "";


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("DELETE FROM expenses WHERE id=$id") === TRUE) {
        $error = "✅ Expense deleted successfully.";
    } else {
        $error = "❌ Error deleting: " . $conn->error;
    }
}


if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_mode = true;

    $sql = "SELECT * FROM expenses WHERE id=$edit_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $expensetype = $row['expense_type'];
    $amount      = $row['amount'];
    $date        = $row['date'];
    $notes       = $row['notes'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id          = $_POST['id'];
    $expensetype = $_POST["expense_type"];
    $amount      = $_POST["amount"];
    $date        = $_POST["date"];
    $notes       = $_POST["notes"];

    if (empty($expensetype) || empty($amount) || empty($date)) {
        $error = "⚠️ Expense type, amount, and date are required!";
    } else if (!is_numeric($amount)) {
        $error = "⚠️ Amount must be a number!";
    } else {
        $sql = "UPDATE expenses 
                SET expense_type='$expensetype', amount='$amount', date='$date', notes='$notes'
                WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $error = "✅ Expense updated successfully!";
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
    <title>View Expenses</title>
    <link rel="stylesheet" href="../CSS/style1.css">
</head>
<body>
<div class="main-container">
    <div class="container table-container">
        <h2>All Expenses</h2>
        <p class="error"><?php echo $error; ?></p>

        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Expense Type</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Notes</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM expenses ORDER BY date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['expense_type']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['date']}</td>
                            <td>{$row['notes']}</td>
                            <td>
                                <a href='view_expense.php?edit={$row['id']}'>Edit</a> | 
                                <a href='view_expense.php?delete={$row['id']}' onclick=\"return confirm('Are you sure?');\">Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No expenses available.</td></tr>";
            }
            ?>
        </table>

        <?php if ($edit_mode) { ?>
            <h2>Edit Expense</h2>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">

                <label>Expense Type:</label>
                <input type="text" name="expense_type" value="<?php echo $expensetype; ?>">

                <label>Amount:</label>
                <input type="text" name="amount" value="<?php echo $amount; ?>">

                <label>Date:</label>
                <input type="date" name="date" value="<?php echo $date; ?>">

                <label>Notes:</label><br>
                <textarea name="notes"><?php echo $notes; ?></textarea>

                <input type="submit" name="update" value="Update Expense">
            </form>
        <?php } ?>

        <h2>Monthly Expense Totals</h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Month</th>
                <th>Total Amount</th>
            </tr>
            <?php
            $sql = "SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(amount) AS total_amount
                    FROM expenses
                    GROUP BY DATE_FORMAT(date, '%Y-%m')
                    ORDER BY month DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['month']}</td>
                            <td>{$row['total_amount']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No monthly totals available.</td></tr>";
            }
            ?>
        </table>

        <p><a href="expense.php">⬅️ Back to Add Expense</a></p>
    </div>
</div>
</body>
</html>
