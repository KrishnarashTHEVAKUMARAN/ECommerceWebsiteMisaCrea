<?php
session_start();
unset($_SESSION["admin"]);
unset($_SESSION["user"]);

require_once("bdconnexion.php");
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
	  -ms-transform: translateY(50%);
  transform: translateY(50%);
  max-width:500px;
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
input[type=text] {
  width: 92%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}
input[type=password] {
  width: 92%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}
input[type=mail] {
  width: 92%;
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
.icon{ width:6%; display:block; float:right;margin-top:-43.5px}
</style>
<script>
function ShowPassword() {
  var x = document.getElementById("psw");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 

</script>
</head>


<body>
<form action='' method='post' name="creation">
<center><fieldset>
<h1>Cr&eacute;e un compte</h1>
<span style="color:red;font-weight:bold;">
<?php
if(isset($_SESSION["errormessage"])){ 
  echo $_SESSION["errormessage"];
}
?>
<a href="index.php" >Revenir à l'accueil</a>
</span>
</br>
<div class="legend1"> Nom :</div></br>
<div align="left"><input type="text" name="nom" align="middle" maxlength="15" /required></div>
<div class="legend1"> Prenom :</div>
<div align="left"><input type="text" name="prenom" /required></div>
<div class="legend1"> Age :</div></br>
<input type="number" name="age" min="0"/required></br>
</br><div class="legend1"> Sexe :</div></br>
</br><select name="sexe" required>
	<option selected hidden></option>
    <option value="m">m</option>
    <option value="f">f</option>
    <option value="autre">autre</option>
</select></br>
<div class="legend1" > Login :</div>
<div align="left"><input type='text' name='login' /required></br></div>
<div class="legend1"> Mail :</div></br>
<div align="left"><input type='mail' name='mail' /required></div>
<div align="left" class="legend1" > Mot de passe (minimum 8 caracteres avec 1 majuscule, miniscule et chiffre):</div>
<div align="left"><input type='password' id='psw' name='psw' pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" /required></br></div>
<a><img onclick="ShowPassword()" src="image/showpsw.png" class="icon"></a>
<html>
	  <head>
	    <title>Inscription</title>
	     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	  </head>
	  <body>
	    <form method="POST">
	      <div class="g-recaptcha" data-sitekey="6Lf5i_4UAAAAAIjxgaQ-pxuZP1Erpfdxi1u6YyDm"></div>
	    </form>
	  </body>
</html>
</br>
<div class="forgotmdp"><a href="forgotpass.php">Mot de passe oubli&eacute; ?</a></div>
<div class="createacc"><a href="Connexion.php">Revenir &agrave; la page de connexion</a></div>
<br/>
<input type='submit' name="submit" /><br>

</fieldset></center>
</form>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('recaptcha/src/autoload.php');
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if(isset($_POST["submit"])){
	$nom=sanitizeString($_POST["nom"]);
	$prenom=sanitizeString($_POST["prenom"]);
	$age=sanitizeString($_POST["age"]);
	$sexe=sanitizeString($_POST["sexe"]);
	$login=sanitizeString($_POST["login"]);
	$mail=sanitizeString($_POST["mail"]);
	$psw=sanitizeString($_POST["psw"]);
	$longueurKey = 15;
	$key = "";
	for($i=1;$i<$longueurKey;$i++) {
	    $key .= mt_rand(0,9);
	}
	$mailcheck = "SELECT COUNT(*) AS nbr FROM users WHERE mail = '".$mail."'";
	$res = mysqli_query($database,$mailcheck);
    $alors = mysqli_fetch_assoc($res);
	if(isset($_POST['g-recaptcha-response'])){
	    $recaptcha = new \ReCaptcha\ReCaptcha('6Lf5i_4UAAAAAGFsZPm0B42TGWzB66hrPhylW_pW');
	    $resp = $recaptcha->verify($_POST['g-recaptcha-response']);
	    if ($resp->isSuccess()) {
			if(!($alors['nbr'] == 0)){
				echo'<script type="text/javascript"> alert("Ce mail est déjà utilisé !")</script>';
			}else{
				if($nom && $prenom && $age && $sexe && $login && $mail && $psw){
					$insert = "INSERT INTO users(nom,prenom,age,sexe,login,mail,mdp,confirmkey) VALUES('".$nom."','".$prenom."','".$age."','".$sexe."','".$login."','".$mail."','".$psw."','".$key."')";
					$result = mysqli_query($database, $insert);
					$mailer = new PHPMailer(true);                              
					try {
						$mailer->Mailer = "smtp";
						$mailer->SMTPDebug = 0;                                 
						$mailer->isSMTP();                                     
						$mailer->Host = 'smtp.gmail.com';                  
						$mailer->SMTPAuth = true;                               
						$mailer->Username = 'ecommercetest92@gmail.com';       //votre adresse mail      
						$mailer->Password = 'testcommerce';                         // votre mdp de votre @mail
						$mailer->SMTPSecure = 'ssl';                            
						$mailer->Port = 465;                                
						
						$mailer->IsHTML(true);
						$mailer->setFrom("ecommercetest92@gmail.com","Admin E-Commerce");  // indiquez votre @mail pour que le client sache que le mail vient de l'admin       
						$mailer->addAddress($mail);

						$body = "Bienvenu sur Misa Crea <br>
						Mr.$nom $prenom vous vous etes inscrit sur notre site.<br>
						Nous voulions confirmer que votre mail est exacte.<br>
						Si vous vouliez confirmez votre inscription, veuillez activer votre compte.<br>
						Pour activer votre compte, veuillez cliquer sur le lien ci-dessous <br>
						ou copier/coller dans votre navigateur Internet.<br>
						Lien : http://localhost/tpweb/E-Commerce/ConfirmationCompte.php?mail=$mail&key=$key<br>
						---------------------------------------------------------<br>
						Ceci est un mail automatique, Merci de ne pas y répondre<br>
						Admin E-Commerce";	
						
						$mailer->isHTML(true);                                  
						$mailer->Subject = "Activation de votre compte";
						$mailer->Body    = $body;
						$mailer->AltBody = strip_tags($body);
						if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
							$mailer->send();
						} 
					echo'<script type="text/javascript"> alert("Mail Envoye")</script>';
					} catch (Exception $e) {
						echo '<h2>Adresse invalide</h2>';
						echo "<h2>Cliquez <a href='Connexion.php'>ici</a> pour être redirigé vers la page connexion</h2>";
					}
				}else{
					echo'<script type="text/javascript"> alert("Veuillez remplir tous les champs")</script>';
				}
			}
		}else{
	        $errors = $resp->getErrorCodes();
			echo'<script type="text/javascript"> alert("Captcha non rempli")</script>';
	    }
	}else {
	    echo'<script type="text/javascript"> alert("Captcha non rempli")</script>';
	}
}

function sanitizeString($var) {
	if(get_magic_quotes_gpc())   
		$var = stripslashes($var); 
		$var = htmlentities($var);    
		return $var;
}

?>

</body>
</html>


