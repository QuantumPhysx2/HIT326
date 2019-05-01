<?php 
// Call script using current directory
require __DIR__."../assets/scripts/config.php"; 

// Initiate a session
// session_start();

// Initialize variables to empty
$username = $password = $confirmPassword = "";
$usernameErr = $passwordErr = $confirmPasswordErr = "";

// Declare boolean for incorrect registration entered
$isLoggedIn = false;

// If User has a stored Cookie session...
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // ...Return this block scope
    header("location: welcome.php");
    // ...Terminate this block scope
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Both Username and Password checking shouldn't occur because of 'required'
    // Check if Username is empty...
    if (empty(trim($_POST["inp_USERNAME"]))) {
        // ...Return an error
        $usernameErr = "<p class='errorMessage'>[PHP] ".__LINE__.": Please enter a Username</p>";
    } else {
        // ...Save to database
        $username = trim($_POST["inp_USERNAME"]);
    }

    // Check if Password is empty...
    if (empty(trim($_POST["inp_PASSWORD"]))) {
        // ...Return an error
        $passwordErr = "<p class='errorMessage'>[PHP] ".__LINE__.": Please enter a Password</p>";
    } else {
        // ...Save to database
        $password = trim($_POST["inp_PASSWORD"]);
    }

    // If there is no error with Username or Password...
    if (empty($usernameErr) && empty($passwordErr)) {
        // ...Prepare our query into the database where the Username matches a Username from the database
        $query = "SELECT *
                  FROM user
                  WHERE Username = :inp_USERNAME";
        if ($stmt = $conn->prepare($query)) {
            // Bind the Statement using a placeholder
            $stmt->bindParam(":inp_USERNAME", $paramUsername, PDO::PARAM_STR);
            $paramUsername = trim($_POST["inp_USERNAME"]);

            // Attempt to execute the Statement...
            if ($stmt->execute()) {
                // ...If there is a matching Username...
                if ($stmt->rowCount() == 1) {
                    // ...Check if the associated column values match the user input
                    if ($row = $stmt->fetch()) {
                        // ...Associate the ID, Username and Password with the provided inputs
                        $id = $row["ID"];
                        $username = $row["Username"];
                        $hashedPassword = $row["Password"];
                        // Call the password_verify() function giving the string as hash as parameters
                        if (password_verify($password, $hashedPassword)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["ID"] = $id;
                            $_SESSION["Username"] = $Username;

                            $isLoggedIn = true;

                            header("location: welcome.php");                            
                        } else {
                            // Should only occur if the password is incorrect
                            $passwordErr = "<p class='errorMessage'>[PHP] ".__LINE__.": The password does not match. Please try again</p>";
                        }
                    } else {
                        // This error shouldn't occur
                        $usernameErr = "<p class='errorMessage'>[PHP] ".__LINE__.": The username does not match. Please try again</p>";
                    }
                } else {
                    echo "<p class='errorMessage'>[PHP] ".__LINE__.": Incorrect username or password. Please try again</p>";
                }
            }
        }
        // Close the Statement
        unset($stmt);
    }
    // Close the PDO connection
    unset($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="BLACKBIRD Technology">
        <meta name="description" content="BLACKBIRD Technology">
        <meta name="keywords" content="Products">
        <meta name="theme-color" content="#0e0e0e">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" href="assets/images/page-icon.ico">
        <title>Login | PC Buy Here</title>
    </head>

    <body>
        <header>
            <div class="navigation">
                <div class="jumbo-1">
                    <a class="home" href="index.php"><img src="assets/images/page-logo.png" alt="PC Buy Here"></a>
                </div>
                <div class="jumbo-2">
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
                <div class="result">
                    <?php if ($isLoggedIn): ?>
                        <h1>Create an Account</h1>
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <input type="text" name="inp_USERNAME" placeholder="Username" required>
                            <input type="password" name="inp_PASSWORD" placeholder="Password" required>
                            <button type="submit" name="inp_LOGIN" id="login-button">Login</button>
                        </form>
                    <?php else: ?>
                        <?php echo $usernameErr; ?>
                        <?php echo $passwordErr; ?>
                        <?php echo $confirmPasswordErr; ?>
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