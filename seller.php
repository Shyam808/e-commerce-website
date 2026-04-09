<?php
session_start();
include "db.php";



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecomm | Home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link rel="stylesheet" href="custom_style.css">
    <link rel="stylesheet" href="flipkart_style.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light sticky-top">
            <div class="container" style="max-width: 1800px;">
                <a href="index.php" class="navbar-brand brand-logo" style="margin-left: 0px;">
                    <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg" alt="Flipkart" height="45" style="margin-right: 10px; padding: 6px 10px; border-radius: 4px;">
                </a>
                <div class="search-bar-container d-none d-md-flex position-relative flex-grow-1">
                    <i class="fas fa-search search-icon"></i>
                    <input class="search-input" type="search" placeholder="Search for products, brands and more" aria-label="Search">
                </div>
                <button class="navbar-toggler order-1 ml-auto" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav d-md-none mt-2 w-100">
                        <li class="w-100">
                            <div class="position-relative">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 12px; color: #aaa;"></i>
                                <input class="form-control w-100 mb-2" type="search" placeholder="Search for products..." style="padding-left: 30px;">
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto align-items-center">
                    <?php if (!isset($_SESSION['email'])): ?>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link nav-btn-login"><i class="far fa-user-circle mr-2" style="font-size: 20px;"></i> Login</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle" style="color: #000; font-weight: 500; display:flex; align-items:center;"><i class="far fa-user-circle mr-2" style="font-size: 20px;"></i><?php echo htmlspecialchars($_SESSION['email']); ?></a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="my_orders.php" class="dropdown-item text-dark">My Orders</a></li>
                                <li><a href="payment.php" class="dropdown-item text-dark">Payments</a></li>
                                <li><a href="my_wishlist.php" class="dropdown-item text-dark">My Wishlist</a></li>
                                <li><a href="cart.php" class="dropdown-item text-dark">My Cart</a></li>
                                <li><a href="my_address.php" class="dropdown-item text-dark">My Address</a></li>
                                <li><a href="profile.php" class="dropdown-item text-dark">My Profile</a></li>
                                <li><a href="logout.php" class="dropdown-item text-danger">Logout</a></li>
                            </ul>

                        </li>
                    <?php endif; ?>
                    <li class="nav-item ml-0 d-none d-md-block">
                        <a href="cart.php" class="nav-link" style="color: #000; font-weight: 500;"><i class="fas fa-shopping-cart mr-2" style="font-size: 20px;"></i> Cart</a>
                    </li>
                    <li class="nav-item ml-0 d-lg-block">
                        <a href="seller.php" class="nav-link" style="color: #2874f0 !important; font-weight: bold;"><i class="fas fa-store mr-2" style="font-size: 20px; color:#2874f0;"></i> Become a Seller</a>
                        <div style="height: 2px; background-color: #2874f0; width: 100%; margin-top: 5px; border-radius: 2px;"></div>
                    </li>
                </ul>
            </div>
        </nav>

        <h2>Comming Soon...</h2>
        <h2 style="color:forestgreen;">Welcome <?php echo $_SESSION['email']; ?> to seller page</h2>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = "index.php";
        }, 4000);
    </script>
