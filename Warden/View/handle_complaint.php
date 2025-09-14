<?php
include '../Php/process_complaint.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Handle Complaints - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/handle_complaints.css"> <!-- Link to the CSS -->
    <link rel="stylesheet" href="../Css/topbar.css">
</head>

<body>

    <!-- Header -->
    <?php include "topbar.php"; ?>

    <!-- Main Content -->
    <main>
        <section id="handle-complaints">
            <h2>Handle Complaints</h2>

            <!-- Form to handle complaint actions (above table) -->
            <form action="" method="POST">
                <label for="complaint_id">Complaint ID</label>
                <input type="text" name="complaint_id" id="complaint_id" placeholder="Enter Complaint ID" class="complaint-id-input">

                <label for="status">Status</label>
                <select name="status" id="status" class="status-select">
                    <option value="Pending" selected>Pending</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Escalated">Escalated</option>
                </select>

                <label for="feedback">Feedback</label>
                <textarea name="feedback" id="feedback" class="feedback-textarea" placeholder="Enter feedback..."></textarea>

                <?php if (isset($_SESSION['errors'])): ?>
                    <p class="error"><?php echo $_SESSION['errors'];
                                        unset($_SESSION['errors']); ?></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <p class="success"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></p>
                <?php endif; ?>

                <button type="submit" class="submit-btn">Save</button>
            </form>

            <!-- Table to display complaints -->
            <div class="table-container">
                <table class="complaints-table">
                    <thead>
                        <tr>
                            <th>Complaint ID</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Complaint Category</th>
                            <th>Complaint Details</th>
                            <th>Status</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <?php
                                // $query="SELECT * FROM complaints";
                                // $result=$conn->query($query);
                                // if ($result->num_rows > 0)
                                // {
                                //     while($row=$result->fetch_assoc())
                                //     {
                                //         echo "<tr>";
                                //         echo "<td>".$row['id']."</td>";
                                //         echo "<td>".$row['student_id']."</td>";
                                //         echo "<td>".$row['fullname']."</td>";
                                //         echo "<td>".$row['category']."</td>";
                                //         echo "<td>".$row['details']."</td>";
                                //         echo "<td>".$row['status']."</td>";
                                //         echo "<td>".$row['feedback']."</td>";
                                //         echo"</tr>";
                                //     }
                                // }
                                // else{
                                //     echo "<tr><td colspan='7'>So Complaints found.</td></tr>";
                                // }
                                ?> -->
                        <?php
                        // Fetch attendance data from the database
                        $query = "SELECT * FROM complaints";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo " <td>" . $row['id'] . "</td>";
                                echo " <td>" . $row['student_id'] . "</td>";
                                echo " <td>" . $row['fullname'] . "</td>";
                                echo " <td>" . $row['category'] . "</td>";
                                echo " <td>" . $row['details'] . "</td>";
                                echo " <td>" . $row['status'] . "</td>";
                                echo " <td>" . $row['feedback'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No Complaints records found.</td></tr>";
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