<?php
include "../Php/process_changepassword.php";
?>



<!DOCTYPE html>
<html>
<head>
    <title>Change Password - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/manage-profile.css">
</head>
<body>

    <main>
        <section id="manage-profile">
            <div class="profile-container">
                <h2>Change Password</h2>

                <div class="profile-info">
                    <h3>Update Your Password</h3>

                    <form action="" method="POST">
                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password">

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password">

                        <?php if (isset($_SESSION['errors'])): ?>
                            <p class="error"><?php echo $_SESSION['errors'];
                                                unset($_SESSION['errors']); ?></p>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                            <p class="success"><?php echo $_SESSION['success'];
                                                unset($_SESSION['success']); ?></p>
                        <?php endif; ?>


                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
