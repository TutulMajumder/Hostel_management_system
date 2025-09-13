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

                <!-- View and Edit Profile Form -->
                <div class="profile-info">
                    <h3>Your Profile</h3>
                    <form action="update_profile.php" method="POST">
                        <div class="form-row">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" value="Warden" required>
                        </div>

                        <div class="form-row">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="warden@example.com" required>
                        </div>

                        <div class="form-row">
                            <label for="role">Role:</label>
                            <input type="text" id="role" name="role" value="Warden" required disabled>
                        </div>

                        <div class="form-row">
                            <label for="phone">Phone:</label>
                            <input type="tel" id="phone" name="phone" value="123-456-7890" required>
                        </div>

                        <div class="button-row">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="button-row">
                    <form action="delete_profile.php" method="POST">
                        <button type="submit" class="btn btn-danger">Delete Profile</button>
                    </form>

                    <form action="change_password.php" method="POST">
                        <button type="submit" class="btn btn-secondary">Change Password</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>