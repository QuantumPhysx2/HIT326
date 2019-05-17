<!doctype html>
<html>
<?php require __DIR__."/head.php"; ?>
<title>Products of <?php echo "$_GET[cate]"; ?> </title>
<body>
  <?php require __DIR__."/header.php"; ?>
  <?php $cate=$_GET['cate'];
        $db = new PDO("mysql:host=localhost;dbname=$cate", 'root','');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM $cate";
        $statement = $db->prepare($query);
        $result = $statement->fetchall(PDO::FETCH_ASSOC);
        $array = $db->Query($query);
        $columnname = $db->Query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA ='$cate'");
  ?>
  <div class="container mt-3">

    <table class="table table-striped mt-4 table-bordered">
      <!-- print column name of table -->
      <thead class='thead-dark'>
        <tr>
        <?php
          foreach ($columnname as $value) {
            echo "<th>$value[0]</th>";
          }
          echo "<th>Option</th>";
        ?>
        </tr>
      </thead>
      <!-- list out the product in select category from database-->
      <?php
      foreach ($array as $key ){
        $size = sizeof($key);
        $halfsize = $size/2;
        echo "<tr>";
        for ($i=0; $i < $halfsize ; $i++) {
          echo "<td>{$key[$i]}</td>";
        }
        echo "<td><a href='cart.add.category.php?cate={$cate}&itemno={$key[0]}'><button type='button' class='btn btn-primary'>Add to cart</button></a></td>";

        echo "</tr>";

      }
      ?>
    </table>
  </div>
 </body>
</html>
