<?php
session_start();
include "../db.php";

if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit();
}

$categories = [
    "fashion",
    "mobiles",
    "books",
    "electronics",
    "headphone",
    "home",
    "appliances",
    "toys & games",
    "food & health",
    "auto accessories",
    "2-wheeler",
    "sports",
    "beauty",
    "furniture"
];

$product = [
    "product_name" => "",
    "category" => "",
    "price" => "",
    "description" => "",
    "image_url" => "",
    "stock" => "",
    "status" => ""
];

$edit_id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$is_edit_mode = false;

if ($edit_id > 0) {
    $select = "SELECT * FROM products WHERE id = $edit_id";
    $result = mysqli_query($conn, $select);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $is_edit_mode = true;
    }
}

if (isset($_POST["add_product"])) {
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $category = mysqli_real_escape_string($conn, $_POST["category"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $image_url = mysqli_real_escape_string($conn, $_POST["image_url"]);
    $stock = mysqli_real_escape_string($conn, $_POST["stock"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    $query = "INSERT INTO products (product_name, category, price, description, image_url, stock, status)
              VALUES ('$product_name', '$category', '$price', '$description', '$image_url', '$stock', '$status')";
    $data = mysqli_query($conn, $query);

    if ($data) {
        echo "<script>alert('Product added successfully.'); window.location.href='view_product.php';</script>";
        exit();
    } else {
        echo "ERROR " . mysqli_error($conn);
    }
}

if (isset($_POST["update_product"])) {
    $update_id = (int) $_POST["id"];
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $category = mysqli_real_escape_string($conn, $_POST["category"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $image_url = mysqli_real_escape_string($conn, $_POST["image_url"]);
    $stock = mysqli_real_escape_string($conn, $_POST["stock"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    $query = "UPDATE products
              SET product_name = '$product_name',
                  category = '$category',
                  price = '$price',
                  description = '$description',
                  image_url = '$image_url',
                  stock = '$stock',
                  status = '$status'
              WHERE id = $update_id";
    $data = mysqli_query($conn, $query);

    if ($data) {
        echo "<script>alert('Product updated successfully.'); window.location.href='view_product.php';</script>";
        exit();
    } else {
        echo "ERROR " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
                <a href="manage_items.php" style=" color: #2874f0;
                    text-decoration: none;
                    background-color: rgb(229, 233, 255);
                    border: 2px solid #2874f0;
                    transform: translateX(8px);
                    box-shadow: 0 10px 18px rgba(40, 116, 240, 0.16);">Manage Product</a>
                <a href="view_product.php">View Product</a>
                <a href="../index.php">View Store</a>
                <a href="orders.php">Orders</a>
                <a href="customers.php">Customers</a>
                <a class="log" href="logout.php">Logout</a>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="sh">
                <h2>Manage Products</h2>
                <p>
                    <?php echo $is_edit_mode ? "Edit the selected product details below." : "This is the manage products page. You can add new products from here."; ?>
                </p>
            </div>
            <div class="tab">
                <form action="" method="post">
                    <?php if ($is_edit_mode) { ?>
                        <input type="hidden" name="id" value="<?php echo (int) $product["id"]; ?>">
                    <?php } ?>

                    <h3><?php echo $is_edit_mode ? "Edit Product" : "Add New Product"; ?></h3>

                    <div class="form-grid">
                        <input type="text" name="product_name" placeholder="Product Name"
                            value="<?php echo htmlspecialchars($product["product_name"]); ?>" required>

                        <select name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo htmlspecialchars($category); ?>"
                                    <?php echo $product["category"] === $category ? "selected" : ""; ?>>
                                    <?php echo htmlspecialchars(ucwords($category)); ?>
                                </option>
                            <?php } ?>
                        </select>

                        <input type="text" name="price" placeholder="Product Price"
                            value="<?php echo htmlspecialchars($product["price"]); ?>" required>

                        <input type="text" name="description" placeholder="Product Description"
                            value="<?php echo htmlspecialchars($product["description"]); ?>" required>

                        <input type="text" name="image_url" placeholder="Product Image URL"
                            value="<?php echo htmlspecialchars($product["image_url"]); ?>" required>

                        <input type="text" name="stock" placeholder="Product Stock"
                            value="<?php echo htmlspecialchars($product["stock"]); ?>" required>

                        <select name="status" required>
                            <option value="">Select Status</option>
                            <option value="active" <?php echo $product["status"] === "active" ? "selected" : ""; ?>>Active</option>
                            <option value="inactive" <?php echo $product["status"] === "inactive" ? "selected" : ""; ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <?php if ($is_edit_mode) { ?>
                            <input type="submit" name="update_product" value="Update Product">
                            <a href="manage_items.php" class="btn btn-primary btn-sm">Cancel</a>
                        <?php } else { ?>
                            <input type="submit" name="add_product" value="Add Product">
                            <input type="reset" value="Clear" class="btn btn-primary btn-sm">
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
