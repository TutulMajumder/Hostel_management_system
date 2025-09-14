<?php
include "../php/schedule_doctor_backend.php"; // backend loaded here
include "topbar.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Schedule Doctor Visits</title>
    <link rel="stylesheet" href="../css/schedule_doctor.css">
    <link rel="stylesheet" href="../css/topbar.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
<div class="container">
    <div class="dashboard-header">
        <h2>Schedule Doctor Visits</h2>
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

    <?php
    if (!empty($success)) { echo "<p class='success'>$success</p>"; }
    if (!empty($error)) { echo "<p class='error'>$error</p>"; }
    ?>

    <div class="content-section">
        <!-- Form Section -->
        <div class="form-section">
            <h3>Schedule New Visit</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Doctor Name:</label>
                    <input type="text" name="doctor_name" placeholder="Enter doctor name">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Visit Date:</label>
                        <input type="date" name="visit_date">
                    </div>
                    <div class="form-group">
                        <label>Visit Time:</label>
                        <input type="time" name="visit_time">
                    </div>
                </div>
                <div class="form-group">
                    <label>Purpose:</label>
                    <textarea name="purpose" placeholder="Purpose of visit" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Maximum Slots:</label>
                    <input type="number" name="max_slots" value="10" min="1">
                </div>
                <div class="form-group">
                    <input type="submit" name="add_visit" value="Schedule Visit">
                </div>
            </form>
        </div>

        <!-- List Section -->
        <div class="list-section">
            <h3>Scheduled Doctor Visits</h3>
            <table class="doctor-table">
                <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Date & Time</th>
                    <th>Purpose</th>
                    <th>Slots</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['doctor_name']) ?></td>
                            <td><?= date("M d, Y", strtotime($row['visit_date'])) . " at " . date("h:i A", strtotime($row['visit_time'])) ?></td>
                            <td><?= htmlspecialchars($row['purpose']) ?></td>
                            <td><?= $row['booked_slots'] . "/" . $row['max_slots'] ?></td>
                            <td>
                                <a href="?delete=<?= $row['id'] ?>" class="cancel-btn">Cancel</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">No scheduled visits found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include "footer.php"; ?>
</body>
</html>
<?php $conn->close(); ?>
