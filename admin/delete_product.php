<?php
session_start();
include "../db.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: view_product.php");
    exit();
}

$query = "DELETE FROM products WHERE id = $id";
$data = mysqli_query($conn, $query);
if($data){
    echo "<script>alert('Data Deleted!'); 
        window.location='view_product.php'; </script>";
}else{
    echo "Error" . mysqli_error($conn);
}

?>
