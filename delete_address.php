<?php
session_start();
include 'db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM addressone WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if($result) {
        echo "<script>alert('Address deleted successfully'); window.location.href='my_address.php';</script>";
    } else {
        echo "<script>alert('Address not deleted');</script>";
    }
}
?>