<?php
session_start();
include "../Db/config.php";

$errors = '';
$email = $password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']);

    // Basic validation
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: ../View/login.php");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: ../View/login.php");
        exit();
    }

    // User roles and redirections
    $user_tables = [
        'students' => 'Student/View/dashboard.php',
        'wardens' => 'warden/View/warden_dashboard.php',
        'health_officers' => 'View/health_dashboard.php',
        'accountants' => 'View/account_dashboard.php'
    ];

    $roles = [
        'students' => 'student',
        'wardens' => 'warden',
        'health_officers' => 'health_officer',
        'accountants' => 'accountant'
    ];

    $found = false;

    foreach ($user_tables as $table => $redirect) {
        $query = "SELECT * FROM $table WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $found = true;

            // Check for inactive warden
            if (isset($user['status']) && $user['status'] !== 'Active') {
                $_SESSION['error'] = "Your account is inactive. Please contact Admin.";
                header("Location: ../View/login.php");
                exit();
            }

            // Verify password
            if ($password === $user['password'] || password_verify($password, $user['password'])) {
                // Remember Me Cookie
                if ($remember) {
                    setcookie('remember_email', $email, time() + (86400 * 7), "/");
                    setcookie('remember_pass', $password, time() + (86400 * 7), "/");
                } else {
                    setcookie('remember_email', '', time() - 3600, "/");
                    setcookie('remember_pass', '', time() - 3600, "/");
                }

                // Start secure session
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $roles[$table];
                $_SESSION['user_table'] = $table;

                header("Location: /HOSTEL-MANAGEMENT-SYSTEM/$redirect");
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: ../View/login.php");
                exit();
            }
        }

        $stmt->close();
    }

    if (!$found) {
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: ../View/login.php");
        exit();
    }
}
