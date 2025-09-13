<?php
if (session_status() === PHP_SESSION_NONE) {

    session_start();

}


if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {

    header("Location: ../login.php");

    exit();
}

?>

<link rel="stylesheet" href="../CSS/Header.css">

<header class="main-header">

    <div class="logo">

        <img src="../img/Home.jpg" alt="Logo" class="logo-img">

        <span class="logo-text">Hostel Management System</span>

    </div>

    <div class="links">

        <a href="../index.php">Home</a>

        <a href="../about.php">About Us</a>

        <a href="../contact.php">Contact</a>

    </div>

    <div class="profile-section">

        <a href="profile.php">

            <img src="../img/profile.jpg" alt="Profile" class="profile-pic">

        </a>
        <span class="username"><?php echo $_SESSION['username']; ?></span>

        <a href="logout.php">

            <img src="../img/logout.jpg" alt="Logout" class="logout-icon">

        </a>

    </div>
    
</header>

