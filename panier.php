<?php
require_once("public/config.php");

//--- AJOUT PANIER ---//
if(isset($_POST['ajout_panier']))
{
	$resultat = executeRequete("SELECT * FROM produit WHERE id_produit='$_POST[id_produit]'");
	$produit = $resultat->fetch_assoc();
	addProductCart($produit['titre'],$_POST['id_produit'],$_POST['quantite'],$produit['prix']);
}
//--- VIDER PANIER ---//
if(isset($_GET['action']) && $_GET['action'] == "vider")
{
	unset($_SESSION['panier']);
}
//--- PAIEMENT ---//
if(isset($_POST['payer']))
{
	for($i=0 ;$i < count($_SESSION['panier']['id_produit']) ; $i++)
	{
		$resultat = executeRequete("SELECT * FROM produit WHERE id_produit=" . $_SESSION['panier']['id_produit'][$i]);
		$produit = $resultat->fetch_assoc();
		if($produit['stock'] < $_SESSION['panier']['quantite'][$i])
		{
			$contenu .= '<hr /><div class="erreur">Stock Restant: ' . $produit['stock'] . '</div>';
			$contenu .= '<div class="erreur">Quantité demandée: ' . $_SESSION['panier']['quantite'][$i] . '</div>';
			if($produit['stock'] > 0)
			{
				$contenu .= '<div class="erreur">la quantité de l\'produit ' . $_SESSION['panier']['id_produit'][$i] . ' à été réduite car notre stock était insuffisant, veuillez vérifier vos achats.</div>';
				$_SESSION['panier']['quantite'][$i] = $produit['stock'];
			}
			else
			{
				$contenu .= '<div class="erreur">l\'produit ' . $_SESSION['panier']['id_produit'][$i] . ' à été retiré de votre panier car nous sommes en rupture de stock, veuillez vérifier vos achats.</div>';
				deleteProductCart($_SESSION['panier']['id_produit'][$i]);
				$i--;
			}
			$erreur = true;
		}
	}
	if(!isset($erreur))
	{
		executeRequete("INSERT INTO commande (id_membre, montant, date_enregistrement) VALUES (" . $_SESSION['membre']['id_membre'] . "," . totalAmount() . ", NOW())");
		$id_commande = $mysqli->insert_id;
		for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
		{
			executeRequete("INSERT INTO details_commande (id_commande, id_produit, quantite, prix) VALUES ($id_commande, " . $_SESSION['panier']['id_produit'][$i] . "," . $_SESSION['panier']['quantite'][$i] . "," . $_SESSION['panier']['prix'][$i] . ")");
		}
		unset($_SESSION['panier']);
		$contenu .= "<div class='validation'>Merci pour votre commande. votre n° de suivi est le $id_commande</div>";
	}
}

include("layouts/header.php");
echo $contenu; ?>
<div class="container">
	<div class="card shopping-cart">
		<div class="card-header bg-dark text-light">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				Panier
				<div class="clearfix"></div>
		</div>
<?php if(empty($_SESSION['panier']['id_produit'])) // panier vide
{
	echo "<tr><td colspan='5'>Votre panier est vide</td></tr>";
}
else
{ ?>
	<div class="card-body">
	<?php for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
	{ ?>
		<div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
				<h4 class="product-name"><strong><?php $_SESSION['panier']['titre'][$i]?></strong></h4>
				<h4>
						<small>Product description</small>
				</h4>
		</div>
		<div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
				<div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
						<h6><strong><?php $_SESSION['panier']['prix'][$i] ?><span class="text-muted">x</span></strong></h6>
				</div>
				<div class="col-4 col-sm-4 col-md-4">
						<div class="quantity">
								<input type="button" value="+" class="plus">
								<input type="number" step="1" max="99" min="1" value="1" title="Qty" class="qty"
											 size="4">
								<input type="button" value="-" class="minus">
						</div>
				</div>
		</div>
	<?php } ?>
	</div>
	<?php echo "<tr><th colspan='3'>Total</th><td colspan='2'>" . totalAmount() . " euros</td></tr>";
	if(isConnected())
	{
		echo '<form method="post" action="">';
		echo '<tr><td colspan="5"><input type="submit" name="payer" value="Valider et déclarer le paiement" /></td></tr>';
		echo '</form>';
	}
	else
	{
		echo '<tr><td colspan="3">Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir payer</td></tr>';
	}
	echo "<tr><td colspan='5'><a href='?action=vider'>Vider mon panier</a></td></tr>";
}
echo "</table><br />"; ?>
	</div>
</div>
<?php include("layouts/footer.php"); ?>
