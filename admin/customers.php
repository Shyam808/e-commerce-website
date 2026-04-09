<?php
session_start();
include "../db.php";

if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
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
                        style="font-size: 20px;"></i><?php echo htmlspecialchars($_SESSION['email']); ?></a>
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
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="manage_items.php">Manage Product</a>
                <a href="../index.php">View Store</a>
                <a href="orders.php">Orders</a>
                <a href="customers.php" style=" color: #2874f0;
                    text-decoration: none;
                    background-color: rgb(229, 233, 255);
                    border: 2px solid #2874f0;
                    transform: translateX(8px);
                    box-shadow: 0 10px 18px rgba(40, 116, 240, 0.16);">Customers</a>
                <a class="log" href="logout.php">Logout</a>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="sh">
                <h2>Manage Customers</h2>
                <p>This is the manage customers page. You can add, edit, or delete customers from here.</p>
            </div>
            <div class="tab">
                <form action="" method="post">
                    <h3>Manage Customers</h3>
                    <div class="form-grid">
                        <?php
                        $query = "SELECT * FROM register";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {  ?>
                            <table class='table table-bordered'>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            <?php    
                            while ($row = mysqli_fetch_assoc($result)) {  ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['password']; ?></td>
                                    <td>
                                        <a href='edit_customer.php?id=<?php echo $row['id']; ?>' class='btn btn-primary btn-sm'>Edit</a>
                                    </td>
                                    <td>
                                        <a href='delete_customer.php?id=<?php echo $row['id']; ?>' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>
                                </tr>
                            <?php    
                            }
                            echo "</table>";
                        } else {
                            echo "<p>No customers found.</p>";
                        }
                        ?>
                    </div>
                    <div class="form-actions">
                        <!-- <input type="submit" name="edit_customer" value="Edit Customer">
                        <input type="submit" name="cancle" value="Cancel"> -->
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
