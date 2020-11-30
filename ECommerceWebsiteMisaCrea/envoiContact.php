<?php 
$nom=$_POST['nom']; 
$mailfrom=$_POST['mail']; 
$objet=$_POST['objet']; 
$message=$_POST['message']; 

//error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);                              
try {
	//Server settings for gmail
	$mail->Mailer = "smtp";
    $mail->SMTPDebug = 0;                                 
    $mail->isSMTP();                                     
    $mail->Host = 'smtp.gmail.com';                  
    $mail->SMTPAuth = true;                               
	$mail->Username = 'EcommerceTest92@gmail.com';       //votre adresse mail      
    $mail->Password = 'testcommerce';                         // votre mdp de votre @mail
    $mail->SMTPSecure = 'ssl';                            
    $mail->Port = 465;                                
	
    //Recipients
	$mail->IsHTML(true);
    $mail->setFrom($mailfrom,$nom);         
    $mail->addAddress('EcommerceTest92@gmail.com'); // indiquez votre adresse mail pour recevoir les avis de vos clients

	$body = "From : $mailfrom <br>
	Message : $message " ;
	
    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = "$objet";
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);
	if (filter_var($mailfrom, FILTER_VALIDATE_EMAIL)) {
		$mail->send();?>
		<html>
		<head>
		<script type="text/javascript">
		function RedirectionJavascript(){
			document.location.href="contact.php";
		}
		alert("Votre message a été envoyé");
		</script>
		</head>
		<!--<body onLoad="setTimeout('RedirectionJavascript()', 2000)">
		<div>Dans 2 secondes vous allez être redirigé vers l'accueil</div>
		</body>-->
		<body onLoad="setTimeout('RedirectionJavascript()', 0)">
		</body>
		</html>
		
		<?php 
	} 
echo 'Message has been sent';
} catch (Exception $e) {
    echo '<h2>Adresse invalide</h2>';
	echo "<h2>Cliquez <a href='contact.php'>ici</a> pour être redirigé vers le contact</h2>";
}

require_once('footer.php');
?></p>


