<?php
session_start();
include 'db.php';

// if (isset($_SESSION['email']) && isset($_SESSION['id'])) {
//     $user_id = (int)$_SESSION['id'];

//     if (!isset($_SESSION['add_to_cart'])) {
//         $_SESSION['add_to_cart'] = [];

//         $data = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id");

//         if ($data) {
//             while ($row = mysqli_fetch_assoc($data)) {
//                 $_SESSION['add_to_cart'][(int)$row['product_id']] = [
//                     'quantity' => (int)$row['quantity'],
//                     'product_name' => $row['product_name'],
//                     'product_image' => $row['product_image']
//                 ];
//             }
//         }
//     }
// }

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

function getForYouProducts($conn, $categories, $existing_ids = [])
{
    $normalized_categories = [];
    foreach ($categories as $category) {
        $normalized_categories[] = "'" . mysqli_real_escape_string($conn, strtolower(trim($category))) . "'";
    }

    if (empty($normalized_categories)) {
        return [];
    }

    $products = [];
    $query = "SELECT * FROM products WHERE LOWER(TRIM(category)) IN (" . implode(", ", $normalized_categories) . ")";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $detail_id = !empty($row['source_product_id']) ? (int) $row['source_product_id'] : (int) $row['id'];

            if (isset($existing_ids[$detail_id])) {
                continue;
            }

            $products[] = [
                'id' => $detail_id,
                'name' => $row['product_name'],
                'price' => 'From ₹' . number_format((float) $row['price'], 0),
                'desc' => $row['description'],
                'img' => $row['image_url']
            ];
            $existing_ids[$detail_id] = true;
        }
    }

    return $products;
}

$suggested_for_you_products = getForYouProducts($conn, ['for you', 'for you - suggested for you'], [
    1 => true,
    2 => true,
    3 => true,
    4 => true,
    5 => true,
    666 => true
]);

$top_smart_tv_products = getForYouProducts($conn, ['for you - top smart tvs'], [
    6 => true,
    7 => true,
    8 => true,
    9 => true
]);

$watch_products = getForYouProducts($conn, ['for you - watches'], [
    10 => true,
    11 => true,
    12 => true,
    13 => true,
    14 => true
]);

$is_frontend_admin = false;
if (isset($_SESSION['email'])) {
    $email_check = mysqli_real_escape_string($conn, $_SESSION['email']);
    $res_admin_chk = mysqli_query($conn, "SELECT username FROM register WHERE email='$email_check'");
    if ($res_admin_chk && mysqli_num_rows($res_admin_chk) > 0) {
        $user_data = mysqli_fetch_assoc($res_admin_chk);
        if (strtolower(trim($user_data['username'])) == 'shyam') {
            $is_frontend_admin = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecomm | Home</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 12px; color: #aaa;"></i>
                                <input class="form-control w-100 mb-2" type="search"
                                    placeholder="Search for products..." style="padding-left: 30px;">
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto align-items-center">
                    <?php if (!isset($_SESSION['email'])): ?>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link nav-btn-login"><i class="far fa-user-circle mr-2"
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
                        <a href="cart.php" class="nav-link" style="color: #000; font-weight: 500;"><i
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
                        <i class="fa-solid fa-bag-shopping" style="color: #2874f0;"></i>
                        <span style="font-size: 13px; font-weight: 600; color: #2874f0;">For You</span>
                        <div
                            style="height: 2px; background-color: #2874f0; width: 100%; margin-top: 5px; border-radius: 2px;">
                        </div>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-shirt"></i>
                        <span style="font-size: 13px;"><a href="category/fashion.php"
                                style="color:#000; ">Fashion</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <span style="font-size: 13px;"><a href="category/mobiles.php"
                                style="color:#000; ">Mobiles</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-book"></i>
                        <span style="font-size: 13px;"><a href="category/books.php"
                                style="color:#000; ">Books</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-laptop"></i>
                        <span style="font-size: 13px;"><a href="category/electronic.php"
                                style="color:#000;">Electronics</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-headset"></i>
                        <span style="font-size: 13px;"><a href="category/headphone.php"
                                style="color:#000; ">Head Phone</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-regular fa-lightbulb"></i>
                        <span style="font-size: 13px;"><a href="category/home.php"
                                style="color:#000; ">Home</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-tv"></i>
                        <span style="font-size: 13px;"><a href="category/appliances.php"
                                style="color:#000; ">Appliances</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-gamepad"></i>
                        <span style="font-size: 13px;"><a href="category/toys.php"
                                style="color:#000; ">Toys, Games</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-burger"></i>
                        <span style="font-size: 13px;"><a href="category/food.php"
                                style="color:#000; ">Food & Health</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-helmet-un"></i>
                        <span style="font-size: 13px;"><a href="category/auto.php"
                                style="color:#000; ">Auto Accessories</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-person-biking"></i>
                        <span style="font-size: 13px;"><a href="category/bikes.php"
                                style="color:#000; ">2 - Wheeler</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-baseball-bat-ball"></i>
                        <span style="font-size: 13px;"><a href="category/sports.php"
                                style="color:#000; ">Sports</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-gem"></i>
                        <span style="font-size: 13px;"><a href="category/beauty.php"
                                style="color:#000; ">Beauty</a></span>
                    </div>
                    <div class="category-item">
                        <i class="fa-solid fa-chair"></i>
                        <span style="font-size: 13px;"><a href="category/furniture.php"
                                style="color:#000; ">Furniture</a></span>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container" style="max-width: 1800px;">
                    <div class="main-img mb-3"><a href="products.php?id=1111">
                            <img src="https://rukminim2.flixcart.com/image/1600/1200/cms-rpd-img/6af77547d14240748c3362678d35507d_19c9615ede8_1.jpg.jpeg?q=80" alt="main-banner" style="width: 100%; border-radius: 8px; height: 1000px; object-fit: fixed; object-position: center; cursor: pointer;">
                        </a>
                    </div>

                    <div id="autoScrollContainer" class="featured-banners">
                        <div class="featured-banner"><a href="products.php?id=101">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/b9d142fcfae0aa20.png?q=80"
                                    alt="Banner 1" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>

                        <div class="featured-banner"><a href="products.php?id=1111">
                                <img src="https://rukminim2.flixcart.com/image/1600/1200/cms-rpd-img/6af77547d14240748c3362678d35507d_19c9615ede8_1.jpg.jpeg?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>
                        <div class="featured-banner"><a href="products.php?id=102">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/2822884bd2eb20cc.jpg?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>
                        <div class="featured-banner"><a href="products.php?id=104">
                                <img src="https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/4654845b7aed1b3f.jpg?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>
                        <div class="featured-banner"><a href="products.php?id=105">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/09661ec206102fdf.jpg?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>
                        <div class="featured-banner"><a href="products.php?id=106">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/67516bc22e3f8982.jpg?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>
                        <div class="featured-banner"><a href="products.php?id=107">
                                <img src="https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/29f4f6d8488f42da.png?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>
                        <div class="featured-banner"><a href="products.php?id=108">
                                <img src="https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/0bb691b83c870479.png?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>

                        <div class="featured-banner"><a href="products.php?id=109">
                                <img src="https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/4fc21205ec478573.png?q=80"
                                    alt="Banner 2" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>
                        <div class="featured-banner"><a href="products.php?id=110">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/fd31b104256670ad.jpg?q=80"
                                    alt="Banner 3" style="border-radius: 4px; cursor: pointer;">
                            </a>
                        </div>
                    </div>

                    <div class="second">
                        <img src="https://rukminim1.flixcart.com/fk-p-flap/380/510/image/0df71628545827c9.png?q=80"
                            alt="">
                        <img src="https://rukminim1.flixcart.com/fk-p-flap/380/510/image/0c217ca609456602.png?q=80"
                            alt="">
                        <img src="https://rukminim1.flixcart.com/fk-p-flap/380/510/image/585cff9f1535c204.png?q=80"
                            alt="">
                        <img src="https://rukminim1.flixcart.com/fk-p-flap/380/510/image/c1b5870b3363b076.png?q=80"
                            alt="">
                        <img src="https://rukminim1.flixcart.com/fk-p-flap/380/510/image/974ea1811b2ec366.png?q=80"
                            alt="">
                        <img src="https://rukminim1.flixcart.com/fk-p-flap/380/510/image/7768efdcf50bf72d.png?q=80"
                            alt="">
                    </div>

                    <div class="product-wrapper" style="border-radius: 20px; margin-top: 20px;">
                        <div class="section-header">
                            <h2 style="margin-left: 15px;">Suggested for you</h2>
                            <button class="btn btn-primary rounded-circle scroll-btn" onclick="scrollRight()"
                                style="width: 32px; height: 32px; padding: 0; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <div id="scrollContainer" class="row m-0 p-3 row-horizontal scroll-container">
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/h/d/9/-original-imagtc2qzgnnuhxh.jpeg?q=70"
                                        class="card-img-top" alt="iPhone 15">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=1"
                                                style="text-decoration: none; color: #000;">Apple iPhone 15</a></div>
                                        <div class="card-text">From ₹65,999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">A16 Bionic Chip
                                        </div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">

                                            <input type="hidden" name="product_id" value="1">
                                            <input type="hidden" name="product_name" value="Apple iPhone 15">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/h/d/9/-original-imagtc2qzgnnuhxh.jpeg?q=70">
                                            <button type="submit" name="add_to_cart"
                                                class="btn btn-primary btn-sm w-100">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add To Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/y/s/g/-original-imahgfmy2zgqvjmy.jpeg?q=70"
                                        class="card-img-top" alt="Galaxy S24 Ultra">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=2"
                                                style="text-decoration: none; color: #000; cursor: pointer;">SAMSUNG
                                                Galaxy S24 Ultra</a></div>
                                        <div class="card-text">From ₹1,29,999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Snapdragon 8 Gen 3
                                        </div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="2">
                                            <input type="hidden" name="product_name" value="SAMSUNG Galaxy S24 Ultra">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/y/s/g/-original-imahgfmy2zgqvjmy.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/u/m/b/-original-imagrdefbw6bhbjr.jpeg?q=70"
                                        class="card-img-top" alt="Nothing Phone 2">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=3"
                                                style="text-decoration: none; color: #000; cursor: pointer;">Nothing
                                                Phone (2)</a></div>
                                        <div class="card-text">Incl. of offers</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Snapdragon 8+ Gen
                                            1</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="3">
                                            <input type="hidden" name="product_name" value="Nothing Phone (2)">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/u/m/b/-original-imagrdefbw6bhbjr.jpeg?q=70">
                                            <button type="submit" name="add_to_cart"
                                                class="btn btn-primary btn-sm w-100">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/e/y/n/pixel-8a-ga04432-in-google-original-imahyn3mqzdbzywg.jpeg?q=70"
                                        class="card-img-top" alt="Google Pixel 8">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=4"
                                                style="text-decoration: none; color: #000; cursor: pointer;">Google
                                                Pixel 8</a></div>
                                        <div class="card-text">Best Camera Choice</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Tensor G3
                                            Processor</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="4">
                                            <input type="hidden" name="product_name" value="Google Pixel 8">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flxixcart.com/image/312/312/xif0q/mobile/e/y/n/pixel-8a-ga04432-in-google-original-imahyn3mqzdbzywg.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/f/r/h/-original-imahft6chdhxfwhj.jpeg?q=70"
                                        class="card-img-top" alt="iPhone 15">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=5"
                                                style="text-decoration: none; color: #000;">Apple iPhone 17 Pro Max</a>
                                        </div>
                                        <div class="card-text">From ₹139999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">A18 Bionic Chip
                                        </div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="5">
                                            <input type="hidden" name="product_name" value="Apple iPhone 17 Pro Max">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/f/r/h/-original-imahft6chdhxfwhj.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- ['id' => 16, 'name' => 'Samsung Galaxy S23 5G', 'price' => '₹74,999', 'desc' => '256 GB ROM', 'img' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/p/w/p/-original-imah4zp8tfzndmmh.jpeg?q=70'], -->

                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/s/n/p/-original-imahfrff5gqmz6ed.jpeg?q=70"
                                        class="card-img-top" alt="iPhone 15">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=666"
                                                style="text-decoration: none; color: #000;">Samsung Galaxy S25 FE 5G</a>
                                        </div>
                                        <div class="card-text">From ₹54999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Exynos 2400e
                                            Processor</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="666">
                                            <input type="hidden" name="product_name" value="Samsung Galaxy S25 FE 5G">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/s/n/p/-original-imahfrff5gqmz6ed.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/s/n/p/-original-imahfrff5gqmz6ed.jpeg?q=70"
                                        class="card-img-top" alt="iPhone 15">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=666"
                                                style="text-decoration: none; color: #000;">Samsung Galaxy S25 FE 5G</a>
                                        </div>
                                        <div class="card-text">From ₹54999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Exynos 2400e
                                            Processor</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="666">
                                            <input type="hidden" name="product_name" value="Samsung Galaxy S25 FE 5G">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/s/n/p/-original-imahfrff5gqmz6ed.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div> -->
                            <?php foreach ($suggested_for_you_products as $suggested_product): ?>
                                <div class="col-5-card p-2">
                                    <div class="card product-card">
                                        <img src="<?php echo htmlspecialchars($suggested_product['img']); ?>"
                                            class="card-img-top" alt="<?php echo htmlspecialchars($suggested_product['name']); ?>">
                                        <div class="card-body">
                                            <div class="card-head"><a href="products.php?id=<?php echo (int) $suggested_product['id']; ?>"
                                                    style="text-decoration: none; color: #000;"><?php echo htmlspecialchars($suggested_product['name']); ?></a></div>
                                            <div class="card-text"><?php echo htmlspecialchars($suggested_product['price']); ?></div>
                                            <div class="text-primary text-muted" style="font-size: 13px;"><?php echo htmlspecialchars($suggested_product['desc']); ?></div>
                                            <form method="POST" class="text-center mt-2 d-inline-block">
                                                <input type="hidden" name="product_id" value="<?php echo (int) $suggested_product['id']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($suggested_product['name']); ?>">
                                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($suggested_product['img']); ?>">
                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm w-100">
                                                    <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add To Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>

                    <div class="new-img">
                        <h2>Brands in Spotlight</h2>
                        <div class="banner-center">
                            <img src="https://rukminim1.flixcart.com/fk-p-flap/1570/520/image/6d9271dc4948f411.png?q=80"
                                alt="">
                        </div>
                    </div>

                    <div class="product-wrapper" style="border-radius: 20px; margin-top: 20px;">
                        <div class="section-header" style="margin-left: 15px;">
                            <h2 style="margin-left: 15px;">Top Smart TVs</h2>
                            <button class="btn btn-primary rounded-circle"
                                style="width: 32px; height: 32px; padding: 0; margin-right: 15px; display: flex; align-items: center; justify-content: center;"><i
                                    class="fas fa-chevron-right"></i></button>
                        </div>
                        <div id="scrollcontainer" class="row m-0 p-3 row-horizontal scroll-container">
                            <div class="col-4-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/television/w/w/i/-original-imahegsctyswfakr.jpeg?q=70"
                                        class="card-img-top" alt="Sony 4K">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=6"
                                                style="text-decoration: none; color: #000; cursor: pointer;">SONY BRAVIA
                                                2 139 cm (55 inch)</a></div>
                                        <div class="card-text">From ₹54,990</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Ultra HD (4K) LED
                                            Smart TV</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="6">
                                            <input type="hidden" name="product_name"
                                                value="SONY BRAVIA 2 139 cm (55 inch)">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/television/w/w/i/-original-imahegsctyswfakr.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/television/m/v/5/-original-imahknwwnvwb7gtb.jpeg?q=70"
                                        class="card-img-top" alt="Samsung QLED">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=7"
                                            style="text-decoration: none; color: #000; cursor: pointer;">SAMSUNG 163cm (65 inch) QLED</a></div>
                                        <div class="card-text">Up to 40% Off</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Ultra HD (4K) Smart TV</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="7">
                                            <input type="hidden" name="product_name"
                                                value="SAMSUNG 163 cm (65 inch) QLED">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/television/m/v/5/-original-imahknwwnvwb7gtb.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/television/u/z/z/-original-imahksjy3hpbdu4v.jpeg?q=70"
                                        class="card-img-top" alt="LG OLED">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=8"
                                                style="text-decoration: none; color: #000; cursor: pointer;">LG 139 cm(55 inch) OLED</a></div>
                                        <div class="card-text">From ₹84,990</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Ultra HD (4K) Smart WebOS TV</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="8">
                                            <input type="hidden" name="product_name" value="LG 139 cm (55 inch) OLED">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/television/u/z/z/-original-imahksjy3hpbdu4v.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/television/j/3/5/-original-imahjf6ypgx2f9sy.jpeg?q=70"
                                        class="card-img-top" alt="LG OLED">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=9"
                                            style="text-decoration: none; color: #000; cursor: pointer;">Xiaomi 43inch Smart TV</a></div>
                                        <div class="card-text">From ₹24,999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Ultra HD (4K) Smart WebOS TV</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="9">
                                            <input type="hidden" name="product_name" value="Xiaomi 43 inch Smart TV">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/television/j/3/5/-original-imahjf6ypgx2f9sy.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-4-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/312/312/xif0q/television/j/3/5/-original-imahjf6ypgx2f9sy.jpeg?q=70"
                                        class="card-img-top" alt="LG OLED">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=9"
                                                style="text-decoration: none; color: #000; cursor: pointer;">Xiaomi 43 inch Smart TV</a></div>
                                        <div class="card-text">From ₹24,999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Ultra HD (4K) Smart WebOS TV</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="9">
                                            <input type="hidden" name="product_name" value="Xiaomi 43 inch Smart TV">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/312/312/xif0q/television/j/3/5/-original-imahjf6ypgx2f9sy.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                            <?php foreach ($top_smart_tv_products as $tv_product): ?>
                                <div class="col-4-card p-2">
                                    <div class="card product-card">
                                        <img src="<?php echo htmlspecialchars($tv_product['img']); ?>"
                                            class="card-img-top" alt="<?php echo htmlspecialchars($tv_product['name']); ?>">
                                        <div class="card-body">
                                            <div class="card-head"><a href="products.php?id=<?php echo (int) $tv_product['id']; ?>"
                                                    style="text-decoration: none; color: #000; cursor: pointer;"><?php echo htmlspecialchars($tv_product['name']); ?></a></div>
                                            <div class="card-text"><?php echo htmlspecialchars($tv_product['price']); ?></div>
                                            <div class="text-primary text-muted" style="font-size: 13px;"><?php echo htmlspecialchars($tv_product['desc']); ?></div>
                                            <form method="POST" class="text-center mt-2 d-inline-block">
                                                <input type="hidden" name="product_id" value="<?php echo (int) $tv_product['id']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($tv_product['name']); ?>">
                                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($tv_product['img']); ?>">
                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>

                    <div class="product-wrapper" style="border-radius: 20px;">
                        <div class="section-header">
                            <h2 style="margin-left: 30px;">Watches</h2>
                            <button class="btn btn-primary rounded-circle"
                                style="width: 32px; height: 32px; padding: 0; margin-right: 15px; display: flex; align-items: center; justify-content: center;"><i
                                    class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="row m-0 p-3 row-horizontal">
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/7/r/e/45-mr993hn-a-ios-apple-yes-original-imagterzzu4fsrqg.jpeg?q=70"
                                        class="card-img-top" alt="Apple Watch Series 9"
                                        style="height: 200px; object-fit: contain; padding: 10px;">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=10"
                                                style="text-decoration: none; color: #000;">Apple Watch Series 9</a>
                                        </div>
                                        <div class="card-text">From ₹13,999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Advanced fitness tracking</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="10">
                                            <input type="hidden" name="product_name" value="Apple Watch Series 9">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/7/r/e/45-mr993hn-a-ios-apple-yes-original-imagterzzu4fsrqg.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/3/m/v/-original-imahagdjcnqhapfu.jpeg?q=70"
                                        class="card-img-top" alt="Samsung Galaxy Watch 6"
                                        style="height: 200px; object-fit: contain; padding: 10px;">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=11"
                                                style="text-decoration: none; color: #000; cursor: pointer;">SAMSUNG Galaxy Watch 6</a></div>
                                        <div class="card-text">From ₹24,990</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Premium Android Watch</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="11">
                                            <input type="hidden" name="product_name" value="SAMSUNG Galaxy Watch 6">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/3/m/v/-original-imahagdjcnqhapfu.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/p/1/s/-original-imahh6z2apwbmuqn.jpeg?q=70"
                                        class="card-img-top" alt="Fire-Boltt Invincible"
                                        style="height: 200px; object-fit: contain; padding: 10px;">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=12"
                                                style="text-decoration: none; color: #000; cursor: pointer;">Fire-Bolt Invincible</a></div>
                                        <div class="card-text">From ₹2,499</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">1.43" AMOLED Display</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="12">
                                            <input type="hidden" name="product_name" value="Fire-Boltt Invincible">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/p/1/s/-original-imahh6z2apwbmuqn.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/612/612/l2z26q80/smartwatch/w/0/l/43-688-wrb-sw-colorfitpro4-std-slvr-gry-android-ios-noise-yes-original-image6yxqtzhahjx.jpeg?q=70"
                                        class="card-img-top" alt="Noise ColorFit Pro 4"
                                        style="height: 200px; object-fit: contain; padding: 10px;">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=13"
                                                style="text-decoration: none; color: #000; cursor: pointer;">Noise ColorFit Pro 4</a></div>
                                        <div class="card-text">From ₹1,999</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Bluetooth Calling Watch</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="13">
                                            <input type="hidden" name="product_name" value="Noise ColorFit Pro 4">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/612/612/l2z26q80/smartwatch/w/0/l/43-688-wrb-sw-colorfitpro4-std-slvr-gry-android-ios-noise-yes-original-image6yxqtzhahjx.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5-card p-2">
                                <div class="card product-card">
                                    <img src="https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/m/n/v/42-9-wave-call-android-ios-boat-yes-original-imagz5hjvvhchfx7.jpeg?q=70"
                                        class="card-img-top" alt="boAt Wave Call"
                                        style="height: 200px; object-fit: contain; padding: 10px;">
                                    <div class="card-body">
                                        <div class="card-head"><a href="products.php?id=14"
                                                style="text-decoration: none; color: #000; cursor: pointer;">boAt Wave Call</a></div>
                                        <div class="card-text">From ₹2,290</div>
                                        <div class="text-primary text-muted" style="font-size: 13px;">Water and Dust Resistant</div>
                                        <form method="POST" class="text-center mt-2 d-inline-block">
                                            <input type="hidden" name="product_id" value="14">
                                            <input type="hidden" name="product_name" value="boAt Wave Call">
                                            <input type="hidden" name="product_image"
                                                value="https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/m/n/v/42-9-wave-call-android-ios-boat-yes-original-imagz5hjvvhchfx7.jpeg?q=70">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($watch_products as $watch_product): ?>
                                <div class="col-5-card p-2">
                                    <div class="card product-card">
                                        <img src="<?php echo htmlspecialchars($watch_product['img']); ?>"
                                            class="card-img-top" alt="<?php echo htmlspecialchars($watch_product['name']); ?>"
                                            style="height: 200px; object-fit: contain; padding: 10px;">
                                        <div class="card-body">
                                            <div class="card-head"><a href="products.php?id=<?php echo (int) $watch_product['id']; ?>"
                                                    style="text-decoration: none; color: #000;"><?php echo htmlspecialchars($watch_product['name']); ?></a></div>
                                            <div class="card-text"><?php echo htmlspecialchars($watch_product['price']); ?></div>
                                            <div class="text-primary text-muted" style="font-size: 13px;"><?php echo htmlspecialchars($watch_product['desc']); ?></div>
                                            <form method="POST" class="text-center mt-2 d-inline-block">
                                                <input type="hidden" name="product_id" value="<?php echo (int) $watch_product['id']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($watch_product['name']); ?>">
                                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($watch_product['img']); ?>">
                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-cart-arrow-down mr-1"></i> Add to cart
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
                    <strong>Copyright &copy; 2026 <a href="note.php">Flipkart Replica</a>.</strong> All rights reserved.
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

    <script src="script.js"></script>
    <script>
        function scrollRight() {
            document.getElementById("scrollContainer").scrollBy({
                left: 340,
                behavior: "smooth"
            });
    }
    </script>
</body>

</html>
