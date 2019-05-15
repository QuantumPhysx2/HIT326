<!doctype html>
<html>
  <?php require __DIR__."/head.php";?>
  <body>
    <?php require __DIR__."/header.php";?>
    <?php
    if(!empty($_GET['search'])&&!empty($_GET['cate'])){
           $cate=$_GET['cate'];
           $search=$_GET['search'];
           $db = new PDO("mysql:host=localhost;dbname=$cate", 'root','');
           $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $query = "SELECT * FROM $cate WHERE NAME LIKE '%" .$search. "%'";
           $statement = $db->prepare($query);
           $binding = array($search);
           $statement -> execute($binding);
           $result = $statement->fetchall(PDO::FETCH_ASSOC);
           $array = $db->Query($query);
           $columnname = $db->Query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA ='$cate'");
           if(!empty($result)){
    ?>
           <div class="container">
             <?php echo "<h2>Search keyword \"{$search}\" in {$cate}</h2>"; ?>
             <table class="table table-striped mt-4 table-bordered">
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
               <?php
               foreach ($array as $key ){
                 $size = sizeof($key);
                 $halfsize = $size/2;
                 echo "<tr>";
                 for ($i=0; $i < $halfsize ; $i++) {
                   echo "<td>{$key[$i]}</td>";
                 }
                 echo "<td><a href='addtocart_search.php?itemno={$key[0]}&cate={$cate}&search={$search}'><button type='button' class='btn btn-primary'>Add to cart</button></a></td>";

                 echo "</tr>";

               }
               ?>
             </table>
           </div>
    <?php
           }
           else{
             echo "
             <div class='container mt-5'>
              <h1>No results</h1>
             </div>";
           }
       }

    else{
       echo "<div class='container mt-3'><h1> Please select a category</h1></div>";
    }
    ?>
  </body>
</html>
