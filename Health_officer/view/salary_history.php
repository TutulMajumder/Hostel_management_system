<?php
// Use a reliable include path from the view folder
include_once __DIR__ . '/../php/salary_history_backend.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Salary History</title>
    <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/salary_history.css">
    <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/topbar.css">
    <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/footer.css">
</head>
<body>
    <h2>Salary History</h2>
    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>

    <?php if (!empty($error)) { ?>
        <p style="color:red;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php } ?>
    <?php if (!empty($success)) { ?>
        <p style="color:green;"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php } ?>

    <p><strong>Username:</strong> <?php echo htmlspecialchars($officer['username'], ENT_QUOTES, 'UTF-8'); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($officer['email'], ENT_QUOTES, 'UTF-8'); ?></p>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Month/Year</th>
                <th>Basic Salary</th>
                <th>Allowances</th>
                <th>Deductions</th>
                <th>Net Salary</th>
                <th>Status</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($salary_records)) { ?>
            <?php foreach ($salary_records as $r) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['month_year'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($r['basic_salary'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($r['allowances'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($r['deductions'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><strong><?php echo htmlspecialchars($r['net_salary'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                    <td><?php echo htmlspecialchars($r['payment_status'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo !empty($r['payment_date']) ? htmlspecialchars($r['payment_date'], ENT_QUOTES, 'UTF-8') : '-'; ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="7">No salary records found.</td></tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>
