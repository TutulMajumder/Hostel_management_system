<?php
include '../DB/config.php';

$error = "";
$success = "";


$fullname = "";
$role = "";
$amount = "";
$payment_date = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname     = trim($_POST["fullname"]);
    $role         = trim($_POST["role"]);
    $amount       = trim($_POST["amount"]);
    $payment_date = trim($_POST["payment_date"]);
    $status       = trim($_POST["status"]);

    if (empty($fullname) || empty($amount) || empty($payment_date)) {
        $error = "⚠️ Full Name, Amount, and Payment Date are required!";
    } else if (!is_numeric($amount)) {
        $error = "⚠️ Salary amount must be a number!";
    } else {
        $sql = "INSERT INTO staff_salary (fullname, role, amount, payment_date, status) 
                VALUES ('$fullname', '$role', '$amount', '$payment_date', '$status')";

        if ($conn->query($sql) === TRUE) {
            $expense_type = "Salary - $role";
            $notes = "Salary paid to $fullname ($role)";
            $sql2 = "INSERT INTO expenses (expense_type, amount, date, notes) 
                     VALUES ('$expense_type', '$amount', '$payment_date', '$notes')";
            $conn->query($sql2);

            $success = "✅ Salary record saved for $fullname and added to expenses!";
           
            $fullname = $role = $amount = $payment_date = $status = "";
        } else {
            $error = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pay Salary</title>
    <link rel="stylesheet" href="../CSS/style6.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <h2>Pay Staff Salary</h2>

            <label>Full Name:</label>
            <input type="text" name="fullname" placeholder="Enter Full Name" 
                   value="<?php echo $fullname; ?>">

            <label>Role:</label>
            <select name="role">
                <option value="">-- Select Role --</option>
                <option value="Teacher"       <?php if($role=="Teacher") echo "selected"; ?>>Teacher</option>
                <option value="Warden"        <?php if($role=="Warden") echo "selected"; ?>>Warden</option>
                <option value="Librarian"     <?php if($role=="Librarian") echo "selected"; ?>>Librarian</option>
                <option value="Cleaner"       <?php if($role=="Cleaner") echo "selected"; ?>>Cleaner</option>
                <option value="Guard"         <?php if($role=="Guard") echo "selected"; ?>>Guard</option>
                <option value="Admin"         <?php if($role=="Admin") echo "selected"; ?>>Admin</option>
                <option value="Health Officer"<?php if($role=="Health Officer") echo "selected"; ?>>Health Officer</option>
            </select>

            <label>Salary Amount:</label>
            <input type="text" name="amount" placeholder="Enter Amount" 
                   value="<?php echo $amount; ?>">

            <label>Payment Date:</label>
            <input type="date" name="payment_date" value="<?php echo $payment_date; ?>">

            <label>Payment Status (Optional):</label>
            <input type="text" name="status" placeholder="Paid / Pending" 
                   value="<?php echo $status; ?>">

            <input type="submit" value="Save Salary Record">
        </form>

        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <?php if (!empty($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>

        <div class="link-row">
            <a href="dashboard.php" class="btn-link">⬅️ Back to Dashboard</a>
            <a href="view_salary.php" class="btn-link">View Salary Records ➡️</a>
        </div>
    </div>
</body>
</html>
