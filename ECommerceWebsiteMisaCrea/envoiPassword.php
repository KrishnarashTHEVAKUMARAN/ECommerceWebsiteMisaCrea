<?php 
session_start();
$mailfrom=$_POST['mail']; 
$token= uniqid();
$date = date('Y-m-d');
$longueurKey = 5;
$code = "";
for($i=1;$i<$longueurKey;$i++) {
	$code .= mt_rand(0,9);
}
require_once("bdconnexion.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$insert = "INSERT INTO recuperation(mail,token,date,code) VALUES('".$mailfrom."','".$token."','".$date."','".$code."')";
$result = mysqli_query($database, $insert);

$recupUser = $bdd->prepare("SELECT * FROM recuperation WHERE mail = ?");
$recupUser->execute(array($mailfrom));
$userRecupExist = $recupUser->rowCount();
if($userRecupExist == 1) {
	$user = $recupUser->fetch();
	$updateuser = $bdd->prepare("UPDATE recuperation SET token = ?, date = ?, code = ?  WHERE mail = ? ");
	$updateuser->execute(array($token,$date,$code,$mailfrom));
}
	
$mail = new PHPMailer(true);                             
try {
	//Server settings for gmail
	$mail->Mailer = "smtp";
    $mail->SMTPDebug = 0;                               
    $mail->isSMTP();                                      
    $mail->Host = 'smtp.gmail.com';                  
    $mail->SMTPAuth = true;                               
	$mail->Username = 'ecommercetest92@gmail.com';       //votre adresse mail      
    $mail->Password = 'testcommerce';                         // votre mdp de votre @mail                          
    $mail->SMTPSecure = 'ssl';                            
    $mail->Port = 465;                                   
	
	$mail->IsHTML(true);
    $mail->setFrom("ecommercetest92@gmail.com","Admin E-Commerce");  // indiquez votre @mail pour que le client sache que le mail vient de l'admin       
    $mail->addAddress($mailfrom); 

	$body = "Bienvenu sur Misa Crea <br>
			Vous avez voulu recuperer votre mot de passe sur notre site.<br>
			Nous voulions confirmer que votre mail est exacte.<br>
			Si vous vouliez recuperer votre password, cliquer sur le lien ci-dessous.<br>
			Et veuillez rentrer le code suivant : $code .<br>
			Lien : http://localhost/tpweb/E-Commerce/RecuperationMdp.php?mail=$mailfrom&token=$token<br>
			-------------------------------------------------------------------------<br>
			Ceci est un mail automatique, Merci de ne pas y répondre<br>
			Admin E-Commerce";
	
    $mail->isHTML(true);                                  
    $mail->Subject = "Recuperation de votre mot de passe";
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);
	$mailcheck = "SELECT COUNT(*) AS nbr FROM users WHERE mail = '".$mailfrom."'";
	$res = mysqli_query($database,$mailcheck);
    $alors = mysqli_fetch_assoc($res);
	if(!($alors['nbr'] == 0)){
		if (filter_var($mailfrom, FILTER_VALIDATE_EMAIL)) {
			$mail->send();?>
			<html>
			<head>
			<script type="text/javascript">
			function RedirectionJavascript(){
				document.location.href="forgotpass.php";
			}
			alert("Mail Envoyé");
			</script>
			</head>
			<body onLoad="setTimeout('RedirectionJavascript()', 0)">
			</body>
			</html>
			
			<?php 
		}
	}else{
		echo"<script type='text/javascript'> alert('Ce mail n\'est pas utilisé ! Veuillez créer un compte')</script>";
		?>
			<head>
			<script type="text/javascript">
			function RedirectionJavascript(){
				document.location.href="forgotpass.php";
			}
			</script>
			</head>
			<body onLoad="setTimeout('RedirectionJavascript()', 0)">
			</body>
		
		<?php 
	}
} catch (Exception $e) {
    echo '<h2>Adresse invalide</h2>';
	echo "<h2>Cliquez <a href='contact.php'>ici</a> pour être redirigé vers le contact</h2>";
}


?></p>


