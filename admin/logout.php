<?php
session_start();
include "../db.php";
session_destroy();
header("Location: admin_login.php");
?>