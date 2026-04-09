<?php
session_start();
include 'db.php';

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
$select = "SELECT * FROM profile WHERE user_id = '$user_id'";
$data = mysqli_query($conn, $select);
$row = $data ? mysqli_fetch_array($data) : null;

$db_name = $row && isset($row['name']) ? $row['name'] : '';
$db_dob = $row && isset($row['dob']) ? $row['dob'] : '';
$db_gender = $row && isset($row['gender']) ? $row['gender'] : '';
$db_number = $row && isset($row['number']) ? $row['number'] : '';

if (isset($_POST['update'])) {
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $email = $_POST['email'];
    $number = $_POST['number'];

    $query = "UPDATE profile SET name='$name', dob='$dob', gender='$gender', email='$email', number='$number' WHERE user_id='$user_id'";
    $data = mysqli_query($conn, $query);
    if ($data) {
        echo "<script>alert('Profile updated successfully'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Profile not updated');</script>";
        echo "ERROR " . mysqli_error($conn);
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Update</title>
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
                        <a href="#" class="nav-link" style="color: #000; font-weight: 500;"><i class="fas fa-store mr-2" style="font-size: 20px;"></i> Become a Seller</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content-wrapper" style="background-color: #f1f3f6; padding: 20px 0;">
            <div class="container" style="max-width: 1800px;">
                <div class="row">
                    <!-- Left Side -->
                    <div class="col-md-3 d-none d-md-block sticky-top">
                        <!-- Profile -->
                        <div class="card mb-3 shadow-sm border-0" style="border-radius: 2px;">
                            <div class="card-body d-flex align-items-center p-3">
                                <img src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/profile-pic-male_4811a1.svg" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">
                                <div>
                                    <div style="font-size: 12px; color: #878787;">Hello,</div>
                                    <div style="font-size: 16px; font-weight: 500; color: #212121; text-transform: capitalize;">
                                        <?php
                                        $display_name = isset($_SESSION['email']) ? explode('@', $_SESSION['email'])[0] : 'User';
                                        echo htmlspecialchars($display_name);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="card shadow-sm border-0" style="border-radius: 2px;">
                            <div class="list-group list-group-flush" style="border-radius: 2px;">
                                <a href="my_orders.php" class="list-group-item list-group-item-action border-bottom-0 py-3" style="color: #878787;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-folder text-primary mr-3" style="width: 20px; font-size: 20px;"></i>
                                        <span style="font-weight: 500; font-size: 16px;">MY ORDERS</span>
                                        <i class="fas fa-chevron-right ml-auto" style="font-size: 12px;"></i>
                                    </div>
                                </a>
                                <div class="list-group-item border-bottom-0 py-3 bg-white" style="border-top: 1px solid #f0f0f0;">
                                    <div class="d-flex align-items-center mb-2" style="color: #878787;">
                                        <i class="fas fa-user text-primary mr-3" style="width: 20px; font-size: 20px;"></i>
                                        <span style="font-weight: 500; font-size: 16px;">ACCOUNT SETTINGS</span>
                                    </div>
                                    <div class="pl-4 ml-3">
                                        <a href="profile.php" class="d-block py-2 text-primary" style="font-weight: 500; font-size: 14px; text-decoration: none; background-color: #f5faff;">Profile Information</a>
                                        <a href="my_address.php" class="d-block py-2 text-dark" style="font-weight: 400; font-size: 14px; text-decoration: none;">Manage Addresses</a>
                                    </div>
                                </div>
                                <div class="list-group-item border-bottom-0 py-3 bg-white" style="border-top: 1px solid #f0f0f0;">
                                    <div class="d-flex align-items-center mb-2" style="color: #878787;">
                                        <i class="fas fa-wallet text-primary mr-3" style="width: 20px; font-size: 20px;"></i>
                                        <span style="font-weight: 500; font-size: 16px;">PAYMENTS</span>
                                    </div>
                                    <div class="pl-4 ml-3">
                                        <a href="payment.php" class="d-block py-2 text-dark" style="font-weight: 400; font-size: 14px; text-decoration: none;">Payment Methods</a>
                                    </div>
                                </div>
                                <a href="logout.php" class="list-group-item list-group-item-action py-3 text-dark" style="border-top: 1px solid #f0f0f0;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-power-off text-primary mr-3" style="width: 20px; font-size: 20px;"></i>
                                        <span style="font-weight: 500; font-size: 16px;">Logout</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Main Content -->
                    <div class="col-md-9">
                        <div class="card shadow-sm border-0" style="border-radius: 2px; padding: 24px 32px; min-height: 500px;">
                            <form method="POST" action="">
                                <div class="section mb-5">
                                    <h4 style="font-size: 18px; font-weight: 500; margin-bottom: 24px;">Edit Personal Information</h4>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="text" name="name" class="form-control" placeholder="First Name" value="<?php echo htmlspecialchars($db_name); ?>" style="border-radius: 2px; height: 40px; border: 1px solid #2874f0; font-size: 14px;" required>
                                        </div>
                                        <div class="col-md-5 mt-3 mt-md-0">
                                            <input type="date" name="dob" class="form-control" placeholder="Date of Birth" style="border-radius: 2px; height: 40px; border: 1px solid #2874f0; font-size: 14px;" value="<?php echo htmlspecialchars($db_dob); ?>">
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p style="font-size: 14px; margin-bottom: 12px;">Your Gender</p>

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="genderMale" name="gender"
                                                class="custom-control-input"
                                                value="male"
                                                <?php echo ($db_gender == 'male' || empty($db_gender)) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="genderMale">
                                                Male
                                            </label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline ml-4">
                                            <input type="radio" id="genderFemale" name="gender"
                                                class="custom-control-input"
                                                value="female"
                                                <?php echo ($db_gender == 'female') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="genderFemale">
                                                Female
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="section mb-5">
                                    <h4 style="font-size: 18px; font-weight: 500; margin-bottom: 24px;">Email Address</h4>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?php echo $_SESSION['email']; ?>" style="border-radius: 2px; height: 40px; border-color: #e0e0e0; font-size: 14px; background-color: #fafafa; color: #878787;" readonly>
                                        </div>
                                        <div class="col-md-7 d-flex align-items-center mt-2 mt-md-0">
                                            <span style="font-size: 12px; color: #878787;">Email address cannot be changed</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="section mb-4">
                                    <h4 style="font-size: 18px; font-weight: 500; margin-bottom: 24px;">Edit Mobile Number</h4>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="number" name="number" class="form-control" placeholder="Mobile Number" value="<?php echo htmlspecialchars($db_number); ?>" style="border-radius: 2px; height: 40px; border: 1px solid #2874f0; font-size: 14px;">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="update" class="btn btn-primary" style="background-color: #2874f0; border: none; border-radius: 2px; padding: 10px 40px; font-size: 16px; font-weight: 500; box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);">SAVE CHANGES</button>
                                <a href="profile.php" class="btn btn-link ml-3" style="color: #2874f0; font-weight: 500; font-size: 16px; text-decoration: none;">CANCEL</a>
                            </form>

                            <!-- Flipkart Info Banner Image -->
                            <div class="mt-5 text-center d-none d-md-block">
                                <img src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/myProfileFooter_4e9fe2.png" alt="Profile Footer" style="width: 100%; max-width: 800px; opacity: 0.8;">
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
                        <strong>Copyright &copy; 2026 <a href="">Flipkart Replica</a>.</strong> All rights reserved.
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