<?php
session_start();
include 'db.php';

if (isset($_SESSION['email']) && isset($_SESSION['id'])) {
    $user_id = (int)$_SESSION['id'];
    $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($product_id && isset($_SESSION['add_to_cart'][$product_id])) {
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id");
        unset($_SESSION['add_to_cart'][$product_id]);
    }
}

header("Location: cart.php");
exit();

?>
