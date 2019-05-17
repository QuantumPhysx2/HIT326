<!DOCTYPE html>
<html lang="en">
  <?php require __DIR__."/head.php"; ?>
  <title>My cart</title>
  <body>
    <?php require __DIR__."/header.php"; ?>
    <main>
        <div class="container mt-3">
        <?php
          $list = $_GET['list'];
          $arr = $_SESSION['cart'];
          if($arr[$list][2]>1){
             $arr[$list][2]--;
          }
          else
          {
              unset($arr[$list]);
              $arr = array_values($arr);
          }
          $_SESSION['cart'] = $arr;
          if (count($_SESSION['cart'])>0) {
            header("location:cart.php");
          }else {
            header("location:cart.php?empty=true");

          }
        ?>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
