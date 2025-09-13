<?php
include "php/manage_profile_backend.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="../Css/manage_profile.css">
</head>
<body>
<main>
    <section id="manage-profile">
        <div class="profile-container">
            <h2>Manage Profile</h2>

            <div class="profile-info">
                <p><strong>Username:</strong> <?= $officer['username'] ?></p>
                <p><strong>Email:</strong> <?= $officer['email'] ?></p>

                <h3>Change Password</h3>
                <form method="POST" action="">
                    <div class="form-row">
                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-row">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-row">
                        <button type="submit" name="change_password" class="btn">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php
// Alert messages
if(isset($_SESSION['success'])){
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']);
}
?>
</body>
</html>
