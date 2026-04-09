<?php
session_start();
include 'db.php';


if (isset($_SESSION['email']) && isset($_SESSION['id'])) {
    $user_id = (int)$_SESSION['id'];

    if (!isset($_SESSION['add_to_cart'])) {
        $_SESSION['add_to_cart'] = [];

        $data = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id");

        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $_SESSION['add_to_cart'][(int)$row['product_id']] = [
                    'quantity' => (int)$row['quantity'],
                    'product_name' => $row['product_name'],
                    'product_id' => (int)$row['product_id'],
                    'product_image' => $row['product_image']
                ];
            }
        }
    }
}

// add quantity and remove quantity from cart 
if (isset($_SESSION['email']) && isset($_SESSION['id'])) {
    $user_id = (int)$_SESSION['id'];

    if (isset($_POST['add_quantity']) || isset($_POST['remove_quantity'])) {
        $p_id = isset($_POST['add_quantity']) ? (int)$_POST['add_quantity'] : (int)$_POST['remove_quantity'];
        $is_add = isset($_POST['add_quantity']);

        $check = mysqli_query($conn, "SELECT quantity FROM cart WHERE user_id = $user_id AND product_id = $p_id");
        if ($check && mysqli_num_rows($check) > 0) {
            $row = mysqli_fetch_assoc($check);
            $current_qty = (int)$row['quantity'];
            $new_qty = $is_add ? $current_qty + 1 : $current_qty - 1;

            if ($new_qty > 0) {
                mysqli_query($conn, "UPDATE cart SET quantity = $new_qty WHERE user_id = $user_id AND product_id = $p_id");
                if (isset($_SESSION['add_to_cart'][$p_id])) {
                    $_SESSION['add_to_cart'][$p_id]['quantity'] = $new_qty;
                }
            } else {
                mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id AND product_id = $p_id");
                if (isset($_SESSION['add_to_cart'][$p_id])) {
                    unset($_SESSION['add_to_cart'][$p_id]);
                }
            }
        }
        header("Location: cart.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecomm | Cart</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link rel="stylesheet" href="custom_style.css">
    <link rel="stylesheet" href="flipkart_style.css">
</head>

<body class="hold-transition layout-top-nav" style="display: flex; flex-direction: column; min-height: 100vh;">
    <div class="wrapper" style="flex: 1; display: flex; flex-direction: column;">
        <nav class="main-header navbar navbar-expand-md navbar-light sticky-top">
            <div class="container" style="max-width: 1800px;">
                <a href="index.php" class="navbar-brand brand-logo">
                    <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg" alt="Flipkart" height="40" style="margin-right: 20px;">
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
                                <li><a href="cart.php" class="dropdown-item text-dark" style="color:#2874f0 !important; font-weight:bold;">My Cart</a></li>
                                <li><a href="my_address.php" class="dropdown-item text-dark">My Address</a></li>
                                <li><a href="profile.php" class="dropdown-item text-dark">My Profile</a></li>
                                <li><a href="logout.php" class="dropdown-item text-danger">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ml-4 d-none d-md-block">
                        <a href="cart.php" class="nav-link" style="color:#2874f0 !important; font-weight: bold;"><i class="fas fa-shopping-cart mr-2" style="font-size: 20px; color: #2874f0;"></i>Cart</a>
                        <div style="height: 2px; background-color: #2874f0; width: 100%; margin-top: 5px; border-radius: 2px;"></div>
                    </li>
                    <li class="nav-item ml-4 d-none d-lg-block">
                        <a href="seller.php" class="nav-link" style="color: #000; font-weight: 500;"><i class="fas fa-store mr-2" style="font-size: 20px;"></i> Become a Seller</a>
                    </li>
                </ul>
            </div>
        </nav>


        <?php if (isset($_SESSION['email']) && !empty($_SESSION['add_to_cart'])): ?>
            <div class="content-wrapper" style="background-color: #f1f3f6; padding: 20px 0; min-height: calc(100vh - 64px); flex: 1;">
                <div class="container" style="max-width: 1800px;">
                    <div class="row">
                        <!-- Left Cart Items Column -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm mb-3 rounded-0">
                                <div class="cart-header bg-white" style="padding: 15px 24px; font-weight: 500; font-size: 18px; border-bottom: 1px solid #f0f0f0;">
                                    My Cart (<?php echo count($_SESSION['add_to_cart']); ?>)
                                </div>

                                <?php
                                $prices = [1111 => 139000, 101 => 13999, 102 => 17999, 103 => 13999, 104 => 249, 105 => 11999, 106 => 299, 107 => 139999, 108 => 31999, 109 => 0, 110 => 0, 1 => 65999, 2 => 129999, 3 => 39999, 4 => 75999, 5 => 139999, 666 => 54990, 6 => 54990, 7 => 89990, 8 => 84990, 9 => 119880, 10 => 13999, 11 => 24990, 12 => 2499, 13 => 2999, 14 => 1499, 15 => 79900, 16 => 39999, 17 => 43999, 18 => 39999, 19 => 44999, 20 => 29999, 21 => 32999, 22 => 32999, 23 => 23999, 24 => 29999, 25 => 79999, 26 => 154999, 27 => 79999, 28 => 34999, 29 => 12499, 30 => 18999, 31 => 23999, 32 => 21999, 33 => 24999, 34 => 14999, 35 => 38999, 36 => 26999, 37 => 23999, 38 => 24999, 39 => 9999, 40 => 13999, 41 => 22999, 42 => 19999, 43 => 24999, 44 => 27999, 45 => 14999, 46 => 27999, 47 => 14999, 50 => 114900, 51 => 34990, 52 => 44990, 53 => 62490, 54 => 54990, 55 => 47990, 56 => 39990, 57 => 169900, 58 => 59990, 59 => 109990, 60 => 124990, 61 => 149990, 62 => 259990, 63 => 114990, 64 => 94990, 111 => 499, 112 => 899, 113 => 1299, 114 => 1599, 115 => 799, 65 => 199, 66 => 149, 67 => 129, 68 => 99, 69 => 119, 70 => 249, 71 => 199, 72 => 299, 73 => 279, 74 => 199, 75 => 349, 76 => 299, 77 => 269, 79 => 179, 80 => 199, 81 => 249, 85 => 1299, 86 => 2999, 87 => 1999, 88 => 24900, 89 => 17999, 90 => 2499, 91 => 6990, 92 => 1999, 93 => 1499, 94 => 1299, 95 => 1699, 96 => 1799, 97 => 1199, 98 => 29990, 99 => 1499, 100 => 2999, 121 => 7490, 122 => 10999, 123 => 1199, 124 => 699, 125 => 199, 126 => 299, 127 => 319, 128 => 999, 129 => 499, 130 => 1299, 131 => 329];
                                
                                $total = 0;
                                $total_items = 0;
                                $total_discount = 0;

                                foreach ($_SESSION['add_to_cart'] as $product_id => $product) {
                                    $price = isset($prices[$product_id]) ? $prices[$product_id] : 0;
                                    $quantity = $product['quantity'];
                                    $discount = $price * 0.20; // 20% discount
                                    $discounted_price = $price - $discount;
                                    $total += $price * $quantity;
                                    $total_discount += $discount * $quantity;
                                    $total_items += $quantity;

                                    $final_total = $total - $total_discount;
                                ?>

                                    <div class="cart-item bg-white" style="padding: 24px; border-bottom: 1px solid #f0f0f0;">
                                        <div class="row">
                                            <div class="col-4 col-md-3 text-center">
                                                <div style="height: 112px; display: flex; align-items: center; justify-content: center;">
                                                    <img src="<?php echo htmlspecialchars(isset($product['product_image']) ? $product['product_image'] : 'https://via.placeholder.com/100'); ?>" alt="Product" style="max-height: 112px; object-fit: contain;">
                                                </div>
                                                <form method="POST" action="cart.php" class="mt-3 d-flex justify-content-center align-items-center mb-0">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" name="remove_quantity" value="<?php echo htmlspecialchars($product_id); ?>" style="border-radius: 50%; width: 28px; height: 28px; padding: 0; line-height: 1;">-</button>
                                                    <input type="text" value="<?php echo htmlspecialchars($product['quantity']); ?>" style="width: 40px; text-align: center; border: 1px solid #c2c2c2; margin: 0 8px; font-weight: 500;" readonly>
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" name="add_quantity" value="<?php echo htmlspecialchars($product_id); ?>" style="border-radius: 50%; width: 28px; height: 28px; padding: 0; line-height: 1;">+</button>
                                                </form>
                                            </div>
                                            <div class="col-8 col-md-9 pt-2">
                                                <h6 class="mb-1 text-truncate" style="font-size: 16px; font-weight: 500;"><?php echo htmlspecialchars($product['product_name']); ?></h6>
                                                <p class="small mb-2" style="font-size: 12px; color: #878787 !important;">Seller: RetailNet <img src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/fa_62673a.png" height="15" class="ml-2"></p>
                                                <div class="price-container my-3" style="display: flex; align-items: baseline; gap: 10px;">
                                                    <span style="font-size: 14px; color: #878787; text-decoration: line-through;">₹<?php echo number_format($price * 1.20); ?></span>
                                                    <span style="font-size: 18px; font-weight: 500; color: #212121;">₹<?php echo number_format($price); ?></span>
                                                    <span style="font-size: 14px; font-weight: 500; color: #388e3c;">16% Off</span>
                                                </div>
                                                <div class="mt-4 pt-2">
                                                    <span class="mr-4" style="font-weight: 500; font-size: 16px; cursor: pointer; color: #212121;">SAVE FOR LATER</span>
                                                    <a href="remove_from_cart.php?id=<?php echo urlencode($product_id); ?>" class="font-weight-bold" style="text-decoration: none; font-size: 16px; color: #212121; cursor: pointer;">REMOVE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                                <div class="bg-white text-right py-3 px-4" style="box-shadow: 0 -2px 10px 0 rgba(0, 0, 0, .1);">
                                    <button class="btn btn-primary" style="background-color: #fb641b; border: none; font-weight: 500; font-size: 16px; padding: 14px 45px; border-radius: 2px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .2);"><a href="payment.php" style="color: #fff;">PLACE ORDER</a></button>
                                </div>
                            </div>
                        </div>

                        <!-- Right Price Details Column -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm rounded-0" style="position: sticky; top: 80px;">
                                <div class="card-header bg-white border-0" style="padding: 13px 24px; border-bottom: 1px solid #f0f0f0 !important;">
                                    <span style="font-size: 16px; font-weight: 500; color: #878787;">PRICE DETAILS</span>
                                </div>
                                <div class="card-body" style="padding: 0 24px;">
                                    <div class="d-flex justify-content-between my-3">
                                        <span style="font-size: 16px;">Price (<?php echo $total_items; ?> item<?php echo $total_items > 1 ? 's' : ''; ?>)</span>
                                        <span style="font-size: 16px;">₹<?php echo number_format($total); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between my-3">
                                        <span style="font-size: 16px;">Discount</span>
                                        <span style="font-size: 16px; color: #388e3c;">− ₹<?php echo number_format($total_discount); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between my-3">
                                        <span style="font-size: 16px;">Delivery Charges</span>
                                        <span style="font-size: 16px; color: #388e3c;"><span style="text-decoration: line-through; color: #878787; margin-right: 5px;">₹180</span>Free</span>
                                    </div>
                                </div>
                                <div class="card-footer bg-white mt-1" style="padding: 20px 24px; border-top: 1px dashed #e0e0e0; border-bottom: 1px dashed #e0e0e0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="font-size: 18px; font-weight: 600;">Total Amount</span>
                                        <span style="font-size: 18px; font-weight: 600;">₹<?php echo number_format($final_total); ?></span>
                                    </div>
                                </div>
                                <div style="padding: 15px 24px;">
                                    <span style="font-size: 16px; font-weight: 500; color: #388e3c;">You will save ₹<?php echo number_format($total_discount); ?> on this order</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif (isset($_SESSION['email']) && empty($_SESSION['add_to_cart'])): ?>
            <div class="content-wrapper" style="background-color: #f1f3f6; padding: 20px 0; min-height: calc(100vh - 64px); flex: 1; display: flex; flex-direction: column;">
                <div class="container mt-4" style="flex: 1; max-width: 1800px;">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <img src="https://rukminim2.flixcart.com/www/800/800/promos/16/05/2019/d438a32e-765a-4d8b-b4a6-520b560971e8.png?q=90" alt="Empty Cart" style="width: 300px; height: auto;">
                            <h5 class="mt-4" style="font-weight: 500;">Your cart is empty!</h5>
                            <button class="btn btn-primary " style="background-color: #2874f0; border-color: #2874f0;"><a href="index.php" style="color: #fff;">Shopping now</a></button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<?php else: ?>
    <div class="content-wrapper" style="background-color: #f1f3f6; padding: 20px 0; min-height: calc(100vh - 64px); flex: 1; display: flex; flex-direction: column;">
        <div class="container mt-4" style="flex: 1; max-width: 1800px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-5">
                    <img src="https://rukminim2.flixcart.com/www/800/800/promos/16/05/2019/d438a32e-765a-4d8b-b4a6-520b560971e8.png?q=90" alt="Empty Cart" style="width: 220px; height: auto;">
                    <h5 class="mt-4" style="font-weight: 500;">Your cart is empty!</h5>
                    <button class="btn btn-primary mt-4" style="background-color: #2874f0; border-color: #2874f0;"><a href="login.php" style="color: #fff;">Login to add items</a></button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>



<footer class="main-footer">
    <div class="">
        <div style=" display: flex;">
            <div style="margin-left: 70px;">
                <strong>Copyright &copy; 2026 <a href="#">Flipkart Replica</a>.</strong> All rights reserved.
            </div>
            <div style="margin-left: 1000px;">
                Premium E-Commerce Experience
            </div>
        </div>
    </div>
</footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<?php if (!empty($alert_message)): ?>
    <script>
        alert("<?php echo addslashes($alert_message); ?>");
    </script>
<?php endif; ?>
</body>

</html>
