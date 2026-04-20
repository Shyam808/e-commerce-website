<?php
session_start();
include "../db.php";

if (!isset($_SESSION['email1'])) {
    header("Location: admin_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
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
                    <li><a href="admin_dashboard.php" class="dropdown-item text-dark">Dashboard</a></li>
                    <li><a href="manage_items.php" class="dropdown-item text-dark">Manage products</a></li>
                    <li><a href="view_product.php" class="dropdown-item text-dark">View products</a></li>
                    <li><a href="orders.php" class="dropdown-item text-dark" style="color:#2874f0 !important; font-weight:bold;">Orders</a></li>
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
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="manage_items.php">Manage Product</a>
                <a href="view_product.php">View Product</a>
                <a href="../index.php">View Store</a>
                <a href="orders.php" style=" color: #2874f0;
                    text-decoration: none;
                    background-color: rgb(242, 242, 242);
                    border: 2px solid #2874f0;
                    transform: translateX(8px);">Orders</a>
                <a href="customers.php">Customers</a>
                <a class="log" href="logout.php">Logout</a>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="sh">
                <h2>Manage Orders</h2>
                <p>This is the manage orders page. You can add, edit, or delete orders from here.</p>
            </div>
            <div class="tab">
                <h3>Orders</h3>
                <div class="table-wrap">
                    <?php
                    $query = "SELECT * FROM my_orders";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) { ?>
                        <table class="table order-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Product ID</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['user_id']; ?></td>
                                        <td><?php echo $row['product_id']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['product_name']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo "<p>No orders found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
