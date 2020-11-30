<?php
require_once("header.php");
function sanitizeString($var) {
	if(get_magic_quotes_gpc())   //si activée magic ajoute des apostrophes avec des barres obliques
		$var = stripslashes($var); //enlève les barres obliques indésirables      // enlève toute balise html
		$var = htmlentities($var);    //egal à la précédente
		return $var;
}
?>
<style>
		fieldset {
			background-color : white;
			max-width:500px;
			padding:16px;
			margin-left: 17px;
			margin-right: auto;
			position: absolute; 
			top: 50%; left: 50%; 
			transform: translate(-50%, -50%); 
		}
		
		input[type=submit] , input[type=reset]{
			background-color: #007f00;
			border:none;
			color: white;
			width: 100%;
			padding: 12px 20px;
			margin: 5px 0;
			box-sizing: border-box;
			opacity: 0.6;
			transition: 0.3s;
		}

		input[type=reset]{
			background-color: red;
		}
		
		input[type=submit]:hover , input[type=reset]:hover {
			opacity: 1
		}
		
		input[type=text] , input[type=password]{
			width: 100%;
			padding: 6px 10px;
			margin: 8px 0;
			box-sizing: border-box;
		}

		input[type=number] {
			width: 100%;
			padding: 6px 10px;
			margin: 2px 0;
			box-sizing: border-box;
		}
		
		h1{
			color:black;
			font-size: 20px;
			text-align: center;
		}
		
		h5{
			color:black;
			text-align: left;
			font-size: 11px;
		}
		
		
</style>
<body>
	<ul class="menuUser">
	<li><a href="?action=show">Afficher votre Profil</a></li>
	<li><a href="?action=modifyProfil">Modifier votre Profil</a></li>
	</ul>
</body>
<?php
require_once("bdconnexion.php");

if(isset($_SESSION["user"])){
	unset($_SESSION["admin"]);
	if(isset($_GET['action'])){
			if($_GET['action']=='show'){
				$mail=sanitizeString($_SESSION['user']);
				$query = "SELECT * FROM users WHERE mail='$mail'";
				$result = mysqli_query($database, $query);
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($result)){
			?>
						<td>
						  <div align="center">
							<fieldset>
							<h4> Nom : <?php echo $row["nom"]; ?></h4>
							<h4> Prenom : <?php echo $row["prenom"]; ?></h4>
							<h4> Login : <?php echo $row["login"]; ?></h4>
							<h4> Age : <?php echo $row["age"]; ?></h4>
							<h4> Sexe : <?php echo $row["sexe"]; ?></h4>
							<h4> Mot de passe (crypte): <?php echo crypt($row["mdp"],"User"); ?></h4>
							</fieldset>
						  </div>
						</td>
			<?php
					}
				}
			?>
		<?php	
			
			}else if ($_GET['action']=='modifyProfil'){
				$mail=sanitizeString($_SESSION['user']);
				$query1 = "SELECT * FROM users WHERE mail='$mail'";
				$result1 = mysqli_query($database, $query1); 
				if(mysqli_num_rows($result1) > 0){
					while($row = mysqli_fetch_array($result1)){
			?>
				<fieldset class="profilmodif">
				<h1><div align="center"><strong>Modification du profil</strong></div></h1>
				<div align="center">
				<form action="" method="post">
				<h5>Nom </h5><input value="<?php echo $row['nom'];?>" type="text" name="nom" align="middle" maxlength="15" /required>
				<h5>Prenom</h5><input value="<?php echo $row['prenom'];?>" type="text" name="prenom" /required>
				<h5>Login</h5><input value="<?php echo $row['login'];?>" type="text" name="login" /required>
				<h5>Age</h5><input value="<?php echo $row['age'];?>" type="number" name="age" min="0"/>
				<h5>Sexe</h5><select  name="sexe" >
							<option selected hidden> <?php echo $row['sexe'];?></option>
							<option value="m">m</option>
							<option value="f">f</option>
							<option value="autre">autre</option>
						</select>
				<h5>Mot de passe (Rentrer si vous souhaitez modifier le mdp)</h5><input title="minimum 8 caracteres avec 1 majuscule, miniscule et chiffre" type="password" name="mdp" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"/>		
				<input type="submit" name="submit1" />
				<input type="reset" name="reset" />
				</div>
				</form>
				</fieldset>
			<?php
					}
				}
				if(isset($_POST["submit1"])){
					$mail=sanitizeString($_SESSION['user']);
					$nom=sanitizeString($_POST["nom"]);
					$prenom=sanitizeString($_POST["prenom"]);
					$login=sanitizeString($_POST["login"]);
					$age=sanitizeString($_POST["age"]);
					$sexe=sanitizeString($_POST["sexe"]);
					$mdp=sanitizeString($_POST["mdp"]);
						if($nom || $prenom || $login || $age || $sexe || $mdp){
							if ($mdp == ""){
								$update = "UPDATE users SET nom='$nom',prenom='$prenom',age='$age',sexe='$sexe' WHERE users.mail='$mail' ";
								$result2 = mysqli_query($database, $update);
							}else{
								$update2 = "UPDATE users SET nom='$nom',prenom='$prenom',age='$age',sexe='$sexe',mdp='$mdp' WHERE users.mail='$mail' ";
								$result3 = mysqli_query($database, $update2);
							}
						}else{
							echo'Veuillez remplir tous les champs';

						}
						 header("Location:userAccount.php?action=show");
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

?>

<?php
require_once("footer.php");
?>