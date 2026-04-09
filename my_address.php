<?php
session_start();
include 'db.php';

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

if (isset($_POST['add_address'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $street_no = $_POST['street_no'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];

    $sql = "INSERT INTO addressone (user_id, name, mobile, address, city, street_no, state, pincode) VALUES ('$user_id', '$name', '$mobile', '$address', '$city', '$street_no', '$state', '$pincode')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Address added successfully'); window.location.href='payment.php';</script>";
    } else {
        echo "<script>alert('Address not added');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Com | My Address</title>
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
                <a href="index.php" class="navbar-brand brand-logo" style="margin-left: 0px;">
                    <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg" alt="Flipkart" height="40" style="margin-right: 10px;">
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
                                <li><a href="payment.php" class="dropdown-item text-dark">Payment</a></li>
                                <li><a href="my_wishlist.php" class="dropdown-item text-dark">My Wishlist</a></li>
                                <li><a href="cart.php" class="dropdown-item text-dark">My Cart</a></li>
                                <li><a href="my_address.php" class="dropdown-item text-dark" style="color:#2874f0 !important; font-weight:bold;">My Address</a></li>
                                <li><a href="profile.php" class="dropdown-item text-dark">My Profile</a></li>
                                <li><a href="logout.php" class="dropdown-item text-danger">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ml-0 d-none d-md-block">
                        <a href="cart.php" class="nav-link" style="color: #000; font-weight: 500;"><i class="fas fa-shopping-cart mr-2" style="font-size: 20px;"></i> Cart</a>
                    </li>
                    <li class="nav-item ml-0 d-lg-block">
                        <a href="seller.php" class="nav-link" style="color: #000; font-weight: 500;"><i class="fas fa-store mr-2" style="font-size: 20px;"></i> Become a Seller</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content-wrapper" style="background-color: #f1f3f6; padding: 20px 0; flex: 1;">
            <div class="container" style="max-width: 1800px;">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card" style="border-radius: 2px; border: none; box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);">
                            <div class="card-body p-4">
                                <h4 style="font-weight: 500; color: #212121; margin-bottom: 20px;">Manage Addresses</h4>
                                <?php
                                $query = "SELECT id, name, mobile, address, city, street_no, state, pincode FROM addressone WHERE user_id='$user_id'";
                                $data = $conn->query($query);
                                if ($data && $data->num_rows > 0):
                                    while ($row = $data->fetch_assoc()):
                                ?>
                                        <div class="current-address mb-4" style="padding: 16px; border: 1px solid #e0e0e0; border-radius: 4px; background-color: #f9f9f9;">
                                            <p style="margin: 0; font-size: 14px; color: #212121;">
                                                <span style="background-color: #f0f0f0; padding: 2px 6px; border-radius: 2px; font-size: 11px; font-weight: 600; color: #878787; margin-right: 10px;">HOME</span>
                                                <strong><?php echo htmlspecialchars(isset($row['name']) && $row['name'] ? $row['name'] : 'User'); ?></strong> &emsp; <?php echo htmlspecialchars($row['mobile']); ?>
                                            </p>
                                            <div style="margin: 10px 0 0 0; font-size: 14px; color: #212121; display: flex; justify-content: space-between; align-items: center;">
                                                <span><?php echo htmlspecialchars($row['address'] . ' ' . $row['street_no'] . ', ' . $row['city'] . ', ' . $row['state'] . ' - ' . $row['pincode']); ?></span>
                                                <div>
                                                    <a href="update_address.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm" name="edit_add">Edit</a>
                                                    <a href="delete_address.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" style="margin-left: 10px;">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    endwhile;
                                else:
                                    ?>
                                    <h6 style="font-weight: 500; color: #2874f0; text-transform: uppercase; font-size: 14px; margin-bottom: 16px;">Add A New Address</h6>

                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required style="border-radius: 2px; padding: 12px; height: auto;">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="number" class="form-control" id="mobile" name="mobile" placeholder="10-digit mobile number" required style="border-radius: 2px; padding: 12px; height: auto;">
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <textarea class="form-control" id="address" name="address" placeholder="Address (Area and Street)" rows="3" required style="border-radius: 2px; padding: 12px;"></textarea>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6 form-group">
                                                <input type="text" class="form-control" id="city" name="city" placeholder="City/District/Town" required style="border-radius: 2px; padding: 12px; height: auto;">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" class="form-control" id="street_no" name="street_no" placeholder="Street No./Name" style="border-radius: 2px; padding: 12px; height: auto;">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6 form-group">
                                                <input type="text" class="form-control" id="state" name="state" placeholder="State" required style="border-radius: 2px; padding: 12px; height: auto;">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="number" class="form-control" id="pincode" name="pincode" placeholder="Pincode" required style="border-radius: 2px; padding: 12px; height: auto;">
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" name="add_address" class="btn btn-primary" style="background-color: #fb641b; border: none; border-radius: 2px; padding: 12px 36px; font-weight: 500; font-size: 15px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);">SAVE AND DELIVER HERE</button>
                                            <a href="#" class="btn btn-link ml-4" style="color: #2874f0; font-weight: 500; text-decoration: none;">CANCEL</a>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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