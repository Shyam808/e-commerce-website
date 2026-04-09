<?php
session_start();
include "../db.php";

$error = "";
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $query = "SELECT * FROM admin_users WHERE email='$email' AND password='$pass'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $_SESSION['email'] = $email;
        header("Location: admin_dashboard.php");
    } else {
        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin <?php echo $_SESSION['email']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">
    <div class="login-main">
        <div class="login-container">
            <form action="" method="post">
                <h2>Admin Login</h2>
                <?php if ($error): ?>
                    <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
                <?php endif; ?>
                <input type="email" name="email" placeholder="Enter Email"><br><br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>
                <input type="submit" name="submit" value="Login"><br><br>
            </form>
        </div>
    </div>
</body>

</html>