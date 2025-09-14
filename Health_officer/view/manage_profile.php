<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../View/login.php");
    exit();
}

include "../DB/config.php";

$officer_id = $_SESSION['id'];

$success = isset($_GET['success']) ? $_GET['success'] : "";
$error   = isset($_GET['error']) ? $_GET['error'] : "";

$stmt = $conn->prepare("SELECT id, name, email, phone, gender, dob, address FROM health_officers WHERE id = ?");
$stmt->bind_param("i", $officer_id);
$stmt->execute();
$result = $stmt->get_result();
$officer = $result->fetch_assoc();

if (!$officer) {
    header("Location: ../View/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Health Officer – Manage Profile</title>
    <link rel="stylesheet" href="../CSS/topbar.css">
    <link rel="stylesheet" href="../CSS/health_officer_profile.css">
    <link rel="stylesheet" href="../CSS/footer.css">
</head>
<body>

<?php include 'topbar.php'; ?>

<div class="container">

    <h2>Manage Profile (Health Officer)</h2>

    <?php if($success) echo "<p class='success'>".htmlspecialchars($success)."</p>"; ?>
    <?php if($error) echo "<p class='error'>".htmlspecialchars($error)."</p>"; ?>

    <!-- Update Profile -->
    <form action="../php/health_officer_profile_actions.php" method="POST" novalidate>
        <input type="hidden" name="action" value="update_profile">
        <input type="hidden" name="id" value="<?php echo (int)$officer['id']; ?>">

        <label>ID:</label>
        <input type="text" value="<?php echo (int)$officer['id']; ?>" disabled>

        <label>Full Name:</label>
        <input type="text" value="<?php echo htmlspecialchars($officer['name']); ?>" disabled>

        <label>Email:</label>
        <input type="email" value="<?php echo htmlspecialchars($officer['email']); ?>" disabled>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($officer['phone']); ?>" required>

        <label>Gender:</label>
        <select name="gender" required>
            <?php
                $genders = ["Male", "Female", "Other"];
                $currentGender = $officer['gender'] ?? "";
                foreach ($genders as $g) {
                    $sel = ($currentGender === $g) ? "selected" : "";
                    echo "<option value=\"{$g}\" {$sel}>{$g}</option>";
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
    <form action="../php/health_officer_profile_actions.php" method="POST" novalidate>
        <input type="hidden" name="action" value="change_password">

        <label>Current Password:</label>
        <input type="password" name="current_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" class="btn">Change Password</button>
    </form>

</div>

</body>
</html>
