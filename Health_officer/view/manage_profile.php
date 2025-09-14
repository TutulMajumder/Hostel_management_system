<?php
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'health_officer') {
    header("Location: ../view/login.php");
    exit();
}

require_once "../db/config.php"; // make sure this sets $conn (MySQLi)

$officer_id = $_SESSION['user_id'];

$success = isset($_GET['success']) ? $_GET['success'] : "";
$error   = isset($_GET['error']) ? $_GET['error'] : "";

// Fetch logged-in health officer (use USERNAME column, not name)
$stmt = $conn->prepare("SELECT id, username, email, phone, gender, dob, address FROM health_officers WHERE id = ?");
$stmt->bind_param("i", $officer_id);
$stmt->execute();
$result = $stmt->get_result();
$officer = $result->fetch_assoc();

if (!$officer) {
    header("Location: ../view/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Health Officer • Manage Profile</title>
    <link rel="stylesheet" href="../css/manage_profile.css">
    <link rel="stylesheet" href="../css/topbar.css">
    <link rel="stylesheet" href="../css/footer.css">

</head>
<body>

<?php include 'topbar.php'; ?>

<div class="container">
    <h2>Health Officer Profile</h2>

    <?php if($success): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <?php if($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <!-- Update Profile -->
    <form action="../php/manage_profile_backend.php" method="POST" novalidate>
        <input type="hidden" name="form_type" value="update_profile">
        <input type="hidden" name="id" value="<?php echo (int)$officer['id']; ?>">

        <label>ID:</label>
        <input type="text" value="<?php echo (int)$officer['id']; ?>" disabled>

        <label>Username:</label>
        <input type="text" value="<?php echo htmlspecialchars($officer['username']); ?>" disabled>

        <label>Email:</label>
        <input type="email" value="<?php echo htmlspecialchars($officer['email']); ?>" disabled>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($officer['phone']); ?>" required>

        <label>Gender:</label>
        <select name="gender" required>
            <?php
                $genders = ["Male","Female","Other"];
                $currentGender = $officer['gender'] ?? "";
                foreach ($genders as $g) {
                    $sel = ($g === $currentGender) ? "selected" : "";
                    echo '<option value="'.htmlspecialchars($g).'" '.$sel.'>'.htmlspecialchars($g).'</option>';
                }
            ?>
        </select>

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?php echo htmlspecialchars($officer['dob']); ?>" required>

        <label>Address:</label>
        <textarea name="address" required><?php echo htmlspecialchars($officer['address']); ?></textarea>

        <button type="submit" class="btn">Update Profile</button>
    </form>

    <!-- Change Password -->
    <h3>Change Password</h3>
    <form action="../php/manage_profile_backend.php" method="POST">
        <input type="hidden" name="form_type" value="change_password">

        <label>Current Password:</label>
        <input type="password" name="current_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" class="btn">Change Password</button>
    </form>

</div>
<?php include 'footer.php'; ?>

</body>
</html>
