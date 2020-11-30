<?php
session_start();
require_once("bdconnexion.php");

$loginuser = sanitizeString($_POST['mail']);
$pswuser = sanitizeString($_POST['psw']);

function sanitizeString($var) {
if(get_magic_quotes_gpc())   //si activée magic ajoute des apostrophes avec des barres obliques
  $var = stripslashes($var); //enlève les barres obliques indésirables      // enlève toute balise html
$var = htmlentities($var);    //egal à la précédente
return $var;
}

$req1 ="SELECT `mail` FROM `users` WHERE mail = '".$loginuser."'";
$req2 ="SELECT `mdp` FROM `users` WHERE mdp = '".$pswuser."'";
$req3 ="SELECT `mail` FROM `users` WHERE mail = '".$loginuser."' AND mdp = '".$pswuser."'";
$req4 ="SELECT `id` FROM `users` WHERE mail = '".$loginuser."' AND mdp = '".$pswuser."' AND id = '1' ";
$req5 ="SELECT `mail` FROM `users` WHERE mail = '".$loginuser."' AND mdp = '".$pswuser."' AND confirme = '1' ";

$result = mysqli_query($connexion,$req1)or die("1");
$result2 = mysqli_query($connexion,$req2)or die("2");
$result3 = mysqli_query($connexion,$req3)or die("3");
$result4 = mysqli_query($connexion,$req4)or die("4");
$result5 = mysqli_query($connexion,$req5)or die("5");


if((mysqli_num_rows($result) and mysqli_num_rows($result2) and mysqli_num_rows($result3))==1){
		if(mysqli_num_rows($result4)){
			$_SESSION["admin"] = $loginuser;
			header('Location:admin.php');
		}
		else{
			if(mysqli_num_rows($result5)){
				$_SESSION["user"] = $loginuser;
				header('Location:index.php');
			}else{
				 echo'<script type="text/javascript"> alert("Veuillez confirmez votre inscription"); window.location.href="Connexion.php";</script>';
			}
		}
}
else
    {
      session_start();
      $_SESSION["errormessage"] = "Le mot de passe est incorrect !";
      header('Location:Connexion.php');
    }
?>