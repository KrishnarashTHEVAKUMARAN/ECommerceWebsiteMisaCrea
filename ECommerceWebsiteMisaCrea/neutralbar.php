<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/cssIndex.css" />
	</head>
	
<body>	
	<div id="neutralbar">
		<h2>Derniers Articles</h2>
		
<?php
require_once("bdconnexion.php");

$query2 = "SELECT * FROM products ORDER BY id DESC LIMIT 0,1 ";
$result3 = mysqli_query($database, $query2);
if(mysqli_num_rows($result3) > 0){
    while($row = mysqli_fetch_array($result3)){
    ?>
        <td>
			<fieldset>
            <h4 class=""> Titre : <?php echo $row["title"]; ?></h4>
            <h4 class=""> Prix : <?php echo $row["price"]; ?> €</h4>
			<img align="center" class="rotate" src="picture/<?php echo $row["title"]; ?>.jpg"/>
			</fieldset>
          </br>
        </td>
	<?php
          }
        }
	?>
	
	</div>	
	<div class="LogoETNom">
		<h1><i><b>Misa</b></i> Créa</h1>
		<p><img src="image/logo2.png" class="LogoAccueil"></p>
		<h6>Misa Créa est une entreprise d'artisanat haut-de-gamme.</br>
		Des oeuvres uniques, faites à la main, dans un de nos ateliers.</br> 
		Chaque produit est fabriqué par un passionné de création,</br>  pour lequel précision et qualité sont les mots d'ordre.</br>
		N'achetez pas n'importe quel cadeau, achetez nos produits !</h6>
		
	</div>	
</body>
</html>