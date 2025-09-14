<?php
include "../Php/process_profile.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Profile - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/manage-profile.css">
</head>

<body>
    <main>
        <section id="manage-profile">
            <div class="profile-container">
                <h2>Manage Profile Information</h2>

                <div class="profile-info">
                    <h3>Your Profile</h3>

                    <form action="" method="POST">
                        <label for="id">ID:</label>
                        <input type="text" id="id" name="id"
                            value="<?php echo htmlspecialchars($user['id']); ?>" readonly>

                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name"
                            value="<?php echo htmlspecialchars($user['username']); ?>">

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email"
                            value="<?php echo htmlspecialchars($user['email']); ?>" readonly>

                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone"
                            value="<?php echo htmlspecialchars($user['phone']); ?>">

                        <label for="gender">Gender:</label>
                        <input type="text" id="gender" name="gender"
                            value="<?php echo htmlspecialchars($user['gender']); ?>" readonly>

                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob"
                            value="<?php echo htmlspecialchars($user['dob']); ?>">



                        <?php if (isset($_SESSION['errors'])): ?>
                            <p class="error"><?php echo $_SESSION['errors'];
                                                unset($_SESSION['errors']); ?></p>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                            <p class="success"><?php echo $_SESSION['success'];
                                                unset($_SESSION['success']); ?></p>
                        <?php endif; ?>


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