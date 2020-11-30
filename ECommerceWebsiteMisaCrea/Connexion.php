<?php
session_start();
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
fieldset{
	background-color : white;
	-ms-transform: translateY(60%);
	transform: translateY(60%);
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
<form action='action.php' method='post'>
<center><fieldset>
<h1>Connexion</h1>
<span style="color:red;font-weight:bold;">
<?php
if(isset($_SESSION["errormessage"])){ 
  echo $_SESSION["errormessage"];
}
?>
<a href="index.php" >Revenir à l'accueil</a>
</span>
<br>
<div class="legend1" title="l'email utiliser lors de votre inscription"> Email : </div></br>
<div align="left"><input type='text' name='mail' required /><br></div>
<div class="legend1" title="Le mot de passe que vous avez entrer lors de l'inscription">Mot de passe :</div>
<div align="left"><input id="psw" type='password' name='psw' required /></div>
<a><img onclick="ShowPassword()" src="image/showpsw.png" class="icon"></a>
<br>
<div class="forgotmdp"><a href="forgotpass.php">Mot de passe oubli&eacute; ?</a></div>
<div class="createacc"><a href="createaccount.php">Cr&eacute;er un compte</a></div>
<br/>
<input type='submit' value='Valider' /><br>

</fieldset></center>
</form>
</body>
</html>
