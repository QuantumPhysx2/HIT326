<?php require __DIR__."../assets/scripts/config.php"; ?>
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
        <title>Welcome | PC Buy Here</title>
    </head>

    <body>
        <header>
            <div class="navigation">
                <div class="jumbo-1">
                    <a class="home" href="index.php"><img src="assets/images/page-logo.png" alt="BLACKBIRD Technology"></a>
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
                    <h1>Welcome, <?php htmlspecialchars($_SESSION["Username"]); ?>!</h1>
                </div>
            </div>
        </main>

        <footer></footer>
        
        <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>