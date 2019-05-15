<?php
  session_start();
  $itemno = $_GET["itemno"];
  $cate = $_GET["cate"];
 if(empty($_SESSION['cart'])){
     $arr = array(
       array($cate,$itemno,1)
     );
     $_SESSION['cart'] = $arr;
 }else{
     $arr = $_SESSION['cart'];
     $bs = false;
     foreach($arr as $v){
       if($v[0]==$cate&$v[1]==$itemno){
         $bs = true;
       }
     }
     if($bs){
       foreach($arr as $k=>$v){
         if($v[0]==$cate&$v[1]==$itemno){
           $arr[$k][2]++;
         }
       }
         $_SESSION['cart'] = $arr;
     }
     else{

         $attr = array($cate,$itemno,1);
         $arr[] = $attr;
         $_SESSION['cart'] = $arr;
     }
 }
 header("location:product.php?cate={$cate}&itemno={$itemno}");
