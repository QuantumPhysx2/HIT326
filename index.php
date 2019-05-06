<?php
// Call script using current directory
require __DIR__."/assets/scripts/config.php";

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
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="icon" href="assets/images/page-icon.ico">
        <title>Home | PC Buy Here</title>
    </head>

    <body>
        <header>
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php"><i class="fas fa-desktop"></i> PC Buy Here</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav  mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="#"><i class="fa fa-cart-plus" title="Marketplace"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa fa-bell-o" title="Icon 2"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa fa-bell-o" title="Icon 3"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa fa-bell-o" title="Icon 4"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa fa-bell-o" title="Icon 5"></i></a>
                </li>
              </ul>
              <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                 <input class="form-control mr-sm-2" type="text" id="search" name="search" />
                 <select class="custom-select custom-select-sm mr-2" name="category">
                    <option value="">Choose catagory</option>
                    <option value="Graphics">GPU</option>
                    <option value="RAM">RAM</option>
                 </select>
                 <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            </div>
          </nav>
        </header>

        <main>
            <div class="container mt-4">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <input type="text" name="inp_USERNAME" placeholder="Username" required>
                    <input type="password" name="inp_PASSWORD" placeholder="Password" required>
                    <input type="password" name="inp_CONFIRMPASSWORD" placeholder="Confirm Password" required>
                    <button type="submit" name="inp_REGISTER" id="register-button">Register</button>
                </form>
                <form action="search.php" method="GET">
                   <label for="search">Search</label>
                   <input type="text" id="search" name="search" />
                   <select name="category">
                    	<option value="">Choose catagory</option>
                    	<option value="Graphics">GPU</option>
                    	<option value="RAM">RAM</option>
                   </select>
                   <input type="submit" value="Submit">
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

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>
