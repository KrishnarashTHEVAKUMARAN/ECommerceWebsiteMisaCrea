<?php
require_once("header.php");
?>
<div class="container flex">
<?php
require_once("bdconnexion.php");


$query1 = "SELECT * FROM products ";
$result2 = mysqli_query($database, $query1);
if(mysqli_num_rows($result2) > 0){
    while($row = mysqli_fetch_array($result2)){
    ?>
	
			<fieldset class="boutiqueproduit">
			<?php if(!isset($_SESSION['user'])){?>
			<a onclick="Msg()"><img class="pic" src="picture/<?php echo $row["title"]; ?>.jpg"/></a>
			<?php }else{ ?>
			<a href="ShowProduit.php?action=showProduct&id=<?php echo $row["id"]; ?>"><img class="pic" src="picture/<?php echo $row["title"]; ?>.jpg"/></a>
			<?php } ?>
            <p> Titre : <?php echo $row["title"]; ?></p>
            <p> Prix : <?php echo $row["price"]; ?> €</p>
			</fieldset>
	
	<?php
          }
        }
		
	?>
</div>
<script>
function Msg(){
	alert("Pour acheter un produit, veuillez vous connecter");
}
</script>

<?php require_once("footer.php"); ?>