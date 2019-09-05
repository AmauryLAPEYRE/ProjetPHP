<?php
function executeRequete($req)
{
	global $mysqli;
	$resultat = $mysqli->query($req);
	if (!$resultat)
	{
		die("Erreur sur la requete sql.<br />Message : " . $mysqli->error . "<br />Code: " . $req);
	}
	return $resultat;
}
//------------------------------------
function debug($var, $mode = 1)
{
		echo '<div style="background: orange; padding: 5px; float: right; clear: both; ">';
		$trace = debug_backtrace();
		$trace = array_shift($trace);
		echo "Debug demandé dans le fichier : $trace[file] à la ligne $trace[line].<hr />";
		if($mode === 1)
		{
			echo "<pre>"; print_r($var); echo "</pre>";
		}
		else
		{
			echo "<pre>"; var_dump($var); echo "</pre>";
		}
	echo '</div>';
}
//------------------------------------
function isConnected()
{
	if(!isset($_SESSION['membre']))
	{
		return false;
	}
	else
	{
		return true;
	}
}
//------------------------------------
function isConnectedAsAdmin()
{
	if(isConnected() && $_SESSION['membre']['statut'] == 1)
	{
			return true;
	}
	return false;
}

function createCart()
{
   if (!isset($_SESSION['panier']))
   {
      $_SESSION['panier']=array();
      $_SESSION['panier']['titre'] = array();
      $_SESSION['panier']['id_produit'] = array();
      $_SESSION['panier']['quantite'] = array();
      $_SESSION['panier']['prix'] = array();
   }
}

function addProductCart($titre,$id_produit,$quantite,$prix)
{
	createCart();
    $position_produit = array_search($id_produit,  $_SESSION['panier']['id_produit']);
    if ($position_produit !== false)
    {
         $_SESSION['panier']['quantite'][$position_produit] += $quantite ;
    }
    else
    {
        $_SESSION['panier']['titre'][] = $titre;
        $_SESSION['panier']['id_produit'][] = $id_produit;
        $_SESSION['panier']['quantite'][] = $quantite;
		$_SESSION['panier']['prix'][] = $prix;
    }
}
//------------------------------------
function totalAmount()
{
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
   {
      $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
   }
   return round($total,2);
}
//------------------------------------
function deleteProductCart($delete_product_id)
{
	$position_produit = array_search($delete_product_id,  $_SESSION['panier']['id_produit']);
	if ($position_produit !== false)
    {
		array_splice($_SESSION['panier']['titre'], $position_produit, 1);
		array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
		array_splice($_SESSION['panier']['quantite'], $position_produit, 1);
		array_splice($_SESSION['panier']['prix'], $position_produit, 1);
	}
}
