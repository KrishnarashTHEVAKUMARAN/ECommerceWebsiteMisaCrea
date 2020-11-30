<?php
$serveur="localhost";
$login="root";
$mdp="";
$bd = "ecommercebase";
$tables = "users";

$connexion=mysqli_connect($serveur,$login,$mdp)
or die("Connexion impossible au serveur $serveur pour $login");

$conn = mysqli_select_db($connexion,$bd)
or die("Impossible d'accéder à la base de données");

$database = mysqli_connect("localhost", "root", "", "ecommercebase");

$bdd = new PDO('mysql:host=localhost;dbname=ecommercebase', 'root', '');
?>
