<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Profile - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/manage-profile.css">
</head>

<body>
    <!-- Main Content -->
    <main>
        <section id="manage-profile">
            <div class="profile-container">
                <h2>Manage Profile Information</h2>

                <!-- Compact, minimal form -->
                <div class="profile-info">
                    <h3>Your Profile</h3>

                    <form action="" method="POST">
                        <label for="id">ID:</label>
                        <input type="text" id="id" name="id" value="WAR001" readonly>

                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" value="Warden">

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="warden@example.com" readonly>

                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone" value="123-456-7890">

                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>

                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob">

                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="change_password.php" class="btn btn-primary">Change Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>