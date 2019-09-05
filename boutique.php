<?php
require_once("public/config.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AFFICHAGE DES CATEGORIES ---//
$contenu .= '<div class="container">';
$contenu .= '<div class="row">';
$categories_des_produits = executeRequete("SELECT DISTINCT categorie FROM produit");
$contenu .= '<div class="col-lg-3">';
$contenu .= '<h2 class="my-4">Catégories</h2>';
$contenu .= '<div class="list-group">';
while($cat = $categories_des_produits->fetch_assoc())
{
	$contenu .= "<a class='list-group-item' href='?categorie="	. $cat['categorie'] . "'>" . $cat['categorie'] . "</a>";
}
$contenu .= "</div>";
$contenu .= "</div>";
//--- AFFICHAGE DES PRODUITS ---//
$contenu .= '<div class="col-lg-9">';
$contenu .= '<div class="row">';
if(isset($_GET['categorie']))
{
	$donnees = executeRequete("SELECT id_produit,reference,titre,photo,prix FROM produit WHERE categorie='$_GET[categorie]'");
	while($produit = $donnees->fetch_assoc())
	{
		$contenu .= '<div class="col-lg-4 col-md-6 mb-4">';
		$contenu .= '<div class="card h-100">';
		$contenu .= "<a href=\"fiche_produit.php?id_produit=$produit[id_produit]\"><img class='card-img-top' src=\"$produit[photo]\" /></a>";
		$contenu .= '<div class="card-body">';
		$contenu .= "<h4 class='card-title'>$produit[titre]</h4>";
		$contenu .= '<a href="fiche_produit.php?id_produit=' . $produit['id_produit'] . '">Voir la fiche</a>';
		$contenu .= "<h5>$produit[prix] euros</h5>";
		$contenu .= '</div>';
		$contenu .= '</div>';
		$contenu .= '</div>';
	}
}
$contenu .= '</div>';
$contenu .= '</div>';
$contenu .= '</div>';
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("layouts/header.php");
echo $contenu;
require_once("layouts/footer.php");
