<?php
include "../php/health_requests_backend.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Health Requests Management</title>
    <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/health_requests.css">
    <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/topbar.css">
    <link rel="stylesheet" href="/Hostel_management_system/Health_officer/css/footer.css">
</head>
<body>
<?php include 'topbar.php'; ?>

<div class="container">
    <div class="dashboard-header">
        <h2>Health Requests Management</h2>
        <div>
            <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="recent-requests">
        <h3>All Health Requests</h3>
        <table class="medicine-table">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Student</th>
                    <th>Symptoms</th>
                    <th>Request Date</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']) . " (" . $row['student_id'] . ")"; ?></td>
                    <td><?php echo htmlspecialchars($row['symptoms']); ?></td>
                    <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                    <td>
                        <?php 
                            if ($row['status'] === "Pending") echo "<span class='badge badge-pending'>Pending</span>";
                            elseif ($row['status'] === "In Progress") echo "<span class='badge badge-in-progress'>In Progress</span>";
                            else echo "<span class='badge badge-resolved'>Resolved</span>";
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['notes']); ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No requests found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Update Request -->
    <div class="update-section">
        <h3>Update Request Status</h3>
        <?php if($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
        <?php if($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>

        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>Request ID:</label>
                    <input type="number" name="request_id" placeholder="Enter Request ID" required>
                </div>
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Notes:</label>
                    <input type="text" name="notes" placeholder="Enter notes">
                </div>
                <div class="form-group">
                    <input type="submit" name="update_request" value="Update Status">
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>
