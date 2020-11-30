<?php
session_start();
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>E-Commerce</title>
		<link rel="stylesheet" href="css/cssIndex.css" />
		<style>
		.iconL{ width:120px; position:absolute;top:0px;left:0}
		</style>
	</head>
	<header>
			<ul class="menu">
				<li><a href="produit.php"><img src="image/produit.png" class="icon">Our Product</a></li>
				<li><a href="contact.php"><img src="image/contact.png" class="icon">Contact</a></li>	
				<li><a href="Panier.php"><img src="image/panier.png" class="icon">Cart</a></li>
				<?php if(!isset($_SESSION['user'])){?>
				<li><a href="Connexion.php"><img src="image/iconConnexion.png" class="icon">Connection</a></li>
				<?php }else{ ?>
				<li><a href="userAccount.php"><img src="image/iconConnexion.png" class="icon">My account</a></li>	
				<li><a href="Deconnexion.php"><img src="image/iconDeconnexion1.png" class="icon">Log Out</a></li>	
				<?php } ?>	
			</ul>
	<a href="index.php"><img src="image/logo.png" border="4" class="iconL"></a>
	</header>
</html>