<?php
include "../Php/process_login.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Hostel Management System</title>
    <link rel="stylesheet" href="../Css/login.css">
</head>
<body>

    <!-- Login Form -->
    <main>
        <section class="login-section">
            <h2>Login</h2>
            <form action="" method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $_COOKIE['remember_email'] ?? ''; ?>"placeholder="Enter your email">

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" value="<?php echo $_COOKIE['remember_pass'] ?? ''; ?>" placeholder="Enter your password">

                <div class="checkbox-container">
                    <input type="checkbox" id="remember" name="remember"
                     <?php if (isset($_COOKIE['remember_email'])) echo 'checked'; ?>>
                    <label for="remember">Remember Me</label>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <span class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                <?php endif; ?>
                <button type="submit" class="submit-btn">Login</button>

                <div class="links">
                    <a href="register.php">Don't have an account? Register</a>
                    <a href="forgot_password.php">Forgot Password?</a>
                </div>
            </form>
        </section>
    </main>

</body>
</html>
