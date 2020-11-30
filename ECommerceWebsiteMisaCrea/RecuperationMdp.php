<?php
session_start();
unset($_SESSION["errormessage"]);
unset($_SESSION["admin"]);
unset($_SESSION["user"]);
?>
<html lang='fr'>
<head>
<meta charset='utf-8'/>

<style>
body {
font-family : 'Open Sans', sans-serif;
background:#dbf5eb;
}
h1{
  color:black;
  font-size: 20px;
}
fieldset
{
  background-color : white;
    -ms-transform: translateY(66%);
  transform: translateY(66%);
  width:400px;
  padding:16px;
  border:none;
  -moz-box-shadow: 0px 0px 10px 5px #656565;
-webkit-box-shadow: 0px 0px 10px 5px #656565;
-o-box-shadow: 0px 0px 10px 5px #656565;
box-shadow: 0px 0px 10px 5px #656565;
filter:progid:DXImageTransform.Microsoft.Shadow(color=#656565, Direction=NaN, Strength=10);
  position: absolute; 
	top: 50%; left: 50%; 
	transform: translate(-50%, -50%); 
}
input[type=mail] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}
input[type=password] {
  width: 75%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}
input[type=submit] {
  background-color: #007f00;
  border:none;
  color: white;
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  opacity: 0.6;
  transition: 0.3s;
}
input[type=submit]:hover {
  opacity: 1
}
/*Police*/
.legend1{
  font-weight:bold;
  font-size: 15px;
  color:black;
  float:left;
  margin-top:17px;
}
.forgotmdp a{
  color:#007f00;
  float:left;
  margin:8;
}
.createacc a{
  color:#007f00;
  float:right;
  margin:8;
}
.createacc a:hover{
  opacity: 0.8;
}
.forgotmdp a:hover{
  opacity: 0.8;
}
</style>
</head>
<body>
<form action='' method='post'>
<center><fieldset>
<h1>Votre code de r&eacute;cup&eacute;ration </h1>
<div class="legend1"> Code :</div>
<input type='password' name='code' maxlength="4" /required><br>
<input type='submit' name="codesubmit" value='Valider' /><br>

</fieldset></center>
</form>
</body>
</html>

<?php
require_once("bdconnexion.php");
$mail=$_GET['mail'];
if(isset($_GET['mail'], $_GET['token']) AND !empty($_GET['mail']) AND !empty($_GET['token'])) {
	$token=$_GET['token'];
	$query1 = "SELECT * FROM recuperation WHERE mail='$mail'";
	$result1 = mysqli_query($database, $query1);
	if(mysqli_num_rows($result1) > 0){
		while($row = mysqli_fetch_array($result1)){
			$bdtoken = $row['token'];
			if($token != $bdtoken){
				echo"<script type='text/javascript'> alert('Votre session a été expiré');window.location.href='http://localhost/tpweb/E-Commerce/forgotpass.php';</script>";
			}else{
				if(isset($_POST["codesubmit"])){
					$query2 = "SELECT * FROM recuperation WHERE mail='$mail'";
					$result2 = mysqli_query($database, $query2);
					if(mysqli_num_rows($result2) > 0){
						while($row = mysqli_fetch_array($result2)){
							$bdcode = $row['code'];
							$code=$_POST['code'];
							if($code == $bdcode){
								echo"<script type='text/javascript'>window.location.href='?action=EnterNewPwd&code=$code&mail=$mail';</script>";
							}else{
								echo"<script type='text/javascript'> alert('Ce code n\'est pas valide ! Veuillez rentrer une code valide');window.location.href='http://localhost/tpweb/E-Commerce/RecuperationMdp.php?mail=$mail&token=$token';</script>";
							}
						}
					}	
				}
			}
		}
	}
}else if($_GET['action']=='EnterNewPwd'){
?>
</style>
</head>
<body>
<form action='' method='post'>
<center><fieldset>
<h1>R&eacute;cup&eacute;ration de mot de passe</h1>
Pour <?php echo($mail); ?> </br>
(min 8 caracteres avec 1 majuscule, miniscule et chiffre)
<form method="post">
	<input type="password" placeholder="Nouveau mot de passe" name="change_mdp" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"/required><br/>
	<input type="password" placeholder="Confirmation du mot de passe" name="change_mdpc" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"/required><br/>
	<input type="submit" value="Valider" name="change_submit"/>
</form>
</fieldset></center>
</form>
</body>
</html>
<?php
	if(isset($_POST["change_submit"])){
		if ($_POST["change_mdp"] == $_POST["change_mdpc"]){
			$mdp = htmlspecialchars($_POST['change_mdp']);
			$null = 'NULL';
			$ins_mdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE mail = ?');
	        $ins_mdp->execute(array($mdp,$mail));
			$del_req = $bdd->prepare('UPDATE recuperation SET token = ?,date = ?,code = ? WHERE mail = ?');
			$del_req->execute(array($null,$null,$null,$mail));
			echo"<script type='text/javascript'> alert('Votre mot de passe a été modifié');window.location.href='http://localhost/tpweb/E-Commerce/Connexion.php';</script>";
		}else {
	        echo"<script type='text/javascript'> alert('Vos mots de passes ne correspondent pas')</script>";
	    }
	}
}else{
	echo"<script type='text/javascript'> alert('Votre session a été expiré');window.location.href='http://localhost/tpweb/E-Commerce/forgotpass.php';</script>";
}



?>



