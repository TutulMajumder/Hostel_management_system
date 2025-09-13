<!DOCTYPE html>

<html>

<head>

  <title>Student Dashboard</title>

  <link rel="stylesheet" href="../CSS/Header.css">

  <link rel="stylesheet" href="../CSS/Dashboard.css">

</head>

<body>

<?php include 'header.php'; ?> 


<main class="dashboard">

  <h1>Welcome, <?php echo $_SESSION["username"]; ?> </h1>


  <?php

  if (isset($_COOKIE["username"])) {

      echo "<p>Welcome back, " . $_COOKIE["username"] . " (from cookie)</p>";

  }

  ?>

  <div class="card-container">

    <a href="apply-room.php" class="card">

      <h3>Apply for Room</h3>

      <p>Submit a new hostel room application.</p>

    </a>

    <a href="complaint.php" class="card">

      <h3>Submit Complaints</h3>

      <p>Report hostel issues easily.</p>

    </a>
    <a href="health.php" class="card">

      <h3>Apply for Health</h3>

      <p>Request medical help and checkups.</p>

    </a>
    <a href="mess-menu.php" class="card">

      <h3>View Mess Menu</h3>

      <p>Check today's food menu.</p>

    </a>
    <a href="TrackRoomStatus.php" class="card">

      <h3>Track Application Status</h3>

      <p>See updates on your room request.</p>

    </a>
    <a href="RequestServices.php" class="card">

      <h3>Request Services</h3>

      <p>Ask for cleaning, maintenance, etc.</p>

    </a>

  </div>
  
</main>

</body>
</html>
