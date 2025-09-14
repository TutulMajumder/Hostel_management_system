<?php
session_start();

session_unset();

session_destroy();

setcookie("username", "", time() - 3600, "/"); // remove cookie

?>

<!DOCTYPE html>

<html>
<head>

  <title> Logout </title>

  <link rel="stylesheet" href="../CSS/style.css">

</head>

<body>
  <div class="container">

    <h2>You are logged out.</h2>

    <a href="../../Warden/View/login.php"><button>Login Again</button></a>
    
  </div>
</body>
</html>
