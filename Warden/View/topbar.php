<?php 
include "../Php/process_topbar.php"; 
?>

<header>
    <div class="left-section">
        <a href="<?php echo isset($_SESSION['dashboard']) ? '/' . ltrim($_SESSION['dashboard'], '/') : '#'; ?>" class="home-link">
            <img src="../img/hotel.png" alt="Logo Icon" title="Back to Dashboard">
        </a>
    </div>

    <div class="header-actions">
        <div class="welcome-text">
            Welcome, <?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?>
        </div>
        <a href="profile_information.php" class="view-profile" title="Manage Profile">
            <img src="../img/profile.png" alt="Profile Icon">
        </a>
        <a href="logout.php" class="logout" title="Logout">
            <img src="../img/logout.png" alt="Logout Icon">
        </a>
    </div>
</header>

