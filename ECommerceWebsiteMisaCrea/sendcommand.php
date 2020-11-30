<?php 
session_start();
$mailfrom=$_SESSION['user']; 

require_once("bdconnexion.php");

$name = $_POST['name'];
$qty = $_POST['qty'];
$price = $_POST['price'];
$total = $_POST['total'];

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
	$mail->Username = 'ecommercetest92@gmail.com';       //votre adresse mail      
    $mail->Password = 'testcommerce';                         // votre mdp de votre @mail                          
    $mail->SMTPSecure = 'ssl';                          
    $mail->Port = 465;                                    
	
    //Recipients
	$mail->IsHTML(true);
    $mail->setFrom("ecommercetest92@gmail.com","Admin E-Commerce");         
    
	$mail->addAddress($mailfrom); 
	$mail->addAddress("ecommerceTest92@gmail.com"); // indiquez vos mail pour que vous receviez aussi la recap du commande
	
	$body = " Bonjour, <br>" ;
	$body .= " Vous avez commandé $qty $name pour $price avec un total de $total € <br>" ;
	$body .= "Merci de votre achat <br>";
	$body .= "Admin E-Commerce";
	
	
	
    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = "Recapitulatif de la commande";
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
				document.location.href="Panier.php";
			}
			alert("Mail Envoyé");
			</script>
			</head>
			<body onLoad="setTimeout('RedirectionJavascript()', 0)">
			</body>
			</html>
			
			<?php 
			unset($_SESSION["shopping_cart"]);
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
	echo "<h2>Cliquez <a href='Panier.php'>ici</a> pour être redirigé vers le Panier</h2>";
}

?></p>