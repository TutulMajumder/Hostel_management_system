<?php 
include "../Php/process_rooms.php"; 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Assign Rooms - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/assign_rooms.css">
    <link rel="stylesheet" href="../Css/topbar.css">
</head>

<body>

    <!-- Header -->
    <?php include "topbar.php"; ?>

    <!-- Main Content -->
    <main>
        <section id="assign-rooms">
            <h2>Assign Rooms</h2>

            <!-- Action Form -->
            <form action="" method="POST">
                <label>Application ID</label>
                <input type="text" name="application_id" placeholder="Enter Application ID" class="request_input">

                <label>Assign Room</label>
                <select name="room_id" class="room-select">
                    <option value="">--Select Room--</option>
                    <?php foreach ($rooms as $room): ?>
                        <?php if ($room['available'] == 1): ?>
                            <option value="<?php echo $room['id']; ?>">
                                <?php echo $room['room_name'] . " (" . $room['room_type'] . ")"; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>

                <span class="error"><?php echo $errors; ?></span>
                <span class="success"><?php echo $success; ?></span>

                <button type="submit" class="submit-btn">Assign</button>
            </form>

            <!-- Pending Applications Table -->
            <div class="table-container">
                <h3>Pending Student Applications</h3>
                <table class="apps-table">
                    <thead>
                        <tr>
                            <th>App ID</th>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Semester</th>
                            <th>Department</th>
                            <th>Preference</th>
                            <th>Block</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>Room ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($applications)): ?>
                            <?php foreach ($applications as $app): ?>
                                <tr>
                                    <td><?php echo $app['id']; ?></td>
                                    <td><?php echo $app['student_id']; ?></td>
                                    <td><?php echo $app['fullname']; ?></td>
                                    <td><?php echo $app['semester']; ?></td>
                                    <td><?php echo $app['department']; ?></td>
                                    <td><?php echo $app['room_preference']; ?></td>
                                    <td><?php echo $app['hostel_block']; ?></td>
                                    <td><?php echo $app['additional_notes']; ?></td>
                                    <td>
                                            <?php echo $app['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $app['room_id'] ?? "-"; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10">No applications found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Room Availability Table -->
            <div class="table-container">
                <h3>Room Availability</h3>
                <table class="rooms-table">
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Room Name</th>
                            <th>Block</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Occupied</th>
                            <th>Available Beds</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rooms)): ?>
                            <?php foreach ($rooms as $room): ?>
                                <tr class="<?php echo ($room['available'] == 1) ? 'available' : 'full'; ?>">
                                    <td><?php echo $room['id']; ?></td>
                                    <td><?php echo $room['room_name']; ?></td>
                                    <td><?php echo $room['block']; ?></td>
                                    <td><?php echo $room['room_type']; ?></td>
                                    <td><?php echo $room['capacity']; ?></td>
                                    <td><?php echo $room['occupied']; ?></td>
                                    <td><?php echo $room['capacity'] - $room['occupied']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7">No rooms available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </section>
    </main>

    <!-- Footer -->
    <?php include "footer.php"; ?>

</body>
</html>
