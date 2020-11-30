<?php
	$bdd = new PDO('mysql:host=localhost;dbname=ecommercebase', 'root', '');
	 
	if(isset($_GET['mail'], $_GET['key']) AND !empty($_GET['mail']) AND !empty($_GET['key'])) {
	   $mail = htmlspecialchars(urldecode($_GET['mail']));
	   $key = htmlspecialchars($_GET['key']);
	   $requser = $bdd->prepare("SELECT * FROM users WHERE mail = ? AND confirmkey = ?");
	   $requser->execute(array($mail, $key));
	   $userexist = $requser->rowCount();
	   if($userexist == 1) {
	      $user = $requser->fetch();
	      if($user['confirme'] == 0) {
	         $updateuser = $bdd->prepare("UPDATE users SET confirme = 1 WHERE mail = ? AND confirmkey = ?");
	         $updateuser->execute(array($mail,$key));
			 echo'<script type="text/javascript"> alert("Votre compte a bien été confirmé !");window.location.href="Connexion.php";</script>';
	      } else {
			 echo'<script type="text/javascript"> alert("Votre compte a déjà été confirmé !");window.location.href="Connexion.php";</script>';
	      }
	   } else {
		  echo'<script type="text/javascript"> alert("L\'utilisateur n\'existe pas !");window.location.href="Connexion.php"; </script>';
	   }
	}
?>