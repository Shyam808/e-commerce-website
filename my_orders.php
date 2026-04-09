<?php
session_start();
include 'db.php';

$user_orders = [];

if (isset($_SESSION['email']) && isset($_SESSION['id'])) {
    $user_id = (int)$_SESSION['id'];

    $data = mysqli_query($conn, "SELECT * FROM my_orders WHERE user_id = $user_id ORDER BY id DESC");

    if ($data) {
        while ($row = mysqli_fetch_array($data)) {
            $user_orders[] = [
                'quantity' => (int)$row['quantity'],
                'product_name' => $row['product_name'],
                'product_id' => (int)$row['product_id'],
                'product_image' => $row['product_image'],
                'price' => (int)$row['price']
            ];
        }
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
                                <li><a href="my_orders.php" class="dropdown-item text-dark" style="color:#2874f0 !important; font-weight:bold;">My Orders</a></li>
                                <li><a href="payment.php" class="dropdown-item text-dark">Payments</a></li>
                                <li><a href="my_wishlist.php" class="dropdown-item text-dark">My Wishlist</a></li>
                                <li><a href="cart.php" class="dropdown-item text-dark">My Cart</a></li>
                                <li><a href="my_address.php" class="dropdown-item text-dark">My Address</a></li>
                                <li><a href="profile.php" class="dropdown-item text-dark">My Profile</a></li>
                                <li><a href="logout.php" class="dropdown-item text-danger">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ml-4 d-none d-md-block">
                        <a href="cart.php" class="nav-link" style="color: #000; font-weight: 500;"><i class="fas fa-shopping-cart mr-2" style="font-size: 20px;"></i> Cart</a>
                    </li>
                    <li class="nav-item ml-4 d-none d-lg-block">
                        <a href="seller.php" class="nav-link" style="color: #000; font-weight: 500;"><i class="fas fa-store mr-2" style="font-size: 20px;"></i> Become a Seller</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content-wrapper" style="background-color: #f1f3f6; padding: 20px 0;">
            <div class="container" style="max-width: 1800px;">
                <div class="row">
                    <!-- Left Sidebar Filters -->
                    <div class="col-md-3 d-none d-md-block sticky-top">
                        <div class="card" style="border-radius: 2px; border: none; box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);">
                            <div class="card-body">
                                <h6 style="font-weight: 500; font-size: 16px; margin-bottom: 15px;" name="filters">Filters</h6>
                                <hr style="margin: 10px -20px 20px;">
                                <div class="form-group mb-4">
                                    <label style="font-size: 12px; font-weight: 500; color: #878787; text-transform: uppercase;">Order Status</label>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="status1">
                                        <label class="custom-control-label" for="status1" style="font-weight: normal; font-size: 14px; cursor: pointer;">On the way</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="status2">
                                        <label class="custom-control-label" for="status2" style="font-weight: normal; font-size: 14px; cursor: pointer;">Delivered</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="status3">
                                        <label class="custom-control-label" for="status3" style="font-weight: normal; font-size: 14px; cursor: pointer;">Cancelled</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="status4">
                                        <label class="custom-control-label" for="status4" style="font-weight: normal; font-size: 14px; cursor: pointer;">Returned</label>
                                    </div>
                                </div>
                                <hr style="margin: 10px -20px 20px;">
                                <div class="form-group mb-0">
                                    <label style="font-size: 12px; font-weight: 500; color: #878787; text-transform: uppercase;">Order Time</label>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="time1">
                                        <label class="custom-control-label" for="time1" style="font-weight: normal; font-size: 14px; cursor: pointer;">Last 30 days</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="time2">
                                        <label class="custom-control-label" for="time2" style="font-weight: normal; font-size: 14px; cursor: pointer;">2025</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="time3">
                                        <label class="custom-control-label" for="time3" style="font-weight: normal; font-size: 14px; cursor: pointer;">2024</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="time4">
                                        <label class="custom-control-label" for="time4" style="font-weight: normal; font-size: 14px; cursor: pointer;">Older</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Orders List -->
                    <div class="col-md-9" >
                        <!-- Search Bar -->
                        <div class="card mb-3" style="border-radius: 2px; border: none; box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);">
                            <div class="card-body p-3 d-flex align-items-center">
                                <input type="text" class="form-control" placeholder="Search your orders here" style="border-radius: 2px; border-color: #f0f0f0;">
                                <button class="btn btn-primary ml-2 d-flex align-items-center shadow-none" name="search_orders" style="background-color: #2874f0; border: none; border-radius: 2px; font-size: 14px; font-weight: 500; padding: 8px 20px;">
                                    <i class="fas fa-search mr-2"></i> Search Orders
                                </button>
                            </div>
                        </div>

                        <style>
                            .order-card:hover {
                                box-shadow: 0 3px 8px 0 rgba(0, 0, 0, .2) !important;
                            }
                        </style>

                        <?php if (!empty($user_orders)): ?>
                            <?php foreach ($user_orders as $product): ?>
                                <!-- Order Item -->
                                <div class="card mb-3 order-card" style="border-radius: 2px; border: none; box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); transition: box-shadow 0.2s ease; ">
                                    <div class="card-body p-0">
                                        <a href="#" style="text-decoration: none; color: inherit; display: block; padding: 20px;">
                                            <div class="row align-items-center">
                                                <div class="col-3 col-md-2 text-center">
                                                    <img src="<?php echo htmlspecialchars(isset($product['product_image']) ? $product['product_image'] : 'https://via.placeholder.com/100'); ?>" alt="Product" style="height: 75px; object-fit: contain;">
                                                </div>
                                                <div class="col-9 col-md-4">
                                                    <h6 style="font-size: 14px; font-weight: 500; color: #212121; margin-bottom: 8px; line-height: 1.4; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars(isset($product['product_name']) ? $product['product_name'] : 'Unknown Product'); ?></h6>
                                                    <p class="text-muted mb-0" style="font-size: 12px; color: #878787;">Qty: <?php echo htmlspecialchars(isset($product['quantity']) ? $product['quantity'] : 1); ?></p>
                                                </div>
                                                <div class="col-4 col-md-2 mt-3 mt-md-0">
                                                    <p style="font-size: 14px; font-weight: 500; margin-bottom: 0;">₹<?php echo htmlspecialchars(isset($product['price']) ? $product['price'] : '0'); ?></p>
                                                </div>
                                                <div class="col-8 col-md-4 mt-3 mt-md-0">
                                                    <?php $status_rand = rand(1, 5); ?>
                                                    <?php if ($status_rand > 3): ?>
                                                        <p style="font-size: 14px; font-weight: 500; margin-bottom: 4px; color: #212121;">
                                                            <i class="fas fa-circle text-success" style="font-size: 10px; vertical-align: middle; margin-right: 8px;"></i> Delivered on <?php echo date('M d', strtotime('-' . rand(1, 5) . ' days')); ?>
                                                        </p>
                                                        <p class="text-muted mb-0" style="font-size: 12px; padding-left: 20px;">Your item has been delivered</p>
                                                    <?php elseif ($status_rand > 1): ?>
                                                        <p style="font-size: 14px; font-weight: 500; margin-bottom: 4px; color: #212121;">
                                                            <i class="fas fa-circle text-warning" style="font-size: 10px; vertical-align: middle; margin-right: 8px;"></i> Expected Delivery on <?php echo date('M d', strtotime('+' . rand(1, 5) . ' days')); ?>
                                                        </p>
                                                        <p class="text-muted mb-0" style="font-size: 12px; padding-left: 20px;">Your item is on the way</p>
                                                    <?php else: ?>
                                                        <p style="font-size: 14px; font-weight: 500; margin-bottom: 4px; color: #212121;">
                                                            <i class="fas fa-circle text-danger" style="font-size: 10px; vertical-align: middle; margin-right: 8px;"></i> Order Cancelled
                                                        </p>
                                                        <p class="text-muted mb-0" style="font-size: 12px; padding-left: 20px;">You cancelled this order</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="card mb-3" style="border-radius: 2px; border: none; box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);">
                                <div class="card-body p-4 text-center">
                                    <h6 style="font-weight: 500; color: #212121;">You have no orders yet</h6>
                                    <a href="index.php" class="btn btn-primary mt-3" style="background-color: #2874f0; border: none; border-radius: 2px;">Start Shopping</a>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
        <div class="">
            <div style=" display: flex;" >
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