<?php
session_start(); 

include("../DB/apply_room_DB.php");


if (isset($_SESSION["username"])) {

    header("Location: dashboard.php"); 

    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = $_POST["username"];

    $pass = $_POST["password"];

    $remember = isset($_POST["remember"]);


    $stmt = $conn->prepare("SELECT * FROM students WHERE email=? LIMIT 1");

    $stmt->bind_param("s", $user);

    $stmt->execute();

    $result = $stmt->get_result();


    if ($row = $result->fetch_assoc()) {

        if (password_verify($pass, $row["password"])) {

            $_SESSION["username"] = $row["fullname"];

            $_SESSION["email"] = $row["email"];

            $_SESSION["id"] = $row["id"]; 

            if ($remember) {

                setcookie("username", $row["fullname"], time() + (86400*30), "/");

            }

            header("Location: dashboard.php"); 

            exit();

        } else {

            $error = "Invalid password!";

        }
    } else {

        $error = "User not found!";
    }
}




?>
<!DOCTYPE html>
<html>
<head>

  <title>Login Page</title>

  <link rel="stylesheet" href="../CSS/style.css">

</head>

<body>

  <div class="container">

    <h2>Login</h2>

    <form method="post">

      <input type="text" name="username" placeholder="Email"

             value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>"><br>

      <input type="password" name="password" placeholder="Password"><br>

      <label><input type="checkbox" name="remember"> Remember Me</label><br>

      <input type="submit" value="Login">

    </form>

    <a href="register_form.php">New User? Register here</a>

    <p class="error"><?php if(isset($error)) echo $error; ?></p>

  </div>
  
</body>
</html>
