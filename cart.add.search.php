<?php
  session_start();
  $itemno = $_GET['itemno'];
  $cate = $_GET['cate'];
  $search = $_GET['search'];
 if(empty($_SESSION['cart'])){
     $array = array(
       array("$cate","$itemno",1)
     );
     $_SESSION['cart'] = $array;
 }else{
     $array = $_SESSION['cart'];
     //check if there is same item in cart.
     $check = false;
     foreach($array as $v){
       if($v[0]==$cate&$v[1]==$itemno){
            $check = true;
        }
     }
     if($check){
         foreach($array as $k=>$v){
             if($v[0]==$cate&$v[1]==$itemno){
                 $array[$k][2]++;
               }

         }
         $_SESSION['cart'] = $array;
     }
     else{
         $attr = array($cate,$itemno,1);
         $array[] = $attr;
         $_SESSION['cart'] = $array;
     }
 }
 header("location:show.product.search.php?cate={$cate}&search={$search}");
