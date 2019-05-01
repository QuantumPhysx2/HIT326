<?php 
// Call script using current directory
require __DIR__."../assets/scripts/config.php"; 

// Initiate a session
// session_start();

// Initialize variables to empty
$username = $password = $confirmPassword = "";
$usernameErr = $passwordErr = $confirmPasswordErr = "";

// Declare boolean for incorrect registration entered
$falseRegistration = false;

// If the server receives a POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If the Username input box is empty...
    if (empty(trim($_POST["inp_USERNAME"]))) {
        // ...return an error message
        $usernameErr = "<p class='errorMessage'>[PHP] ".__LINE__.": Username is Absent: Please enter a Username</p>";
    } else {
        // ...otherwise if provided, execute following code
        // Set our query
        $query = "SELECT ID 
                  FROM user 
                  WHERE Username=:inp_USERNAME";
        // Prepare the query
        if ($stmt = $conn->prepare($query)) {
            // Bind variable to the prepared statement as parameters
            $stmt->bindParam(":inp_USERNAME", $paramUsername, PDO::PARAM_STR);
            // Set Username parameter
            $paramUsername = trim($_POST["inp_USERNAME"]);

            // Attempt to execute prepared statement
            if ($stmt->execute()) {
                // If there is a matching username in the table...
                if ($stmt->rowCount() == 1) {
                    // ...Return an error
                    // ERROR: Should only occur if the same username is provided
                    $usernameErr = "<p class='errorMessage'>[PHP] ".__LINE__.": Username Error: Username already taken</p>";
                } else {
                    // Strip whitespaces from BEGINNING and END of given input
                    // Set the Username to the given value
                    $username = trim($_POST["inp_USERNAME"]);
                }
            } else {
                // Should only occur if there was a connection to database error
                echo "<p class='errorMessage'>[PHP] ".__LINE__.": Login Error: Something went wrong. Please try again</p>";
            }
        }
        // Destroy and reset $stmt variable for re-use
        unset($stmt);
    }

    // If the Password input box is empty...
    if (empty(trim($_POST["inp_PASSWORD"]))) {
        // ...return error message
        $passwordErr = "<p class='errorMessage'>[PHP]".__LINE__.": Please enter a Password</p>";
    } elseif (strlen(trim($_POST["inp_PASSWORD"])) < 8) {
        // ...if Password is less than 8 characters long
        $passwordErr = "<p class='errorMessage'>[PHP] ".__LINE__.": Password Not Long Enough: Password must be at least 8 characters long</p>";
    } else {
        // ...otherwise, set Password to the given input
        $password = trim($_POST["inp_PASSWORD"]);
    }

    // If the Confirm Password input box is empty...
    if (empty(trim($_POST["inp_CONFIRMPASSWORD"]))) {
        // Should'nt occur because of 'required' in each input
        $confirmPasswordErr = "<p class='errorMessage'>[PHP] ".__LINE__.": Password Error: Missing confirmed password. Please try again</p>";
    } else {
        $confirmPassword = trim($_POST["inp_CONFIRMPASSWORD"]);
        
        // If there is an empty password AND password doesn't match confirmation password...
        if (empty($passwordErr) && ($password != $confirmPassword)) {
            // ...return an error message
            $confirmPasswordErr = "<p class='errorMessage'>[PHP] ".__LINE__.": Mis-matching Password: Password did not match</p>";
        }
    }

    // If there are no errors found in the inputs...
    if (empty($usernameErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        // ...execute the following lines to insert into the database
        $query = "INSERT INTO user (Username, Password)
                  VALUES (:inp_USERNAME, :inp_PASSWORD)";
        
        if ($stmt = $conn->prepare($query)) {
            // ...bind statement with Username and Password and represent as SQL character
            $stmt->bindParam(":inp_USERNAME", $paramUsername, PDO::PARAM_STR);
            $stmt->bindParam(":inp_PASSWORD", $paramPassword, PDO::PARAM_STR);

            // Set Username parameter to given Username input value
            $paramUsername = $username;
            // Set Password parameter to a hashed Password input value
            $paramPassword = password_hash($password, PASSWORD_DEFAULT);

            // Attempt to execute prepared statement
            if ($stmt->execute()) {
                // ...Return this file on success
                header("location: index.php");
            } else {
                echo "<p class='errorMessage'>[PHP] ".__LINE__.": Something bizarre happened. Please try again";
            }
        }
        unset($stmt);
    }
    // Set this trigger to true if there was an incorrect login registration
    $falseRegistration = True;
    // Destroy the connection on fail
    unset($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="HIT326">
        <meta name="description" content="HIT326">
        <meta name="keywords" content="Products">
        <meta name="theme-color" content="#222">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" href="assets/images/page-icon.ico">
        <title>Home | PC Buy Here</title>
    </head>

    <body>
        <header>
            <div class="navigation">
                <div class="jumbo-1">
                    <a class="home" href="index.php"><img src="assets/images/page-logo.png" alt="PC Buy Here"></a>
                </div>
                <div class="jumbo-2">
                    <!-- Refer to: https://www.w3schools.com/icons/fontawesome_icons_webapp.asp -->
                    <a class="nav-child" href="index.php"><i class="fa fa-cart-plus" title="Marketplace"></i></a>
                    <a class="nav-child" href="#"><i class="fa fa-bell-o" title="Icon 2"></i></a>
                    <a class="nav-child" href="#"><i class="fa fa-bell-o" title="Icon 3"></i></a>
                    <a class="nav-child" href="#"><i class="fa fa-bell-o" title="Icon 4"></i></a>
                    <a class="nav-child" href="#"><i class="fa fa-bell-o" title="Icon 5"></i></a>
                    <a class="nav-child" href="login.php"><i class="fa fa-user" title="Login"></i></a>
                </div>
            </div>
        </header>

        <main>
            <div class="container">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <input type="text" name="inp_USERNAME" placeholder="Username" required>
                    <input type="password" name="inp_PASSWORD" placeholder="Password" required>
                    <input type="password" name="inp_CONFIRMPASSWORD" placeholder="Confirm Password" required>
                    <button type="submit" name="inp_REGISTER" id="register-button">Register</button>
                </form>
                
                <div class="result">
                    <?php if ($falseRegistration): ?>
                        <?php echo $usernameErr; ?>
                        <?php echo $passwordErr; ?>
                        <?php echo $confirmPasswordErr; ?>
                    <?php else: ?>
                        <h1>Some stuff here</h1>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <footer></footer>
        
        <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>