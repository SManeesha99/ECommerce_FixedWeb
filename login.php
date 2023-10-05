<?php
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["username"])) {
    header("location:index.php");
}

// Generate a CSRF token and store it in the session.
$csrfToken = bin2hex(random_bytes(32)); // Generate a random token
$_SESSION['csrf_token'] = $csrfToken;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify the CSRF token before processing the form submission.
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // CSRF token is valid; process the login form.
        $username = $_POST["username"];
        $password = $_POST["pwd"];
        $flag = 'true';

        // Your database query and user authentication logic here.

        if ($authenticated) {
            // User is authenticated; redirect to the desired page.
            $_SESSION['username'] = $username;
            header("location:index.php");
        } else {
            // Authentication failed.
            echo '<h1>Invalid Login! Redirecting...</h1>';
            header("Refresh: 3; url=index.php");
        }
    } else {
        // CSRF token is invalid; reject the request.
        echo 'CSRF Token Validation Failed.';
        // You may want to log this event for security monitoring.
    }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login || BOLT Sports Shop</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>

    <!-- Content Security Policy (CSP) Header -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'">

    <!-- X-Frame-Options Header -->
    <meta http-equiv="X-Frame-Options" content="DENY"> <!-- or use SAMEORIGIN if required -->

</head>
<body>

    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a href="index.php">BOLT Sports Shop</a></h1>
        </li>
        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
      </ul>

      <section class="top-bar-section">
      <!-- Right Nav Section -->
        <ul class="right">
          <li><a href="about.php">About</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="cart.php">View Cart</a></li>
          <li><a href="orders.php">My Orders</a></li>
          <li><a href="contact.php">Contact</a></li>
          <?php

          if(isset($_SESSION['username'])){
            echo '<li><a href="account.php">My Account</a></li>';
            echo '<li><a href="logout.php">Log Out</a></li>';
          }
          else{
            echo '<li class="active"><a href="login.php">Log In</a></li>';
            echo '<li><a href="register.php">Register</a></li>';
          }
          ?>
        </ul>
      </section>
    </nav>





    <form method="POST" action="verify.php" style="margin-top:30px;">

    <!-- add CSRF token to the form as a hidden field -->
    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
      
    <div class="row">
        <div class="small-8">

          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Email</label>
            </div>
            <div class="small-8 columns">
              <input type="email" id="right-label" placeholder="nayantronix@gmail.com" name="username">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Password</label>
            </div>
            <div class="small-8 columns">
              <input type="password" id="right-label" name="pwd">
            </div>
          </div>

          <div class="row">
            <div class="small-4 columns">

            </div>
            <div class="small-8 columns">
                <input type="submit" id="right-label" value="Login" style="background: #0078A0; border: none; color: #fff; font-family: 'Helvetica Neue', sans-serif; font-size: 1em; padding: 10px;">
                <input type="reset" id="right-label" value="Reset" style="background: #0078A0; border: none; color: #fff; font-family: 'Helvetica Neue', sans-serif; font-size: 1em; padding: 10px;">
            </div>
          </div>
        </div>
      </div>
    </form>


    <div class="row" style="margin-top:10px;">
      <div class="small-12">

      <footer>
    <p style="text-align:center; font-size:0.8em;">&copy; BOLT Sports Shop. All Rights Reserved.</p>
</footer>

<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>
</body>
</html>