<?php
session_start();
unset($_SESSION["user"]);
unset($_SESSION["admin"]);
unset($_SESSION["errormessage"]);
unset($_SESSION["errormessage1"]);
unset($_SESSION["shopping_cart"]);

header("Location:index.php");
?>