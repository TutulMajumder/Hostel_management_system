<?php
include "../Php/process_attendabce.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Track Attendance - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/track_attendance.css">
    <link rel="stylesheet" href="../Css/topbar.css">
</head>

<body>

    <!-- Header -->
    <?php include "topbar.php"; ?>

    <!-- Main Content -->
    <main>
        <section id="track-attendance">
            <h2>Track Attendance</h2>

            <!-- Attendance Entry Form -->
            <form action="" method="POST">
                <label for="attendance_date">Select Date:</label>
                <input type="date" id="attendance_date" name="attendance_date" class="date-input">

                <label for="student_id">Student ID:</label>
                <input type="text" name="student_id" id="student_id" placeholder="Enter Student ID" class="request_input">

                <label for="attendance_status">Status:</label>
                <select name="status" id="attendance_status" class="status-select">
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>

                <?php if (isset($_SESSION['errors'])): ?>
                    <p class="error"><?php echo $_SESSION['errors'];
                                        unset($_SESSION['errors']); ?></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <p class="success"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></p>
                <?php endif; ?>

                <button type="submit" class="submit-btn">Submit Attendance</button>
            </form>

            <!-- Attendance Table -->
            <div class="table-container">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>Attendance ID</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="attendance-table-body">
                        <?php
                        // Fetch attendance data from the database
                        $query = "SELECT * FROM attendance";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['student_id'] . "</td>";
                                echo "<td>" . $row['fullname'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>" . $row['date'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No attendance records found.</td></tr>";
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