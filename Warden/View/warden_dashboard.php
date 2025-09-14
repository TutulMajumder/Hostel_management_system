<?php
include "../Php/process_dashboard.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Warden Dashboard - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="../Css/topbar.css">
</head>

<body>
    <!-- Header -->
    <?php include "topbar.php" ?>

    <!-- Main Content -->
    <main>
        <section id="feature-cards">
            <div class="card-row">
                <a href="assign_rooms.php" class="card-link">
                    <div class="card">
                        <h3>Assigning Rooms</h3>
                        <p>Manage room assignments for students.</p>
                    </div>
                </a>
                <a href="leave_request.php" class="card-link">
                    <div class="card">
                        <h3>Leave Requests</h3>
                        <p>View and manage leave requests.</p>
                    </div>
                </a>
                <a href="handle_complaint.php" class="card-link">
                    <div class="card">
                        <h3>Handle Complaints</h3>
                        <p>View and handle student complaints.</p>
                    </div>
                </a>
            </div>

            <div class="card-row">
                <a href="post_notice.php" class="card-link">
                    <div class="card">
                        <h3>Post Notices</h3>
                        <p>Post important notices for the hostel.</p>
                    </div>
                </a>
                <a href="track_attendance.php" class="card-link">
                    <div class="card">
                        <h3>Track Attendance</h3>
                        <p>Track and manage student attendance.</p>
                    </div>
                </a>
                <a href="handle_services.php" class="card-link">
                    <div class="card">
                        <h3>Maintenance and Services</h3>
                        <p>Manage maintenance requests and services.</p>
                    </div>
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include "footer.php" ?>
</body>

</html>
