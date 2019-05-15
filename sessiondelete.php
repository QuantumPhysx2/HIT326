<?php

session_start();
session_destroy();
header("location:cart.php?empty=true");
?>
