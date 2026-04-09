<?php
session_start();
include 'db.php';

$prices = [1111 => 139000, 101 => 13999, 102 => 17999, 103 => 13999, 104 => 249, 105 => 11999, 106 => 299, 107 => 139999, 108 => 31999, 109 => 0, 110 => 0, 1 => 65999, 2 => 129999, 3 => 39999, 4 => 75999, 5 => 139999, 666 => 54990, 6 => 54990, 7 => 89990, 8 => 84990, 9 => 119880, 10 => 13999, 11 => 24990, 12 => 2499, 13 => 2999, 14 => 1499, 15 => 79900, 16 => 39999, 17 => 43999, 18 => 39999, 19 => 44999, 20 => 29999, 21 => 32999, 22 => 32999, 23 => 23999, 24 => 29999, 25 => 79999, 26 => 154999, 27 => 79999, 28 => 34999, 29 => 12499, 30 => 18999, 31 => 23999, 32 => 21999, 33 => 24999, 34 => 14999, 35 => 38999, 36 => 26999, 37 => 23999, 38 => 24999, 39 => 9999, 40 => 13999, 41 => 22999, 42 => 19999, 43 => 24999, 44 => 27999, 45 => 14999, 46 => 27999, 47 => 14999, 50 => 114900, 51 => 34990, 52 => 44990, 53 => 62490, 54 => 54990, 55 => 47990, 56 => 39990, 57 => 169900, 58 => 59990, 59 => 109990, 60 => 124990, 61 => 149990, 62 => 259990, 63 => 114990, 64 => 94990, 111 => 499, 112 => 899, 113 => 1299, 114 => 1599, 115 => 799, 65 => 199, 66 => 149, 67 => 129, 68 => 99, 69 => 119, 70 => 249, 71 => 199, 72 => 299, 73 => 279, 74 => 199, 75 => 349, 76 => 299, 77 => 269, 79 => 179, 80 => 199, 81 => 249, 85 => 1299, 86 => 2999, 87 => 1999, 88 => 24900, 89 => 17999, 90 => 2499, 91 => 6990, 92 => 1999, 93 => 1499, 94 => 1299, 95 => 1699, 96 => 1799, 97 => 1199, 98 => 29990, 99 => 1499, 100 => 2999, 121 => 7490, 122 => 10999, 123 => 1199, 124 => 699, 125 => 199, 126 => 299, 127 => 319, 128 => 999, 129 => 499, 130 => 1299, 131 => 329];
$total = 0;
$user_id = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;
$total_items = 0;
if (isset($_SESSION['add_to_cart'])) {
    foreach ($_SESSION['add_to_cart'] as $product_id => $product) {
        $price = isset($prices[$product_id]) ? $prices[$product_id] : 0;
        $total += $price * $product['quantity'];
        $total_items += $product['quantity'];
    }
}

if (isset($_POST['payment'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $cart_number = isset($_POST['cart_number']) ? $_POST['cart_number'] : '';
    $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : 'CARD';
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    $discount = $total - $discount_amount;

    $sql = "INSERT INTO payment (user_id, email, cart_number, cvv, password) VALUES ('$user_id', '$email', '$cart_number', '$cvv', '$password')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Add items to my_orders
        if (isset($_SESSION['add_to_cart']) && is_array($_SESSION['add_to_cart'])) {
            foreach ($_SESSION['add_to_cart'] as $pid => $product) {
                $product_id = (int)$pid;
                $quantity = isset($product['quantity']) ? (int)$product['quantity'] : 1;
                $price = isset($prices[$product_id]) ? $prices[$product_id] : 0;
                $product_name = mysqli_real_escape_string($conn, $product['product_name']);
                $product_image = mysqli_real_escape_string($conn, $product['product_image']);
                // $product_price = mysqli_real_escape_string($conn, $product['product_price']);
                $order_sql = "INSERT INTO my_orders (user_id, product_id, quantity, price, product_name, product_image) VALUES ('$user_id', '$product_id', '$quantity', '$price', '$product_name', '$product_image')";
                mysqli_query($conn, $order_sql);
            }
        }

        // Clear cart logged in
        if (isset($_SESSION['id'])) {
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");
        }
        if (isset($_SESSION['add_to_cart'])) {
            unset($_SESSION['add_to_cart']);
        }
        echo "<script>alert('Order Placed! Check My Orders!'); window.location.href='my_orders.php';</script>";
        exit();
    } else {
        echo "<script>alert('Payment failed. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flipkart Payment</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="flipkart_style.css">
    <link rel="stylesheet" href="payment_style.css">
</head>

<body>

    <div class="payment-header" style="background-color: #d3d9e4ff;">
        <div class="container" style="max-width: 1248px; display: flex; align-items: center;">
            <a href="index.php"><img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/fkheaderlogo_exploreplus-44005d.svg" alt="Flipkart"></a>
            <span style="font-size: 20px; font-style: italic; font-weight: 600; margin-left: 20px; color: #2874f0;">Secure Payment</span>
        </div>
    </div>

    <div class="container mt-4 mb-5" style="max-width: 1248px;">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <div class="step-container">
                    <div class="step-header">
                        <div class="step-number">1</div>
                        <div class="step-title">LOGIN <span style="margin-left:10px; text-transform:none; color:#212121; font-weight:600; font-size:14px;"><i class="fas fa-check" style="color:#2874f0;"></i> <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Guest'; ?></span></div>
                    </div>
                </div>

                <div class="step-container">
                    <div class="step-header">
                        <div class="step-number">2</div>
                        <div class="step-title"><a href="my_address.php" style="color: #212121;">DELIVERY ADDRESS</a> <span style="margin-left:10px; text-transform:none; color:#212121; font-weight:600; font-size:14px;"><i class="fas fa-check" style="color:#2874f0;"></i> Home -
                                <?php
                                $query = "SELECT name, address, city, state, pincode FROM addressone WHERE user_id='$user_id'";
                                $data = $conn->query($query);
                                if ($data && $data->num_rows > 0) {
                                    while ($row = $data->fetch_array()) {
                                        echo htmlspecialchars($row['name'] . ' ' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ' - ' . $row['pincode']);
                                    }
                                } else {
                                    echo "Please Add a Delivery Address";
                                }
                                ?>
                            </span></div>
                    </div>
                </div>

                <div class="step-container">
                    <div class="step-header">
                        <div class="step-number">3</div>
                        <div class="step-title">ORDER SUMMARY <span style="margin-left:10px; text-transform:none; color:#212121; font-weight:600; font-size:14px;"><i class="fas fa-check" style="color:#2874f0;"></i> <?php echo $total_items; ?> Item<?php echo $total_items > 1 ? 's' : ''; ?></span></div>
                    </div>
                </div>

                <div class="step-container step-active">
                    <div class="step-header">
                        <div class="step-number">4</div>
                        <div class="step-title">PAYMENT OPTIONS</div>
                    </div>

                    <div class="row m-0 border-top" style="border-color: #f0f0f0 !important;">
                        <div class="col-md-4 payment-tabs">
                            <div class="payment-tab-item active" id="tab-card" onclick="switchTab('card')">Credit / Debit / ATM Card</div>
                            <div class="payment-tab-item" id="tab-cod" onclick="switchTab('cod')">Cash on Delivery</div>
                        </div>

                        <div class="col-md-8 payment-content bg-white">
                            <!-- Card Payment Form -->
                            <div id="content-card">
                                <form action="payment.php" method="POST">
                                    <input type="hidden" name="payment_mode" value="CARD">
                                    <h5 class="mb-4" style="font-size: 16px; font-weight: 500;">Enter Card Details</h5>

                                    <input type="number" name="cart_number" class="fk-input" placeholder="**** **** 8514" required>

                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="fk-input" placeholder="Valid Thru (MM/YY)" required>
                                        </div>
                                        <div class="col-6">
                                            <input type="password" name="cvv" class="fk-input" placeholder="CVV" required>
                                        </div>
                                    </div>
                                    <input type="email" name="email" class="fk-input" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" placeholder="Email Address for Receipt" required>
                                    <input type="password" name="password" class="fk-input" placeholder="Account Password to Confirm" required>

                                    <button type="submit" name="payment" class="btn-pay mt-3 w-100">PAY ₹<?php echo number_format($total); ?></button>
                                </form>
                            </div>

                            <!-- COD Form -->
                            <div id="content-cod" style="display: none;">
                                <form action="payment.php" method="POST">
                                    <input type="hidden" name="payment_mode" value="COD">
                                    <input type="hidden" name="cart_number" value="COD">
                                    <input type="hidden" name="cvv" value="000">
                                    <input type="hidden" name="password" value="COD_ORDER">
                                    <input type="hidden" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'cod@order.com'; ?>">

                                    <div class="text-center mb-4">
                                        <i class="fas fa-money-bill-wave" style="font-size: 40px; color: #388e3c; margin-bottom: 15px;"></i>
                                        <h5 style="font-size: 16px; font-weight: 500;">Pay securely by cash on delivery</h5>
                                    </div>
                                    <p style="font-size: 14px; color: #878787; text-align: center; margin-bottom: 25px;">You can pay via Cash/UPI on delivery.</p>

                                    <button type="submit" name="payment" class="btn-pay w-100">CONFIRM ORDER</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Price Details -->
            <div class="col-lg-4">
                <div class="right-section">
                    <div class="price-details">
                        <div class="price-header">PRICE DETAILS</div>
                        <div class="price-row mt-2">
                            <span>Price (<?php echo $total_items; ?> item<?php echo $total_items > 1 ? 's' : ''; ?>)</span>
                            <span>₹<?php echo number_format($total); ?></span>
                        </div>
                        <div class="price-row">
                            <span>Discount</span>
                            <span style="color: #388e3c;">− ₹0</span>
                        </div>
                        <div class="price-row">
                            <span>Delivery Charges</span>
                            <span style="color: #388e3c;">Free</span>
                        </div>
                        <div class="price-total">
                            <span>Total Payable</span>
                            <span>₹<?php echo number_format($total); ?></span>
                        </div>
                    </div>
                    <div class="mt-3 p-3 bg-white" style="box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius: 2px;">
                        <span style="font-size: 14px; font-weight: 500; display:flex; align-items:center;">
                            <i class="fas fa-shield-alt mr-2" style="color: #878787; font-size: 18px;"></i>
                            Safe and Secure Payments. Easy returns. 100% Authentic products.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            document.getElementById('tab-card').classList.remove('active');
            document.getElementById('tab-cod').classList.remove('active');
            document.getElementById('content-card').style.display = 'none';
            document.getElementById('content-cod').style.display = 'none';

            document.getElementById('tab-' + tab).classList.add('active');
            document.getElementById('content-' + tab).style.display = 'block';
        }
    </script>
</body>

</html>