<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}


?>
<h4 style="color: green; float: left; margin-left: 20px; font-size: 20px; font-weight: bold;">Welcome <?php echo $_SESSION['email']; ?></h4>
<a href="logout.php" style="color: red; float: right; margin-right: 20px; font-size: 20px; text-decoration: none; font-weight: bold;">Logout</a>