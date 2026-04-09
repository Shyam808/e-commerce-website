<?php
session_start();
include '../db.php';
include '../products.php';

$alert_message = '';
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['email'])) {
        $alert_message = 'Please login to add products to cart!';
    } else {
        $product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
        $user_id = (int) $_SESSION['id'];
        if ($product_id && !isset($_SESSION['add_to_cart'][$product_id])) {
            $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
            $product_image = isset($_POST['product_image']) ? mysqli_real_escape_string($conn, $_POST['product_image']) : '';
            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity, product_name, product_image) VALUES ($user_id, $product_id, 1, '$product_name', '$product_image')");
            $_SESSION['add_to_cart'][$product_id] = [
                'quantity' => 1,
                'product_name' => $product_name,
                'product_image' => $product_image
            ];
            $alert_message = 'Product added to your cart!';
        } else if (isset($_SESSION['add_to_cart'][$product_id])) {
            $alert_message = 'Product is already in your cart!';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HeadPhones</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link rel="stylesheet" href="../custom_style.css">
    <link rel="stylesheet" href="../flipkart_style.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light sticky-top">
            <div class="container" style="max-width: 1800px;">
                <a href="../index.php" class="navbar-brand brand-logo" style="margin-left: 0px;">
                    <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg"
                        alt="Flipkart" height="45" style="margin-right: 10px; padding: 6px 10px; border-radius: 4px;">
                </a>
                <div class="search-bar-container d-none d-md-flex position-relative flex-grow-1">
                    <i class="fas fa-search search-icon"></i>
                    <input class="search-input" type="search" placeholder="Search for products, brands and more"
                        aria-label="Search">
                </div>
                <button class="navbar-toggler order-1 ml-auto" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav d-md-none mt-2 w-100">
                        <li class="w-100">
                            <div class="position-relative">
                                <i class="fas fa-search"
                                    style="position: absolute; left: 10px; top: 12px; color: #aaa;"></i>
                                <input class="form-control w-100 mb-2" type="search"
                                    placeholder="Search for products..." style="padding-left: 30px;">
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto align-items-center">
                    <?php if (!isset($_SESSION['email'])): ?>
                        <li class="nav-item">
                            <a href="../login.php" class="nav-link nav-btn-login"><i class="far fa-user-circle mr-2"
                                    style="font-size: 20px;"></i> Login</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle"
                                style="color: #000; font-weight: 500; display:flex; align-items:center;"><i
                                    class="far fa-user-circle mr-2"
                                    style="font-size: 20px;"></i><?php echo htmlspecialchars($_SESSION['email']); ?></a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="../my_orders.php" class="dropdown-item text-dark">My Orders</a></li>
                                <li><a href="../payment.php" class="dropdown-item text-dark">Payments</a></li>
                                <li><a href="../my_wishlist.php" class="dropdown-item text-dark">My Wishlist</a></li>
                                <li><a href="../cart.php" class="dropdown-item text-dark">My Cart</a></li>
                                <li><a href="../my_address.php" class="dropdown-item text-dark">My Address</a></li>
                                <li><a href="../profile.php" class="dropdown-item text-dark">My Profile</a></li>
                                <li><a href="../logout.php" class="dropdown-item text-danger">Logout</a></li>
                            </ul>

                        </li>
                    <?php endif; ?>
                    <li class="nav-item ml-0 d-none d-md-block">
                        <a href="../cart.php" class="nav-link" style="color: #000; font-weight: 500;"><i
                                class="fas fa-shopping-cart mr-2" style="font-size: 20px;"></i> Cart</a>
                    </li>
                    <li class="nav-item ml-0 d-lg-block">
                        <a href="seller.php" class="nav-link" style="color: #000; font-weight: 500;"><i
                                class="fas fa-store mr-2" style="font-size: 20px;"></i> Become a Seller</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content-wrapper" style="background-color: transparent;">
            <div class="hero">
                <div class="categories-container"
                    style="justify-content: flex-start; gap: 10px; justify-content: space-around; ">
                    <div class="category-item">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span style="font-size: 13px; font-weight: 600;"><a href="../index.php" style="color:#000;">For
                                You</a></span>
                        <div class="uline" style="display: none;"></div>
                    </div>
                    <div class="category-item active">
                        <i class="fa-solid fa-shirt"></i>
                        <span style="font-size: 13px;"><a href="fashion.php" style="color:#000;">Fashion</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <span style="font-size: 13px;"><a href="mobiles.php" style="color:#000;">Mobiles</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-book"></i>
                        <span style="font-size: 13px;"><a href="books.php"
                                style="color:#000">Books</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-laptop"></i>
                        <span style="font-size: 13px;"><a href="electronic.php"
                                style="color:#000;">Electronics</a>a</span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-headset" style="color: #2874f0;"></i>
                        <span style="font-size: 13px;"><a href="headphone.php"
                                style="color:#2874f0 !important; font-weight: bold;">Head Phone</a></span>
                            <div
                            style="height: 2px; background-color: #2874f0; width: 100%; margin-top: 5px; border-radius: 2px;">
                        </div>
                    </div>
                    <div class="category-item">
                        <i class="fa-regular fa-lightbulb"></i>
                        <span style="font-size: 13px;"><a href="home.php"style="color:#000">Home</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-tv"></i>
                        <span style="font-size: 13px;"><a href="appliances.php" style="color:#000">Appliances</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-gamepad"></i>
                        <span style="font-size: 13px;"><a href="toys.php" style="color:#000">Toys, Games</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-burger"></i>
                        <span style="font-size: 13px;"><a href="food.php" style="color:#000">Food & Health</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-helmet-un"></i>
                        <span style="font-size: 13px;"><a href="auto.php" style="color:#000">Auto Accessories</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-person-biking"></i>
                        <span style="font-size: 13px;"><a href="two_wheeler.php" style="color:#000">2 - Wheeler</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-baseball-bat-ball"></i>
                        <span style="font-size: 13px;"><a href="sports.php" style="color:#000">Sports</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-gem"></i>
                        <span style="font-size: 13px;"><a href="beauty.php" style="color:#000">Beauty</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-chair"></i>
                        <span style="font-size: 13px;"><a href="furniture.php" style="color:#000">Furniture</a></span>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container" style="max-width: 1800px;">
                    <div id="autoScrollContainer" class="featured-banners"
                        style="display:flex; justify-content: space-between;height: 300px;">
                        <div class="featured-banner" style="width: 585px; height: 300px; "><a
                                href="#">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/9231385aa2753ef7.png?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer; height: 300px;">
                            </a>
                        </div>
                        <div class="featured-banner" style="width: 585px; height: 300px;"><a
                                href="#">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/609ea1b8ff0747f0.png?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer; height: 300px;">
                            </a>
                        </div>
                        <div class="" style="width: 585px; height: 300px; object-fit: fixed;"><a
                                href="#">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1620/790/image/ae078eed92386431.jpg?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer; height: 300px;">
                            </a>
                        </div>
                    </div>

                    <?php
                    $headphones = [];
                    foreach ($products as $catalogProduct) {
                        $catalogId = isset($catalogProduct['id']) ? (int) $catalogProduct['id'] : 0;
                        if (($catalogId >= 85 && $catalogId <= 100) || ($catalogId >= 121 && $catalogId <= 124)) {
                            $headphones[] = [
                                'id' => $catalogId,
                                'name' => $catalogProduct['name'],
                                'price' => '₹' . number_format((float) (isset($catalogProduct['price']) ? $catalogProduct['price'] : 0), 0),
                                'desc' => isset($catalogProduct['desc']) ? $catalogProduct['desc'] : '',
                                'img' => isset($catalogProduct['image']) ? $catalogProduct['image'] : ''
                            ];
                        }
                    }
                    ?>
                    <div class="parent-nano"
                        style="width: 1500px; border-radius: 20px; background: #fff; gap: 15px; padding-bottom: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 20px;">
                        <div class="nano-mobiles">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/724653fb19a4dd61.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/2d92dd6aaa9a2334.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/fca2cb9d5185cbed.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/dde189ac7fd1835d.png?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/cccf3e944fd1a0b4.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/e811fca07e4fc9e2.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/dcd5633aa033bd01.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/b7be9cb9e0fa7304.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/49b4b7c8e762b980.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/46a8cf1df7166e13.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/aded8350f9172a7d.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/0a24ae14127249f8.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/f5b98f986fd27c04.jpg?q=80"
                                alt="">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/98/98/image/1d86f08d701c391a.jpg?q=80"
                                alt="">
                        </div>
                    </div>
                    <div class="product-wrapper"
                        style="border-radius: 20px; background: #fff; padding-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 5px;">
                        <div class="section-header"
                            style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; padding: 15px;">
                            <h2 style="margin: 0; font-size: 22px; font-weight: 500;">Headphones, Neckbands & Earbuds</h2>
                            <!-- <button class="btn btn-primary rounded-circle" style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;"><i class="fas fa-chevron-right"></i></button> -->
                        </div>
                        <div class="row m-0 p-3" style="display: flex; flex-wrap: wrap;">
                            <?php foreach ($headphones as $headphone): ?>
                                <div class="p-2" style="flex: 0 0 calc(100% / 5); max-width: calc(100% / 5);">
                                    <div class="card product-card"
                                        style="border: none; position: relative; height: 100%; transition: transform 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                        <div
                                            style="height: 180px; display: flex; align-items: center; justify-content: center; padding: 15px;">
                                            <img src="<?php echo $headphone['img']; ?>"
                                                style="max-height: 100%; max-width: 100%; object-fit: contain;"
                                                alt="<?php echo htmlspecialchars($headphone['name']); ?>">
                                        </div>
                                        <div class="card-body text-center" style="padding: 10px;">
                                            <div class="card-head"
                                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 5px;">
                                                <a href="../products.php?id=<?php echo $headphone['id']; ?>"
                                                    style="text-decoration: none; color: #212121; font-weight: 500; font-size: 14px;">
                                                    <?php echo htmlspecialchars($headphone['name']); ?>
                                                </a>
                                            </div>
                                            <div class="card-text"
                                                style="color: #388e3c; font-weight: 500; font-size: 14px; margin-bottom: 3px;">
                                                <?php echo htmlspecialchars($headphone['price']); ?>
                                            </div>
                                            <div class="text-muted"
                                                style="font-size: 12px; margin-bottom: 10px; color: #878787 !important;">
                                                <?php echo htmlspecialchars($headphone['desc']); ?>
                                            </div>
                                            <form method="POST" class="text-center mt-auto d-inline-block w-100">
                                                <input type="hidden" name="product_id" value="<?php echo $headphone['id']; ?>">
                                                <input type="hidden" name="product_name"
                                                    value="<?php echo htmlspecialchars($headphone['name']); ?>">
                                                <input type="hidden" name="product_image"
                                                    value="<?php echo $headphone['img']; ?>">
                                                <button type="submit" name="add_to_cart"
                                                    class="btn btn-primary btn-sm w-100">
                                                    <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add To Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
    <script src="../script.js">
        function scrollRight() {
            const container = document.getElementById('scrollcontainer');
            container.scrollBy({ left: 300, behavior: 'smooth' });
        }
    </script>
</body>

</html>
