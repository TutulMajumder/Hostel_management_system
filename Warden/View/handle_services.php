<?php
include "../Php/process_services.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Services - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/handle_services.css">
    <link rel="stylesheet" href="../Css/topbar.css">
</head>

<body>

    <!-- Header -->
    <?php include "topbar.php"; ?>

    <!-- Main Content -->
    <main>
        <section id="manage-services">
            <h2>Manage Service Requests</h2>

            <form action="" method="POST">
                <label>Service Id</label>
                <input type="text" name="service_id" placeholder="Enter Service ID" class="request_input">
                <label>Assigned Date</label>
                <input type="date" name="assign_date" class="date-input">
                <label>Status</label>
                <select name="status" class="status-select">
                    <option value="Pending" selected>Pending</option>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="In Progress">In Progress</option>
                </select>
                <label>Feedback</label>
                <textarea name="feedback" class="feedback-textarea" placeholder="Enter feedback..."></textarea>
                <span class="error"><?php echo $errors; ?></span>
                <span class="success"><?php echo $success; ?></span>
                <button type="submit" class="submit-btn">Save</button>
            </form>
            <div class="table-container">
                <table class="services-table">
                    <thead>
                        <tr>
                            <th>Service ID</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Service Type</th>
                            <th>Service Details</th>
                            <th>Preferred Date</th>
                            <th>Assigned Date</th>
                            <th>Status</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch the complaints from the database
                        $query="SELECT * FROM services";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['student_id'] . "</td>";
                                echo "<td>" . $row['fullname'] . "</td>";
                                echo "<td>" . $row['service_type'] . "</td>";
                                echo '<td>' . $row['details'] . '</td>';
                                echo "<td>" . $row['preferred_date'] . "</td>";
                                echo "<td>" . $row['assign_date'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>" . $row['feedback'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            // If no records are found, display this message
                            echo "<tr><td colspan='8'>No service requests found.</td></tr>";
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