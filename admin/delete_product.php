<?php
session_start();
include "../db.php";

$id = $_GET['id'];
$query = "DELETE FROM products WHERE id='$id'";
$data = mysqli_query($conn, $query);
if($data){
    echo "<script>alert('Data Deleted!'); 
        window.location='view_products.php';</script>";
}else{
    echo "Error" . mysqli_error($conn);
}

?>