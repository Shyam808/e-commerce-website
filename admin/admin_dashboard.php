<?php
session_start();
include "../db.php";

if (!isset($_SESSION['email1'])) {
    header("Location: admin_login.php");
    exit();
}

$customer_count = 0;
$customer_count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM register");

if ($customer_count_query) {
    $customer_count_row = mysqli_fetch_assoc($customer_count_query);
    $customer_count = (int) $customer_count_row['total'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="index.php" class="navbar-brand brand-logo" style="margin-left: -50px;">
                <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg"
                    alt="Flipkart" height="45" style="border-radius: 4px;">
            </a>
        </div>
        <div class="search-bar">
            <i class="fas fa-search search-icon"></i>
            <input class="search-input" type="serch" placeholder="Search for products, brands and more">
        </div>
        <div class="header-right" style="color: black !important; ">
            <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="nav-link dropdown-toggle"
                    style="color: #000; font-weight: 500; display:flex; align-items:center;"><i
                        class="far fa-user-circle mr-2"
                        style="font-size: 20px;"></i><?php echo htmlspecialchars($_SESSION['email1']); ?></a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                    <li><a href="orders.php" class="dropdown-item text-dark">Orders</a></li>
                    <li><a href="payment.php" class="dropdown-item text-dark">Payments</a></li>
                    <li><a href="cart.php" class="dropdown-item text-dark">Cart</a></li>
                    <li><a href="customers.php" class="dropdown-item text-dark">Customers</a></li>
                    <li><a href="logout.php" class="dropdown-item text-danger">Logout</a></li>
                </ul>
            </li>
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="dashboard-layout">
        <div class="left-sidebar">
            <div class="left">
                <h3>Admin Panel</h3>
                <a href="admin_dashboard.php" style=" color: #2874f0;
                    text-decoration: none;
                    background-color: rgb(229, 233, 255);
                    border: 2px solid #2874f0;
                    transform: translateX(8px);
                    box-shadow: 0 10px 18px rgba(40, 116, 240, 0.16);">Dashboard</a>
                <a href="manage_items.php">Manage Product</a>
                <a href="view_product.php">View Product</a>                
                <a href="../index.php">View Store</a>
                <a href="orders.php">Orders</a>
                <a href="customers.php">Customers</a>
                <a class="log" href="logout.php">Logout</a>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="sh">
                <h2>Welcome Admin</h2>
                <p>Select an option from the left sidebar.</p>
            </div>
            <div class="history">
                <div class="first">
                    <div class="history-icon customer-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="history-text">
                        <h3>Customers</h3>
                        <span class="history-count"><?php echo $customer_count; ?></span>
                        <p>Manage registered users</p>
                    </div>
                </div>
                <div class="second">
                    <div class="history-icon order-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="history-text">
                        <h3>Orders</h3>
                        <span class="history-count">
                            <?php
                            $order_count = 0;
                            $order_count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM my_orders");
                            if ($order_count_query) {
                                $order_count_row = mysqli_fetch_assoc($order_count_query);
                                $order_count = (int) $order_count_row['total'];
                            }
                            echo $order_count;
                            ?>
                        </span>
                        <p>Track placed orders</p>
                    </div>
                </div>
                <div class="third">
                    <div class="history-icon cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="history-text">
                        <h3>Carts</h3>
                        <spna class="history-count">
                            <?php
                            $cart_count = 0;
                            $cart_count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM cart");
                            if ($cart_count_query) {
                                $cart_count_row = mysqli_fetch_assoc($cart_count_query);
                                $cart_count = (int) $cart_count_row['total'];
                            }
                            echo $cart_count;   
                            ?>
                        </spna>
                        <p>View active shopping carts</p>
                    </div>
                </div>
                <div class="forth">
                    <div class="history-icon payment-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="history-text">
                        <h3>Payments</h3>
                        <span class="history-count">
                            <?php
                            $payment_count = 0;
                            $payment_count_query = mysqli_query($conn, "SELECT SUM(price) AS total FROM my_orders");
                            if ($payment_count_query) {
                                $payment_count_row = mysqli_fetch_assoc($payment_count_query);
                                $payment_count = (int) $payment_count_row['total'];
                            }
                            echo $payment_count;   
                            ?>  
                            </span>
                        <p>Monitor recent transactions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
