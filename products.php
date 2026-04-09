<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$alert_message = '';
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['email'])) {
        $alert_message = 'Please login to add products to cart!';
    } else {
        $product_id_post = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
        $user_id = (int) $_SESSION['id'];
        if ($product_id_post && !isset($_SESSION['add_to_cart'][$product_id_post])) {
            $product_name_post = mysqli_real_escape_string($conn, $_POST['product_name']);
            $product_image_post = isset($_POST['product_image']) ? mysqli_real_escape_string($conn, $_POST['product_image']) : '';
            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity, product_name, product_image) VALUES ($user_id, $product_id_post, 1, '$product_name_post', '$product_image_post')");
            $_SESSION['add_to_cart'][$product_id_post] = [
                'quantity' => 1,
                'product_name' => $product_name_post,
                'product_image' => $product_image_post
            ];
            $alert_message = 'Product added to your cart!';
        } else if (isset($_SESSION['add_to_cart'][$product_id_post])) {
            $alert_message = 'Product is already in your cart!';
        }
    }
}

$products = [
    // index
    1111 => [
        'id' => 1111,
        'name' => 'Samsung Galaxy S26 Ultra',
        'price' => 139000,
        'original_price' => 159000,
        'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/d/0/x/-original-imahhyzrnhgzvdk4.jpeg?q=70',
        'desc' => 'Snapdragon Elite 8S Gen 5',
        'rating' => 5.5,
        'reviews' => 56234
    ],
    101 => [
        'id' => 101,
        'name' => 'Samsung Galaxy F70e 5G',
        'price' => 13999,
        'original_price' => 19990,
        'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/3/u/i/-original-imahkur3ethtv2hq.jpeg?q=70',
        'desc' => 'Dimensity 6000+ Processor',
        'rating' => 4.1,
        'reviews' => 725
    ],
    102 => [
        'id' => 102,
        'name' => 'Vivo T5x 5G',
        'price' => 17999,
        'original_price' => 21990,
        'image' => 'https://rukminim2.flixcart.com/image/1860/1860/xif0q/mobile/z/m/e/-original-imahhhfv5ffnzjbv.jpeg?q=90',
        'desc' => 'Segmetns Biggest battery',
        'rating' => 5,
        'reviews' => 'sale starts today'
    ],
    103 => [
        'id' => 103,
        'name' => 'Samsung Galaxy F70e 5G',
        'price' => 13999,
        'original_price' => 19990,
        'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/3/u/i/-original-imahkur3ethtv2hq.jpeg?q=70',
        'desc' => 'Dimensity 6000+ Processor',
        'rating' => 4.1,
        'reviews' => 725
    ],
    104 => ['id' => 104, 'name' => 'Pack of 2 curtains', 'price' => 249, 'original_price' => 300, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/4654845b7aed1b3f.jpg?q=80', 'desc' => 'Home Appliances', 'rating' => 4.2, 'reviews' => 1456],
    105 => ['id' => 105, 'name' => 'Realme P4 Lite 5G', 'price' => 11999, 'original_price' => 14999, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/09661ec206102fdf.jpg?q=80', 'desc' => '128 GB Storage/ 8 GB RAM', 'rating' => 3.1, 'reviews' => 1236],
    106 => ['id' => 106, 'name' => 'Summer Skin Care', 'price' => 299, 'original_price' => 349, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/67516bc22e3f8982.jpg?q=80', 'desc' => 'Skincare', 'rating' => 4.8, 'reviews' => 5234],
    107 => ['id' => 107, 'name' => 'Samsung S26 Ultra', 'price' => 139999, 'original_price' => 159999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/29f4f6d8488f42da.png?q=80', 'desc' => 'Snapdragon Elite 8S Gen 5', 'rating' => 4.8, 'reviews' => 5234],
    108 => ['id' => 108, 'name' => 'Daikin', 'price' => 31999, 'original_price' => 34000, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/0bb691b83c870479.png?q=80', 'desc' => '1.5 Ton 3 Star Split AC', 'rating' => 4.5, 'reviews' => 5315],
    109 => ['id' => 109, 'name' => 'musucle', 'price' => 0, 'original_price' => 0, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/4fc21205ec478573.png?q=80', 'desc' => 'protein'],
    110 => ['id' => 110, 'name' => 'Campus Shoes', 'price' => 0, 'original_price' => 0, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1580/770/image/fd31b104256670ad.jpg?q=80', 'desc' => 'Campus Shoes'],

    1 => ['id' => 1, 'name' => 'Apple iPhone 15 (Black, 128 GB)', 'price' => 65999, 'original_price' => 79900, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/h/d/9/-original-imagtc2qzgnnuhxh.jpeg?q=70', 'desc' => 'A16 Bionic Chip', 'rating' => 4.6, 'reviews' => 4209],
    2 => ['id' => 2, 'name' => 'SAMSUNG Galaxy S24 Ultra', 'price' => 129999, 'original_price' => 134999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/y/s/g/-original-imahgfmy2zgqvjmy.jpeg?q=70', 'desc' => 'Snapdragon 8 Gen 3', 'rating' => 4.8, 'reviews' => 1250],
    3 => ['id' => 3, 'name' => 'Nothing Phone (2)', 'price' => 39999, 'original_price' => 44999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/u/m/b/-original-imagrdefbw6bhbjr.jpeg?q=70', 'desc' => 'Snapdragon 8+ Gen 1', 'rating' => 4.4, 'reviews' => 890],
    4 => ['id' => 4, 'name' => 'Google Pixel 8', 'price' => 75999, 'original_price' => 82999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/e/y/n/pixel-8a-ga04432-in-google-original-imahyn3mqzdbzywg.jpeg?q=70', 'desc' => 'Tensor G3 Processor', 'rating' => 4.5, 'reviews' => 2100],
    5 => ['id' => 5, 'name' => 'Apple iPhone 17 Pro Max (Black, 128 GB)', 'price' => 139999, 'original_price' => 149999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/f/r/h/-original-imahft6chdhxfwhj.jpeg?q=70', 'desc' => 'A18 Bionic Chip', 'rating' => 5, 'reviews' => 15025],
    666 => ['id' => 666, 'name' => 'Samsung S25 FE 5G(Black, 256 GB)', 'price' => 54990, 'original_price' => 74900, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/s/n/p/-original-imahfrff5gqmz6ed.jpeg?q=70', 'desc' => 'Exynos 2500 Multitasking Processor', 'rating' => 5.7, 'reviews' => 102586],
    6 => ['id' => 6, 'name' => 'SONY BRAVIA 2 139 cm (55 inch)', 'price' => 54990, 'original_price' => 74900, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/television/w/w/i/-original-imahegsctyswfakr.jpeg?q=70', 'desc' => 'Ultra HD (4K) LED Smart TV', 'rating' => 4.7, 'reviews' => 3400],
    7 => ['id' => 7, 'name' => 'SAMSUNG 163 cm (65 inch) QLED', 'price' => 89990, 'original_price' => 134900, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/television/m/v/5/-original-imahknwwnvwb7gtb.jpeg?q=70', 'desc' => 'Ultra HD (4K) Smart TV', 'rating' => 4.6, 'reviews' => 1850],
    8 => ['id' => 8, 'name' => 'LG 139 cm (55 inch) OLED', 'price' => 84990, 'original_price' => 119990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/television/u/z/z/-original-imahksjy3hpbdu4v.jpeg?q=70', 'desc' => 'Ultra HD (4K) Smart WebOS TV', 'rating' => 4.8, 'reviews' => 920],
    9 => ['id' => 9, 'name' => 'Hisense 85E7Q 215 cm (85 inch) QLED', 'price' => 119880, 'original_price' => 249999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/television/j/3/5/-original-imahjf6ypgx2f9sy.jpeg?q=70', 'desc' => 'Hisense 85E7Q 215 cm (85 inch) QLED Ultra HD (4K) Smart VIDAA TV with Dolby Vision Atmos, 120 High Refresh Rate, AI 4K Upscaler (85E7Q)', 'rating' => 4.8, 'reviews' => 920],
    10 => ['id' => 10, 'name' => 'Apple Watch Series 9', 'price' => 13999, 'original_price' => 29990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/smart-watch/w/w/i/-original-imagrdefbw6bhbjr.jpeg?q=70', 'desc' => 'Apple Watch Series 9', 'rating' => 4.3, 'reviews' => 6320],
    11 => ['id' => 11, 'name' => 'SAMSUNG Galaxy Watch 6', 'price' => 24990, 'original_price' => 29990, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/3/m/v/-original-imahagdjcnqhapfu.jpeg?q=70', 'desc' => 'SAMSUNG Galaxy Watch 6 Premium Android Watch', 'rating' => 5, 'reviews' => 9587],
    12 => ['id' => 12, 'name' => 'Fire-Boltt Invincible', 'price' => 2499, 'original_price' => 3499, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/p/1/s/-original-imahh6z2apwbmuqn.jpeg?q=70', 'desc' => 'Fire-Boltt Invincible 1.43" AMOLED Display', 'rating' => 3.8, 'reviews' => 1120],
    13 => ['id' => 13, 'name' => 'Noise ColorFit Pro 4', 'price' => 2999, 'original_price' => 3499, 'image' => 'https://rukminim2.flixcart.com/image/612/612/l2z26q80/smartwatch/w/0/l/43-688-wrb-sw-colorfitpro4-std-slvr-gry-android-ios-noise-yes-original-image6yxqtzhahjx.jpeg?q=70', 'desc' => 'Noise ColorFit Pro 4 Bluetooth Calling Watch', 'rating' => 4.2, 'reviews' => 2250],
    14 => ['id' => 14, 'name' => 'boAt Wave Call', 'price' => 1499, 'original_price' => 2499, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/smartwatch/m/n/v/42-9-wave-call-android-ios-boat-yes-original-imagz5hjvvhchfx7.jpeg?q=70', 'desc' => 'boAt Wave Call Water and Dust Resistant', 'rating' => 4.5, 'reviews' => 5324],

    //mobiles
    15 => ['id' => 15, 'name' => 'Apple iPhone 15 (Black)', 'price' => 79900, 'original_price' => 89900, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/h/d/9/-original-imagtc2qzgnnuhxh.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.5, 'reviews' => 2546],
    16 => ['id' => 16, 'name' => 'Samsung Galaxy S23 FE 5G', 'price' => 39999, 'original_price' => 60900, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/p/w/p/-original-imah4zp8tfzndmmh.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 3.5, 'reviews' => 2345],
    17 => ['id' => 17, 'name' => 'Google Pixel 7a (Charcoal)', 'price' => 43999, 'original_price' => 49999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/e/y/n/pixel-8a-ga04432-in-google-original-imahyn3mqzdbzywg.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.6, 'reviews' => 9586],
    18 => ['id' => 18, 'name' => 'OnePlus 11R 5G', 'price' => 39999, 'original_price' => 44999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/d/c/i/11r-5g-cph2487-oneplus-original-imahhnrhh7cudya6.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.3, 'reviews' => 2145],
    19 => ['id' => 19, 'name' => 'Nothing Phone (2)', 'price' => 44999, 'original_price' => 49999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/u/m/b/-original-imagrdefbw6bhbjr.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.4, 'reviews' => 1987],
    20 => ['id' => 20, 'name' => 'Motorola Edge 40', 'price' => 29999, 'original_price' => 34999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/b/q/6/edge-40-pay40028in-motorola-original-imagpqzdnhrgvhj7.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.2, 'reviews' => 1654],
    21 => ['id' => 21, 'name' => 'Vivo V29 5G', 'price' => 32999, 'original_price' => 36999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/5/e/x/v29-5g-v2250-vivo-original-imagtyqfjag4qbdw.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.1, 'reviews' => 1345],
    22 => ['id' => 22, 'name' => 'OPPO Reno10 5G', 'price' => 32999, 'original_price' => 37999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/3/u/w/-original-imagtcrvzrqnnxpc.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.0, 'reviews' => 1543],
    23 => ['id' => 23, 'name' => 'Realme 11 Pro 5G', 'price' => 23999, 'original_price' => 26999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/2/z/4/-original-imagqxx2haehpjnf.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.2, 'reviews' => 2432],
    24 => ['id' => 24, 'name' => 'POCO F5 5G', 'price' => 29999, 'original_price' => 33999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/k/s/8/f5-5g-mzb0epnin-poco-original-imagpep3afhmezhb.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.4, 'reviews' => 2876],
    25 => ['id' => 25, 'name' => 'Xiaomi 13 Pro', 'price' => 79999, 'original_price' => 89999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/z/l/m/note-13-pro-5g-mzb0g42inin-mzb0g42in-redmi-original-imah4e97g4agtgut.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.5, 'reviews' => 987],

    26 => ['id' => 26, 'name' => 'Samsung Galaxy Z Fold5', 'price' => 154999, 'original_price' => 164999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/y/g/l/-original-imagztmghzuhz7kf.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.6, 'reviews' => 765],
    27 => ['id' => 27, 'name' => 'Apple iPhone 14 Plus', 'price' => 79999, 'original_price' => 89999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/l/v/8/-original-imaghx9qudmydgc4.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.7, 'reviews' => 3456],
    28 => ['id' => 28, 'name' => 'Iqoo Neo 7 Pro', 'price' => 34999, 'original_price' => 38999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/6/m/e/neo-7-pro-i2217-iqoo-original-imagrhs69jx3g2sy.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.3, 'reviews' => 1789],
    29 => ['id' => 29, 'name' => 'Realme Narzo 60x 5G', 'price' => 12499, 'original_price' => 14999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/t/s/y/narzo-60-5g-rmx3750-realme-original-imagrht2yzyc2jyj.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.0, 'reviews' => 3456],
    30 => ['id' => 30, 'name' => 'Motorola G84 5G', 'price' => 18999, 'original_price' => 21999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/7/2/y/g84-5g-paym0017in-motorola-original-imagsyd2hzd63rr7.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.2, 'reviews' => 1567],
    31 => ['id' => 31, 'name' => 'Infinix Zero 30 5G', 'price' => 23999, 'original_price' => 26999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/p/2/k/chandrayaan-3-x6731-isro-original-imagsycut4rx7ztp.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.1, 'reviews' => 987],
    32 => ['id' => 32, 'name' => 'Lava Agni 2 5G', 'price' => 21999, 'original_price' => 24999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/2/o/j/agni-2-lxx504-lava-original-imahgpp3ywmyzmys.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.0, 'reviews' => 876],
    33 => ['id' => 33, 'name' => 'Redmi Note 12 Pro', 'price' => 24999, 'original_price' => 28999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/m/j/o/-original-imaghkvue4yjecju.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.2, 'reviews' => 2123],
    34 => ['id' => 34, 'name' => 'Tecno Pova 5 Pro', 'price' => 14999, 'original_price' => 17999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/q/k/b/pova-5-pro-5g-lh8n-tecno-original-imah27t3g9wgxzy7.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 3.9, 'reviews' => 765],
    35 => ['id' => 35, 'name' => 'Samsung Galaxy A54', 'price' => 38999, 'original_price' => 42999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/t/h/6/-original-imagnrhk2jpnnajr.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.3, 'reviews' => 1654],
    36 => ['id' => 36, 'name' => 'OnePlus Nord CE 3', 'price' => 26999, 'original_price' => 29999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/p/r/b/nord-ce-3-lite-5g-ce2099-oneplus-original-imagzj42cctpjjze.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.1, 'reviews' => 1432],
    37 => ['id' => 37, 'name' => 'Vivo T2 Pro 5G', 'price' => 23999, 'original_price' => 26999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/g/b/x/-original-imagtt4h4ptmxgwn.jpeg?q=70', 'desc' => '128 GB ROM', 'rating' => 4.2, 'reviews' => 987],
    38 => ['id' => 38, 'name' => 'Oppo F23 5G', 'price' => 24999, 'original_price' => 28999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/8/3/h/f23-5g-cph2527-oppo-original-imagsn7ga5cbzhpx.jpeg?q=70', 'desc' => '256 GB ROM', 'rating' => 4.0, 'reviews' => 654],
    39 => ['id' => 39, 'name' => 'Realme C53', 'price' => 9999, 'original_price' => 11999, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/mobile/5/q/6/-original-imags487ftf3g2s7.jpeg?q=70', 'desc' => '64 GB ROM', 'rating' => 3.8, 'reviews' => 2345],
    40 => ['id' => 40, 'name' => 'Motorola g57 Power', 'price' => 13999, 'original_price' => 17999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/36e488546c97ab15.jpg?q=80', 'desc' => '8GB RAM/128GB ROM', 'rating' => 3.8, 'reviews' => 2345],
    41 => ['id' => 41, 'name' => 'Nothing Phone 3a', 'price' => 22999, 'original_price' => 25999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/184bc5fded583b58.jpg?q=80', 'desc' => '64 GB ROM', 'rating' => 3.8, 'reviews' => 2345],
    42 => ['id' => 42, 'name' => 'Vivo T4R', 'price' => 19999, 'original_price' => 22999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/0731e50ff81b23ed.jpg?q=80', 'desc' => '64 GB ROM Curved Display', 'rating' => 3.8, 'reviews' => 2345],
    43 => ['id' => 43, 'name' => 'Realme P4 Power', 'price' => 24999, 'original_price' => 27999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/3b0f6e8f5b909fd9.jpg?q=80', 'desc' => '64 GB ROM 10000mAh Battery', 'rating' => 3.8, 'reviews' => 2345],
    44 => ['id' => 44, 'name' => 'Nothiing Phone 4a', 'price' => 27999, 'original_price' => 29999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/373c4f61d862cf42.png?q=80', 'desc' => '64 GB ROM 70 megapixel Zoom', 'rating' => 3.8, 'reviews' => 2345],
    45 => ['id' => 45, 'name' => 'Redami Note 14 SE', 'price' => 14999, 'original_price' => 17999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/081ce0307ed48951.jpg?q=80', 'desc' => '64 GB ROM 120Hz Refresh Rate', 'rating' => 3.8, 'reviews' => 2345],
    46 => ['id' => 46, 'name' => 'Motorola edge70 Fusion', 'price' => 27999, 'original_price' => 29999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/fe7c99d717aea9a6.png?q=80', 'desc' => '64 GB ROM 7000mAh Silicon Battery ', 'rating' => 3.8, 'reviews' => 2345],
    47 => ['id' => 47, 'name' => 'Vivo T4X 5G', 'price' => 14999, 'original_price' => 17999, 'image' => 'https://rukminim1.flixcart.com/fk-p-flap/1580/770/image/2858eec69ccd127d.png?q=80', 'desc' => '64 GB ROM best segment', 'rating' => 3.8, 'reviews' => 2345],


    //laptops
    50 => ['id' => 50, 'name' => 'Apple MacBook Air M2', 'price' => 114900, 'original_price' => 124900, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/2/v/v/-original-imagfdeqter4sj2j.jpeg?q=70', 'desc' => '8GB RAM/256GB SSD/Mac OS M2', 'rating' => 4.6, 'reviews' => 325],
    51 => ['id' => 51, 'name' => 'Lenovo IdeaPad Slim 3', 'price' => 34990, 'original_price' => 39990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/3/s/q/ideapad-slim-3-lenovo-original-imagz9g2r5hzqkzf.jpeg?q=70', 'desc' => '8GB RAM/512GB SSD/Windows 11', 'rating' => 4.2, 'reviews' => 1456],
    52 => ['id' => 52, 'name' => 'ASUS Vivobook 15', 'price' => 44990, 'original_price' => 49990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/z/j/r/vivobook-15-asus-original-imagz7u9hzv6txgj.jpeg?q=70', 'desc' => '16GB RAM/512GB SSD/Windows 11', 'rating' => 4.3, 'reviews' => 1789],
    53 => ['id' => 53, 'name' => 'HP Pavilion 14', 'price' => 62490, 'original_price' => 69990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/u/0/m/hp-pavilion-14-original-imagz9g6f4v5h8sz.jpeg?q=70', 'desc' => '16GB RAM/512GB SSD/Windows 11', 'rating' => 4.4, 'reviews' => 954],
    54 => ['id' => 54, 'name' => 'Acer Aspire 5', 'price' => 54990, 'original_price' => 59990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/w/l/m/acer-aspire-5-original-imagz6xtcz6gqzpq.jpeg?q=70', 'desc' => '16GB RAM/512GB SSD/Windows 11', 'rating' => 4.2, 'reviews' => 875],
    55 => ['id' => 55, 'name' => 'Dell Inspiron 15', 'price' => 47990, 'original_price' => 52990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/8/b/w/dell-inspiron-15-original-imagz7xqdzfywhbn.jpeg?q=70', 'desc' => '8GB RAM/512GB SSD/Windows 11', 'rating' => 4.1, 'reviews' => 1123],
    56 => ['id' => 56, 'name' => 'MSI Modern 14', 'price' => 39990, 'original_price' => 44990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/x/k/p/msi-modern-14-original-imagz8gqhhqvgrkz.jpeg?q=70', 'desc' => '8GB RAM/512GB SSD/Windows 11', 'rating' => 4.0, 'reviews' => 643],
    57 => ['id' => 57, 'name' => 'Apple MacBook Pro M3', 'price' => 169900, 'original_price' => 179900, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/v/p/f/apple-macbook-pro-m3-original-imagz9cghygh8m6f.jpeg?q=70', 'desc' => '8GB RAM/512GB SSD/Mac OS', 'rating' => 4.7, 'reviews' => 456],
    58 => ['id' => 58, 'name' => 'HP Victus Gaming', 'price' => 59990, 'original_price' => 64990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/r/p/p/hp-victus-original-imagz8t4wphh9qg2.jpeg?q=70', 'desc' => '16GB RAM/512GB SSD/RTX 3050', 'rating' => 4.4, 'reviews' => 1356],
    59 => ['id' => 59, 'name' => 'Acer Predator Helios', 'price' => 109990, 'original_price' => 119990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/m/9/w/acer-predator-helios-original-imagz8zg8thkzjzh.jpeg?q=70', 'desc' => '16GB RAM/1TB SSD/RTX 4060', 'rating' => 4.6, 'reviews' => 756],
    60 => ['id' => 60, 'name' => 'Lenovo Legion 5', 'price' => 124990, 'original_price' => 134990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/q/h/x/lenovo-legion-5-original-imagz9gn5w5zgfcz.jpeg?q=70', 'desc' => '16GB RAM/1TB SSD/RTX 4060', 'rating' => 4.6, 'reviews' => 643],
    61 => ['id' => 61, 'name' => 'ASUS ROG Strix', 'price' => 149990, 'original_price' => 159990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/y/j/3/asus-rog-strix-original-imagz9gxu2k9hhpb.jpeg?q=70', 'desc' => '16GB RAM/1TB SSD/RTX 4070', 'rating' => 4.7, 'reviews' => 542],
    62 => ['id' => 62, 'name' => 'Dell Alienware m16', 'price' => 259990, 'original_price' => 269990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/e/b/g/dell-alienware-m16-original-imagz9j5q9hbgmsp.jpeg?q=70', 'desc' => '32GB RAM/1TB SSD/RTX 4080', 'rating' => 4.8, 'reviews' => 321],
    63 => ['id' => 63, 'name' => 'HP Omen 16', 'price' => 114990, 'original_price' => 124990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/f/y/j/hp-omen-16-original-imagz9j2gghh9f9b.jpeg?q=70', 'desc' => '16GB RAM/1TB SSD/RTX 4060', 'rating' => 4.5, 'reviews' => 498],
    64 => ['id' => 64, 'name' => 'Microsoft Surface Laptop 5', 'price' => 94990, 'original_price' => 104990, 'image' => 'https://rukminim2.flixcart.com/image/312/312/xif0q/computer/j/j/z/microsoft-surface-laptop-5-original-imagz8tf3gxv9n2n.jpeg?q=70', 'desc' => '8GB RAM/256GB SSD/Windows 11', 'rating' => 4.3, 'reviews' => 276],
    // 111 to 115 fashion products
    111 => ['id' => 111, 'name' => 'Men s Printed T-Shirt', 'price' => 499, 'original_price' => 899, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/t-shirt/x/o/v/xl-black-ngu-2-drifth-original-imahh922dancaf7g.jpeg?q=70', 'desc' => '100% Cotton', 'rating' => 4, 'reviews' => 1059],

    112 => ['id' => 112, 'name' => 'Men s Loose Fit Jeans', 'price' => 899, 'original_price' => 1199, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/t-shirt/x/o/v/xl-black-ngu-2-drifth-original-imahh922dancaf7g.jpeg?q=70', 'desc' => 'Premium Denim', 'rating' => 4.1, 'reviews' => 1675],

    113 => ['id' => 113, 'name' => 'Red Tape Sneakers', 'price' => 1299, 'original_price' => 1599, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/t-shirt/x/o/v/xl-black-ngu-2-drifth-original-imahh922dancaf7g.jpeg?q=70', 'desc' => 'Comfortable & stylish', 'rating' => 4.6, 'reviews' => 2368],

    114 => ['id' => 114, 'name' => 'Men s Winter Jacket', 'price' => 1599, 'original_price' => 1799, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/t-shirt/x/o/v/xl-black-ngu-2-drifth-original-imahh922dancaf7g.jpeg?q=70', 'desc' => 'Windproof & warm', 'rating' => 3.2, 'reviews' => 5841],

    115 => ['id' => 115, 'name' => 'Fastrack Wayfarer', 'price' => 799, 'original_price' => 899, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/t-shirt/x/o/v/xl-black-ngu-2-drifth-original-imahh922dancaf7g.jpeg?q=70', 'desc' => '100% UV Protection', 'rating' => 2, 'reviews' => 1259],
    //116 => ['id' => 116, 'name' => 'Fastrack Wayfarer', 'price' => 0, 'original_price' => 0, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1620/790/image/9f9bfeab466aed2c.png?q=80', 'desc' => 'Safari trolley bag', 'rating' => 2, 'reviews' => 1259],

    // 65 to 84 books products
    65 => ['id' => 65, 'name' => 'Valmiki Ramayan', 'price' => 199, 'original_price' => 299, 'image' => 'https://rukminim2.flixcart.com/image/1860/1860/xif0q/book/j/h/d/-original-imahgwhequjjwy2g.jpeg?q=90', 'desc' => 'Religious Book', 'rating' => 4.5, 'reviews' => 2543],

    66 => ['id' => 66, 'name' => 'Bhagavad Gita', 'price' => 149, 'original_price' => 249, 'image' => 'https://rukminim2.flixcart.com/image/1860/1860/xif0q/shopsy-regionalbooks/e/g/k/2019-2019-bhaktivedant-book-trust-hardcover-hindi-bhagwat-gita-original-imahhhhjhwgmzagz.jpeg?q=90', 'desc' => 'Spiritual Book', 'rating' => 4.6, 'reviews' => 3241],

    67 => ['id' => 67, 'name' => 'Sampurna Chanakya Niti', 'price' => 129, 'original_price' => 199, 'image' => 'https://rukminim2.flixcart.com/image/1860/1860/l071d3k0/book/7/5/z/sampurna-chanakya-niti-original-imagcf5qjcpjsemz.jpeg?q=90', 'desc' => 'Motivational Book', 'rating' => 4.3, 'reviews' => 1892],

    68 => ['id' => 68, 'name' => 'Hindi Story Book', 'price' => 99, 'original_price' => 149, 'image' => 'https://rukminim2.flixcart.com/image/1860/1860/xif0q/book/p/l/h/-original-imahjx48tnufhpfh.jpeg?q=90', 'desc' => 'Educational Book', 'rating' => 4.1, 'reviews' => 874],

    69 => ['id' => 69, 'name' => 'Regional Hindi Book', 'price' => 119, 'original_price' => 179, 'image' => 'https://rukminim2.flixcart.com/image/1860/1860/xif0q/regionalbooks/z/i/m/-original-imahkkgrgwntayvy.jpeg?q=90', 'desc' => 'Literature Book', 'rating' => 4.2, 'reviews' => 932],

    70 => ['id' => 70, 'name' => 'General English', 'price' => 249, 'original_price' => 399, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/book/k/8/q/general-english-completely-revised-new-edition-original-imah63hyyncavhhe.jpeg?q=70', 'desc' => 'Competitive Exam Book', 'rating' => 4.4, 'reviews' => 2145],

    71 => ['id' => 71, 'name' => 'Computer Aptitude', 'price' => 199, 'original_price' => 299, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/book/z/g/6/computer-aptitude-for-banking-and-insurance-english-printed-original-imahaeyaeqyzyvuz.jpeg?q=70', 'desc' => 'Banking Exam Book', 'rating' => 4.3, 'reviews' => 1567],

    72 => ['id' => 72, 'name' => 'How to Crack UPSC', 'price' => 299, 'original_price' => 449, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/book/o/o/r/how-to-crack-upsc-civil-services-examination-original-imahgz5qpytpjjfp.jpeg?q=70', 'desc' => 'UPSC Preparation Book', 'rating' => 4.5, 'reviews' => 3124],

    73 => ['id' => 73, 'name' => 'Modern India History', 'price' => 279, 'original_price' => 399, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/book/v/c/k/a-brief-history-of-modern-india-original-imahfhrar9hyjfw9.jpeg?q=70', 'desc' => 'History Book', 'rating' => 4.6, 'reviews' => 2875],

    74 => ['id' => 74, 'name' => 'Computer General Knowledge', 'price' => 199, 'original_price' => 299, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/book/w/g/q/computer-general-knowledge-useful-for-upsc-ugc-net-sbi-bank-po-original-imah9rw2efydnvyx.jpeg?q=70', 'desc' => 'GK Book', 'rating' => 4.2, 'reviews' => 1342],

    75 => ['id' => 75, 'name' => 'MBA Entrance Guide', 'price' => 349, 'original_price' => 499, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/book/w/i/o/mba-entrance-exam-guide-original-imah52cb5hzszt7g.jpeg?q=70', 'desc' => 'MBA Preparation Book', 'rating' => 4.4, 'reviews' => 1654],

    76 => ['id' => 76, 'name' => 'Bharat Ka Itihas', 'price' => 299, 'original_price' => 399, 'image' => 'https://rukminim2.flixcart.com/image/612/612/book/6/1/4/bharat-ka-itihas-csat-state-pcs-nda-cds-net-set-ctet-bank-po-original-imae2e8bjhjzhzg7.jpeg?q=70', 'desc' => 'Indian History Book', 'rating' => 4.3, 'reviews' => 1211],

    77 => ['id' => 77, 'name' => 'Science & Technology', 'price' => 269, 'original_price' => 349, 'image' => 'https://rukminim2.flixcart.com/image/612/612/jm0wscw0/book/6/1/4/science-and-technology-civil-services-prelims-and-main-original-imaf9f24g2rcckf3.jpeg?q=70', 'desc' => 'Civil Service Book', 'rating' => 4.5, 'reviews' => 2412],

    79 => ['id' => 79, 'name' => 'Samanya Gyan', 'price' => 179, 'original_price' => 249, 'image' => 'https://rukminim2.flixcart.com/image/612/612/jpcxrww0/book/5/9/6/samanya-gyan-digdarshan-2019-hindi-general-studies-2019-original-imafbgx5e5wsfy5u.jpeg?q=70', 'desc' => 'General Knowledge Book', 'rating' => 4.2, 'reviews' => 956],

    80 => ['id' => 80, 'name' => 'Bhagavad Gita Gujarati', 'price' => 199, 'original_price' => 299, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/regionalbooks/b/h/a/bhagavad-gita-yatharoop-gujarati-hardcover-free-japa-mala-and-original-imahew4h38abzus7.jpeg?q=70', 'desc' => 'Religious Book Gujarati', 'rating' => 4.7, 'reviews' => 1789],
    81 => ['id' => 81, 'name' => 'Shikshak Abhiyogyata 2025', 'price' => 249, 'original_price' => 349, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/book/g/n/l/shikshak-abhiyogyata-2025-original-imahe2fqdugmxxzj.jpeg?q=70', 'desc' => 'Teaching Exam Book', 'rating' => 4.3, 'reviews' => 1123],
    82 => ['id' => 82, 'name' => 'Books', 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1620/790/image/750e4f449589c018.jpg?q=80', 'desc' => '50% off'],
    83 => ['id' => 83, 'name' => 'Books', 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1620/790/image/7d976bb94f429c59.jpg?q=80', 'desc' => 'Up to 70% off'],
    84 => ['id' => 84, 'name' => 'Books', 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1620/790/image/4f0c22503194c20c.jpg?q=80', 'desc' => '50% off'],

    //85 to 124 headphones
    85 => ['id' => 85, 'name' => 'boAt Airdopes 141', 'price' => 1299, 'original_price' => 1599, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/d/m/v/-original-imahgmgzncxzepne.jpeg?q=70', 'desc' => 'True Wireless Earbuds', 'rating' => 4.3, 'reviews' => 1542],
    86 => ['id' => 86, 'name' => 'OnePlus Nord Buds 2', 'price' => 2999, 'original_price' => 3299, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/t/t/3/true-wireless-earbuds-nord-2-ce-mobile-earbuds-with-mic-2r-12-original-imahhvpywhenk3z8.jpeg?q=70', 'desc' => 'True Wireless Earbuds', 'rating' => 4.4, 'reviews' => 1321],
    87 => ['id' => 87, 'name' => 'Realme Buds Air 3', 'price' => 1999, 'original_price' => 2499, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/n/o/q/-original-imahfg7sywfpzths.jpeg?q=70', 'desc' => 'True Wireless Earbuds', 'rating' => 4.2, 'reviews' => 985],
    88 => ['id' => 88, 'name' => 'Apple AirPods Pro', 'price' => 24900, 'original_price' => 26900, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/e/a/f/-original-imagtc44nk4b3hfg.jpeg?q=70', 'desc' => 'Premium Earbuds', 'rating' => 4.7, 'reviews' => 756],
    89 => ['id' => 89, 'name' => 'Samsung Galaxy Buds2', 'price' => 17999, 'original_price' => 19999, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/m/2/f/buds2pro-black-aaradhy-enterprises-original-imahjrffg9gcmka4.jpeg?q=70', 'desc' => 'Premium Earbuds', 'rating' => 4.5, 'reviews' => 654],
    90 => ['id' => 90, 'name' => 'JBL Wave 200TWS', 'price' => 2499, 'original_price' => 2999, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/q/b/a/-original-imahbabu4cgvupzh.jpeg?q=70', 'desc' => 'True Wireless Earbuds', 'rating' => 4.3, 'reviews' => 845],
    91 => ['id' => 91, 'name' => 'Nothing Buds 2', 'price' => 6990, 'original_price' => 7990, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/t/e/e/-original-imahhucjvstk8txh.jpeg?q=70', 'desc' => 'True Wireless Earbuds', 'rating' => 4.4, 'reviews' => 532],
    92 => ['id' => 92, 'name' => 'OnePlus Bullets Z2', 'price' => 1999, 'original_price' => 2299, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/i/p/4/e305a-e305b-oneplus-original-imahe6hbbfhhtycy.jpeg?q=70', 'desc' => 'Bluetooth Neckband', 'rating' => 4.2, 'reviews' => 976],
    93 => ['id' => 93, 'name' => 'boAt Rockerz 255', 'price' => 1499, 'original_price' => 1999, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/u/l/z/-original-imahgnf4hm7kvf6b.jpeg?q=70', 'desc' => 'Bluetooth Neckband', 'rating' => 4.1, 'reviews' => 1432],
    94 => ['id' => 94, 'name' => 'Realme Buds Wireless', 'price' => 1299, 'original_price' => 1599, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/f/k/h/-original-imahyy62vg5r3wue.jpeg?q=70', 'desc' => 'Bluetooth Neckband', 'rating' => 4.2, 'reviews' => 865],
    95 => ['id' => 95, 'name' => 'Sony WI-C100', 'price' => 1699, 'original_price' => 1999, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/b/q/k/-original-imagrufzqwuctzv9.jpeg?q=70', 'desc' => 'Bluetooth Neckband', 'rating' => 4.3, 'reviews' => 432],
    96 => ['id' => 96, 'name' => 'OPPO Enco M32', 'price' => 1799, 'original_price' => 2199, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/g/c/c/-original-imahej2rtfkgktza.jpeg?q=70', 'desc' => 'Bluetooth Neckband', 'rating' => 4.2, 'reviews' => 567],
    97 => ['id' => 97, 'name' => 'Noise Tune Active', 'price' => 1199, 'original_price' => 1499, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/shopsy-headphone/s/t/m/bluetooth-wired-yes-z3-bluetooth-neckband-upto-52-hours-playtime-original-imahhb8cff6eufhg.jpeg?q=70', 'desc' => 'Bluetooth Neckband', 'rating' => 4.0, 'reviews' => 321],
    98 => ['id' => 98, 'name' => 'Sony WH-1000XM5', 'price' => 29990, 'original_price' => 32990, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/v/d/g/-original-imahgr295uvptwq7.jpeg?q=70', 'desc' => 'Over-Ear Headphones', 'rating' => 4.8, 'reviews' => 210],
    99 => ['id' => 99, 'name' => 'boAt Rockerz 450', 'price' => 1499, 'original_price' => 1999, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/6/v/p/-original-imaheznnsjryzba2.jpeg?q=70', 'desc' => 'On-Ear Headphones', 'rating' => 4.1, 'reviews' => 754],
    100 => ['id' => 100, 'name' => 'JBL Tune 510BT', 'price' => 2999, 'original_price' => 3499, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/r/0/r/-original-imahhrt7fgarcwzc.jpeg?q=70', 'desc' => 'On-Ear Headphones', 'rating' => 4.3, 'reviews' => 542],
    121 => ['id' => 121, 'name' => 'Sennheiser HD 450BT', 'price' => 7490, 'original_price' => 8990, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/t/1/m/pro-c-oneodio-original-imahhptukzdz5jty.jpeg?q=70', 'desc' => 'Over-Ear Headphones', 'rating' => 4.5, 'reviews' => 234],
    122 => ['id' => 122, 'name' => 'Skullcandy Hesh ANC', 'price' => 10999, 'original_price' => 12999, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/x/b/q/-original-imah97hjfgdzcawa.jpeg?q=70', 'desc' => 'Over-Ear Headphones', 'rating' => 4.4, 'reviews' => 198],
    123 => ['id' => 123, 'name' => 'Philips Upbeat', 'price' => 1199, 'original_price' => 1499, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/l/9/l/-original-imah4u2fbuuvgggu.jpeg?q=70', 'desc' => 'On-Ear Headphones', 'rating' => 4.0, 'reviews' => 456],
    124 => ['id' => 124, 'name' => 'Zebronics Zeb-Thunder', 'price' => 699, 'original_price' => 999, 'image' => 'https://rukminim2.flixcart.com/image/612/612/xif0q/headphone/a/o/6/zeb-thunder-pro-zebronics-original-imagyg8yhq3qy4un.jpeg?q=70', 'desc' => 'On-Ear Headphones', 'rating' => 3.9, 'reviews' => 678],


    // 125 to 131 home
    125 => ['id' => 125, 'name' => 'Water Bottle', 'price' => 199, 'original_price' => 299, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1670/2520/image/304acf4a1f1a7768.jpg?q=80', 'desc' => 'Cold Water Bottle', 'rating' => 4.2, 'reviews' => 321],
    126 => ['id' => 126, 'name' => 'Door Curtain', 'price' => 299, 'original_price' => 399, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1670/2520/image/e3e56374158f565b.jpg?q=80', 'desc' => 'Home Appliances', 'rating' => 4.1, 'reviews' => 245],
    127 => ['id' => 128, 'name' => 'Mosquito Net', 'price' => 319, 'original_price' => 399, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1670/2520/image/db2e0848e22e408d.jpg?q=80', 'desc' => 'Mosquito Net', 'rating' => 4.0, 'reviews' => 198],
    128 => ['id' => 129, 'name' => 'Dryer Stand', 'price' => 999, 'original_price' => 1299, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1670/2520/image/c818ac5e2e6f4855.jpg?q=80', 'desc' => 'Clothes Dryer Stand', 'rating' => 4.3, 'reviews' => 432],
    129 => ['id' => 130, 'name' => 'Door Locks', 'price' => 499, 'original_price' => 699, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1670/2520/image/fa72c688263c56c6.jpg?q=80', 'desc' => 'Heavy Door Lock', 'rating' => 4.2, 'reviews' => 276],
    130 => ['id' => 131, 'name' => 'Power Tool', 'price' => 1299, 'original_price' => 1599, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1670/2520/image/15a3847c157990f3.jpg?q=80', 'desc' => 'Power Tool Box', 'rating' => 4.4, 'reviews' => 189],
    131 => ['id' => 132, 'name' => 'Extension Board', 'price' => 329, 'original_price' => 499, 'image' => 'https://rukminim2.flixcart.com/fk-p-flap/1670/2520/image/15994633b50b2fa5.jpg?q=80', 'desc' => 'Extension Board 500W', 'rating' => 4.1, 'reviews' => 354],
];

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
if (!isset($products[$product_id])) {
    $product_id = 1;
}
$product = $products[$product_id];

if (basename($_SERVER['SCRIPT_FILENAME']) !== 'products.php') {
    return;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecomm | Product Details</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link rel="stylesheet" href="flipkart_style.css">
    <link rel="stylesheet" href="products_style.css">
</head>

<body class="hold-transition layout-top-nav" style="display: flex; flex-direction: column; min-height: 100vh;">
    <div class="wrapper" style="flex: 1; display: flex; flex-direction: column;">
        <nav class="main-header navbar navbar-expand-md navbar-light sticky-top">
            <div class="container" style="max-width: 1800px;">
                <a href="index.php" class="navbar-brand brand-logo">
                    <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg"
                        alt="Flipkart" height="40" style="margin-right: 20px;">
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
                    <li class="nav-item ml-4 d-none d-md-block">
                        <a href="cart.php" class="nav-link" style="color: #000; font-weight: 500;"><i
                                class="fas fa-shopping-cart mr-2" style="font-size: 20px;"></i> Cart</a>
                    </li>
                    <li class="nav-item ml-4 d-none d-lg-block">
                        <a href="#" class="nav-link" style="color: #000; font-weight: 500;"><i class="fas fa-store mr-2"
                                style="font-size: 20px;"></i> Become a Seller</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content-wrapper" style="background-color: #fff; padding: 20px 0; flex: 1;">
            <div class="container" style="max-width: 1800px;">
                <div class="row bg-white p-3">

                    <!-- Left Column: Image & Buttons -->
                    <div class="col-md-5">
                        <div class="product-image-container mb-3" style="border: 1px solid #f0f0f0;">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" class="product-main-image"
                                alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <div
                                style="position: absolute; top: 10px; right: 10px; width: 36px; height: 36px; border-radius: 50%; border: 1px solid #f0f0f0; background: #fff; display: flex; align-items: center; justify-content: center; color: #c2c2c2; cursor: pointer; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1);">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <form method="POST" style="flex: 1; display: flex;">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="product_name"
                                    value="<?php echo htmlspecialchars($product['name']); ?>">
                                <input type="hidden" name="product_image"
                                    value="<?php echo htmlspecialchars($product['image']); ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-add-cart w-100">
                                    <i class="fas fa-shopping-cart mr-2"></i> ADD TO CART
                                </button>
                            </form>
                            <button class="btn btn-buy-now">
                                <i class="fas fa-bolt mr-2"></i> BUY NOW
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: Details -->
                    <div class="col-md-7 pl-md-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-2" style="font-size: 12px; color: #878787;">
                                <li class="breadcrumb-item"><a href="index.php" style="color: #878787;">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </li>
                            </ol>
                        </nav>

                        <h1 class="product-title m-0"><?php echo htmlspecialchars($product['name']); ?></h1>

                        <div class="mt-2 d-flex align-items-center gap-3">
                            <span class="rating-badge">
                                <?php echo $product['rating']; ?> <i class="fas fa-star"
                                    style="font-size: 10px; margin-left: 3px;"></i>
                            </span>
                            <span style="color: #878787; font-size: 14px; margin-left: 10px; font-weight: 500;">
                                <?php echo number_format($product['reviews']); ?> Ratings & Reviews
                            </span>
                            <img src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/fa_62673a.png"
                                height="21" class="ml-3">
                        </div>

                        <div style="color: #388e3c; font-size: 14px; font-weight: 500; margin-top: 15px;">Extra
                            <?php echo number_format($product['original_price'] - $product['price']); ?> off
                        </div>

                        <?php
                        $discount = round((($product['original_price'] - $product['price']) / $product['original_price']) * 100);
                        ?>
                        <div class="price-section">
                            <span class="current-price">₹<?php echo number_format($product['price']); ?></span>
                            <span
                                class="original-price">₹<?php echo number_format($product['original_price']); ?></span>
                            <span class="discount-pct"><?php echo $discount; ?>% off</span>
                        </div>

                        <div class="mt-4">
                            <div style="font-size: 16px; font-weight: 500; margin-bottom: 12px;">Available offers</div>
                            <ul class="offers-list">
                                <li>
                                    <i class="fas fa-tag"></i>
                                    <span><strong>Bank Offer</strong> 5% Cashback on Flipkart Axis Bank Card <a href="#"
                                            style="color: #2874f0; text-decoration: none;">T&C</a></span>
                                </li>
                                <li>
                                    <i class="fas fa-tag"></i>
                                    <span><strong>Special Price</strong> Get extra discount (price inclusive of
                                        cashback/coupon) <a href="#"
                                            style="color: #2874f0; text-decoration: none;">T&C</a></span>
                                </li>
                                <li>
                                    <i class="fas fa-tag"></i>
                                    <span><strong>Partner Offer</strong> Sign up for Flipkart Pay Later and get Flipkart
                                        Gift Card worth up to ₹500* <a href="#"
                                            style="color: #2874f0; text-decoration: none;">Know More</a></span>
                                </li>
                            </ul>
                        </div>

                        <div class="row mt-4 pt-3" style="border-top: 1px solid #f0f0f0;">
                            <div class="col-3" style="color: #878787; font-size: 14px;">Highlights</div>
                            <div class="col-9">
                                <ul style="padding-left: 15px; font-size: 14px; line-height: 1.8;">
                                    <li><?php echo htmlspecialchars($product['desc']); ?></li>
                                    <li>1 Year Warranty for Phone and 6 Months Warranty for In-Box Accessories</li>
                                    <li>7 Days Replacement Policy</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-3" style="color: #878787; font-size: 14px;">Seller</div>
                            <div class="col-9">
                                <div style="color: #2874f0; font-size: 14px; font-weight: 500;">RetailNet</div>
                                <ul style="padding-left: 15px; font-size: 14px; line-height: 1.8; margin-top: 5px;">
                                    <li>14 day return policy</li>
                                    <li>GST invoice available</li>
                                </ul>
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
