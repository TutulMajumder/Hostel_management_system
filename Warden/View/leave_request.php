<?php
include "../Php/process_leave_request.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Leave Requests - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/leave_request.css">
    <link rel="stylesheet" href="../Css/topbar.css">
</head>

<body>

    <!-- Header -->
    <?php include "topbar.php"; ?>

    <!-- Main Content -->
    <main>
        <section id="leave-requests">
            <h2>Leave Requests</h2>

            <!-- Leave Request Form (for admin to approve/reject requests) -->
            <form action="" method="POST">
                <label for="student_id">Student ID:</label>
                <input type="text" name="student_id" id="student_id" placeholder="Enter Student ID" class="request_input">

                <label for="status">Status:</label>
                <select name="status" id="status" class="status-select" required>

                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>

                    <option value="Rejected">Rejected</option>
                </select>

                <label for="feedback">Feedback:</label>
                <textarea name="feedback" id="feedback" class="feedback-textarea" placeholder="Enter feedback..."></textarea>

                <?php if (isset($_SESSION['errors'])): ?>
                    <p class="error"><?php echo $_SESSION['errors'];
                                        unset($_SESSION['errors']); ?></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <p class="success"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></p>
                <?php endif; ?>
                <button type="submit" class="submit-btn">Submit</button>
            </form>

            <!-- Leave Request Table -->
            <div class="table-container">
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>Leave Request ID</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Leave Start Date</th>
                            <th>Leave End Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Leave Application</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch attendance data from the database
                        $query = "SELECT * FROM leave_requests";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['student_id'] . "</td>";
                                echo "<td>" . $row['student_name'] . "</td>";
                                echo "<td>" . $row['leave_start_date'] . "</td>";
                                echo "<td>" . $row['leave_end_date'] . "</td>";
                                echo "<td>" . $row['reason'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>" . $row['feedback'] . "</td>";
                                echo "<td>" . $row['file_path'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No Leave requests records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include "footer.php"; ?>

</body>

</html>