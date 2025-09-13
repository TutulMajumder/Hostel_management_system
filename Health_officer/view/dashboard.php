<?php
include "../php/dashboard_backend.php"; // Include backend
?>
<!DOCTYPE html>
<html>
<head>
    <title>Health Officer Dashboard</title>
    <link rel="stylesheet" href="/WT_Summer24-25/Health_officer/css/dashboard.css">
    <link rel="stylesheet" href="/WT_Summer24-25/Health_officer/css/topbar.css">
    <link rel="stylesheet" href="/WT_Summer24-25/Health_officer/css/footer.css">
</head>
<body>

<?php include 'topbar.php'; ?>

<main>
    <div class="container">
        <div class="dashboard-header">
            <h2>Health Officer Dashboard</h2>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="feature-icon">📋</div>
                <div class="stat-number"><?php echo $recent_requests ? $recent_requests->num_rows : 0; ?></div>
                <div>Recent Requests</div>
            </div>
            <div class="stat-card">
                <div class="feature-icon">👨‍⚕️</div>
                <div class="stat-number"><?php echo $doctor_visits; ?></div>
                <div>Doctor Visits</div>
            </div>
            <div class="stat-card">
                <div class="feature-icon">💊</div>
                <div class="stat-number"><?php echo $low_stock; ?></div>
                <div>Low Stock Items</div>
            </div>
            <div class="stat-card">
                <div class="feature-icon">💬</div>
                <div class="stat-number"><?php echo $new_feedback; ?></div>
                <div>New Feedback</div>
            </div>
        </div>

        <!-- Feature Cards (6 main features) -->
        <div class="features-grid">
            <a href="health_requests.php" class="feature-card">
                <div class="feature-icon">❤️</div>
                <div class="feature-title">Health Request Management</div>
                <p>Manage and respond to student health requests</p>
            </a>
            <a href="schedule_doctor.php" class="feature-card">
                <div class="feature-icon">👨‍⚕️</div>
                <div class="feature-title">Schedule Doctor Visits</div>
                <p>Schedule and manage doctor appointments</p>
            </a>
            <a href="medicine_inventory.php" class="feature-card">
                <div class="feature-icon">💊</div>
                <div class="feature-title">Medicine Inventory</div>
                <p>Track medicine stock and place orders</p>
            </a>
            <a href="health_feedback.php" class="feature-card">
                <div class="feature-icon">💬</div>
                <div class="feature-title">Health Feedback</div>
                <p>Review student feedback on health services</p>
            </a>
            <a href="health_reports.php" class="feature-card">
                <div class="feature-icon">📊</div>
                <div class="feature-title">Student Reports</div>
                <p>Access student medical history and reports</p>
            </a>
            <a href="salary_history.php" class="feature-card">
                <div class="feature-icon">💰</div>
                <div class="feature-title">Salary History</div>
                <p>View your salary payments and history</p>
            </a>
        </div>

        <!-- Recent Health Requests Table -->
        <div class="recent-requests">
            <h3>Recent Health Requests</h3>
            <table>
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Symptoms</th>
                        <th>Request Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($recent_requests && $recent_requests->num_rows > 0) {
                    while($row = $recent_requests->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>#".htmlspecialchars($row['id'])."</td>";
                        echo "<td>".htmlspecialchars($row['student_id'])."</td>";
                        echo "<td>".htmlspecialchars($row['name'])."</td>";
                        echo "<td>".htmlspecialchars($row['symptoms'])."</td>";
                        echo "<td>".htmlspecialchars($row['request_date'])."</td>";

                        if ($row['status'] == "Pending") {
                            echo '<td><span class="badge badge-pending">Pending</span></td>';
                        } elseif ($row['status'] == "In Progress") {
                            echo '<td><span class="badge badge-in-progress">In Progress</span></td>';
                        } else {
                            echo '<td><span class="badge badge-resolved">Resolved</span></td>';
                        }
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="6">No recent requests found.</td></tr>';
                }
                ?>
                </tbody>
            </table>
            <a href="health_requests.php" class="view-all">View All Requests →</a>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
