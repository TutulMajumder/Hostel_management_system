<?php
session_start();


session_unset();
session_destroy();


header("Location: ../../Warden/View/login.php"); 
exit();
?>
