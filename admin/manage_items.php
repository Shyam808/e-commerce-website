<?php
session_start();
include "../db.php";

if (!isset($_SESSION['email1'])) {
    header("Location: admin_login.php");
    exit();
}

$categories = [
    "For you",
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

$for_you_sections = [
    "for you - suggested for you" => "Suggested For You",
    "for you - top smart tvs" => "Top Smart TVs",
    "for you - watches" => "Watches"
];

$product = [
    "product_name" => "",
    "category" => "",
    "price" => "",
    "description" => "",
    "image_url" => "",
    "stock" => "",
    "status" => "",
    "source_product_id" => "",
    "for_you_section" => ""
];

$has_source_product_id = false;
$column_result = mysqli_query($conn, "SHOW COLUMNS FROM products LIKE 'source_product_id'");
if ($column_result && mysqli_num_rows($column_result) > 0) {
    $has_source_product_id = true;
}

$edit_id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$is_edit_mode = false;

if ($edit_id > 0) {
    $select = "SELECT * FROM products WHERE id = $edit_id";
    $result = mysqli_query($conn, $select);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $saved_category = strtolower(trim($product["category"]));
        if (isset($for_you_sections[$saved_category])) {
            $product["for_you_section"] = $saved_category;
            $product["category"] = "For you";
        }
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
    $source_product_id = isset($_POST["source_product_id"]) ? (int) $_POST["source_product_id"] : 0;
    $for_you_section = isset($_POST["for_you_section"]) ? strtolower(trim($_POST["for_you_section"])) : "";

    if (strtolower(trim($category)) === "for you") {
        $category = isset($for_you_sections[$for_you_section]) ? $for_you_section : "for you - suggested for you";
    }

    if ($has_source_product_id) {
        $source_product_value = $source_product_id > 0 ? $source_product_id : "NULL";
        $query = "INSERT INTO products (product_name, category, price, description, image_url, stock, status, source_product_id)
                  VALUES ('$product_name', '$category', '$price', '$description', '$image_url', '$stock', '$status', $source_product_value)";
    } else {
        $query = "INSERT INTO products (product_name, category, price, description, image_url, stock, status)
                  VALUES ('$product_name', '$category', '$price', '$description', '$image_url', '$stock', '$status')";
    }
    $data = mysqli_query($conn, $query);

    if ($data) {
        if ($has_source_product_id && $source_product_id <= 0) {
            $new_id = (int) mysqli_insert_id($conn);
            mysqli_query($conn, "UPDATE products SET source_product_id = $new_id WHERE id = $new_id");
        }
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
    $source_product_id = isset($_POST["source_product_id"]) ? (int) $_POST["source_product_id"] : 0;
    $for_you_section = isset($_POST["for_you_section"]) ? strtolower(trim($_POST["for_you_section"])) : "";

    if (strtolower(trim($category)) === "for you") {
        $category = isset($for_you_sections[$for_you_section]) ? $for_you_section : "for you - suggested for you";
    }

    $query = "UPDATE products
              SET product_name = '$product_name',
                  category = '$category',
                  price = '$price',
                  description = '$description',
                  image_url = '$image_url',
                  stock = '$stock',
                  status = '$status'";

    if ($has_source_product_id) {
        $source_product_value = $source_product_id > 0 ? $source_product_id : $update_id;
        $query .= ",
                  source_product_id = $source_product_value";
    }

    $query .= "
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
                        style="font-size: 20px;"></i><?php echo htmlspecialchars($_SESSION['email1']); ?></a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                    <li><a href="admin_dashboard.php" class="dropdown-item text-dark">Dashboard</a></li>
                    <li><a href="manage_items.php" class="dropdown-item text-dark" style="color:#2874f0 !important; font-weight:bold;">Manage products</a></li>
                    <li><a href="view_product.php" class="dropdown-item text-dark">View products</a></li>
                    <li><a href="orders.php" class="dropdown-item text-dark">Orders</a></li>
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
                    background-color: rgb(242, 242, 242);
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

                        <select name="category" id="category-select" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo htmlspecialchars($category); ?>"
                                    <?php echo $product["category"] === $category ? "selected" : ""; ?>>
                                    <?php echo htmlspecialchars(ucwords($category)); ?>
                                </option>
                            <?php } ?>
                        </select>

                        <div id="for-you-section-wrap" style="<?php echo $product["category"] === "For you" ? "" : "display: none;"; ?>">
                            <select name="for_you_section" id="for-you-section-select">
                                <option value="">Select For You Section</option>
                                <?php foreach ($for_you_sections as $section_value => $section_label) { ?>
                                    <option value="<?php echo htmlspecialchars($section_value); ?>"
                                        <?php echo $product["for_you_section"] === $section_value ? "selected" : ""; ?>>
                                        <?php echo htmlspecialchars($section_label); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <input type="text" name="price" placeholder="Product Price"
                            value="<?php echo htmlspecialchars($product["price"]); ?>" required>

                        <input type="text" name="description" placeholder="Product Description"
                            value="<?php echo htmlspecialchars($product["description"]); ?>" required>

                        <input type="text" name="image_url" placeholder="Product Image URL"
                            value="<?php echo htmlspecialchars($product["image_url"]); ?>" required>

                        <?php if ($has_source_product_id) { ?>
                            <input type="number" name="source_product_id" placeholder="Product Detail ID"
                                value="<?php echo htmlspecialchars((string) ($product["source_product_id"] ?: "")); ?>" min="1">
                        <?php } ?>

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
    <script>
        const categorySelect = document.getElementById('category-select');
        const forYouSectionWrap = document.getElementById('for-you-section-wrap');
        const forYouSectionSelect = document.getElementById('for-you-section-select');

        function toggleForYouSection() {
            const isForYou = categorySelect && categorySelect.value === 'For you';

            if (forYouSectionWrap) {
                forYouSectionWrap.style.display = isForYou ? '' : 'none';
            }

            if (!isForYou && forYouSectionSelect) {
                forYouSectionSelect.value = '';
            }
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', toggleForYouSection);
            toggleForYouSection();
        }
    </script>
</body>

</html>
