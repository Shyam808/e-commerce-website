<?php
session_start();

if(isset($_POST["email"])){
    session_destroy();
}
header("Location: login.php");  




?>