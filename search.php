<?php
if(!empty($_GET['search'])&&!empty($_GET['category'])){
   $search = htmlspecialchars($_GET['search'],ENT_QUOTES, 'UTF-8');
   $category = htmlspecialchars($_GET['category'],ENT_QUOTES, 'UTF-8');
   echo "<h2>Searched for {$search}</h2>";

   try{
       $db = new PDO("mysql:host=localhost;dbname=$category", 'root','');
       $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $query = "SELECT * FROM $category WHERE GPUname LIKE '%" . $search . "%'";


       $statement = $db->prepare($query);
       $binding = array($search);
       $statement -> execute($binding);
       $result = $statement->fetchall(PDO::FETCH_ASSOC);
       $array = $db->Query($query);
       if(!empty($result)){
         ?>

        <table border="1" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <th>Name</th>
            <th>Base Clock (MHz)</th>
            <th>Boost Clock (MHz)</th>
            <th>Vram (GB)</th>
            <th>Memory Type</th>
            <th>Price1</th>
            <th>Price</th>
          </tr>
          <?php
            foreach ($array as $key ) {
             echo "<tr>
                    <td>{$key[1]}</td>
                    <td>{$key[2]}</td>
                    <td>{$key[3]}</td>
                    <td>{$key[4]}</td>
                    <td>{$key[5]}</td>
                    <td>{$key[6]}</td>
                    <td>{$key[7]}</td>
                    <td><a href='add.php?itemNo={$key[0]}'>Buy</a></td>
                   </tr>" ;
            }
          ?>
        </table>
<?php
       }
       else{
         echo "<p>No results</p>";
       }
   }
   catch(PDOException $e){
       echo "<h2>Error with database because: {$e->getMessage()}</h2>";
   }
}
else{
   echo "<p>Type an other name.</p>";
}
?>
