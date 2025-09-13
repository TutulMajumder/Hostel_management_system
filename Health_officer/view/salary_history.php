<?php include "../php/salary_history_backend.php"; ?>
<?php include 'topbar.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Salary History</title>
    <link rel="stylesheet" href="/WT_Summer24-25/health_officer/css/salary_history.css">
    <link rel="stylesheet" href="/WT_Summer24-25/health_officer/css/topbar.css">
    <link rel="stylesheet" href="/WT_Summer24-25/health_officer/css/footer.css">
</head>
<body>
<div class="container">
    <div class="dashboard-header">
        <h2>💰 Salary History</h2>
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

    <div class="officer-info">
        <p><strong>Username:</strong> <?= htmlspecialchars($officer['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($officer['email']) ?></p>
    </div>

    <div class="list-section">
        <table>
            <thead>
                <tr>
                    <th>Month/Year</th>
                    <th>Basic Salary</th>
                    <th>Allowances</th>
                    <th>Deductions</th>
                    <th>Net Salary</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                    <th>Processed By</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($salary_records)): ?>
                    <?php foreach($salary_records as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['month_year']) ?></td>
                            <td><?= htmlspecialchars($row['basic_salary']) ?></td>
                            <td><?= htmlspecialchars($row['allowances']) ?></td>
                            <td><?= htmlspecialchars($row['deductions']) ?></td>
                            <td><?= htmlspecialchars($row['net_salary']) ?></td>
                            <td style="color:<?= $row['payment_status']=='Paid'?'green':'orange' ?>">
                                <?= htmlspecialchars($row['payment_status']) ?>
                            </td>
                            <td><?= $row['payment_date'] ? htmlspecialchars($row['payment_date']) : '-' ?></td>
                            <td><?= htmlspecialchars($row['processed_by']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8">No salary records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="/WT_Summer24-25/project_dev/js/salary_history.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>
