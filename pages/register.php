<?php
// Initiate session token
session_start();

// Main connection script
require __DIR__."../../assets/php/db.php";

// !!! Section done by Gia Tran !!!
// Initialize variables to empty
$username = $password = $confirmPassword = "";
$usernameErr = $passwordErr = $confirmPasswordErr = "";

$falseRegistration = false;

// If request method is a POST...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- Username ---
    // Setting up username input error checking
    if (empty(trim($_POST["username"]))) {
        // ...return an error message 
        $usernameErr = "<p id='err-message'>".__LINE__." Username is empty. Please try again</p>";
    } else {
        // Set our query using placeholders in WHERE condition
        $query = "SELECT ID 
                  FROM user 
                  WHERE Username=:username";
        // Define our statement to the preparation of the query
        $stmt = $conn->prepare($query);
        if ($stmt) {
            // Bind parameter to variable as an SQL string data type
            $stmt->bindParam(":username", $paramUsername, PDO::PARAM_STR);
            $paramUsername = trim($_POST["username"]);

            if ($stmt->execute()) {
                // If we find a row with the same username...
                if ($stmt->rowCount() == 1) {
                    // ...return an error
                    // Should only occur if the same username is found in the database
                    $usernameErr = "<p id='err-message>".__LINE__." Username is already taken. Please try again</p>";
                } else {
                    // ...return a success
                    // Eliminate whitespaces from the username input on POST
                    $username = trim($_POST["username"]);
                }
            } else {
                // ...return line number with error message
                // This shouldn't occur 
                echo "<p id='err-message'>".__LINE__." Something went wrong. Please try again</p>";
            }
        }
        // Destroy and reset the statement for re-use in this block scope
        unset($stmt);
    }

    // --- Password ---
    // Setting up password input error checking
    if (empty(trim($_POST["password"]))) {
        // ...return error if password input is empty
        $passwordErr = "<p id='err-message'>".__LINE__." Please enter a password</p>";
    } else if (strlen(trim($_POST["password"])) < 8) {
        // ...return error if the trimmed password is less than 8 characters long
        $passwordErr = "<p id='err-message'>".__LINE__." Password needs to be longer than 8 characters long. Please try again</p>";
    } else {
        // ...set password to the trimmed version of password input
        $password = trim($_POST["password"]);
    }

    // Setting up confirm password input checking
    if (empty(trim($_POST["confirmpassword"]))) {
        // ...return error if passwords do not match
        $confirmPasswordErr = "<p id='err-message'>".__LINE__." Passwords do not match. Please try again</p>";
    } else {
        // ...return a success
        $confirmPassword = trim($_POST["confirmpassword"]);

        // If we receive an empty password and passwords do not match...
        if (empty($passwordErr) && ($password != $confirmPassword)) {
            // ...return an error
            $confirmPasswordErr = "<p id='err-message'>".__LINE__." Passwords do not match. Please try again</p>";
        }
    }

    // If we receive no errors from the username, password or confirm password...
    if (empty($usernameErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        // ...set our query to insert the values into the database
        $query = "INSERT INTO user (Username, Password)
                  VALUES (:username, :password)";
        $stmt = $conn->prepare($query);

        // Repeat same process using same logic in the username error checking
        if ($stmt) {
            // ...bind statement with the username and password 
            $stmt->bindParam(":username", $paramUsername, PDO::PARAM_STR);
            $stmt->bindParam(":password", $paramPassword, PDO::PARAM_STR);

            // Set username parameter to the given username
            $paramUsername = $username;
            // Set password to the hashed value of password using the Bcrypt hashing method
            $paramPassword = password_hash($password, PASSWORD_BCRYPT);

            // If the statement calls the execute method successfully...
            if ($stmt->execute()) {
                // ...return user to the same page
                header("location: register.php");
            } else {
                // ...otherwise, return error
                echo "<p id='err-message'>".__LINE__." Insertion to database failed. Check the configurations</p>";
            }
        }
        // Destroy and reset the $stmt variable for re-use in this block scope
        unset($stmt);
    }
    $falseRegistration = true;
    // Destroy and reset the connection to the 'user' database if left connected
    unset($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Gia, Matthew, Chi-Yin">
    <meta name="description" content="PC Buy Here">
    <meta name="keywords" content="HIT326">
    <meta name="theme-color" content="#222">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../assets/images/page-icon.ico">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Register | PC Buy Here</title>
  </head>

  <body id="productsPage">
    <header>
      <div class="admin-options">
        <ul>
          <a href="register.php"><i class="fa fa-user-circle" id="active" title="Login"></i></a>
          <a href="#"><i class="fa fa-shopping-cart" title="Shopping Cart"></i></a>
          <a href="#"><i class="fa fa-bookmark" title="Wishlist"></i></a>
          <a href="#"><i class="fa fa-cogs" title="Settings"></i></a>
          <a href="#"><i class="fa fa-sign-out" title="Logout"></i></a>
        </ul>
      </div>

      <div class="top-header">
        <span class="open-slider">
          <a class="open-slider-icon">
            <svg>
              <path d="M0,5 30,5"></path>
              <path d="M0,14 30,14"></path>
              <path d="M0,23 30,23"></path>
            </svg>
          </a>
        </span>
        <h1><a href="../index.php"><img src="../assets/images/page-logo.png" alt="Page Logo.jpg" class="logo"></a></h1>
      </div>
      
      <div class="bottom-header">
        <ul class="navigation">
          <li><a href="../index.php">Home</a></li>
          <li><a href="product.php">Main Products</a></li>
          <li><a href="#">Payment Information</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>

      <div class="mobile-nav">
        <a href="../index.php"><i class="fa fa-home"></i></a>
        <a href="product.php" id="active"><i class="fa fa-dollar"></i></a>
        <a href="#"><i class="fa fa-user-circle-o"></i></a>
        <a href="#"><i class="fa fa-question-circle-o"></i></a>
      </div>
    </header>
  
    <main>
      <div id="backdrop"></div>
      <div class="sidenav">
        <span class="close-slider-icon">&times;</span>
        <h1>PC Buy Here</h1>
        <div class="sidenav-section-2">
          <a href="#">PCCG Gaming PCs</a>
          <a href="#">Barebone / NUC</a>
          <a href="#">Cables</a>
          <a href="#">Cameras</a>
          <a href="#">Card Readers</a>
          <a href="#">Cases</a>
          <a href="#">Cooling</a>
          <a href="#">CPUs</a>
          <a href="#">Fans & Accessories</a>
          <a href="#">Flash Memory</a>
          <a href="#">Gaming Chairs</a>
          <a href="#">Gaming Peripherals</a>
          <a href="#">Gaming Cards</a>
          <a href="#">Hard Drives & SSDs</a>
          <a href="#">Headphones & Mics</a>
          <a href="#">Home Media</a>
          <a href="#">Keyboards</a>
          <a href="#">Laptops</a>
          <a href="#">LED Lighting</a>
          <a href="#">Memory</a>
          <a href="#">Merchandise</a>
          <a href="#">Mice & Mouse Pads</a>
          <a href="#">Monitors</a>
          <a href="#">Motherboards</a>
          <a href="#">NAS</a>
          <a href="#">Networking</a>
          <a href="#">Optical Drives & Media</a>
          <a href="#">Phone Accessories</a>
          <a href="#">Power Supplies</a>
          <a href="#">Services</a>
          <a href="#">Software</a>
          <a href="#">Sound Cards</a>
          <a href="#">Speakers</a>
          <a href="#">Tools & Screws</a>
          <a href="#">USB Devices & Cards</a>
          <a href="#">USB Flash Drives</a>
          <a href="#">Video Capture</a>
          <a href="#">Virtual Reality</a>
          <a href="#">Clearance</a>
        </div>
      </div>

      <div class="container">
        <h1 class="key-header">Register</h1>
        <!-- <div class="wrapper"></div> -->
        <div class="wrapper">
            <div class="register-form">
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="INPusername">Username:</label>
                    <input type="text" name="username" id="INPusername" required>

                    <label for="INPpassword">Password:</label>
                    <input type="password" name="password" id="INPpassword" required>

                    <label for="INPpassword">Confirm Password:</label>
                    <input type="password" name="confirmpassword" id="INPconfirmpassword" required>

                    <!-- <label for="INPcheckbox"><input type="checkbox" name="checkbox" id="INPcheckbox">Remember me</label> -->
                    <button type="submit" id="submit">Register</button>
                </form>

                <?php if ($falseRegistration): ?>
                    <div class="error">
                        <?php echo $usernameErr; ?>
                        <?php echo $passwordErr; ?>
                        <?php echo $confirmPasswordErr; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
      <div class="top-footer">
        <div class="left-footer">
          <h1>Products</h1>
          <ul>
            <li><a href="#">New Products</a></li>
            <li><a href="#">Systems</a></li>
            <li><a href="#">Brands</a></li>
            <li><a href="#">Bundles</a></li>
            <li><a href="#">Clearance</a></li>
          </ul>
        </div>
        <div class="center-footer-1">
          <h1>My Account</h1>
          <ul>
            <li><a href="#">My Dashboard</a></li>
            <li><a href="#">Order History</a></li>
            <li><a href="#">Warranty</a></li>
            <li><a href="#">Wishlist</a></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </div>
        <div class="center-footer-2">
          <h1>Social Media</h1>
          <ul>
            <li><a href="#"><i class="fa fa-facebook"></i>Facebook</a></li>
            <li><a href="#"><i class="fa fa-twitter"></i>Twitter</a></li>
            <li><a href="#"><i class="fa fa-google"></i>Google+</a></li>
            <li><a href="#"><i class="fa fa-pinterest"></i>Pinterest</a></li>
          </ul>
        </div>
        <div class="center-footer-3">
          <h1>Help & Contact</h1>
          <ul>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Frequently Asked Questions</a></li>
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </div>
        <div class="right-footer">
          <h1>Trading Hours</h1>
          <ul>
            <li>Mon - Fri: 8:00AM - 5:00PM</li>
            <li>Sat - Sun: Closed</li>
          </ul>
        </div>
      </div>

      <div class="middle-footer">
        <h1>Our Registered Partners:</h1>
        <div class="gimp">
          <!-- PLACE PLACEHOLDER <img> CONTENT HERE 
          <div class="registerd-partner">
            <a href="#"><img src="../assets/images/.png" alt="icn_registered"></a>
          </div>
          -->
        </div>
      </div>

      <div class="bottom-footer">
        <p class="copyright-text">Copyright © 2019 PC Buy Here. All rights reserved</p>
        <p class="ownership-text">Developed by Gia, Matthew and Chi-Yin</p>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/gestures.js"></script>
  </body>
</html>

