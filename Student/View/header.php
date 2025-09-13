<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is a student
$username = 'Guest';
if (isset($_SESSION['role']) && $_SESSION['role'] == 'student') {
    // Use email as display if fullname not set
    $username = $_SESSION['email'] ?? 'Guest';
}
?>
<link rel="stylesheet" href="../CSS/Header.css">

<header class="main-header">
  <div class="logo">
    <img src="../img/Home.jpg" alt="Logo" class="logo-img">
    <span class="logo-text">Hostel Management System</span>
  </div>

  <div class="profile-section">
    <a href="../view/profile.php">
      <img src="../img/profile.jpg" alt="Profile" class="profile-pic">
    </a>
    <span class="username"><?php echo htmlspecialchars($username); ?></span>
    <a href="../view/logout.php">
      <img src="../img/logout.jpg" alt="Logout" class="logout-icon">
    </a>
  </div>
</header>
