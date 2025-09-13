<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Rooms - Hostel Management</title>
    <link rel="stylesheet" href="../Css/topbar.css">
    <link rel="stylesheet" href="../Css/assign_rooms.css">
</head>
<body>

<?php include 'topbar.php'; ?>

<main id="assign-rooms">
    <h2>Assign Rooms</h2>

    <!-- Student Applications -->
    <section class="applications">
        <h3>Pending Student Applications</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Semester</th>
                        <th>Department</th>
                        <th>Room Preference</th>
                        <th>Notes</th>
                        <th>Assign Room</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>STU001</td>
                        <td>John Doe</td>
                        <td>2nd</td>
                        <td>CSE</td>
                        <td>Single</td>
                        <td>Near elevator</td>
                        <td>
                            <select>
                                <option value="">--Select Room--</option>
                                <option value="A101">A101 (Single)</option>
                                <option value="B201">B201 (Single)</option>
                            </select>
                            <button class="assign-btn">Assign</button>
                        </td>
                    </tr>
                    <tr>
                        <td>STU002</td>
                        <td>Jane Smith</td>
                        <td>1st</td>
                        <td>EEE</td>
                        <td>Double</td>
                        <td>Near window</td>
                        <td>
                            <select>
                                <option value="">--Select Room--</option>
                                <option value="C301">C301 (Double)</option>
                            </select>
                            <button class="assign-btn">Assign</button>
                        </td>
                    </tr>
                    <tr>
                        <td>STU003</td>
                        <td>Michael Lee</td>
                        <td>3rd</td>
                        <td>BBA</td>
                        <td>Shared</td>
                        <td>No preference</td>
                        <td>
                            <select>
                                <option value="">--Select Room--</option>
                                <option value="B202">B202 (Shared)</option>
                            </select>
                            <button class="assign-btn">Assign</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Rooms Info -->
    <section class="rooms-info">
        <h3>Room Availability</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Room No</th>
                        <th>Block</th>
                        <th>Type</th>
                        <th>Capacity</th>
                        <th>Occupied</th>
                        <th>Available Beds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="available">
                        <td>A101</td>
                        <td>A Block</td>
                        <td>Single</td>
                        <td>1</td>
                        <td>0</td>
                        <td>1</td>
                    </tr>
                    <tr class="available">
                        <td>B201</td>
                        <td>B Block</td>
                        <td>Single</td>
                        <td>1</td>
                        <td>0</td>
                        <td>1</td>
                    </tr>
                    <tr class="available">
                        <td>C301</td>
                        <td>C Block</td>
                        <td>Double</td>
                        <td>2</td>
                        <td>0</td>
                        <td>2</td>
                    </tr>
                    <tr class="partial">
                        <td>A102</td>
                        <td>A Block</td>
                        <td>Shared</td>
                        <td>3</td>
                        <td>1</td>
                        <td>2</td>
                    </tr>
                    <tr class="full">
                        <td>B203</td>
                        <td>B Block</td>
                        <td>Shared</td>
                        <td>3</td>
                        <td>3</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
!-- Footer -->
    <?php include "footer.php"; ?>
</body>
</html>
