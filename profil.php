<?php
require_once("public/config.php");

if(!isConnected())
{
	header("location:connexion.php");
}
$contenu .= '<p class="centre">Bonjour <strong>' . $_SESSION['membre']['pseudo'] . '</strong></p>';
$contenu .= '<div class="cadre"><h2>Informations Personnels</h2>';
$contenu .= '<p>Email : ' . $_SESSION['membre']['email'] . '<br>';
$contenu .= 'Ville : ' . $_SESSION['membre']['ville'] . '<br>';
$contenu .= 'Code Postal: ' . $_SESSION['membre']['code_postal'] . '<br>';
$contenu .= 'Adresse : ' . $_SESSION['membre']['adresse'] . '</p></div><br /><br />';

require_once("layouts/header.php");
echo $contenu;
require_once("layouts/footer.php");
