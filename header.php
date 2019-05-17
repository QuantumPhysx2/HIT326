<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php"><i class="fas fa-desktop"></i> PC Buy Here</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav  mr-auto">
        <li class="nav-item">
          <div class="">
            <a class="nav-link" href="show.product.category.php?cate=Graphics">Graphics Cards</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="show.product.category.php?cate=CPU">CPU</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="show.product.category.php?cate=Memory">Memory</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"></a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="show.product.search.php" method="GET">
         <input class="form-control mr-sm-2" type="text" id="search" name="search" />
         <select class="custom-select custom-select-sm mr-2" name="cate">
            <option value="">Choose catagory</option>
            <option value="Graphics">GPU</option>
            <option value="Memory">RAM</option>
         </select>
         <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>

      <?php
        $sum = 0;
        session_start();
        if(empty($_SESSION['cart'])){
          echo "<div>
                  <a class='nav-link' href='cart.php?empty=true'>
                   <button type='button' class='btn btn-primary'>
                      <span><i class='fa fa-cart-plus fa-2x' title='Marketplace'></i></span>
                      <span class='badge badge-light'>0</span>
                   </button>
                 </a>
               </div>";
        }else{
          $cart = $_SESSION['cart'];
          foreach ($cart as $key => $value) {
            $sum = $sum + $cart[$key][2];
          }
          echo "<div>
                  <a class='nav-link' href='cart.php'>
                   <button type='button' class='btn btn-primary'>
                      <span><i class='fa fa-cart-plus fa-2x' title='Marketplace'></i></span>
                      <span class='badge badge-warning'>{$sum}</span>
                   </button>
                 </a>
               </div>";
        }
      ?>
    </div>
  </nav>
</header>
