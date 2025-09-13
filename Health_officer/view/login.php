<?php
session_start();

// If already logged in → redirect
if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
    exit();
}

// Capture error from backend redirect
$error = isset($_GET['error']) ? $_GET['error'] : "";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Health Officer Login</title>
  <link rel="stylesheet" href="/WT_Summer24-25/health_officer/css/login.css">
</head>
<body>
  <div class="container">
    <h2>Health Officer Login</h2>
    <form method="post" action="../php/login_backend.php">
      <input type="text" name="username" placeholder="Username"
         value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>"><br>

      <input type="password" name="password" placeholder="Password"><br>
      <label><input type="checkbox" name="remember"> Remember Me</label><br>
      <input type="submit" value="Login">
    </form>
    
    <p><a href="forgot_password.php">Forgot Password?</a></p>

    <?php if ($error): ?>
      <p class="error" style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
  </div>
</body>
</html>
