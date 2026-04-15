<?php
session_start();
include "../db.php";
if(isset($_POST["email1"])){
    session_destroy();
}
header("Location: admin_login.php");
?>