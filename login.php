<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login || MULD Online Shop</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <style>
        #login-container {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-top: 150px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-form label {
            font-weight: bold;
        }

        .login-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .login-buttons input[type="submit"] {
            background: #0078A0;
            border: none;
            color: #fff;
            font-family: 'Helvetica Neue', sans-serif;
            font-size: 1em;
            padding: 10px;
            margin-right: 10px;
            cursor: pointer;
        }
        .login-buttons input[type="reset"] {
            background: #FF0000;
            border: none;
            color: #fff;
            font-family: 'Helvetica Neue', sans-serif;
            font-size: 1em;
            padding: 10px;
            margin-right: 10px;
            cursor: pointer;
        }
    </style>
    <script src="js/vendor/modernizr.js"></script>

    <!-- Content Security Policy (CSP) Header -->
    <meta http-equiv="Content-Security-Policy">

    <!-- X-Frame-Options Header -->
    <meta http-equiv="X-Frame-Options" content="DENY"> <!-- or use SAMEORIGIN if required -->

</head>
<body>

    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a href="index.php">MULD Online Shop</a></h1>
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
    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
      <div class="row">
        <div class="small-8">

          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Email</label>
            </div>

            <form method="POST" action="verify.php">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <div class="row">
                    <div class="small-12 columns">
                        <label for="username">Email</label>
                        <input type="email" id="username" placeholder="example@gmail.com" name="username">
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter Password" name="pwd">
                    </div>
                </div>
                <div class="row login-buttons">
                    <div class="small-12 columns">
                        <input type="submit" value="Login">
                        <input type="reset" value="Reset">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top:150px;">
        <div class="small-12">
            <footer>
                <p style="text-align:center; font-size:0.8em;">&copy; MULD Online Shop || #2023.</p>
            </footer>
        </div>
    </div>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
        $(document).foundation();
    </script>
</body>
</html>
