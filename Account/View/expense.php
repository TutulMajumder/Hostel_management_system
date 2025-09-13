<?php
include '../DB/config.php'; 

$error = "";
$success = "";

$expensetype = "";
$amount = "";
$date = "";
$notes = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expensetype = $_POST["expense_type"];
    $amount      = $_POST["amount"];
    $date        = $_POST["date"];
    $notes       = $_POST["notes"];

    if (empty($expensetype) || empty($amount) || empty($date)) {
        $error = "⚠️ All fields except notes are required!";
    } else if (!is_numeric($amount)) {
        $error = "⚠️ Amount must be a number!";
    } else {
        $sql = "INSERT INTO expenses (expense_type, amount, date, notes) 
                VALUES ('$expensetype', '$amount', '$date', '$notes')";

        if ($conn->query($sql) === TRUE) {
            $success = "✅ Expense record saved successfully!";
            $expensetype = $amount = $date = $notes = "";
        } else {
            $error = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Expenses</title>
    <link rel="stylesheet" href="../CSS/style6.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <h2>Manage Expenses</h2>

            <label>Expense Type:</label>
            <input type="text" name="expense_type" placeholder="e.g., Electricity Bill, Maintenance" 
                   value="<?php echo $expensetype; ?>">

            <label>Amount:</label>
            <input type="text" name="amount" placeholder="Enter Amount" value="<?php echo $amount; ?>">

            <label>Date:</label>
            <input type="date" name="date" value="<?php echo $date; ?>">

            <label>Notes:</label>
            <textarea name="notes" placeholder="Optional details..."><?php echo $notes; ?></textarea>

            <input type="submit" value="Save Expense">
        </form>

        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <?php if (!empty($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>

        <div class="link-row">
            <a href="dashboard.php" class="btn-link">⬅️ Back to Dashboard</a>
            <a href="view_expense.php" class="btn-link">View Expenses ➡️</a>
        </div>
    </div>
</body>
</html>
