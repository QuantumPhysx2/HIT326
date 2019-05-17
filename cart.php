<!DOCTYPE html>
<html lang="en">
  <?php require __DIR__."/head.php"; ?>
  <title>My cart</title>
  <body>
    <?php require __DIR__."/header.php"; ?>
    <main>
        <div class="container mt-3">

        <?php
        $total=0;

        if (isset($_GET['empty'])) {
          echo "<h1>SHOPPING CART IS EMPTY.</h1>";

        }else {
          echo "<h1>YOUR SHOPPING CART</h1>";
          echo "
          <table class='table table-striped mt-4 table-bordered'>
            <!-- print column name of table -->
            <thead class='thead-dark'>
              <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quntaty</th>
                <th>Option</th>
              </tr>
            </thead>";

          if (!empty($_SESSION['cart'])){
            $arr = $_SESSION["cart"];
            foreach ($arr as $key => $value) {
              $db = new PDO("mysql:host=localhost;dbname=$value[0]", 'root','');
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $query = "SELECT * FROM $value[0] WHERE id = $value[1]";
              $arr_product = $db->Query($query);
              $columnname = $db->Query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA ='$value[0]'");
              echo "<tr>";
              $tem=0;
              $name=0;
              $price=0;
              foreach ($arr_product as $valuee) {
                foreach ($columnname as $column_name) {
                  $tem++;
                  if ($column_name[0]=='NAME') {
                    $name=$tem-1;
                    continue;
                  }elseif ($column_name[0]=='Price') {
                    $price=$tem-1;
                  }
                }
                  echo "<td>$valuee[$name]</td>";
                  echo "<td>$valuee[$price]</td>";
                  $total = $total + $valuee[$price]*$value[2];
              }
              echo "<td>$value[2]</td>";
              echo "<td><a href='cart.delete.item.php?list=$key'>Delete</a></td>";
              echo "</tr>";
            }}
            echo "</table>";
            echo "<div><span><a href='cart.clear.php'>Clear the shopping cart  </a></span>";
            echo "<span><a  href='welcome.php'><button type='button' class='btn btn-danger btn-sm float-right'>Checkout</button></a></span>";
            echo "<span class='float-right'><h3>Total price :<mark>$total</mark></h3></span></div>";
          }
        ?>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
