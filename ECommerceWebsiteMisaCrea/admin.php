<h2> <span class="titre">Bienvenu sur votre espace administrateur</span><h2>
<span style="float:right;font-weight:bold;font-size:20px;color:blue;"><a href="Deconnexion.php"><img src="image/iconDeconnexion.png" class="icon"></a></span>

<link rel="stylesheet" href="css/cssAdmin.css" />
<br/>

<ul class="menu">
<li><a href="?action=add">Ajouter un ou des produit(s)</a></li>
<li><a href="?action=modifyanddelete">Modifier/Supprimer un produit</a></li>
<li><a href="?action=change">Changer votre coordonnées</a></li>

</ul>

<?php
session_start();
require_once("bdconnexion.php");

if(isset($_SESSION["admin"])){
	unset($_SESSION["user"]);
	if(isset($_GET['action'])){
		if($_GET['action']=='add'){
			if(isset($_POST["submit"])){
				$title=sanitizeString($_POST["title"]);
				$description=sanitizeString($_POST["description"]);
				$price=sanitizeString($_POST["price"]);
				$img = $_FILES['img']['name'];
				$img_tmp = $_FILES['img']['tmp_name'];
				if(!empty($img_tmp)){
					$image = explode('.',$img);
					$image_ext = end($image);
					if(in_array(strtolower($image_ext),array('png','jpg','jpeg'))==false){
						echo'Veuillez rentrer une image ayant pour extension : png, jpg ou jpeg';
					}else{
						$image_size = getimagesize($img_tmp);
						if($image_size['mime']=='image/jpeg'){
							$image_src= imagecreatefromjpeg($img_tmp);
						}else if($image_size['mime']=='image/png'){
							$image_src= imagecreatefrompng($img_tmp); 
						}else{
							$image_src= false;	
							echo'Veuillez rentrer une image valide';
						}
						if($image_src !== false){
							$image_width=300;
							if($image_size[0]==$image_width){
								$image_finale = $image_src;
							}else{
								$new_width[0]=$image_width;
								$new_height[1]=300;
								$image_finale = imagecreatetruecolor($new_width[0],$new_height[1]);
								imagecopyresampled($image_finale,$image_src,0,0,0,0,$new_width[0],$new_height[1],$image_size[0],$image_size[1]);
							}
							imagejpeg($image_finale,'picture/'.$title.'.jpg');
						}
					}					
				}else{
					echo'Veuillez rentrer une image';
				}
					if($title && $description && $price){
						$insert = "INSERT INTO products(title,description,price) VALUES('".$title."','".$description."','".$price."')";
						$result = mysqli_query($database, $insert);
						//print_r($insert); ////teste pour voir si l'insertion se passe correctement
					}else{
						echo'Veuillez remplir tous les champs';
					}
					 header('Location:admin.php?action=add');
			}
	?>	
	<fieldset>
	<h1><strong>Ajout d'un ou des produit(s)</strong></h1>
	<form action="" method="post" enctype="multipart/form-data">
	<h3>Titre du produit (15 caracteres maximum)</h3><input type="text" name="title" align="middle" maxlength="15" /required>
	<h3>Description (200 caracteres maximum) <br> Remarque: Les ' empechent l'insertion</h3><textarea cols="45" rows="5" maxlength="200" name="description"required></textarea>
	<h3>Prix</h3><input type="number" name="price" step="0.01" min='0.01' /required>
	<h3>Image</h3><input type="file" name="img"/required>
	<input type="submit" name="submit" />
	<input type="reset" name="reset" />
	</form>
	</fieldset>
	
	<?php	
		}else if($_GET['action']=='modifyanddelete'){
			$query = "SELECT * FROM products ";
			$result1 = mysqli_query($database, $query);
			if(mysqli_num_rows($result1) > 0){
				while($row = mysqli_fetch_array($result1)){  
        ?>
		<td>
		<div class="modifyanddelete">
			<h4 class=""> Produit : <?php echo $row["title"]; ?> 
				<a class="lienmodifie" href="?action=modify&amp;id=<?php echo $row["id"]; ?>">Modifier</a> 
				<a class="lienmodifie" href="?action=delete&amp;id=<?php echo $row["id"]; ?>&amp;nom=<?php echo $row["title"]; ?>">X</a> 
			</h4>
		</div> 
		</td>
		<?php
          }
        }
		?>
<?php			
		}else if($_GET['action']=='modify'){
			$id=$_GET['id'];
			$query1 = "SELECT * FROM products WHERE id=$id";
			$result2 = mysqli_query($database, $query1); 
			if(mysqli_num_rows($result2) > 0){
				while($row = mysqli_fetch_array($result2)){
					$oldtitle=$row['title'];
?>

		<fieldset>
		<h1><strong>Modification du produit selectionn&eacute;</strong></h1>
		<a href="?action=modifyanddelete" style="font-size:0.75em;">Revenir à l'arri&egrave;re</a>
		<form action="" method="post">
		<h3>Titre du produit (15 caracteres maximum)</h3><input value="<?php echo $row['title'];?>" type="text" name="title" align="middle" maxlength="15" /required>
		<h3>Description (200 caracteres maximum)</h3><textarea cols="45" rows="5" maxlength="200" name="description"required><?php echo $row['description'];?></textarea>
		<h3>Prix</h3><input value="<?php echo $row['price'];?>" type="number" name="price" step="0.01" min='0.01' /required>
		<input type="submit" name="submit1" />
		<input type="reset" name="reset" />
		</form>
		</fieldset>
		<?php
          }
        }
		if(isset($_POST["submit1"])){
				$title=sanitizeString($_POST["title"]);
				rename("picture/".$oldtitle.".jpg", "picture/".$title.".jpg");
				$description=sanitizeString($_POST["description"]);
				$price=sanitizeString($_POST["price"]);
					if($title && $description && $price){
						$update = "UPDATE products SET title='$title',description='$description',price='$price' WHERE products.id= $id ";
						$result = mysqli_query($database, $update);
					}else{
						echo'Veuillez remplir tous les champs';
						
					}
					header("Location:admin.php?action=modify&id=$id");
			}
		?>
<?php		
		}else if($_GET['action']=='delete'){
			$id=$_GET['id'];
			$query3 = "SELECT * FROM products WHERE id=$id";
			$result4 = mysqli_query($database, $query3);
			if(mysqli_num_rows($result4) > 0){
				while($row = mysqli_fetch_array($result4)){
					$title = $row['title'];
				}
			}
			unlink("picture/".$title.".jpg");
			$query2 = "DELETE FROM products WHERE id =$id";
			$result3 = mysqli_query($database, $query2);
			header('Location:admin.php?action=modifyanddelete');			
		
			
		}else if($_GET['action']=='change'){
			$query3 = "SELECT * FROM users WHERE id='1'";
			$result4 = mysqli_query($database, $query3);
			if(mysqli_num_rows($result4) > 0){
				while($row = mysqli_fetch_array($result4)){
        ?>
        <td>
          <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
			<fieldset>
            <h4> Nom : <?php echo $row["nom"]; ?></h4>
            <h4> Prenom : <?php echo $row["prenom"]; ?></h4>
            <h4> Age : <?php echo $row["age"]; ?></h4>
            <h4> Sexe : <?php echo $row["sexe"]; ?></h4>
			<h4> Mot de passe (crypte): <?php echo crypt($row["mdp"],"KO"); ?></h4>
			<a class="" href="?action=modifyProfil">Modifier</a>
			</fieldset>
          </div>
        </td>
		<?php
				}
			}
		?>
<?php
		}else if($_GET['action']=='modifyProfil'){	
			$query4 = "SELECT * FROM users WHERE id=1";
			$result5 = mysqli_query($database, $query4); 
			if(mysqli_num_rows($result5) > 0){
				while($row = mysqli_fetch_array($result5)){
?>

		<fieldset class="profilmodif">
		<h1><strong>Modification du profil</strong></h1>
		<a href="?action=change" style="font-size:0.75em;">Revenir à l'arri&egrave;re</a>
		<form action="" method="post">
		<h5>Nom </h5><input value="<?php echo $row['nom'];?>" type="text" name="nom" align="middle" maxlength="15" /required>
		<h5>Prenom</h5><input value="<?php echo $row['prenom'];?>" type="text" name="prenom" /required>
		<h5>Age</h5><input value="<?php echo $row['age'];?>" type="number" name="age" min="0"/>
		<h5>Sexe</h5><select  name="sexe" >
                    <option selected hidden> <?php echo $row['sexe'];?></option>
                    <option value="m">m</option>
                    <option value="f">f</option>
                    <option value="autre">autre</option>
                </select>
		<h5>Mot de passe (Rentrer si vous souhaitez modifier le mdp)</h5><input value="" type="text" name="mdp" />		
		<input type="submit" name="submit1" />
		<input type="reset" name="reset" />
		</form>
		</fieldset>
		<?php
          }
        }
		if(isset($_POST["submit1"])){
				$nom=sanitizeString($_POST["nom"]);
				$prenom=sanitizeString($_POST["prenom"]);
				$age=sanitizeString($_POST["age"]);
				$sexe=sanitizeString($_POST["sexe"]);
				$mdp=sanitizeString($_POST["mdp"]);
					if($nom || $prenom || $age || $sexe || $mdp){
						if ($mdp == ""){
							$update2 = "UPDATE users SET nom='$nom',prenom='$prenom',age='$age',sexe='$sexe' WHERE users.id=1 ";
							$result1 = mysqli_query($database, $update2);
						}else{
							$update1 = "UPDATE users SET nom='$nom',prenom='$prenom',age='$age',sexe='$sexe',mdp='$mdp' WHERE users.id=1 ";
							$result = mysqli_query($database, $update1);
						}
					}else{
						echo'Veuillez remplir tous les champs';
						
					}
					 header("Location:admin.php?action=change");
			}
		?>	
<?php		
		}else{
			die('Une erreur s&apos;est produite.');
		}
	}else{	
	}
}else{
	header('Location:Connexion.php');
}

function sanitizeString($var) {
	if(get_magic_quotes_gpc())   //si activée magic ajoute des apostrophes avec des barres obliques
		$var = stripslashes($var); //enlève les barres obliques indésirables      // enlève toute balise html
		$var = htmlentities($var);    //egal à la précédente
		return $var;
}
?>

