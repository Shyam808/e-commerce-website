<?php
$host = 'localhost';
$username = 'root';
$password = 'sp@1245';
$dbname = 'e_com';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else{
    // echo "DB Connected!";
}

?>