<?php
require_once("public/config.php");

if(!isConnectedAsAdmin())
{
	header("location:connexion.php");
	exit();
}

if(isset($_GET['action']) && $_GET['action'] == "suppression")
{
	$resultat = executeRequete("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]");
	$produit_a_supprimer = $resultat->fetch_assoc();
	$chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . $produit_a_supprimer['photo'];
	if(!empty($produit_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer))	unlink($chemin_photo_a_supprimer);
	$contenu .= '<div class="validation">Suppression du produit : ' . $_GET['id_produit'] . '</div>';
	executeRequete("DELETE FROM produit WHERE id_produit=$_GET[id_produit]");
	$_GET['action'] = 'affichage';
}
//--- ENREGISTREMENT PRODUIT ---//
if(!empty($_POST))
{
	$photo_bdd = "";
	if(!empty($_FILES['photo']['name']))
	{
		$nom_photo = $_POST['reference'] . '_' .$_FILES['photo']['name'];
		$photo_bdd = "photo/$nom_photo";
		$photo_dossier = $_SERVER['DOCUMENT_ROOT'] . "/shop/photo/$nom_photo";
		copy($_FILES['photo']['tmp_name'],$photo_dossier);
	}
	foreach($_POST as $indice => $valeur)
	{
		$_POST[$indice] = htmlEntities(addSlashes($valeur));
	}
	executeRequete("REPLACE INTO produit (id_produit, reference, categorie, titre, description, photo, prix, stock) values ('$_POST[id_produit]', '$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]',  '$photo_bdd',  '$_POST[prix]',  '$_POST[stock]')");
	$_GET['action'] = 'affichage';
}

if(isset($_GET['action']) && $_GET['action'] == "affichage")
{
	$resultat = executeRequete("SELECT * FROM produit"); ?>
	<div class='container'>
	<div class='table-wrapper'>
	<div class='table-title'>
	<div class='row'>
	</div>
	<div><h2>Produits</h2></div>
	<div>
	<button type='button' class='btn btn-info add-new'><i class='fa fa-plus'></i><a href='?action=ajout'>Ajout d'un produit</a></button>
	<div style="color:mediumseagreen" class="validation">Le produit à bien été modifié</div>
	</div>
	</div>
	<table class='table table-bordered'>
	<thead>
	<tr>
	<p>Nombre de produit(s) dans la boutique : <?php echo $resultat->num_rows?></p>
	<?php $contenu .= '<table border="1" cellpadding="5"><tr>';

	while($colonne = $resultat->fetch_field())
	{
		$contenu .= '<th>' . $colonne->name . '</th>';
	}
	$contenu .= '<th>Modifier</th>';
	$contenu .= '<th>Supprimer</th>';
	$contenu .= '</tr>';
	echo "</thead>";
	echo "<tbody>";
	while ($ligne = $resultat->fetch_assoc())
	{
		$contenu .= '<tr>';
		foreach ($ligne as $indice => $information)
		{
			if($indice == "photo")
			{
				$contenu .= '<td><img src="' . $information . '" width="70" height="70" /></td>';
			}
			else
			{
				$contenu .= '<td>' . $information . '</td>';
			}
		}
		$contenu .= '<td><a class="edit" data-toggle="tooltip" data-original-title="Edit" href="?action=modification&id_produit=' . $ligne['id_produit'] .'"><i class="material-icons"></i></a></td>';
		$contenu .= '<td><a class="delete" data-toggle="tooltip" href="?action=suppression&id_produit=' . $ligne['id_produit'] .'" OnClick="return(confirm(\'Etes vous sur de vouloir supprimmer cet élément ?\'));"><i class="material-icons"></i></a></td>';
		$contenu .= '</tr>';
	}
	echo "</tbody>";
	echo "</table";
	echo "</div>";
}
require_once("layouts/header.php");
echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
	if(isset($_GET['id_produit']))
	{
		$resultat = executeRequete("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]");
		$produit_actuel = $resultat->fetch_assoc();
	} ?>
	<div class="container">
		<section class="panel panel-default">
		<div class="panel-heading">
		<h3 class="panel-title">Modifier le produit</h3>
		</div>
		<div class="panel-body">
			<form role="form" method="post" class="form-horizontal" enctype="multipart/form-data" action="">
					<div class="form-group">
						<div class="col-sm-9">
		          <input type="hidden" id="id_produit" name="id_produit" value="<?php if(isset($produit_actuel['id_produit'])) echo $produit_actuel['id_produit']; ?>">
		        </div>
					</div>
					<div class="form-group">
						<label  for="id_produit">Référence</label>
		        <input class="form-control" type="text" id="reference" name="reference" placeholder="" value="<?php if(isset($produit_actuel['reference'])) echo $produit_actuel['reference'];  ?>">
					</div>
					<div class="form-group">
						<label for="id_produit">Catégorie</label>
		         <input class="form-control" type="text" id="categorie" name="categorie" placeholder="la categorie de produit" value="<?php if(isset($produit_actuel['categorie'])) echo $produit_actuel['categorie']; ?>">
					</div>
					<div class="form-group">
						<label for="id_produit">Titre</label>
		        <input class="form-control" type="text" id="titre" name="titre" placeholder="le titre du produit" value="<?php if(isset($produit_actuel['titre'])) echo $produit_actuel['titre'];  ?>">
					</div>
					<div class="form-group">
		        <label for="about">Description</label>
		        <textarea class="form-control" name="description" id="description"><?php if(isset($produit_actuel['description'])) echo $produit_actuel['description']; ?></textarea>
		      </div>
					<label for="photo">Image</label>
					<div class="custom-file">
				    <input type="file" name="photo" class="custom-file-input" id="validatedCustomFile">
				    <label class="custom-file-label" for="validatedCustomFile">Chercher</label>
				    <div class="invalid-feedback">Fichier invalide</div>
				  </div>
					<div class="form-row">
		        <div class="form-group col-md-6">
		    	  	<label for="date_start">Prix</label>
		    	  	<input class="form-control" type="number" id="prix" name="prix"  value="<?php if(isset($produit_actuel['prix'])) echo $produit_actuel['prix']; ?>">
		        </div>
			    	<div class="form-group col-md-6">
		    	  	<label for="date_finish">Stock</label>
		    	  	<input class="form-control" type="number" id="stock" name="stock" value="<?php if(isset($produit_actuel['stock'])) echo $produit_actuel['stock']; ?>">
		        </div>
		      </div>
					<hr>
	        <button type="submit" class="btn btn-primary" value="<?php echo ucfirst($_GET['action'])?> . ' du produit">Valider</button>
			</form>
			</div>
		</section>
	</div>
<?php }
require_once("layouts/footer.php"); ?>
