<?php
session_start();
unset($_SESSION["errormessage"]); //Reinitialisation du message d'erreur
unset($_SESSION["admin"]);
unset($_SESSION["user"]);
require_once("bdconnexion.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
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
  width: 100%;
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
</style>
</head>


<body>
<form action='envoiPassword.php' method='post'>
<center><fieldset>
<h1>R&eacute;cup&eacute;ration de votre mot de passe</h1>
<br>
<div class="legend1" title="Le login qui vous as ete attribue lors de l'inscription"> Mail :</div><br>
<input type='mail' name='mail' /required><br>
<br>
<div class="forgotmdp"><a href="Connexion.php">Revenir &agrave; la page de connexion</a></div>
<div class="createacc"><a href="createaccount.php">Cr&eacute;er un compte</a></div>
<br/>
<input type='submit' name="submit" value='Valider' /><br>

</fieldset></center>
</form>
</body>
</html>


